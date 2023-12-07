-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 07 2023 г., 16:09
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'NULL',
  `comment` text NOT NULL DEFAULT 'NULL',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `new_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `declanes`
--

CREATE TABLE `declanes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subscribes_id` bigint(20) UNSIGNED NOT NULL,
  `donor_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `declanes`
--

INSERT INTO `declanes` (`id`, `created_at`, `updated_at`, `subscribes_id`, `donor_id`) VALUES
(1, '2023-11-15 17:31:28', '2023-11-15 17:31:28', 61, 1),
(2, '2023-11-15 17:33:59', '2023-11-15 17:33:59', 61, 1),
(3, '2023-11-16 10:48:14', '2023-11-16 10:48:14', 61, 1),
(4, '2023-11-16 10:48:34', '2023-11-16 10:48:34', 61, 1),
(5, '2023-11-16 10:48:43', '2023-11-16 10:48:43', 61, 1),
(6, '2023-11-16 10:51:08', '2023-11-16 10:51:08', 61, 1),
(7, '2023-11-16 10:51:47', '2023-11-16 10:51:47', 61, 1),
(8, '2023-11-21 13:25:32', '2023-11-21 13:25:32', 61, 1),
(9, '2023-11-28 14:54:21', '2023-11-28 14:54:21', 153, 3),
(10, '2023-11-28 14:54:47', '2023-11-28 14:54:47', 61, 1),
(11, '2023-11-28 14:55:38', '2023-11-28 14:55:38', 153, 3),
(12, '2023-11-28 14:56:04', '2023-11-28 14:56:04', 153, 3),
(13, '2023-11-28 14:57:30', '2023-11-28 14:57:30', 61, 1),
(14, '2023-11-29 15:07:35', '2023-11-29 15:07:35', 61, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `donors`
--

CREATE TABLE `donors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `coast` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `subscribs_amount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) DEFAULT 'approved',
  `offer_reference` varchar(255) NOT NULL DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `donors`
--

