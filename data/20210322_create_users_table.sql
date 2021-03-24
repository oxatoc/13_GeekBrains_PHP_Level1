DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    `id`          int(11)      NOT NULL AUTO_INCREMENT,
    `name`        varchar(150) NOT NULL,
    `password`    varchar(255) NOT NULL,
    `role`    varchar(255)      NOT NULL,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

/* Пароль - admin */
INSERT INTO users (`name`, `password`, `role`)
VALUES ('admin', '$2y$10$TlewdxHMinuFJECT3bvJZuE57WYrCFB6vtRVxRqe1WewvXuw3IhJi', 'admin');
