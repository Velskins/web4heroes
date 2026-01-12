CREATE DATABASE IF NOT EXISTS `web4heroes` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web4heroes`;

CREATE TABLE `addresses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `street` VARCHAR(255) NOT NULL,
    `supplement` VARCHAR(255) NULL,
    `zipcode` VARCHAR(20) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `country` VARCHAR(100) DEFAULT 'France'
) ENGINE=InnoDB;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(100) NOT NULL,
    `firstname` VARCHAR(100) NOT NULL,
    `gender` ENUM('M', 'F', 'Other') NOT NULL,
    `birthdate` DATE NOT NULL,
    `phone` VARCHAR(20) NULL,
    `role` ENUM('citizen', 'hero', 'admin') DEFAULT 'citizen',
    `is_verified` BOOLEAN DEFAULT FALSE,
    `newsletter_optin` BOOLEAN DEFAULT FALSE,
    `address_id` INT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`address_id`) REFERENCES `addresses`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `hero_profiles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL UNIQUE,
    `alias` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `photo_path` VARCHAR(255) NULL,
    `is_active` BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `villains` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NULL,
    `alias` VARCHAR(100) NOT NULL,
    `specialty` VARCHAR(100) NOT NULL,
    `sector` VARCHAR(100) NULL,
    `status` ENUM('Free', 'In Prison', 'Unknown') DEFAULT 'Unknown',
    `description` TEXT NULL,
    `photo_path` VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE `incident_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `incident_statuses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `incidents` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `citizen_id` INT NULL,
    `hero_id` INT NULL,
    `villain_id` INT NULL,
    `type_id` INT NOT NULL,
    `status_id` INT NOT NULL,
    `address_id` INT NULL,
    `priority` ENUM('Low', 'Normal', 'High') DEFAULT 'Normal',
    `description` TEXT NOT NULL,
    `date_incident` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `admin_comment` TEXT NULL,
    FOREIGN KEY (`citizen_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`hero_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`villain_id`) REFERENCES `villains`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`type_id`) REFERENCES `incident_types`(`id`),
    FOREIGN KEY (`status_id`) REFERENCES `incident_statuses`(`id`),
    FOREIGN KEY (`address_id`) REFERENCES `addresses`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `movies` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hero_id` INT NOT NULL,
    `imdb_id` VARCHAR(20) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `year` INT NULL,
    `poster_url` VARCHAR(255) NULL,
    `is_visible` BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (`hero_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `reviews` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `incident_id` INT NOT NULL,
    `citizen_id` INT NULL,
    `hero_id` INT NOT NULL,
    `rating` TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    `comment` TEXT NULL,
    `is_moderated` BOOLEAN DEFAULT FALSE,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`incident_id`) REFERENCES `incidents`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`citizen_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`hero_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `newsletter_subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `subscribed_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