INSERT INTO `donors` (`id`, `created_at`, `updated_at`, `user_id`, `name`, `uri`, `theme`, `coast`, `subscribs_amount`, `status`, `offer_reference`) VALUES
(1, '2023-11-03 11:48:55', '2023-11-03 11:48:55', 1, 'localhost', 'https://laravel.su/docs/8.x/eloquent', 'eloquent', 5, 0, 'approved', 'null'),
(3, '2023-11-03 13:33:41', '2023-11-03 13:33:41', 1, 'localhost2', 'https://laravel.com/docs', 'обучение, торговля, вышивание, фигня', 1, 1, 'approved', 'null,5'),
(4, '2023-11-11 13:53:47', '2023-11-11 13:53:47', 1, 'localhost/news', 'http://localhost/redirector/laravel/public/news', 'all themes', 1, 2, 'approved', 'null,19,5'),
(26, '2023-11-29 08:27:15', '2023-11-29 08:27:15', 11, 'localhost тестовый', 'http://localhost/redirector/laravel/public/tests', 'обучение, торговля, вышивание, транспорт', 3, 2, 'approved', 'null,153,151'),
(32, '2023-11-29 12:02:06', '2023-11-29 12:02:06', 11, 'loc', 'https://www.sadovodu.ru', 'обучение, торговля, вышивание, транспорт', 2, 0, 'deleted', 'null'),
(35, '2023-11-29 12:34:48', '2023-11-29 12:34:48', 11, 'locссссс', 'https://www.sadovodu.ru/admin/catalog/', 'обучение, торговля, вышивание', 3, 0, 'deleted', 'null'),
(45, '2023-12-07 14:38:53', '2023-12-07 14:38:53', 11, 'loc', 'https://seller.ozon.ru', 'обучение, торговля, вышивание', 3, 0, 'approved', 'null');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_13_083920_create_contact_models_table', 1),
(6, '2023_09_22_151750_remove__likes_from__contact_models', 1),
(7, '2023_09_22_155340_create_comments_table', 1),
(8, '2023_09_23_061322_set__index__comments', 1),
(9, '2023_09_25_194645_change_index_comments', 1),
(10, '2023_09_26_130739_create_news_models_table', 1),
(11, '2023_10_29_170935_add_role_column_to_users', 2),
(14, '2023_10_31_185059_rename__contact_models_table', 3),
(15, '2023_10_31_203526_rename_columns_in__offers_table', 4),
(19, '2023_10_31_205720_add_columns_in__offers_table', 5),
(20, '2023_10_31_224925_add_foreign_index_to__offers_table', 5),
(24, '2023_11_01_164120_add_columns_in__offers_table', 6),
(25, '2023_11_02_202931_create__donors_table', 6),
(26, '2023_11_02_204902_add_foreign_to__donods_table', 7),
(31, '2023_11_03_165618_create__subscribes_table', 8),
(32, '2023_11_03_170620_add_foreign_to__subscribes_table', 8),
(34, '2023_11_08_203354_add_column_to__donors_table', 9),
(36, '2023_11_11_163215_create__transitions_table', 10),
(37, '2023_11_11_164038_add_foreign_to_transitions_table', 11),
(38, '2023_11_13_172833_drop_collumns__from_transitions_table', 12),
(39, '2023_11_15_135305_add_column_to_users_table', 13),
(40, '2023_11_15_195120_create_declanes_table', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `news_models`
--

CREATE TABLE `news_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thenew` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news_models`
--

INSERT INTO `news_models` (`id`, `name`, `title`, `thenew`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Юлька', 'все говно?', 'все норм', 1, '2023-10-19 17:35:33', '2023-10-19 17:35:33');

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_uri` varchar(255) DEFAULT NULL,
  `link_text` text DEFAULT NULL,
  `site_theme` varchar(255) DEFAULT 'обучение',
  `coast` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `subscribs_amount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `user_id`, `created_at`, `updated_at`, `site_name`, `site_uri`, `link_text`, `site_theme`, `coast`, `subscribs_amount`, `status`) VALUES
(5, 1, '2023-11-01 14:07:37', '2023-11-01 14:07:37', 'sadovodu.ru', 'https://www.sadovodu.ru/admin', 'продажа всего и всем!!!', 'интернет магазин', 1, 2, 'active'),
(19, 1, '2023-11-02 08:21:28', '2023-11-02 08:21:28', 'sadovodu.ru', 'https://www.sadovodu.ru/', 'normal text now!', 'saaaaddd', 1, 1, 'active'),
(151, 10, '2023-11-28 17:26:58', '2023-11-28 17:26:58', 'the new site', 'https://ya.ru', 'yandexxxх', 'yandex', 2, 1, 'active'),
(153, 10, '2023-11-29 08:15:13', '2023-11-29 08:15:13', 'the new site name 2', 'https://parcelsapp.com/freight-tracking', 'отследите свой груз', 'логистика, транспорт', 2, 1, 'active'),
(158, 10, '2023-12-07 15:00:36', '2023-12-07 15:00:36', 'sadovodu.ru/snow', 'https://www.sadovodu.ru/snow', 'новые снегоуборочные машины', 'снегоуборщики', 2, 0, 'deleted');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('dorofeev.i@inbox.ru', '$2y$10$AeaX7ikHOtDx8vzmqT6ma.lMug5/EDQ.jG0hVJGSTNtVRmGnISj5C', '2023-11-28 20:26:35');

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `subscribes`
--

CREATE TABLE `subscribes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `donor_id` bigint(20) UNSIGNED NOT NULL,
  `coast` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subscribes`
--

INSERT INTO `subscribes` (`id`, `created_at`, `updated_at`, `offer_id`, `donor_id`, `coast`, `status`) VALUES
(61, '2023-11-10 14:02:01', '2023-11-10 14:02:01', 19, 1, 1, 'deleted'),
(63, '2023-11-10 16:57:09', '2023-11-10 16:57:09', 19, 3, 1, 'deleted'),
(64, '2023-11-11 13:54:25', '2023-11-11 13:54:25', 19, 4, 5, 'active'),
(65, '2023-11-13 15:05:07', '2023-11-13 15:05:07', 5, 4, 1, 'active'),
(67, '2023-11-23 10:35:40', '2023-11-23 10:35:40', 5, 1, 1, 'deleted'),
(68, '2023-11-23 10:38:00', '2023-11-23 10:38:00', 5, 1, 1, 'deleted'),
(69, '2023-11-23 10:41:21', '2023-11-23 10:41:21', 5, 1, 1, 'deleted'),
(70, '2023-11-23 10:43:12', '2023-11-23 10:43:12', 5, 1, 1, 'deleted'),
(71, '2023-11-23 10:45:51', '2023-11-23 10:45:51', 5, 1, 1, 'deleted'),
(72, '2023-11-23 10:47:29', '2023-11-23 10:47:29', 5, 1, 1, 'deleted'),
(73, '2023-11-23 10:49:06', '2023-11-23 10:49:06', 5, 1, 1, 'deleted'),
(74, '2023-11-23 11:20:07', '2023-11-23 11:20:07', 5, 1, 1, 'deleted'),
(75, '2023-11-23 11:22:45', '2023-11-23 11:22:45', 5, 1, 1, 'deleted'),
(76, '2023-11-23 11:25:23', '2023-11-23 11:25:23', 5, 1, 1, 'deleted'),
(77, '2023-11-23 11:26:09', '2023-11-23 11:26:09', 5, 1, 1, 'deleted'),
(78, '2023-11-23 11:26:57', '2023-11-23 11:26:57', 5, 1, 1, 'deleted'),
(79, '2023-11-23 11:27:33', '2023-11-23 11:27:33', 5, 1, 1, 'deleted'),
(80, '2023-11-23 11:27:36', '2023-11-23 11:27:36', 5, 1, 1, 'deleted'),
(81, '2023-11-23 11:45:43', '2023-11-23 11:45:43', 5, 1, 1, 'deleted'),
(82, '2023-11-23 11:46:58', '2023-11-23 11:46:58', 5, 1, 1, 'deleted'),
(83, '2023-11-23 12:11:22', '2023-11-23 12:11:22', 5, 1, 1, 'deleted'),
(84, '2023-11-23 12:12:27', '2023-11-23 12:12:27', 5, 3, 1, 'deleted'),
(85, '2023-11-23 12:13:58', '2023-11-23 12:13:58', 5, 1, 1, 'deleted'),
(86, '2023-11-23 12:15:04', '2023-11-23 12:15:04', 5, 1, 1, 'deleted'),
(87, '2023-11-23 12:28:14', '2023-11-23 12:28:14', 5, 1, 1, 'deleted'),
(88, '2023-11-23 12:29:26', '2023-11-23 12:29:26', 5, 3, 1, 'deleted'),
(89, '2023-11-23 14:22:24', '2023-11-23 14:22:24', 5, 1, 1, 'deleted'),
(90, '2023-11-23 14:22:29', '2023-11-23 14:22:29', 5, 3, 1, 'deleted'),
(91, '2023-11-23 14:30:14', '2023-11-23 14:30:14', 5, 1, 1, 'deleted'),
(92, '2023-11-23 14:46:11', '2023-11-23 14:46:11', 5, 1, 1, 'deleted'),
(93, '2023-11-23 14:56:48', '2023-11-23 14:56:48', 5, 1, 1, 'deleted'),
(94, '2023-11-23 14:59:01', '2023-11-23 14:59:01', 5, 1, 1, 'deleted'),
(95, '2023-11-23 15:04:18', '2023-11-23 15:04:18', 5, 1, 1, 'deleted'),
(96, '2023-11-23 15:05:20', '2023-11-23 15:05:20', 5, 1, 1, 'deleted'),
(97, '2023-11-23 15:09:00', '2023-11-23 15:09:00', 5, 1, 1, 'deleted'),
(98, '2023-11-23 15:09:08', '2023-11-23 15:09:08', 5, 3, 1, 'deleted'),
(99, '2023-11-23 15:14:15', '2023-11-23 15:14:15', 5, 1, 1, 'deleted'),
(100, '2023-11-23 15:18:50', '2023-11-23 15:18:50', 5, 3, 1, 'deleted'),
(101, '2023-11-23 15:19:05', '2023-11-23 15:19:05', 5, 3, 1, 'deleted'),
(102, '2023-11-23 15:21:59', '2023-11-23 15:21:59', 5, 1, 1, 'deleted'),
(103, '2023-11-23 15:26:09', '2023-11-23 15:26:09', 5, 3, 1, 'deleted'),
(104, '2023-11-23 15:29:35', '2023-11-23 15:29:35', 5, 1, 1, 'deleted'),
(105, '2023-11-23 15:31:05', '2023-11-23 15:31:05', 5, 1, 1, 'deleted'),
(106, '2023-11-23 15:31:48', '2023-11-23 15:31:48', 5, 1, 1, 'deleted'),
(107, '2023-11-23 15:33:36', '2023-11-23 15:33:36', 5, 1, 1, 'deleted'),
(108, '2023-11-23 15:37:37', '2023-11-23 15:37:37', 5, 1, 1, 'deleted'),
(109, '2023-11-23 15:40:10', '2023-11-23 15:40:10', 5, 1, 1, 'deleted'),
(110, '2023-11-23 15:41:15', '2023-11-23 15:41:15', 5, 1, 1, 'deleted'),
(111, '2023-11-23 15:42:47', '2023-11-23 15:42:47', 5, 1, 1, 'deleted'),
(112, '2023-11-23 15:44:38', '2023-11-23 15:44:38', 5, 1, 1, 'deleted'),
(113, '2023-11-23 15:46:41', '2023-11-23 15:46:41', 5, 1, 1, 'deleted'),
(114, '2023-11-23 15:47:09', '2023-11-23 15:47:09', 5, 1, 1, 'deleted'),
(115, '2023-11-23 15:48:23', '2023-11-23 15:48:23', 19, 1, 1, 'deleted'),
(116, '2023-11-24 09:57:55', '2023-11-24 09:57:55', 19, 3, 1, 'deleted'),
(117, '2023-11-24 09:59:57', '2023-11-24 09:59:57', 5, 3, 1, 'deleted'),
(118, '2023-11-24 10:03:38', '2023-11-24 10:03:38', 5, 1, 1, 'deleted'),
(119, '2023-11-24 10:05:31', '2023-11-24 10:05:31', 5, 3, 1, 'deleted'),
(120, '2023-11-24 10:08:14', '2023-11-24 10:08:14', 5, 1, 1, 'deleted'),
(121, '2023-11-24 10:10:50', '2023-11-24 10:10:50', 5, 1, 1, 'deleted'),
(122, '2023-11-24 10:14:42', '2023-11-24 10:14:42', 5, 3, 1, 'deleted'),
(123, '2023-11-24 10:17:26', '2023-11-24 10:17:26', 5, 1, 1, 'deleted'),
(124, '2023-11-24 10:18:44', '2023-11-24 10:18:44', 5, 3, 1, 'deleted'),
(125, '2023-11-24 10:19:32', '2023-11-24 10:19:32', 5, 1, 1, 'deleted'),
(126, '2023-11-24 10:21:30', '2023-11-24 10:21:30', 5, 3, 1, 'deleted'),
(127, '2023-11-24 10:23:42', '2023-11-24 10:23:42', 5, 1, 1, 'deleted'),
(128, '2023-11-24 10:33:30', '2023-11-24 10:33:30', 5, 3, 1, 'deleted'),
(129, '2023-11-24 10:34:33', '2023-11-24 10:34:33', 5, 1, 1, 'deleted'),
(130, '2023-11-24 10:36:17', '2023-11-24 10:36:17', 5, 3, 1, 'deleted'),
(131, '2023-11-24 10:44:52', '2023-11-24 10:44:52', 5, 1, 1, 'deleted'),
(132, '2023-11-24 10:48:24', '2023-11-24 10:48:24', 5, 3, 1, 'deleted'),
(133, '2023-11-24 10:51:55', '2023-11-24 10:51:55', 5, 1, 1, 'deleted'),
(134, '2023-11-24 10:53:08', '2023-11-24 10:53:08', 5, 3, 1, 'deleted'),
(135, '2023-11-24 10:53:14', '2023-11-24 10:53:14', 19, 1, 1, 'deleted'),
(136, '2023-11-24 10:53:19', '2023-11-24 10:53:19', 19, 3, 1, 'deleted'),
(137, '2023-11-24 10:54:22', '2023-11-24 10:54:22', 19, 3, 1, 'deleted'),
(138, '2023-11-24 11:01:36', '2023-11-24 11:01:36', 19, 3, 1, 'deleted'),
(139, '2023-11-24 11:04:48', '2023-11-24 11:04:48', 19, 3, 1, 'deleted'),
(140, '2023-11-24 11:05:50', '2023-11-24 11:05:50', 19, 3, 1, 'deleted'),
(141, '2023-11-24 11:07:26', '2023-11-24 11:07:26', 19, 3, 1, 'deleted'),
(142, '2023-11-24 11:22:45', '2023-11-24 11:22:45', 19, 3, 1, 'deleted'),
(143, '2023-11-24 11:22:53', '2023-11-24 11:22:53', 19, 1, 1, 'deleted'),
(144, '2023-11-24 11:24:49', '2023-11-24 11:24:49', 5, 1, 1, 'deleted'),
(145, '2023-11-24 11:31:38', '2023-11-24 11:31:38', 5, 1, 1, 'deleted'),
(146, '2023-11-24 11:34:59', '2023-11-24 11:34:59', 5, 1, 1, 'deleted'),
(147, '2023-11-24 11:40:04', '2023-11-24 11:40:04', 5, 1, 1, 'deleted'),
(148, '2023-11-24 11:52:45', '2023-11-24 11:52:45', 19, 1, 1, 'deleted'),
(149, '2023-11-24 12:27:53', '2023-11-24 12:27:53', 5, 1, 1, 'deleted'),
(150, '2023-11-24 12:29:05', '2023-11-24 12:29:05', 5, 1, 1, 'deleted'),
(151, '2023-11-24 12:29:52', '2023-11-24 12:29:52', 5, 1, 1, 'deleted'),
(152, '2023-11-24 12:29:56', '2023-11-24 12:29:56', 5, 3, 1, 'deleted'),
(153, '2023-11-24 12:38:26', '2023-11-24 12:38:26', 5, 3, 1, 'active'),
(154, '2023-11-29 08:53:52', '2023-11-29 08:53:52', 153, 26, 2, 'active'),
(155, '2023-11-29 12:58:43', '2023-11-29 12:58:43', 151, 26, 2, 'deleted'),
(156, '2023-11-29 12:59:04', '2023-11-29 12:59:04', 151, 32, 2, 'deleted'),
(157, '2023-11-29 12:59:09', '2023-11-29 12:59:09', 151, 35, 2, 'deleted'),
(158, '2023-11-29 13:01:43', '2023-11-29 13:01:43', 151, 26, 2, 'deleted'),
(159, '2023-11-29 13:09:22', '2023-11-29 13:09:22', 151, 26, 2, 'deleted'),
(160, '2023-11-29 13:09:33', '2023-11-29 13:09:33', 151, 32, 2, 'deleted'),
(161, '2023-11-29 13:09:41', '2023-11-29 13:09:41', 151, 35, 2, 'deleted'),
(162, '2023-11-29 14:39:36', '2023-11-29 14:39:36', 151, 26, 2, 'active'),
(163, '2023-11-29 15:01:21', '2023-11-29 15:01:21', 19, 32, 1, 'deleted'),
(164, '2023-12-07 15:01:35', '2023-12-07 15:01:35', 158, 26, 2, 'deleted');

-- --------------------------------------------------------

--
-- Структура таблицы `transitions`
--

CREATE TABLE `transitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subscribes_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `transitions`
--

INSERT INTO `transitions` (`id`, `created_at`, `updated_at`, `subscribes_id`) VALUES
(1, '2023-11-13 16:38:30', '2023-11-13 16:38:30', 65),
(2, '2023-11-13 16:40:48', '2023-11-13 16:40:48', 65),
(3, '2023-11-13 16:40:58', '2023-11-13 16:40:58', 65),
(4, '2023-11-13 16:41:15', '2023-11-13 16:41:15', 65),
(5, '2023-11-13 16:41:45', '2023-11-13 16:41:45', 65),
(6, '2023-11-13 16:42:38', '2023-11-13 16:42:38', 65),
(7, '2023-11-13 16:43:38', '2023-11-13 16:43:38', 65),
(8, '2023-11-13 16:43:38', '2023-11-13 16:43:38', 65),
(9, '2023-11-13 16:47:23', '2023-11-13 16:47:23', 65),
(10, '2023-11-14 11:33:52', '2023-11-14 11:33:52', 64),
(11, '2023-11-15 17:20:52', '2023-11-15 17:20:52', 64),
(12, '2023-11-15 17:51:43', '2023-11-15 17:51:43', 64),
(13, '2023-11-16 10:21:15', '2023-11-16 10:21:15', 64),
(14, '2023-11-16 10:22:59', '2023-11-16 10:22:59', 64),
(15, '2023-11-21 13:11:00', '2023-11-21 13:11:00', 64),
(16, '2023-11-21 13:11:30', '2023-11-21 13:11:30', 64),
(17, '2023-11-21 13:19:29', '2023-11-21 13:19:29', 64),
(18, '2023-11-21 13:22:15', '2023-11-21 13:22:15', 64),
(19, '2023-11-21 13:24:12', '2023-11-21 13:24:12', 64),
(20, '2023-11-21 13:27:51', '2023-11-21 13:27:51', 64),
(21, '2023-11-27 16:37:51', '2023-11-27 16:37:51', 64),
(22, '2023-11-28 14:54:17', '2023-11-28 14:54:17', 64),
(23, '2023-11-28 14:54:42', '2023-11-28 14:54:42', 65),
(24, '2023-11-28 14:57:23', '2023-11-28 14:57:23', 64),
(25, '2023-11-28 14:57:27', '2023-11-28 14:57:27', 65),
(26, '2023-11-29 08:55:32', '2023-11-29 08:55:32', 154),
(27, '2023-11-29 15:07:19', '2023-11-29 15:07:19', 64),
(28, '2023-11-29 15:07:28', '2023-11-29 15:07:28', 65);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('client','web_master','admin') NOT NULL DEFAULT 'client',
  `status` varchar(255) NOT NULL DEFAULT 'authorized'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'ivan', 'a@a.a', NULL, '$2y$10$eqS2mtwqhhykxlFOXVgxc.qdrQHht8pVohmaqgiNAb0xOaX0/Tr7G', '0DOBjaIR5aVz3W2KGheDWtfDgrArG3U9Z6h9hdQFuSAuOOyoOyY3bEzahms5', '2023-10-17 16:02:08', '2023-10-17 16:02:08', 'admin', 'authorized'),
