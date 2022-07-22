DROP SCHEMA IF EXISTS `task_force`;

CREATE SCHEMA IF NOT EXISTS `task_force` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE `task_force`;

CREATE TABLE IF NOT EXISTS `cities` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `lat` DECIMAL (11, 8),
    `long` DECIMAL (11, 8),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `icon` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `password` VARCHAR(45) NOT NULL,
    `dt_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `last_visit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `about` VARCHAR(255) DEFAULT NULL,
    `birthday` TIMESTAMP DEFAULT CURRENT_TIMESTAMP DEFAULT NULL,
    `address` VARCHAR(255) DEFAULT NULL,
    `phone` VARCHAR(15) DEFAULT NULL,
    `skype` VARCHAR(50) DEFAULT NULL,
    `role` TINYINT DEFAULT 1,
    `rate` INT DEFAULT NULL,

    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `users_categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `favorites` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `favorite_user_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`favorite_user_id`) REFERENCES `users` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `tasks` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `executor_id` INT UNSIGNED NOT NULL,
    `customer_id` INT UNSIGNED DEFAULT NULL,
    `dt_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `status` TINYINT DEFAULT 1,
    `expire` TIMESTAMP NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `address` VARCHAR(255) DEFAULT NULL,
    `budget` INT DEFAULT NULL,
    `lat` DECIMAL (11, 8),
    `long` DECIMAL (11, 8),

    FOREIGN KEY (`executor_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `tasks_categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `task_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `replies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dt_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `rate` INT DEFAULT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `task_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `opinions` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dt_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `rate` INT DEFAULT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `task_id` INT UNSIGNED NOT NULL,
    `executor_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
    FOREIGN KEY (`executor_id`) REFERENCES `users` (`id`),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `author_id` INT UNSIGNED NOT NULL,
    `recipient_id` INT UNSIGNED NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `rate` INT NOT NULL,

    FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`),
    PRIMARY KEY (`id`, `author_id`, `recipient_id`)
);
