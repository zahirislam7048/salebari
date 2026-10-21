-- ============================================================
-- SaleBari admin dashboard — database schema
-- Written for MySQL; install.php rewrites the few type differences
-- for SQLite on the fly so this file stays the single source of truth.
-- No FK constraints — integrity is kept at the app level.
-- ============================================================

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'admin',
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  parent_id INT UNSIGNED NULL,
  level TINYINT NOT NULL,
  slug VARCHAR(80) NOT NULL,
  name_en VARCHAR(160) NOT NULL,
  name_bn VARCHAR(160) NULL,
  icon VARCHAR(20) NULL,
  count_label_en VARCHAR(60) NULL,
  count_label_bn VARCHAR(60) NULL,
  featured TINYINT NOT NULL DEFAULT 0,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE stalls (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(160) NOT NULL,
  name VARCHAR(160) NOT NULL,
  category_id INT UNSIGNED NULL,
  mall_id INT UNSIGNED NULL,
  city VARCHAR(80) NULL,
  address VARCHAR(255) NULL,
  phone VARCHAR(30) NULL,
  description TEXT NULL,
  logo_emoji VARCHAR(10) NULL,
  logo_image VARCHAR(255) NULL,
  seller_id INT UNSIGNED NULL,
  package VARCHAR(40) NULL,
  review_status VARCHAR(20) NOT NULL DEFAULT 'approved',
  verified TINYINT NOT NULL DEFAULT 0,
  rating DECIMAL(2,1) NULL,
  product_count INT UNSIGNED NOT NULL DEFAULT 0,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE malls (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(160) NOT NULL,
  name VARCHAR(160) NOT NULL,
  logo_image VARCHAR(255) NULL,
  city_name_en VARCHAR(120) NOT NULL,
  city_name_bn VARCHAR(120) NULL,
  closed_day VARCHAR(20) NULL,
  stall_count INT UNSIGNED NOT NULL DEFAULT 0,
  description_en VARCHAR(255) NULL,
  description_bn VARCHAR(255) NULL,
  address VARCHAR(255) NULL,
  opening_hours VARCHAR(160) NULL,
  website VARCHAR(255) NULL,
  mobile VARCHAR(40) NULL,
  phone VARCHAR(40) NULL,
  email VARCHAR(190) NULL,
  map_url VARCHAR(600) NULL,
  facebook VARCHAR(255) NULL,
  instagram VARCHAR(255) NULL,
  about LONGTEXT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE brands (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL,
  logo_image VARCHAR(255) NULL,
  location VARCHAR(200) NULL,
  address VARCHAR(255) NULL,
  website VARCHAR(255) NULL,
  mobile VARCHAR(40) NULL,
  phone VARCHAR(40) NULL,
  email VARCHAR(190) NULL,
  map_url VARCHAR(600) NULL,
  facebook VARCHAR(255) NULL,
  instagram VARCHAR(255) NULL,
  youtube VARCHAR(255) NULL,
  twitter VARCHAR(255) NULL,
  linkedin VARCHAR(255) NULL,
  description LONGTEXT NULL,
  seller_id INT UNSIGNED NULL,
  review_status VARCHAR(20) NOT NULL DEFAULT 'approved',
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE deals (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  stall_name VARCHAR(160) NOT NULL,
  title_en VARCHAR(200) NOT NULL,
  title_bn VARCHAR(200) NULL,
  icon VARCHAR(10) NULL,
  price_display_en VARCHAR(40) NOT NULL,
  price_display_bn VARCHAR(40) NULL,
  old_price_display_en VARCHAR(40) NULL,
  old_price_display_bn VARCHAR(40) NULL,
  discount_pct TINYINT NULL,
  gradient VARCHAR(20) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  active TINYINT NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL
);

CREATE TABLE real_estate_listings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(200) NOT NULL,
  title_bn VARCHAR(200) NULL,
  tag VARCHAR(20) NOT NULL DEFAULT 'sale',
  price_display_en VARCHAR(60) NOT NULL,
  price_display_bn VARCHAR(60) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  active TINYINT NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL
);

CREATE TABLE settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  k VARCHAR(80) NOT NULL,
  v_en TEXT NULL,
  v_bn TEXT NULL
);

CREATE TABLE subscribers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  stall_id INT UNSIGNED NULL,
  brand_id INT UNSIGNED NULL,
  title_en VARCHAR(200) NOT NULL,
  title_bn VARCHAR(200) NULL,
  slug VARCHAR(220) NOT NULL,
  meta_title VARCHAR(200) NULL,
  meta_description VARCHAR(320) NULL,
  description_en LONGTEXT NULL,
  description_bn LONGTEXT NULL,
  price_display VARCHAR(60) NULL,
  images TEXT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE blog_posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(200) NOT NULL,
  title_bn VARCHAR(200) NULL,
  slug VARCHAR(220) NOT NULL,
  meta_title VARCHAR(200) NULL,
  meta_description VARCHAR(320) NULL,
  cover_image VARCHAR(255) NULL,
  content_en LONGTEXT NULL,
  content_bn LONGTEXT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'draft',
  published_at DATETIME NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE sellers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NULL,
  phone VARCHAR(30) NULL,
  password_hash VARCHAR(255) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL
);
