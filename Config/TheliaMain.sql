
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- moretextarea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `moretextarea`;

CREATE TABLE `moretextarea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `position` INTEGER,
    `typobj` INTEGER,
    `typch` INTEGER,
    `template_id` INTEGER,
    `title` VARCHAR(100),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- product_moretextarea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_moretextarea`;

CREATE TABLE `product_moretextarea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_id` INTEGER NOT NULL,
    `moretextarea_id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'fr_FR',
    `chapo` VARCHAR(255),
    `value` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_product_moretextarea_moretextarea_id` (`moretextarea_id`),
    INDEX `fi_product_moretextarea_product_id` (`product_id`),
    CONSTRAINT `fk_product_moretextarea_moretextarea_id`
        FOREIGN KEY (`moretextarea_id`)
        REFERENCES `moretextarea` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_product_moretextarea_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- category_moretextarea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_moretextarea`;

CREATE TABLE `category_moretextarea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `category_id` INTEGER NOT NULL,
    `moretextarea_id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'fr_FR',
    `chapo` VARCHAR(255),
    `value` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_category_moretextarea_moretextarea_id` (`moretextarea_id`),
    INDEX `fi_category_moretextarea_category_id` (`category_id`),
    CONSTRAINT `fk_category_moretextarea_moretextarea_id`
        FOREIGN KEY (`moretextarea_id`)
        REFERENCES `moretextarea` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_category_moretextarea_category_id`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- folder_moretextarea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `folder_moretextarea`;

CREATE TABLE `folder_moretextarea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `folder_id` INTEGER NOT NULL,
    `moretextarea_id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'fr_FR',
    `chapo` VARCHAR(255),
    `value` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_folder_moretextarea_moretextarea_id` (`moretextarea_id`),
    INDEX `fi_folder_moretextarea_folder_id` (`folder_id`),
    CONSTRAINT `fk_folder_moretextarea_moretextarea_id`
        FOREIGN KEY (`moretextarea_id`)
        REFERENCES `moretextarea` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_folder_moretextarea_folder_id`
        FOREIGN KEY (`folder_id`)
        REFERENCES `folder` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- content_moretextarea
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `content_moretextarea`;

CREATE TABLE `content_moretextarea`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `content_id` INTEGER NOT NULL,
    `moretextarea_id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'fr_FR',
    `chapo` VARCHAR(255),
    `value` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_content_moretextarea_moretextarea_id` (`moretextarea_id`),
    INDEX `fi_content_moretextarea_content_id` (`content_id`),
    CONSTRAINT `fk_content_moretextarea_moretextarea_id`
        FOREIGN KEY (`moretextarea_id`)
        REFERENCES `moretextarea` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_content_moretextarea_content_id`
        FOREIGN KEY (`content_id`)
        REFERENCES `content` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
