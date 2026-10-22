<?php
/* ============================================================
   SaleBari — site configuration
   Copy this file's values for your cPanel hosting before upload.
   Nothing else in the app should need editing.
   ============================================================ */

/* --- Database ------------------------------------------------
   On Namecheap cPanel: MySQL Databases -> create database + user,
   add the user to the database with ALL PRIVILEGES, then paste the
   full prefixed names below (e.g. cpaneluser_salebari).           */
define('DB_DRIVER', getenv('SB_DB_DRIVER') ?: 'mysql');   // mysql | sqlite
define('DB_HOST',   'localhost');
define('DB_NAME',   'salebari');
define('DB_USER',   'salebari_user');
define('DB_PASS',   'CHANGE_ME');
define('DB_SQLITE_PATH', __DIR__ . '/data/salebari.sqlite');  // local dev only

/* --- Site ---------------------------------------------------- */
define('SITE_NAME', 'SaleBari');
/* Leave blank if the site lives at your domain's root. Set this only if
   it lives in a sub-folder, e.g. '/salebari'. */
define('BASE_URL', '');

define('CONTACT_PHONE', '+8801644842785');
define('CONTACT_EMAIL', 'salebarirealestate@gmail.com');

/* --- Product images -------------------------------------------- */
define('MAX_IMAGES',       6);
define('MAX_UPLOAD_BYTES', 10 * 1024 * 1024);

/* --- Debug ----------------------------------------------------- */
define('SHOW_ERRORS', getenv('SB_DEBUG') === '1');
