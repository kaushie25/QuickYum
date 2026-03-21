-- ============================================================
--  QuickYum – MySQL Database Dump
--  Database : quickyum
--  Created  : 2025
-- ============================================================

CREATE DATABASE IF NOT EXISTS `quickyum`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `quickyum`;

-- ── users ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(60)  NOT NULL,
  `email`      VARCHAR(120) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── recipes ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `recipes` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`      INT(11)      DEFAULT NULL,
  `title`        VARCHAR(150) NOT NULL,
  `category`     ENUM('breakfast','lunch','dinner') NOT NULL,
  `tags`         VARCHAR(255) DEFAULT '',
  `cook_time`    INT(11)      NOT NULL COMMENT 'minutes',
  `ingredients`  TEXT         NOT NULL,
  `instructions` TEXT         NOT NULL,
  `status`       ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_recipe_user` (`user_id`),
  CONSTRAINT `fk_recipe_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── messages (contact form) ───────────────────────────────────
CREATE TABLE IF NOT EXISTS `messages` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `email`      VARCHAR(120) NOT NULL,
  `message`    TEXT         NOT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Sample approved recipes ───────────────────────────────────
INSERT INTO `recipes`
  (`user_id`, `title`, `category`, `tags`, `cook_time`, `ingredients`, `instructions`, `status`)
VALUES
(NULL, 'Avocado Egg Toast',   'breakfast', 'vegan,quick', 10,
 "2 slices sourdough bread\n1 ripe avocado\n2 eggs\nPinch of chilli flakes\nSalt & pepper\n1 tsp lemon juice",
 "Toast sourdough until golden.\nMash avocado with lemon juice, salt and pepper.\nFry eggs to your liking.\nSpread avocado on toast, top with egg and chilli flakes.",
 'approved'),
(NULL, 'Butter Chicken', 'dinner', '', 45,
 "500g chicken breast\n1 can tomato purée\n1 cup heavy cream\n2 tbsp butter\n1 onion\n4 garlic cloves\n1 tsp garam masala",
 "Marinate chicken 15 min.\nFry onion & garlic in butter.\nAdd chicken, cook 6 min.\nAdd tomato purée & spices, simmer 15 min.\nStir in cream, cook 5 min more.",
 'approved');
