-- ============================================================
-- SmartTest — Jadvallar va Admin
-- 1-qadam: Shu faylni import qiling
-- ============================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `smarttest`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smarttest`;

-- Jadvallarni o'chirish (tartib muhim)
DROP TABLE IF EXISTS `test_results`;
DROP TABLE IF EXISTS `test_sessions`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `subjects`;
DROP TABLE IF EXISTS `users`;

-- ─── users ───────────────────────────────────────────────────
CREATE TABLE `users` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `is_admin`   TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── subjects ────────────────────────────────────────────────
CREATE TABLE `subjects` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(150) NOT NULL,
  `icon`        VARCHAR(20)  NOT NULL DEFAULT '📚',
  `description` TEXT,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── questions ───────────────────────────────────────────────
CREATE TABLE `questions` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id`     INT UNSIGNED NOT NULL,
  `question_text`  TEXT NOT NULL,
  `option_a`       TEXT NOT NULL,
  `option_b`       TEXT NOT NULL,
  `option_c`       TEXT NOT NULL,
  `option_d`       TEXT NOT NULL,
  `correct_option` CHAR(1) NOT NULL,
  `difficulty`     TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_subject`    (`subject_id`),
  KEY `idx_difficulty` (`difficulty`),
  CONSTRAINT `fk_q_subject`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── test_sessions ───────────────────────────────────────────
CREATE TABLE `test_sessions` (
  `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`            INT UNSIGNED NOT NULL,
  `subject_id`         INT UNSIGNED NOT NULL,
  `current_difficulty` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `question_number`    TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `correct_count`      SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `answered_ids`       TEXT,
  `answers_log`        TEXT,
  `started_at`         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ts_user`    (`user_id`),
  KEY `idx_ts_subject` (`subject_id`),
  CONSTRAINT `fk_ts_user`
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ts_subject`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── test_results ────────────────────────────────────────────
CREATE TABLE `test_results` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED NOT NULL,
  `subject_id`     INT UNSIGNED NOT NULL,
  `score`          SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `easy_correct`   TINYINT UNSIGNED DEFAULT 0,
  `medium_correct` TINYINT UNSIGNED DEFAULT 0,
  `hard_correct`   TINYINT UNSIGNED DEFAULT 0,
  `time_taken`     INT UNSIGNED DEFAULT NULL,
  `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tr_user`    (`user_id`),
  KEY `idx_tr_subject` (`subject_id`),
  CONSTRAINT `fk_tr_user`
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tr_subject`
    FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ─── Admin foydalanuvchi ─────────────────────────────────────
-- Parol: 123456 (PHP password_hash bilan yaratilgan)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`) VALUES
(1, 'Administrator', 'admin@gmail.com',
 '$2y$10$n4HZHPpgZRS.AN9XyyKR9uHM08.yHXvEy5BwYU5Ofejy0ZUFnfi.W', 1);

-- Agar yuqoridagi hash ishlamasa, PHPda quyidagini bajaring:
-- php -r "echo password_hash('123456', PASSWORD_DEFAULT);"
-- Natijani users jadvalidagi password maydoniga qo'ying

