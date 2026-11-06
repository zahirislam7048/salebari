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

    /* Shrink and re-encode (max 1600px, WebP where the server can) so pages load fast on mobile data. */
    $ext     = $allowed[$info[2]];
    $name    = bin2hex(random_bytes(12));
    $optimal = optimize_image($file['tmp_name'], (int) $info[2], $dir . '/' . $name);
    if ($optimal !== null) {
        return 'uploads/' . $subdir . '/' . $name . '.' . $optimal;
    }

    $name .= '.' . $ext;
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

/**
 * Resize (longest side <= IMAGE_MAX_SIDE) and re-encode an uploaded image.
 * Writes "$destBase.webp" (or .jpg/.png when WebP is unavailable) and returns the extension,
 * or null when nothing was done (GD missing, animated GIF, decode failure) so the caller keeps the original.
 */
function optimize_image(string $src, int $type, string $destBase): ?string
{
    $maxSide = defined('IMAGE_MAX_SIDE') ? (int) IMAGE_MAX_SIDE : 1600;
    if (!extension_loaded('gd') || $type === IMAGETYPE_GIF) {
        return null;
    }
    try {
        $img = null;
        if ($type === IMAGETYPE_JPEG && function_exists('imagecreatefromjpeg')) {
            $img = @imagecreatefromjpeg($src);
            if ($img && function_exists('exif_read_data')) {
                $exif = @exif_read_data($src);
                $rot  = [3 => 180, 6 => -90, 8 => 90][(int) ($exif['Orientation'] ?? 1)] ?? 0;
                if ($rot) {
                    $r = imagerotate($img, $rot, 0);
                    if ($r) { $img = $r; }
                }
            }
        } elseif ($type === IMAGETYPE_PNG && function_exists('imagecreatefrompng')) {
            $img = @imagecreatefrompng($src);
        } elseif ($type === IMAGETYPE_WEBP && function_exists('imagecreatefromwebp')) {
            $img = @imagecreatefromwebp($src);
        }
        if (!$img) {
            return null;
        }
        $w = imagesx($img);
        $h = imagesy($img);
        if (max($w, $h) > $maxSide) {
            $scale = $maxSide / max($w, $h);
            $small = imagescale($img, max(1, (int) round($w * $scale)), max(1, (int) round($h * $scale)));
            if ($small) { $img = $small; }
        }
        imagepalettetotruecolor($img);
        imagealphablending($img, false);
        imagesavealpha($img, true);

        if (function_exists('imagewebp') && imagewebp($img, $destBase . '.webp', 82)) {
            return 'webp';
        }
        if ($type === IMAGETYPE_PNG) {
            return imagepng($img, $destBase . '.png', 8) ? 'png' : null;
        }
        // JPEG: flatten any transparency onto white
        $flat = imagecreatetruecolor(imagesx($img), imagesy($img));
        imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
        imagecopy($flat, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
        return imagejpeg($flat, $destBase . '.jpg', 82) ? 'jpg' : null;
    } catch (Throwable $e) {
        return null;
    }
}
