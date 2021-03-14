DROP TABLE IF EXISTS gallery;
CREATE TABLE gallery
(
    `id`          int(11)      NOT NULL AUTO_INCREMENT,
    `address`     varchar(150) NOT NULL,
    `size`        int(150)     NOT NULL,
    `name`        varchar(150) NOT NULL,
    `views_count` int(11)      NOT NULL DEFAULT 0,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE INDEX image_UNIQUE (`name` ASC),
    UNIQUE INDEX id_UNIQUE (`id` ASC)
);
