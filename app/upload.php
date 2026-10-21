<?php
/* Image uploads (product photos, blog covers/inline images). Files land
   under uploads/<subdir>/, never trusted by extension alone — validated by
   real image content (getimagesize). */

/**
 * Save one uploaded file (a single $_FILES[...] entry) under uploads/<subdir>/.
 * Returns the stored relative path (e.g. 'uploads/products/xxx.jpg') or
 * null if the slot was empty. Throws RuntimeException on a real problem.
 */
function save_uploaded_image(array $file, string $subdir): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        throw new RuntimeException($file['name'] . ' is too large for this server\'s upload limit. Try a smaller image, or ask your host to raise upload_max_filesize/post_max_size.');
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload of ' . $file['name'] . ' failed (error code ' . $file['error'] . ').');
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        throw new RuntimeException($file['name'] . ' is larger than ' . (MAX_UPLOAD_BYTES / 1024 / 1024) . 'MB.');
    }

    /* Any resolution/aspect ratio is accepted — only the file type is checked. */
    $info = @getimagesize($file['tmp_name']);
    $allowed = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp', IMAGETYPE_GIF => 'gif'];
    if ($info === false || !isset($allowed[$info[2]])) {
        throw new RuntimeException($file['name'] . ' is not a valid image (jpg, png, webp or gif only).');
    }

    $dir = APP_ROOT . '/uploads/' . $subdir;
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException(
            "Could not create the uploads/$subdir folder — the uploads/ folder itself isn't writable by PHP. "
            . 'In cPanel File Manager, right-click uploads/, choose Permissions, and set it to 755 (or 775 if 755 still fails).'
        );
    }
    if (!is_writable($dir)) {
        throw new RuntimeException(
            "uploads/$subdir/ exists but isn't writable by PHP. "
            . 'In cPanel File Manager, right-click that folder, choose Permissions, and set it to 755 (or 775 if 755 still fails).'
        );
    }

    $name = bin2hex(random_bytes(12)) . '.' . $allowed[$info[2]];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        throw new RuntimeException(
            'Could not save ' . $file['name'] . ' — the folder looked writable but the file write itself failed. '
            . "This can happen if the disk is full, or if uploads/$subdir/ is owned by a different user than PHP runs "
            . 'as (re-create the folder from cPanel File Manager rather than via FTP/zip extraction if so).'
        );
    }

    return 'uploads/' . $subdir . '/' . $name;
}

function save_product_image(array $file): ?string
{
    return save_uploaded_image($file, 'products');
}

/**
 * Save every file in a multi-file input (e.g. $_FILES['images']), up to
 * MAX_IMAGES. Returns the list of stored relative paths.
 */
function save_product_images(array $filesField, int $alreadyHave = 0): array
{
    $saved = [];
    $count = count($filesField['name'] ?? []);
    for ($i = 0; $i < $count; $i++) {
        if (($alreadyHave + count($saved)) >= MAX_IMAGES) {
            break;
        }
        if (($filesField['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        $single = [
            'name'     => $filesField['name'][$i],
            'type'     => $filesField['type'][$i],
            'tmp_name' => $filesField['tmp_name'][$i],
            'error'    => $filesField['error'][$i],
            'size'     => $filesField['size'][$i],
        ];
        $path = save_product_image($single);
        if ($path) {
            $saved[] = $path;
        }
    }
    return $saved;
}

/** A blog post's single cover image, from $_FILES['cover_image']. */
function save_blog_cover(array $file): ?string
{
    return save_uploaded_image($file, 'blog');
}

function delete_uploaded_file(string $relativePath): void
{
    $full = APP_ROOT . '/' . ltrim($relativePath, '/');
    $uploadsRoot = realpath(APP_ROOT . '/uploads') ?: "\0";
    if (is_file($full) && strpos(realpath($full) ?: '', $uploadsRoot) === 0) {
        unlink($full);
    }
}
