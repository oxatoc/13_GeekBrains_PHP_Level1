DROP TABLE IF EXISTS products;
CREATE TABLE products
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `name`        varchar(150)  NOT NULL,
    `price`       decimal(8, 2) NOT NULL DEFAULT 0,
    `image_uri`   varchar(150)  NOT NULL,
    `size`        int(11) NOT NULL,
    `views_count` int(11) NOT NULL DEFAULT 0,
    `created_at`  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE INDEX image_uri_UNIQUE (`image_uri` ASC),
    UNIQUE INDEX id_UNIQUE (`id` ASC)
);

INSERT INTO products (`name`, `price`, `image_uri`, `size`)
VALUES ('чай', 253, '/img/bags_of_tea.jpg', 82217)
     , ('хлеб тостовый', 89, '/img/bread.jpg', 203330)
     , ('сыр', 420, '/img/cheese.jpg', 50797)
     , ('курица охлажденная', 138, '/img/chicken_carcass_cooled.jpg', 31367)
     , ('кофе в зернах', 280, '/img/coffee.jpg', 141873)
     , ('масло подсолнечное', 92, '/img/cooking_oil.jpg', 57368)
     , ('ветчина для тостов', 548, '/img/ham_for_tosts.jpg', 49709)
     , ('мороженное', 73, '/img/ice_cream.jpg', 82980)
     , ('молоко', 85, '/img/milk.jpg', 9650)
     , ('картофель', 69, '/img/potato.jpg', 64287)
     , ('сметана', 75, '/img/sour_cream.jpg', 58013)

