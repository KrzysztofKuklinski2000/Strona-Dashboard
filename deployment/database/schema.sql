-- Importuj wyłącznie do nowej, pustej bazy MySQL 8.0+.
-- Po błędzie sprawdź stan bazy: instrukcje DDL nie są wycofywane transakcją.

SET NAMES utf8mb4;

CREATE TABLE `camp` (
    `id` tinyint unsigned NOT NULL DEFAULT '1',
    `city` varchar(50) NOT NULL,
    `city_start` varchar(50) NOT NULL,
    `date_start` date NOT NULL,
    `date_end` date NOT NULL,
    `time_start` time NOT NULL,
    `time_end` time NOT NULL,
    `place` varchar(100) NOT NULL,
    `accommodation` text NOT NULL,
    `meals` text NOT NULL,
    `trips` text NOT NULL,
    `staff` text NOT NULL,
    `transport` text NOT NULL,
    `training` text NOT NULL,
    `insurance` text NOT NULL,
    `cost` int NOT NULL,
    `advancePayment` int NOT NULL,
    `advanceDate` date NOT NULL,
    `guesthouse` varchar(70) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `chk_camp_singleton` CHECK (`id` = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `contact` (
    `id` tinyint unsigned NOT NULL DEFAULT '1',
    `email` text NOT NULL,
    `phone` varchar(20) NOT NULL,
    `address` text NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `chk_contact_singleton` CHECK (`id` = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `fees` (
    `id` tinyint unsigned NOT NULL DEFAULT '1',
    `reduced_contribution_1_month` int NOT NULL,
    `reduced_contribution_2_month` int NOT NULL,
    `family_contribution_month` int NOT NULL,
    `reduced_contribution_1_year` int NOT NULL,
    `reduced_contribution_2_year` int NOT NULL,
    `family_contribution_year` int NOT NULL,
    `extra_information` text NOT NULL,
    `fees_information` text,
    PRIMARY KEY (`id`),
    CONSTRAINT `chk_fees_singleton` CHECK (`id` = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `gallery` (
    `id` int NOT NULL AUTO_INCREMENT,
    `image_name` text NOT NULL,
    `description` varchar(50) NOT NULL,
    `created_at` date NOT NULL,
    `updated_at` date NOT NULL,
    `position` int NOT NULL DEFAULT '1',
    `category` enum('training','camp') DEFAULT NULL,
    `status` tinyint NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `gallery_categories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `slug` varchar(100) NOT NULL,
    `position` int NOT NULL DEFAULT '1',
    `status` tinyint NOT NULL DEFAULT '1',
    `created_at` date NOT NULL,
    `updated_at` date NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `gallery_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `gallery_category` (
    `gallery_id` int NOT NULL,
    `category_id` int NOT NULL,
    PRIMARY KEY (`gallery_id`,`category_id`),
    KEY `gallery_category_category_id_index` (`category_id`),
    CONSTRAINT `gallery_category_category_fk` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE CASCADE,
    CONSTRAINT `gallery_category_gallery_fk` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `homepage_posts` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(60) NOT NULL,
    `created` date NOT NULL,
    `updated` date NOT NULL,
    `status` tinyint NOT NULL,
    `position` int NOT NULL DEFAULT '1',
    `type` varchar(50) NOT NULL DEFAULT 'simple_text',
    `payload` json DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `important_posts` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(60) NOT NULL,
    `description` text NOT NULL,
    `created` date NOT NULL,
    `updated` date NOT NULL,
    `status` tinyint NOT NULL,
    `important` int DEFAULT NULL,
    `position` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `locations` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `city` varchar(50) NOT NULL,
    `address` varchar(200) NOT NULL,
    `description` text,
    `map_embed_url` text,
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `created_at` date NOT NULL,
    `updated_at` date NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `news` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(60) NOT NULL,
    `created` date DEFAULT NULL,
    `updated` date DEFAULT NULL,
    `status` tinyint(1) NOT NULL,
    `position` int NOT NULL DEFAULT '1',
    `type` varchar(50) NOT NULL DEFAULT 'article',
    `payload` json DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `page_views` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `path` varchar(255) NOT NULL,
    `viewed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_page_views_viewed_at` (`viewed_at`),
    KEY `idx_page_views_path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `subscribers` (
    `id` int NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `is_active` tinyint(1) DEFAULT '1',
    `confirmation_token_hash` char(64) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
    `confirmation_expires_at` datetime DEFAULT NULL,
    `confirmation_last_sent_at` datetime DEFAULT NULL,
    `confirmed_at` datetime DEFAULT NULL,
    `unsubscribe_token` char(64) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `uq_subscribers_confirmation_token_hash` (`confirmation_token_hash`),
    UNIQUE KEY `uq_subscribers_unsubscribe_token` (`unsubscribe_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `timetable` (
    `id` int NOT NULL AUTO_INCREMENT,
    `day` varchar(20) NOT NULL,
    `advancement_group` varchar(40) NOT NULL,
    `start` time NOT NULL,
    `end` time NOT NULL,
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `location_id` int DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_timetable_location_id` (`location_id`),
    CONSTRAINT `fk_timetable_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

CREATE TABLE `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `login` varchar(50) NOT NULL,
    `password` varchar(250) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
