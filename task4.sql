CREATE TABLE `products`
(
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(128) NOT NULL,
  `description` TEXT         NOT NULL,
  `price`       decimal(10, 2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;

CREATE TABLE `clients`
(
  `id`    INT(11)      NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(100) NOT NULL,
  `email` varchar(64)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM;

CREATE TABLE `orders`
(
  `id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `client_id`    INT(11)     NOT NULL,
  `created`      datetime    NOT NULL,
  `ip`           VARCHAR(15) NOT NULL,
  `client_phone` INT(10)     NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = MyISAM;


CREATE TABLE `order_product`
(
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `order_id`   INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = MyISAM;

CREATE INDEX orders_client_id ON orders (client_id);
CREATE INDEX order_product_product_client_id ON order_product (order_id, product_id);

START TRANSACTION;
INSERT INTO `orders`
VALUES (client_id, created, amount);
ROLLBACK;
INSERT INTO `order_product`
VALUES (order_id, product_id);
COMMIT;

SELECT o.id, created, COUNT(op.id) AS count_product, AVG(p.price) AS avg_product_price
FROM orders AS o
       JOIN order_product AS op ON op.order_id = o.id
       JOIN products AS p ON p.id = op.product_id
GROUP BY o.id
HAVING count_product > 1
ORDER BY created
LIMIT 10