(2, 'Flossie Barton', 'bobby.watsica@example.org', '2023-10-17 16:03:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'z0T260GNlG', '2023-10-17 16:03:22', '2023-10-17 16:03:22', 'client', 'authorized'),
(3, 'Test User', 'test@example.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MBYeoTKiCB', '2023-10-17 16:03:22', '2023-10-17 16:03:22', 'client', 'authorized'),
(4, 'Test User', 'devonte.goyette@example.org', '2023-10-17 16:03:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PBLNjDOSLx', '2023-10-17 16:03:22', '2023-10-17 16:03:22', 'client', 'authorized'),
(6, 'Lucious Hintz', 'fklein@example.com', '2023-10-17 16:03:22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vZMLcjhhfe', '2023-10-17 16:03:22', '2023-10-17 16:03:22', 'client', 'authorized'),
(7, 'bob', 'b@b.b', NULL, '$2y$10$Y56.WGB5DQNaA3PIvzM31ecB/qL5JbnphqXiMnoZm0z9Sy6KuprEG', NULL, '2023-10-29 16:56:31', '2023-10-29 16:56:31', 'client', 'authorized'),
(9, 'sam', 's@s.s', NULL, '$2y$10$O3sgriCUQWjqkpoOUSGbMeyUzyY9oZA91K40qtsu7Gpfg.FvZRUti', 'XfxMDtHBt5QZCa93TKSAAjdkxpCUxZhR3WnuGi7BXUsd29fa8EvD2j5M5H62', '2023-10-29 17:20:22', '2023-10-29 17:20:22', 'web_master', 'authorized'),
(10, 'Клиентик', 'dorofeev.i@inbox.ru', NULL, '$2y$10$ZhHe/AmKGe8mR/FhFCv/P.Dc6WkpWc1YZTBvCu13y4YVRAWvGZ0uO', 'o81NUQ4LuNOJftv4dwo8lqtCsuFzenWgGYwmZ09bJP49VYoH4zHukMmYbNjD', '2023-11-28 17:24:21', '2023-11-28 20:25:46', 'client', 'authorized'),
(11, 'Web master', 'd@d.d', NULL, '$2y$10$fdIgyKc3zAWeS5WpZWpHyeidsT61g.pk0MS7cguyDRfzs5unftcJu', 'FFJCYJiEwDwBS74cwXeq0iU5PHuoQYJc8U6Et9rFqqt9SalHQZJVpt5uUQs7', '2023-11-29 08:16:23', '2023-11-29 14:38:55', 'web_master', 'authorized'),
(12, 'админ', 'admin@admin.ru', NULL, '$2y$10$7OgVr6b2KfNZ.vyLWLXWv../AomNZQ1OuHMs0jIY0ztO/Qy7hl2CG', 'vRJ4pKZs6UnlFrze3W2inKskLH33jlKC8xqjsGGXCQu90nWJwRhbr9DgfgjW', '2023-11-29 09:25:28', '2023-11-29 09:25:28', 'admin', 'authorized');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_name_index` (`name`);

--
-- Индексы таблицы `declanes`
--
ALTER TABLE `declanes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `declanes_subscribes_id_foreign` (`subscribes_id`),
  ADD KEY `declanes_donor_id_foreign` (`donor_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Индексы таблицы `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donors_user_id_foreign` (`user_id`),
  ADD KEY `uri` (`uri`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news_models`
--
ALTER TABLE `news_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_models_name_index` (`name`);

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_user_id_foreign` (`user_id`),
  ADD KEY `site_uri` (`site_uri`),
  ADD KEY `subscribes_amount` (`subscribs_amount`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscribes_offer_id_foreign` (`offer_id`),
  ADD KEY `subscribes_donor_id_foreign` (`donor_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Индексы таблицы `transitions`
--
ALTER TABLE `transitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transitions_subscribes _id_foreign` (`subscribes_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `declanes`
--
ALTER TABLE `declanes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `donors`
--
ALTER TABLE `donors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `news_models`
--
ALTER TABLE `news_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT для таблицы `transitions`
--
ALTER TABLE `transitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `offers` (`id`);

--
-- Ограничения внешнего ключа таблицы `declanes`
--
ALTER TABLE `declanes`
  ADD CONSTRAINT `declanes_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`),
  ADD CONSTRAINT `declanes_subscribes_id_foreign` FOREIGN KEY (`subscribes_id`) REFERENCES `subscribes` (`id`);

--
-- Ограничения внешнего ключа таблицы `donors`
--
ALTER TABLE `donors`
  ADD CONSTRAINT `donors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `subscribes`
--
ALTER TABLE `subscribes`
  ADD CONSTRAINT `subscribes_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`),
  ADD CONSTRAINT `subscribes_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`);

--
-- Ограничения внешнего ключа таблицы `transitions`
--
ALTER TABLE `transitions`
  ADD CONSTRAINT `transitions_subscribes _id_foreign` FOREIGN KEY (`subscribes_id`) REFERENCES `subscribes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
