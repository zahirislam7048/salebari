# SaleBari admin dashboard — local dev & Namecheap deployment

## What this is

The public site (`index.html`, `category.html`, `listing.html`, `stall/`, `market/`) is
still the static HTML/CSS/JS site it always was — nothing about it changed. Alongside it,
this adds a PHP + MySQL **admin dashboard** (`/admin/`) backed by a database, so the site's
categories, stalls, shopping malls, homepage deals, real-estate strip, settings and
newsletter subscribers can be managed from a browser instead of by editing JS files.

The dashboard reads and writes the database. The public pages do not read from it yet —
that wiring (turning `index.html`/`category.html` into PHP that pulls from these tables) is
a separate follow-up phase, flagged in the project plan.

## Local development

Requires a local PHP install (8.1+) — none was found on this machine when this was built.
No MySQL needed for local testing: the app can run on SQLite instead.

```bash
SB_DB_DRIVER=sqlite SB_DEBUG=1 php -S 127.0.0.1:8100 -t .
```

Then visit `http://127.0.0.1:8100/install.php` once to create the database tables, your
admin login, and load the site's current content into it. Log in at
`http://127.0.0.1:8100/admin/login.php` afterwards.

The SQLite file is created at `data/salebari.sqlite` (gitignore this in real use).

## Namecheap cPanel deployment

1. **Create a MySQL database**: cPanel → MySQL Databases → create a database and a user,
   add the user to the database with ALL PRIVILEGES. Note the full prefixed names
   (e.g. `cpaneluser_salebari`).
2. **Upload the whole `SaleBari` folder** to your domain/subdomain's document root.
3. **First install only: copy `config.sample.php` to `config.php`**, then edit it. (Updates never include `config.php`, so your database settings are never overwritten.) **Edit `config.php`**: set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` to the values from
   step 1.
4. **Visit `/install.php`** once in your browser. Create the admin account — this also
   creates the tables and loads the site's current categories/stalls/deals/settings.
5. **Delete `install.php`** from the server immediately after — while it exists, anyone who
   finds it can create a new admin account.
6. Log in at `/admin/login.php`.

## Products & image uploads

The **Products** admin page (`/admin/products.php`) lets you add real listings — title,
Bangla title, SEO meta title/description, English and Bangla descriptions, price, and up
to 6 images — attached to a category via two dropdowns (pick the top-level category, then
the specific subcategory/leaf it belongs to).

Uploaded images are validated as real image files (not just checked by extension) and
stored under `uploads/products/`. That folder ships with its own `.htaccess` that blocks
any uploaded file from ever being executed as a script — don't remove it. On Namecheap
this folder is writable by default; if uploads fail with a permission error, set it to
755 in File Manager (right-click the folder → Permissions).

## Notes

- Single admin role — no seller self-service accounts.
- Deleting a category with subcategories is blocked in the dashboard; delete the
  subcategories first.
