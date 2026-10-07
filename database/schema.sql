CREATE TABLE IF NOT EXISTS categories
(
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS posts
(
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image        VARCHAR(255) NOT NULL,
    title        VARCHAR(255) NOT NULL,
    description  TEXT         NOT NULL,
    content      TEXT         NOT NULL,
    views        INT UNSIGNED NOT NULL DEFAULT 0,
    published_at DATETIME     NOT NULL,
    INDEX idx_posts_published_at (published_at),
    INDEX idx_posts_views (views)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS post_category
(
    post_id     INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, category_id),
    INDEX idx_post_category_category (category_id),
    FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;