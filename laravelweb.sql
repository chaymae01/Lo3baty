-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 20, 2025 at 09:20 AM
-- Server version: 8.3.0
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelweb`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `send_reservation_expiration_notifications_proc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `send_reservation_expiration_notifications_proc` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE res_id BIGINT;
    DECLARE cli_id BIGINT;

    DECLARE cur CURSOR FOR 
        SELECT id, client_id 
        FROM reservations 
        WHERE statut = 'active'
          AND date_fin BETWEEN NOW() AND NOW() + INTERVAL 24 HOUR;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO res_id, cli_id;

        IF done THEN
            LEAVE read_loop;
        END IF;

        IF res_id IS NULL OR cli_id IS NULL THEN
            ITERATE read_loop;
        END IF;

        INSERT INTO notifications(
            id, 
            type, 
            notifiable_type, 
            notifiable_id, 
            data, 
            created_at, 
            updated_at
        ) VALUES (
            UUID(),
            'App\\Notifications\\ReservationExpirationNotification',
            'App\\Models\\Utilisateur',
            cli_id,
            JSON_OBJECT(
                'type', 'reservation_expiration',
                'reservation_id', res_id,
                'message', CONCAT('Réservation se termine dans ', TIMESTAMPDIFF(HOUR, NOW(), (SELECT date_fin FROM reservations WHERE id = res_id)), 'h'),
                'url', CONCAT('/reservations/', res_id)
            ),
            NOW(),
            NOW()
        );

    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_pass` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `prenom`, `email`, `mot_pass`, `created_at`, `updated_at`) VALUES
(1, 'Chaymae', 'Houda', 'admin@lo3baty.com', '$2y$12$CfzE2p7612SlZbCtIiYCMeATNelXXvGxvb5HW7.26KqAseYr7ej0u', '2025-05-14 10:53:53', '2025-05-14 10:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_publication` date NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` enum('active','archivee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `prix_journalier` decimal(8,2) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  `premium_periode` enum('7','15','30') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `premium_start_date` timestamp NULL DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objet_id` bigint UNSIGNED NOT NULL,
  `proprietaire_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annonces_objet_id_foreign` (`objet_id`),
  KEY `annonces_proprietaire_id_foreign` (`proprietaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `annonces`
--

INSERT INTO `annonces` (`id`, `date_publication`, `date_debut`, `date_fin`, `statut`, `prix_journalier`, `premium`, `premium_periode`, `premium_start_date`, `adresse`, `objet_id`, `proprietaire_id`, `created_at`, `updated_at`) VALUES
(1, '2025-05-15', '2025-05-16', '2025-05-21', 'active', 50.00, 1, '7', '2025-05-15 04:19:34', '34.0083637,-6.8538748', 1, 1, '2025-05-15 04:19:34', '2025-05-15 04:34:40'),
(2, '2025-05-15', '2025-05-15', '2025-08-15', 'active', 30.00, 0, NULL, NULL, '85.0511288,-180.0000000', 2, 1, '2025-05-15 04:19:34', '2025-05-15 04:33:15'),
(3, '2025-05-15', '2025-05-15', '2025-08-15', 'archivee', 60.00, 0, NULL, NULL, '85.0511288,-180.0000000', 3, 1, '2025-05-15 04:19:34', '2025-05-15 04:33:19'),
(4, '2025-05-15', '2025-05-16', '2025-05-19', 'active', 120.00, 0, NULL, NULL, '34.0502967,-6.7495096', 4, 3, '2025-05-15 11:06:27', '2025-05-15 11:06:27'),
(5, '2025-05-15', '2025-05-16', '2025-05-20', 'active', 120.00, 1, '15', '2025-05-15 12:23:40', '35.5607453,-5.3640747', 5, 3, '2025-05-15 12:23:09', '2025-05-15 12:23:40');

--
-- Triggers `annonces`
--
DROP TRIGGER IF EXISTS `nouvelle_annonce_notification`;
DELIMITER $$
CREATE TRIGGER `nouvelle_annonce_notification` AFTER INSERT ON `annonces` FOR EACH ROW BEGIN
    -- Déclarations doivent être en premier
    DECLARE done INT DEFAULT FALSE;
    DECLARE user_id BIGINT;
    DECLARE objet_nom VARCHAR(255);
    DECLARE prix_formatted VARCHAR(20);
    DECLARE dates_dispo VARCHAR(100);
    DECLARE user_cursor CURSOR FOR SELECT id FROM utilisateurs;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Instructions exécutables
    SELECT nom INTO objet_nom FROM objets WHERE id = NEW.objet_id;
    SET prix_formatted = FORMAT(NEW.prix_journalier, 2);
    SET dates_dispo = CONCAT('Du ', DATE_FORMAT(NEW.date_debut, '%d/%m'), ' au ', DATE_FORMAT(NEW.date_fin, '%d/%m'));

    OPEN user_cursor;
    user_loop: LOOP
        FETCH user_cursor INTO user_id;
        IF done THEN
            LEAVE user_loop;
        END IF;

        INSERT INTO notifications (
            id,
            type,
            notifiable_type,
            notifiable_id,
            data,
            read_at,
            created_at,
            updated_at
        ) VALUES (
            UUID(),
            'App\Notifications\NouvelleAnnonceNotification',
            'App\Models\Utilisateur',
            user_id,
            JSON_OBJECT(
                'type', 'nouvelle_annonce',
                'annonce_id', NEW.id,
                'message', CONCAT('✨ Nouveau jouet disponible ! "', objet_nom, '" à ', prix_formatted, 'Dhs/jour'),
                'details', JSON_OBJECT(
                    'objet', objet_nom,
                    'prix', CONCAT(prix_formatted, 'Dhs/jour'),
                    'disponibilite', dates_dispo,
                    'premium', IF(NEW.premium = 1, 'Oui', 'Non')
                ),
                'url', CONCAT('http://localhost:8000/annonces/', NEW.id),
                'created_at', DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s')
            ),
            NULL,
            NOW(),
            NOW()
        );
    END LOOP;
    CLOSE user_cursor;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `nouvelle_annonce_update`;
DELIMITER $$
CREATE TRIGGER `nouvelle_annonce_update` AFTER UPDATE ON `annonces` FOR EACH ROW BEGIN
    -- Déclarations
    DECLARE objet_nom VARCHAR(255);
    DECLARE nouveau_prix VARCHAR(20);
    DECLARE ancien_prix VARCHAR(20);
    DECLARE message_principal VARCHAR(255);
    DECLARE type_changement VARCHAR(50);
    
    -- Instructions exécutables
    SELECT nom INTO objet_nom FROM objets WHERE id = NEW.objet_id;
    SET nouveau_prix = FORMAT(NEW.prix_journalier, 2);
    SET ancien_prix = FORMAT(OLD.prix_journalier, 2);
    
    -- Déterminer le type de changement
    IF OLD.prix_journalier != NEW.prix_journalier THEN
        SET type_changement = 'prix';
        SET message_principal = CONCAT('? Prix modifié ! "', objet_nom, '" : ', ancien_prix, 'Dhs → ', nouveau_prix, 'Dhs');
    ELSE
        SET type_changement = 'autre';
        SET message_principal = CONCAT('✏️ Annonce modifiée : "', objet_nom, '"');
    END IF;

    IF (OLD.prix_journalier != NEW.prix_journalier OR
        OLD.statut != NEW.statut OR
        OLD.premium != NEW.premium) THEN

        INSERT INTO notifications (
            id,
            type,
            notifiable_type,
            notifiable_id,
            data,
            read_at,
            created_at,
            updated_at
        )
        SELECT
            UUID(),
            'App\Notifications\AnnonceModifieeNotification',
            'App\Models\Utilisateur',
            u.id,
            JSON_OBJECT(
                'type', 'annonce_modifiee',
                'annonce_id', NEW.id,
                'message', message_principal,
                'details', JSON_OBJECT(
                    'changement', type_changement,
                    'nouveau_prix', CONCAT(nouveau_prix, '€'),
                    'ancien_prix', CONCAT(ancien_prix, '€'),
                    'dates', JSON_OBJECT(
                        'debut', DATE_FORMAT(NEW.date_debut, '%d/%m/%Y'),
                        'fin', DATE_FORMAT(NEW.date_fin, '%d/%m/%Y')
                    ),
                    'premium', IF(NEW.premium = 1, 'Oui', 'Non')
                ),
                'url', CONCAT('http://localhost:8000/annonces/', NEW.id),
                'urgence', IF(type_changement = 'prix' AND NEW.prix_journalier < OLD.prix_journalier, 'haute', 'normale')
            ),
            NULL,
            NOW(),
            NOW()
        FROM utilisateurs u
        WHERE u.role = 'client';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Jouet Bébé', NULL, NULL),
(2, 'Puzzle', NULL, NULL),
(3, 'Lego', NULL, NULL),
(4, 'Jeu de société', NULL, NULL),
(5, 'Véhicules', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_on_annonces`
--

DROP TABLE IF EXISTS `evaluation_on_annonces`;
CREATE TABLE IF NOT EXISTS `evaluation_on_annonces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `objet_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `note` tinyint NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_on_annonces_objet_id_foreign` (`objet_id`),
  KEY `evaluation_on_annonces_client_id_foreign` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_on_annonces`
--

INSERT INTO `evaluation_on_annonces` (`id`, `objet_id`, `client_id`, `note`, `commentaire`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 5, 'L\'objet était exactement comme décrit, parfait.', '2025-05-14 04:19:34', '2025-05-14 04:19:34'),
(2, 4, 3, 5, 'csdfvb', '2025-05-15 12:28:28', '2025-05-15 12:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_on_clients`
--

DROP TABLE IF EXISTS `evaluation_on_clients`;
CREATE TABLE IF NOT EXISTS `evaluation_on_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `partner_id` bigint UNSIGNED NOT NULL,
  `note` tinyint NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_on_clients_reservation_id_foreign` (`reservation_id`),
  KEY `evaluation_on_clients_client_id_foreign` (`client_id`),
  KEY `evaluation_on_clients_partner_id_foreign` (`partner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_on_clients`
--

INSERT INTO `evaluation_on_clients` (`id`, `reservation_id`, `client_id`, `partner_id`, `note`, `commentaire`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 4, 'Client ponctuel, respectueux du matériel.', '2025-05-14 04:19:34', '2025-05-14 04:19:34'),
(2, 3, 3, 3, 3, 'fghcjvbj,kn.', '2025-05-15 12:26:49', '2025-05-15 12:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_on_partners`
--

DROP TABLE IF EXISTS `evaluation_on_partners`;
CREATE TABLE IF NOT EXISTS `evaluation_on_partners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint UNSIGNED NOT NULL,
  `partner_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `note` tinyint NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `signaler` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluation_on_partners_reservation_id_foreign` (`reservation_id`),
  KEY `evaluation_on_partners_partner_id_foreign` (`partner_id`),
  KEY `evaluation_on_partners_client_id_foreign` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluation_on_partners`
--

INSERT INTO `evaluation_on_partners` (`id`, `reservation_id`, `partner_id`, `client_id`, `note`, `commentaire`, `signaler`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 5, 'Très bon service, partenaire sérieux !', 0, '2025-05-14 04:19:34', '2025-05-15 04:35:57'),
(2, 3, 3, 3, 4, 'sdcv', 1, '2025-05-15 12:28:28', '2025-05-15 12:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objet_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_objet_id_foreign` (`objet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `url`, `objet_id`, `created_at`, `updated_at`) VALUES
(1, 'images/objets/lego.jpg', 1, NULL, NULL),
(2, 'images/objets/lego1.jpg', 1, NULL, NULL),
(3, 'images/objets/voiture.jpg', 2, NULL, NULL),
(4, 'images/objets/dob.jpg', 3, NULL, NULL),
(5, 'products/UA324zKQfjhIyuhmyl1BWoJgxJqbIOXM5yeNxaU1.webp', 4, '2025-05-15 11:05:59', '2025-05-15 11:05:59'),
(6, 'products/b9nTSdVwQPKv9h70uH2ZCXIqnqiJZc5yQpJIxm7W.jpg', 4, '2025-05-15 11:05:59', '2025-05-15 11:05:59'),
(7, 'products/0vSbXL1gQ0d4gwZKOhiDWZao3VFej48cvWu1X2Lv.jpg', 4, '2025-05-15 11:05:59', '2025-05-15 11:05:59'),
(8, 'products/FmiG25KoOeUTdmMA5RgMJfV1IcRn4fsu9CuZmho9.webp', 5, '2025-05-15 12:21:52', '2025-05-15 12:21:52'),
(9, 'products/3demg6p4xQJQnkClmfxQjbUKl6ekXRpAxsjb7onQ.jpg', 5, '2025-05-15 12:21:52', '2025-05-15 12:21:52'),
(10, 'products/K62iEaeLPEclZjKbnUQp9bqp2KuEoAlKn4WuKIZu.jpg', 5, '2025-05-15 12:21:52', '2025-05-15 12:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"ed2a0322-1552-4f29-88ab-fe9614add47f\",\"displayName\":\"App\\\\Notifications\\\\ReclamationRepondueNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Utilisateur\\\";s:2:\\\"id\\\";a:1:{i:0;i:3;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:49:\\\"App\\\\Notifications\\\\ReclamationRepondueNotification\\\":2:{s:14:\\\"\\u0000*\\u0000reclamation\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Reclamation\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"utilisateur\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"bdd0786c-9bda-4ce4-995f-233fcf9acd58\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1747312520,\"delay\":null}', 0, NULL, 1747312520, 1747312520),
(2, 'default', '{\"uuid\":\"6c4e75f4-c7e1-4ee8-8ef5-207424367986\",\"displayName\":\"App\\\\Notifications\\\\ReclamationRepondueNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Utilisateur\\\";s:2:\\\"id\\\";a:1:{i:0;i:3;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:49:\\\"App\\\\Notifications\\\\ReclamationRepondueNotification\\\":2:{s:14:\\\"\\u0000*\\u0000reclamation\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Reclamation\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"utilisateur\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"30ec9ad0-1e7f-4f46-8062-1439d7a1a730\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1747312737,\"delay\":null}', 0, NULL, 1747312737, 1747312737),
(3, 'default', '{\"uuid\":\"d6cd549f-50a8-40eb-ad30-0e74616a50af\",\"displayName\":\"App\\\\Notifications\\\\ReclamationRepondueNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Utilisateur\\\";s:2:\\\"id\\\";a:1:{i:0;i:3;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:49:\\\"App\\\\Notifications\\\\ReclamationRepondueNotification\\\":2:{s:14:\\\"\\u0000*\\u0000reclamation\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Reclamation\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"utilisateur\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"4787924e-88d2-4ee0-a1a1-1a037f3d75d0\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1747315188,\"delay\":null}', 0, NULL, 1747315188, 1747315188);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_23_214254_create_utilisateurs_table', 1),
(5, '2025_04_23_214750_create_admins_table', 1),
(6, '2025_04_23_214750_create_categories_table', 1),
(7, '2025_04_23_214751_create_objets_table', 1),
(8, '2025_04_23_214752_create_images_table', 1),
(9, '2025_04_23_214753_create_annonces_table', 1),
(10, '2025_04_23_214754_create_reservations_table', 1),
(11, '2025_04_23_214756_create_notifications_table', 1),
(12, '2025_04_23_214758_create_reclamations_table', 1),
(13, '2025_05_05_104457_create_evaluation_on_clients_table', 1),
(14, '2025_05_05_104655_create_evaluation_on_partners_table', 1),
(15, '2025_05_05_104724_create_evaluation_on_annonces_table', 1),
(16, '2025_05_05_104841_create_paiement_clients_table', 1),
(17, '2025_05_05_104919_create_paiement_partenaires_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('beca08f5-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\NouvelleAnnonceNotification', 'App\\Models\\Utilisateur', 3, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"nouvelle_annonce\", \"details\": {\"prix\": \"120.00Dhs/jour\", \"objet\": \"fgsfrdhtgfjg\", \"premium\": \"Non\", \"disponibilite\": \"Du 16/05 au 20/05\"}, \"message\": \"✨ Nouveau jouet disponible ! \\\"fgsfrdhtgfjg\\\" à 120.00Dhs/jour\", \"annonce_id\": 5, \"created_at\": \"2025-05-15 14:23:09\"}', NULL, '2025-05-15 13:23:09', '2025-05-15 13:23:09'),
('beca06a6-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\NouvelleAnnonceNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"nouvelle_annonce\", \"details\": {\"prix\": \"120.00Dhs/jour\", \"objet\": \"fgsfrdhtgfjg\", \"premium\": \"Non\", \"disponibilite\": \"Du 16/05 au 20/05\"}, \"message\": \"✨ Nouveau jouet disponible ! \\\"fgsfrdhtgfjg\\\" à 120.00Dhs/jour\", \"annonce_id\": 5, \"created_at\": \"2025-05-15 14:23:09\"}', NULL, '2025-05-15 13:23:09', '2025-05-15 13:23:09'),
('beca023c-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\NouvelleAnnonceNotification', 'App\\Models\\Utilisateur', 1, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"nouvelle_annonce\", \"details\": {\"prix\": \"120.00Dhs/jour\", \"objet\": \"fgsfrdhtgfjg\", \"premium\": \"Non\", \"disponibilite\": \"Du 16/05 au 20/05\"}, \"message\": \"✨ Nouveau jouet disponible ! \\\"fgsfrdhtgfjg\\\" à 120.00Dhs/jour\", \"annonce_id\": 5, \"created_at\": \"2025-05-15 14:23:09\"}', NULL, '2025-05-15 13:23:09', '2025-05-15 13:23:09'),
('469ce4ec-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\ReclamationRepondueNotification', 'App\\Models\\Utilisateur', 3, '{\"url\": \"http://localhost:8000/reclamations/4\", \"type\": \"reclamation_reponse\", \"sujet\": \"fbndfhnd\", \"message\": \"Réponse à votre réclamation portant sur \\\"fbndfhnd\\\"\", \"reponse\": \"zdffgdghfjhshfg\", \"reclamation_id\": 4}', '2025-05-15 12:19:54', '2025-05-15 13:19:48', '2025-05-15 12:19:54'),
('bd99cfc0-14af-4a52-aafc-9e74e500190e', 'App\\Notifications\\NouvelleAnnonceNotification', 'App\\Models\\Utilisateur', 2, '{\"type\":\"nouvelle_annonce\",\"annonce_id\":5,\"message\":\"Nouvelle annonce disponible\",\"titre\":null,\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/annonces\\/5\",\"created_at\":\"2025-05-15 13:23:09\"}', NULL, '2025-05-15 12:23:09', '2025-05-15 12:23:09'),
('c5cfc08b-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\AnnonceModifieeNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"annonce_modifiee\", \"details\": {\"dates\": {\"fin\": \"20/05/2025\", \"debut\": \"16/05/2025\"}, \"premium\": \"Non\", \"changement\": \"autre\", \"ancien_prix\": \"120.00€\", \"nouveau_prix\": \"120.00€\"}, \"message\": \"✏️ Annonce modifiée : \\\"fgsfrdhtgfjg\\\"\", \"urgence\": \"normale\", \"annonce_id\": 5}', NULL, '2025-05-15 13:23:21', '2025-05-15 13:23:21'),
('c65d0dae-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\AnnonceModifieeNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"annonce_modifiee\", \"details\": {\"dates\": {\"fin\": \"20/05/2025\", \"debut\": \"16/05/2025\"}, \"premium\": \"Non\", \"changement\": \"autre\", \"ancien_prix\": \"120.00€\", \"nouveau_prix\": \"120.00€\"}, \"message\": \"✏️ Annonce modifiée : \\\"fgsfrdhtgfjg\\\"\", \"urgence\": \"normale\", \"annonce_id\": 5}', NULL, '2025-05-15 13:23:22', '2025-05-15 13:23:22'),
('ccee9fa3-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\AnnonceModifieeNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"annonce_modifiee\", \"details\": {\"dates\": {\"fin\": \"20/05/2025\", \"debut\": \"16/05/2025\"}, \"premium\": \"Non\", \"changement\": \"autre\", \"ancien_prix\": \"120.00€\", \"nouveau_prix\": \"120.00€\"}, \"message\": \"✏️ Annonce modifiée : \\\"fgsfrdhtgfjg\\\"\", \"urgence\": \"normale\", \"annonce_id\": 5}', NULL, '2025-05-15 13:23:33', '2025-05-15 13:23:33'),
('cd8676e7-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\AnnonceModifieeNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"annonce_modifiee\", \"details\": {\"dates\": {\"fin\": \"20/05/2025\", \"debut\": \"16/05/2025\"}, \"premium\": \"Non\", \"changement\": \"autre\", \"ancien_prix\": \"120.00€\", \"nouveau_prix\": \"120.00€\"}, \"message\": \"✏️ Annonce modifiée : \\\"fgsfrdhtgfjg\\\"\", \"urgence\": \"normale\", \"annonce_id\": 5}', NULL, '2025-05-15 13:23:34', '2025-05-15 13:23:34'),
('d105e4d1-318f-11f0-8f8a-0a002700000b', 'App\\Notifications\\AnnonceModifieeNotification', 'App\\Models\\Utilisateur', 2, '{\"url\": \"http://localhost:8000/annonces/5\", \"type\": \"annonce_modifiee\", \"details\": {\"dates\": {\"fin\": \"20/05/2025\", \"debut\": \"16/05/2025\"}, \"premium\": \"Oui\", \"changement\": \"autre\", \"ancien_prix\": \"120.00€\", \"nouveau_prix\": \"120.00€\"}, \"message\": \"✏️ Annonce modifiée : \\\"fgsfrdhtgfjg\\\"\", \"urgence\": \"normale\", \"annonce_id\": 5}', NULL, '2025-05-15 13:23:40', '2025-05-15 13:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tranche_age` enum('<3','3-5','6-8','9-12','13+') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` enum('Neuf','Bon état','Usage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` bigint UNSIGNED NOT NULL,
  `proprietaire_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `objets_categorie_id_foreign` (`categorie_id`),
  KEY `objets_proprietaire_id_foreign` (`proprietaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `objets`
--

INSERT INTO `objets` (`id`, `date_ajout`, `nom`, `description`, `tranche_age`, `ville`, `etat`, `categorie_id`, `proprietaire_id`, `created_at`, `updated_at`) VALUES
(1, '2025-05-15 05:19:34', 'Lego Star Wars', 'Un set complet de Lego Star Wars.', '<3', 'Tétouan', 'Neuf', 3, 1, '2025-05-14 04:19:34', '2025-05-14 04:19:34'),
(2, '2025-05-15 05:19:34', 'Voiture télécommandée', 'Voiture rapide et résistante.', '<3', 'Tétouan', 'Bon état', 5, 1, '2025-05-14 04:19:34', '2025-05-14 04:19:34'),
(3, '2025-05-15 05:19:34', 'Voiture rouge', 'Voiture rapide.', '<3', 'Tétouan', 'Usage', 3, 1, '2025-05-14 04:19:34', '2025-05-14 04:19:34'),
(4, '2025-05-15 12:05:59', 'jkjkb', 'bhbhkjbjkbjkbjk', '3-5', 'rabat', 'Neuf', 2, 3, '2025-05-15 11:05:59', '2025-05-15 11:05:59'),
(5, '2025-05-15 13:21:52', 'fgsfrdhtgfjg', 'dfzgxbcnh', '6-8', 'tetouan', 'Neuf', 3, 3, '2025-05-15 12:21:52', '2025-05-15 12:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `paiements_clients`
--

DROP TABLE IF EXISTS `paiements_clients`;
CREATE TABLE IF NOT EXISTS `paiements_clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `montant` decimal(8,2) NOT NULL,
  `methode` enum('paypal','especes','carte') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_paiement` timestamp NOT NULL,
  `etat` enum('effectué','annulé','en_attente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `livraison` tinyint(1) NOT NULL DEFAULT '0',
  `montant_livraison` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paiements_clients_reservation_id_foreign` (`reservation_id`),
  KEY `paiements_clients_client_id_foreign` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paiements_clients`
--

INSERT INTO `paiements_clients` (`id`, `reservation_id`, `client_id`, `montant`, `methode`, `date_paiement`, `etat`, `livraison`, `montant_livraison`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 150.00, 'especes', '2025-05-12 04:19:34', 'effectué', 0, 0.00, '2025-05-15 04:19:34', '2025-05-15 04:35:37'),
(2, 2, 2, 300.00, 'paypal', '2025-05-14 04:19:34', 'en_attente', 0, 0.00, '2025-05-15 04:19:34', '2025-05-15 04:19:34'),
(3, 3, 3, 260.00, 'carte', '2025-05-15 12:25:04', 'effectué', 1, 20.00, '2025-05-15 12:25:04', '2025-05-15 12:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `paiements_partenaires`
--

DROP TABLE IF EXISTS `paiements_partenaires`;
CREATE TABLE IF NOT EXISTS `paiements_partenaires` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `annonce_id` bigint UNSIGNED NOT NULL,
  `partenaire_id` bigint UNSIGNED NOT NULL,
  `montant` decimal(8,2) NOT NULL,
  `methode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_paiement` timestamp NOT NULL,
  `periode` enum('7','15','30') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paiements_partenaires_annonce_id_foreign` (`annonce_id`),
  KEY `paiements_partenaires_partenaire_id_foreign` (`partenaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paiements_partenaires`
--

INSERT INTO `paiements_partenaires` (`id`, `annonce_id`, `partenaire_id`, `montant`, `methode`, `date_paiement`, `periode`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 35.00, 'carte', '2025-05-13 04:19:34', '7', '2025-05-15 04:19:34', '2025-05-15 04:19:34'),
(2, 2, 1, 25.00, 'paypal', '2025-05-14 04:19:34', '15', '2025-05-15 04:19:34', '2025-05-15 04:19:34'),
(3, 5, 3, 25.00, 'carte', '2025-05-15 12:23:40', '15', '2025-05-15 12:23:40', '2025-05-15 12:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reclamations`
--

DROP TABLE IF EXISTS `reclamations`;
CREATE TABLE IF NOT EXISTS `reclamations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sujet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reponse` text COLLATE utf8mb4_unicode_ci,
  `statut` enum('en_attente','en_cours','resolue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `piece_jointe` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_reponse` timestamp NULL DEFAULT NULL,
  `utilisateur_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reclamations_utilisateur_id_foreign` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reclamations`
--

INSERT INTO `reclamations` (`id`, `sujet`, `contenu`, `reponse`, `statut`, `piece_jointe`, `date_reponse`, `utilisateur_id`, `created_at`, `updated_at`) VALUES
(1, 'Objet endommagé', 'L\'objet ne correspond pas à la description.', NULL, 'en_cours', NULL, NULL, 1, '2025-05-15 04:19:34', '2025-05-15 04:19:34'),
(2, 'hhiohiohil', 'ihiugiuuioh', 'hiuhiohlkl hlhihio', 'resolue', NULL, '2025-05-15 11:35:19', 3, '2025-05-15 11:35:01', '2025-05-15 11:35:19'),
(3, 'lhhill', 'jnllihl', 'bhjkhjkhjk', 'resolue', NULL, '2025-05-15 11:38:57', 3, '2025-05-15 11:38:41', '2025-05-15 11:38:57'),
(4, 'fbndfhnd', 'hdthdthdt', 'zdffgdghfjhshfg', 'resolue', NULL, '2025-05-15 12:19:48', 3, '2025-05-15 12:19:14', '2025-05-15 12:19:48');

--
-- Triggers `reclamations`
--
DROP TRIGGER IF EXISTS `after_reclamation_update`;
DELIMITER $$
CREATE TRIGGER `after_reclamation_update` AFTER UPDATE ON `reclamations` FOR EACH ROW BEGIN
    IF (NEW.reponse IS NOT NULL AND (OLD.reponse IS NULL OR NEW.reponse != OLD.reponse)) THEN
        INSERT INTO notifications (
            id,
            type,
            notifiable_type,
            notifiable_id,
            data,
            read_at,
            created_at,
            updated_at
        ) VALUES (
            UUID(),
            'App\Notifications\ReclamationRepondueNotification',
            'App\Models\Utilisateur',
            NEW.utilisateur_id,
            JSON_OBJECT(
                'url', CONCAT('http://localhost:8000/reclamations/', NEW.id),
                'type', 'reclamation_reponse',
                'sujet', NEW.sujet,
                'message', CONCAT('Réponse à votre réclamation portant sur "', NEW.sujet, '"'),
                'reponse', NEW.reponse,
                'reclamation_id', NEW.id
            ),
            NULL,
            NOW(),
            NOW()
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `annonce_id` bigint UNSIGNED NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `is_email` tinyint(1) NOT NULL DEFAULT '0',
  `statut` enum('en_attente','confirmée','refusée') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `evaluation_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_client_id_foreign` (`client_id`),
  KEY `reservations_annonce_id_foreign` (`annonce_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `annonce_id`, `date_debut`, `date_fin`, `is_email`, `statut`, `evaluation_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-05-09 00:00:00', '2025-05-15 17:00:00', 0, 'confirmée', NULL, '2025-05-15 04:19:34', '2025-05-15 04:35:37'),
(2, 1, 2, '2025-05-25 00:00:00', '2025-05-30 00:00:00', 0, 'confirmée', NULL, '2025-05-15 04:19:34', '2025-05-15 04:19:34'),
(3, 3, 4, '2025-05-08 00:00:00', '2025-05-15 00:00:00', 0, 'confirmée', '2025-05-15', '2025-05-15 12:25:04', '2025-05-15 12:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fXTTbg8VGnwKLxd8ZeD4cyQQHxh34CPqxpjGuE2a', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFlSY1hLS1VtTzgxdFBNdkZLSHdlbndpeW9FYTNtVVhCN0hFQzJ1TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hbm5vbmNlcz9fdG9rZW49Nm5FYnkya3p5Tk84ZFBWVW1QbWQ4eXB5TjRnY0dNOXptV3JJYlJ4TiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747311853),
('TfRWu3Ae7LkN9395qhe3iWiQBK6Jj1eyuqei6K9T', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDVkZVVKY0NBWWRvUDV5d0hBdE1zZ0ZZUkxqNEVyNnZWc2pXTW5odCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHM/X3Rva2VuPXJndXlsZ3pFclgzWXpYMHY0Sk9odG9rZnVqTE0xTDU0THBtcTU4WUkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1747309973),
('aRe7l3deEG97GmBClGTOTHqiRZs39yxwYddmBwWc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDg2OTZvMWtMNmRZSzM4TkdsWlpicFo0VWtUSTNlVGhsVTR5VElnZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hbm5vbmNlcz9fdG9rZW49c3JhMVBJQ3NCN3IyZTdrRU1zNkhCQUhlejRjQmRWUkEzazBDZHUyMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747311810),
('3DuN4UbcNkzH72qC19mLW6eFHjB72qdPqGOESH8U', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkVEa2dwYlA5S2EyVG1NWVU5MXBOUTltZU1HZDVZY1o0ZGlPb3ZzaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHM/X3Rva2VuPWhoUGVJbXp6YkRBSHdnN1dvRXZLd0JWdjJnUkhwZ09odUJiMkZDVHAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1747312795),
('ID9Gq7QpiB4lNeBfxqY8KIDprdI0s4RCBnqN90H2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUJNV0pod0tSOTh2R2dhbTZnZlpOTTk3TU1KQTRITFR5eGNVYlBYZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHM/X3Rva2VuPWNEREV3SXFkeHRHUWxuWnRkaVg1Q0l0Qmp3QU1QcG5YRGtLUnBhVTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1747311976),
('Py7hljcSV6gwjJmaBeP666kHxONyUbrxeDgzN62c', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVBCRDFkRTlCRVk5ZXh2ZDZCbHJYektFQnlQR0YySm8wdVI4em5BRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHM/X3Rva2VuPU5HOGFiU0RBMFJ0WWcxZDFUYjVCZkd6aVJZVWR3YjRsaGRsSzlta2IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1747314534),
('KtKeylXTgQlO1FzRhqtgXloTK0swJJDCotZYqvfK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHNESW8ycHlPeEt4SEYwdlBwcnB1RUlGaTVmaVRHSEptcVRhQloydiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHM/X3Rva2VuPTh2eWFxelhxQkltaVpwZUVFS041R3NrVEtMUVpMYzdtNkttcGhNU20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1747315932),
('FZuS7hFRlW7VdmI2Q98qdcvDodUab5PO9LAaThdk', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMXZDeFhiNHR3T2hsc0hUcUQ3ZlRnbFFGd3BrQXJ2Qzh6Vm5MVHlGeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc3RhdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo1OiJlcnJvciI7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjU6ImVycm9yIjtzOjM5OiJBY3Rpb24gbm9uIGF1dG9yaXPDqWUgcG91ciB2b3RyZSByw7RsZS4iO30=', 1747315533),
('A6pl1I7VsK1Kv2ElrYHykJa31pVF2AZUOGHKWunL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2xFNUZVZmdsZGdwMWVpU3E2eEtWQ1pXN0dwNWo0NVBEdmxqS29XMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1747315932),
('VM6ScXNZUyrUqGyc2jb6EhJkjq2B3IH38vIPOzxB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR29ocXNvYlZmRHhhTXp5RXZOV1Eza3ZoYjVndEFmVk5BOFFsN29PTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYXJ0ZW5haXJlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1747315886);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-05-15 04:19:34', '$2y$12$WpLVC0pfpVAvpxIcYhQjzu6bgG2KZY8xkRysbZc8HkFHgh13o9pLG', 'WMAr2b06l5', '2025-05-15 04:19:34', '2025-05-15 04:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','partenaire') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `image_profil` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `cin_recto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin_verso` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_annonce` enum('active','desactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `utilisateurs_surnom_unique` (`surnom`),
  UNIQUE KEY `utilisateurs_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `surnom`, `email`, `mot_de_passe`, `role`, `image_profil`, `is_active`, `cin_recto`, `cin_verso`, `email_verified_at`, `created_at`, `updated_at`, `notification_annonce`) VALUES
(1, 'Bensaddik', 'Med', 'bensm', 'mbens@gmail.com', '$2y$12$e0cTU6bvIA.o20ZspBcrjuQQ/5bKbDg8ez/tD27whxowxMJyyIDdq', 'partenaire', 'profile_images/l1wgJMWByc0hO5zgnpaPhIk7MM0EeEm0JHO2QYAC.png', 1, 'cins/6k1Kv5NDplSlwsFp2QnL05HXAB7hGr2A16mDLn4z.png', 'cins/8cr9nAj10QsENjoDNFclrHki5JxR1gY71KI8aX5e.png', '2025-05-15 04:19:34', '2025-05-14 04:19:34', '2025-05-15 04:36:09', 'active'),
(2, 'test', 'test2', 'test2', 'test2@gmail.com', '$2y$12$sVAwiq1XKy.o9RSQfZE/POeb67sgCTErJjk6gfGR5Eg7r//TwymMm', 'client', 'images/profils/profil.jpg', 1, NULL, NULL, '2025-05-15 04:19:34', '2025-05-14 04:19:34', '2025-05-14 04:19:34', 'active'),
(3, 'bhjbhjkbk', 'tes', 'test3', 'test3@gmail.com', '$2y$12$zFbqJ/oXF6Eev4sj1COlG.i7sQKONW.kyZEbBBfIVf3SEiPxhERze', 'client', 'profile_images/YQOhUlcIYOwRfdR1B4XVIc4qGoJlkPMqNEQKkh55.png', 1, 'cins/ZXw0B9QAZ9jbuHK3JRndKaZaOqNjUD1pCFr0TEEd.png', 'cins/TSN3nMYZRGUOpCWtzrZcHMwVUbz9G1tat60wUHhA.png', '2025-05-15 04:19:34', '2025-05-14 04:19:34', '2025-05-15 12:32:07', 'active');

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `send_reservation_notifications_event`$$
CREATE DEFINER=`root`@`localhost` EVENT `send_reservation_notifications_event` ON SCHEDULE EVERY 3 HOUR STARTS '2025-05-15 13:45:43' ON COMPLETION NOT PRESERVE ENABLE DO CALL send_reservation_expiration_notifications_proc()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
