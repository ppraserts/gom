-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2016 at 11:56 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gom`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int(10) UNSIGNED NOT NULL,
  `aboutus_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `aboutus_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`id`, `aboutus_description_th`, `aboutus_description_en`, `created_at`, `updated_at`) VALUES
(1, '<p>นับตั้งแต่ประเทศไทยเข้าเป็นสมาชิกองค์การการค้าโลก (World Trade Organization : WTO) ในฐานะผู้ร่วมก่อตั้งร่วมกับประเทศอื่นๆ อีก 80 ประเทศ เมื่อวันที่ 28 ธันวาคม พ.ศ. 2537 มีการบังคับใช้ความตกลงด้านสุขอนามัยและสุขอนามัยพืช(Agreement on the Application of Sanitary and Phytosanitary Measures : SPS) ที่กำหนดกติกาให้ประเทศต่างๆ ใช้มาตรการด้านมาตรฐานและความปลอดภัยอาหาร ควบคุมการส่งออกนำเข้าสินค้าเกษตรและอาหาร ทำให้กระทรวงเกษตรและสหกรณ์ ตระหนักถึงความสำคัญในการแข่งขันทางการค้าสินค้าเกษตรและอาหารในต่างประเทศที่จะทวีความรุนแรงมากขึ้น&nbsp;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยเหตุนี้ จึงได้มีการปรับโครงสร้างองค์กรเพื่อรองรับการเปลี่ยนแปลงดังกล่าว โดยในปี พ.ศ. 2540 ได้จัดตั้ง สำนักงานมาตรฐานและตรวจสอบสินค้าเกษตร (สมก.) เป็นหน่วยงานสังกัดสำนักงานปลัดกระทรวงเกษตรและสหกรณ์ เพื่อเป็นศูนย์กลางในการประสานงานและพัฒนามาตรฐานสินค้าเกษตรของประเทศให้สอดคล้องกับมาตรฐานสากล โดยร่วมมือกับหน่วยงานต่างๆภายในกระทรวงเกษตรและสหกรณ์ มุ่งการให้บริการแบบเบ็ดเสร็จในการนำเข้าและส่งออกสินค้าเกษตร&nbsp;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จนกระทั่งพระราชบัญญัติปรับปรุงโครงสร้างกระทรวง ทบวง กรม มีผลบังคับใช้เมื่อปี 2545 สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ (มกอช.) จึงได้รับการจัดตั้งขึ้นในวันที่ 9 ตุลาคม พ.ศ. 2545 ตามกฎกระทรวงแบ่งส่วนราชการ สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ กระทรวงเกษตรและสหกรณ์ พ.ศ. 2545 โดยอาศัยอำนาจตามความในมาตรา 8 ฉ แห่งพระราชบัญญัติระเบียบบริหารราชการแผ่นดิน (ฉบับที่ 4) พ.ศ. 2543 เป็นหน่วยงานระดับกรม ภายใต้กระทรวงเกษตรและสหกรณ์</p>\r\n', '<p>นับตั้งแต่ประเทศไทยเข้าเป็นสมาชิกองค์การการค้าโลก (World Trade Organization : WTO) ในฐานะผู้ร่วมก่อตั้งร่วมกับประเทศอื่นๆ อีก 80 ประเทศ เมื่อวันที่ 28 ธันวาคม พ.ศ. 2537 มีการบังคับใช้ความตกลงด้านสุขอนามัยและสุขอนามัยพืช(Agreement on the Application of Sanitary and Phytosanitary Measures : SPS) ที่กำหนดกติกาให้ประเทศต่างๆ ใช้มาตรการด้านมาตรฐานและความปลอดภัยอาหาร ควบคุมการส่งออกนำเข้าสินค้าเกษตรและอาหาร ทำให้กระทรวงเกษตรและสหกรณ์ ตระหนักถึงความสำคัญในการแข่งขันทางการค้าสินค้าเกษตรและอาหารในต่างประเทศที่จะทวีความรุนแรงมากขึ้น&nbsp;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยเหตุนี้ จึงได้มีการปรับโครงสร้างองค์กรเพื่อรองรับการเปลี่ยนแปลงดังกล่าว โดยในปี พ.ศ. 2540 ได้จัดตั้ง สำนักงานมาตรฐานและตรวจสอบสินค้าเกษตร (สมก.) เป็นหน่วยงานสังกัดสำนักงานปลัดกระทรวงเกษตรและสหกรณ์ เพื่อเป็นศูนย์กลางในการประสานงานและพัฒนามาตรฐานสินค้าเกษตรของประเทศให้สอดคล้องกับมาตรฐานสากล โดยร่วมมือกับหน่วยงานต่างๆภายในกระทรวงเกษตรและสหกรณ์ มุ่งการให้บริการแบบเบ็ดเสร็จในการนำเข้าและส่งออกสินค้าเกษตร&nbsp;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จนกระทั่งพระราชบัญญัติปรับปรุงโครงสร้างกระทรวง ทบวง กรม มีผลบังคับใช้เมื่อปี 2545 สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ (มกอช.) จึงได้รับการจัดตั้งขึ้นในวันที่ 9 ตุลาคม พ.ศ. 2545 ตามกฎกระทรวงแบ่งส่วนราชการ สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ กระทรวงเกษตรและสหกรณ์ พ.ศ. 2545 โดยอาศัยอำนาจตามความในมาตรา 8 ฉ แห่งพระราชบัญญัติระเบียบบริหารราชการแผ่นดิน (ฉบับที่ 4) พ.ศ. 2543 เป็นหน่วยงานระดับกรม ภายใต้กระทรวงเกษตรและสหกรณ์</p>\r\n', '2016-09-24 20:43:03', '2016-11-05 07:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'W',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `usertype`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin admin', 'ppraserts@gmail.com', '$2y$10$RqioPwsdr0I.C01EyrulAe6Ari8.rSQR6MNyFGmHYZblpXGMfEBlu', 'W', '7LGNJ6p4lvZEEOrs6Nonn2uqN4rYBbEbsRSLUQq5zg6zcjCWIO6oVG8lwLl5', '2016-09-12 03:16:24', '2016-11-07 02:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `admins_password_resets`
--

CREATE TABLE `admins_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(10) UNSIGNED NOT NULL,
  `contactus_address_th` text COLLATE utf8_unicode_ci NOT NULL,
  `contactus_address_en` text COLLATE utf8_unicode_ci NOT NULL,
  `contactus_latitude` decimal(11,8) NOT NULL,
  `contactus_longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `contactus_address_th`, `contactus_address_en`, `contactus_latitude`, `contactus_longitude`, `created_at`, `updated_at`) VALUES
(1, '<p>&nbsp; &nbsp;ที่ตั้ง สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ&nbsp;<br />\r\n&nbsp; &nbsp;เลขที่ 50 ถนนพหลโยธิน แขวงลาดยาว เขตจตุจักร กรุงเทพมหานคร 10900&nbsp;<br />\r\n&nbsp; &nbsp;โทรศัพท์ +662- 561-2277&nbsp;<br />\r\n&nbsp; &nbsp;ข้อเสนอแนะติดต่อ itc@acfs.go.th</p>\r\n', '<p>&nbsp; &nbsp;ที่ตั้ง สำนักงานมาตรฐานสินค้าเกษตรและอาหารแห่งชาติ&nbsp;<br />\r\n&nbsp; &nbsp;เลขที่ 50 ถนนพหลโยธิน แขวงลาดยาว เขตจตุจักร กรุงเทพมหานคร 10900&nbsp;<br />\r\n&nbsp; &nbsp;โทรศัพท์ +662- 561-2277&nbsp;<br />\r\n&nbsp; &nbsp;ข้อเสนอแนะติดต่อ itc@acfs.go.th</p>\r\n', '13.75633100', '100.50176500', '2016-11-04 02:39:59', '2016-11-04 02:41:18');

-- --------------------------------------------------------

--
-- Table structure for table `contactusform`
--

CREATE TABLE `contactusform` (
  `id` int(10) UNSIGNED NOT NULL,
  `contactusform_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactusform_messagebox` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `downloaddocuments`
--

CREATE TABLE `downloaddocuments` (
  `id` int(10) UNSIGNED NOT NULL,
  `downloaddocument_title_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `downloaddocument_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `downloaddocument_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `downloaddocument_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `downloaddocument_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(10) UNSIGNED NOT NULL,
  `faq_question_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faq_answer_th` text COLLATE utf8_unicode_ci NOT NULL,
  `faq_question_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faq_answer_en` text COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `faqcategory_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `faq_question_th`, `faq_answer_th`, `faq_question_en`, `faq_answer_en`, `sequence`, `created_at`, `updated_at`, `faqcategory_id`) VALUES
(1, 'Is account registration required?', '<p>Account registration at&nbsp;<strong>PrepBootstrap</strong>&nbsp;is only required if you will be selling or buying themes. This ensures a valid communication channel for all parties involved in any transactions.</p>\r\n', 'Is account registration required?', '<p>Account registration at&nbsp;<strong>PrepBootstrap</strong>&nbsp;is only required if you will be selling or buying themes. This ensures a valid communication channel for all parties involved in any transactions.</p>\r\n', 999, '2016-11-04 23:12:20', '2016-11-04 23:12:20', 1),
(2, 'Can I submit my own Bootstrap templates or themes?', '<p>A lot of the content of the site has been submitted by the community. Whether it is a commercial element/template/theme or a free one, you are encouraged to contribute. All credits are published along with the resources.</p>\r\n', 'Can I submit my own Bootstrap templates or themes?', '<p>A lot of the content of the site has been submitted by the community. Whether it is a commercial element/template/theme or a free one, you are encouraged to contribute. All credits are published along with the resources.</p>\r\n', 999, '2016-11-04 23:12:39', '2016-11-04 23:12:39', 1),
(3, 'What is the currency used for all transactions?', '<p>All prices for themes, templates and other items, including each seller&#39;s or buyer&#39;s account balance are in&nbsp;<strong>USD</strong></p>\r\n', 'What is the currency used for all transactions?', '<p>All prices for themes, templates and other items, including each seller&#39;s or buyer&#39;s account balance are in&nbsp;<strong>USD</strong></p>\r\n', 999, '2016-11-04 23:13:02', '2016-11-04 23:13:02', 1),
(4, 'Who cen sell items?', '<p>Any registed user, who presents a work, which is genuine and appealing, can post it on&nbsp;<strong>PrepBootstrap</strong>.</p>\r\n', 'Who cen sell items?', '<p>Any registed user, who presents a work, which is genuine and appealing, can post it on&nbsp;<strong>PrepBootstrap</strong>.</p>\r\n', 999, '2016-11-04 23:13:29', '2016-11-04 23:13:29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `faqcategorys`
--

CREATE TABLE `faqcategorys` (
  `id` int(10) UNSIGNED NOT NULL,
  `faqcategory_title_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faqcategory_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `faqcategory_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faqcategory_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faqcategorys`
--

INSERT INTO `faqcategorys` (`id`, `faqcategory_title_th`, `faqcategory_description_th`, `faqcategory_title_en`, `faqcategory_description_en`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'สินค้า', '<p>พบกับคำถามพบบ่อยและบทความน่ารู้เกี่ยวกับบริการหลัก AIS GSM และ One-2-Call</p>\r\n', 'Product', '<p>AIS GSM and One-2-Call</p>\r\n', 999, '2016-09-29 00:17:54', '2016-11-05 07:46:57'),
(2, 'บริการ', 'บริการเสริมต่างๆ จากเอไอเอสมีอะไรบ้าง และให้ประโยชน์อย่างไร เรามีคำตอบให้ที่นี่', 'Service', 'Service', 999, '2016-09-29 00:20:31', '2016-09-29 00:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` int(10) UNSIGNED NOT NULL,
  `market_title_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `market_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `market_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `market_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `marketimage_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `market_title_th`, `market_description_th`, `market_title_en`, `market_description_en`, `marketimage_file`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'ตลาดเกษตรอินทรีย์', 'สินค้าเกษตรปลอดสารพิษ', 'ตลาดเกษตรอินทรีย์', 'สินค้าเกษตรปลอดสารพิษ', 'upload/market/1478246940/01.jpg', 1, '2016-09-24 20:43:03', '2016-11-04 01:09:00'),
(2, 'ตลาดระบบตามสอบสินค้นเกษตร', 'สินค้าเกษตรที่มี QR Code ในการตรวจสอบ', 'ตลาดระบบตามสอบสินค้นเกษตร', 'สินค้าเกษตรที่มี QR Code ในการตรวจสอบ', 'upload/market/1478246986/02.jpg', 2, '2016-09-24 20:43:03', '2016-11-04 01:09:46'),
(3, 'ตลาดแปลงใหญ่', 'สินค้าที่รวบรวมจากตลาดแปลงใหญ่', 'ตลาดแปลงใหญ่', 'สินค้าที่รวบรวมจากตลาดแปลงใหญ่', 'upload/market/1478247162/03.jpg', 3, '2016-09-24 20:43:03', '2016-11-04 01:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

CREATE TABLE `medias` (
  `id` int(10) UNSIGNED NOT NULL,
  `media_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_name_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_urllink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000001_create_users_table', 1),
(2, '2014_10_12_000002_create_password_resets_table', 1),
(3, '2016_09_12_000003_create_aboutus_table', 1),
(4, '2016_09_12_000004_create_contactus_table', 1),
(5, '2016_09_12_000005_create_contactusform_table', 1),
(6, '2016_09_12_000006_create_downloaddocument_table', 1),
(7, '2016_09_12_000007_create_media_table', 1),
(8, '2016_09_12_000008_create_slideimage_table', 1),
(9, '2016_09_12_000009_create_faqcategory_table', 1),
(10, '2016_09_12_000010_create_faq_table', 1),
(11, '2016_09_12_000011_create_productcategory_table', 1),
(12, '2016_10_02_151847_add_column_to_users', 1),
(13, '2016_11_04_062415_create_market_table', 2),
(17, '2016_11_05_114737_create_admins_table', 3),
(18, '2016_11_05_114801_create_admins_passowrd_resets_table', 3),
(19, '2016_11_06_023513_addcolumns_users_table', 3),
(20, '2016_11_06_072902_addcolumns2_users_table', 4),
(22, '2016_11_06_124806_create_products_table', 5),
(24, '2016_11_07_062218_create_news_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `news_title_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `news_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `news_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `news_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `news_created_at` date NOT NULL,
  `news_place` text COLLATE utf8_unicode_ci NOT NULL,
  `news_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `news_sponsor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `news_document_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_title_th`, `news_description_th`, `news_title_en`, `news_description_en`, `news_created_at`, `news_place`, `news_tags`, `news_sponsor`, `news_document_file`, `sequence`, `created_at`, `updated_at`) VALUES
(4, 'รัสเซียห้ามการนำเข้าเกลือจาก EU และ ยูเครน', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; พระราชกฤษฎีกาของรัสเซียว่าด้วยการห้ามนำเข้าเกลือจากต่างประเทศต่าง ที่มีมาตรการคว่ำบาตรรัสเซีย มีผลบังคับใช้แล้วตั้งแต่วันที่ 1 พฤศจิกายน 2559 โดยมาตรการตอบโต้ครั้งนี้ส่งผลกระทบต่อ 26 ประเทศที่ คิดเป็นปริมาณเกลือถึง 424,300 ตัน หรือร้อยละ 40.2 ของเกลือที่รัสเซียนำเข้าทั้งหมดตั้งแต่ต้นปีจนถึงเดือนสิงหาคม 2559 โดยเฉพาะอย่างยิ่ง เมื่อเทียบจากสถิติในปี 2558 จะส่งผลต่อสหภาพยุโรปซึ่งเป็นกลุ่มประเทศมีส่วนแบ่งตลาดเกลือบริโภคถึงร้อยละ 17.8 และส่วนแบ่งตลาดเกลือที่ใช้ในภาคอุตสาหกรรมถึงร้อยละ 63.9 ในรัสเซีย</p>\r\n\r\n<p><br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อนึ่ง แม้ว่ารัสเซียจะห้ามนำเข้าเกลือจากประเทศต่างๆ ในปริมาณมากเช่นนี้ แต่คาดการณ์ว่าจะไม่กระทบต่อการบริโภคเกลือในประเทศ เนื่องจากผู้ผลิตรายใหญ่หลายรายในรัสเซียได้ออกมาขานรับมาตรการดังกล่าว โดยเร่งเพิ่มการผลิตเกลือในปี 2559 นี้อีกร้อยละ 15 ซึ่งทำให้มีเกลือเพียงพอต่อปริมาณความต้องการในประเทศ ทั้งนี้ รัสเซียมีความต้องการเกลือในการทำอาหารโดยเฉลี่ย 1.3 ล้านตัน/ปี และต้องการเกลือในอุตสาหกรรมโดยเฉลี่ย 4 ล้านตัน/ปี ในขณะที่กำลังการผลิตเกลือในประเทศมีราว 3.6 ล้านตัน/ปี</p>\r\n', 'รัสเซียห้ามการนำเข้าเกลือจาก EU และ ยูเครน', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; พระราชกฤษฎีกาของรัสเซียว่าด้วยการห้ามนำเข้าเกลือจากต่างประเทศต่าง ที่มีมาตรการคว่ำบาตรรัสเซีย มีผลบังคับใช้แล้วตั้งแต่วันที่ 1 พฤศจิกายน 2559 โดยมาตรการตอบโต้ครั้งนี้ส่งผลกระทบต่อ 26 ประเทศที่ คิดเป็นปริมาณเกลือถึง 424,300 ตัน หรือร้อยละ 40.2 ของเกลือที่รัสเซียนำเข้าทั้งหมดตั้งแต่ต้นปีจนถึงเดือนสิงหาคม 2559 โดยเฉพาะอย่างยิ่ง เมื่อเทียบจากสถิติในปี 2558 จะส่งผลต่อสหภาพยุโรปซึ่งเป็นกลุ่มประเทศมีส่วนแบ่งตลาดเกลือบริโภคถึงร้อยละ 17.8 และส่วนแบ่งตลาดเกลือที่ใช้ในภาคอุตสาหกรรมถึงร้อยละ 63.9 ในรัสเซีย</p>\r\n\r\n<p><br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; อนึ่ง แม้ว่ารัสเซียจะห้ามนำเข้าเกลือจากประเทศต่างๆ ในปริมาณมากเช่นนี้ แต่คาดการณ์ว่าจะไม่กระทบต่อการบริโภคเกลือในประเทศ เนื่องจากผู้ผลิตรายใหญ่หลายรายในรัสเซียได้ออกมาขานรับมาตรการดังกล่าว โดยเร่งเพิ่มการผลิตเกลือในปี 2559 นี้อีกร้อยละ 15 ซึ่งทำให้มีเกลือเพียงพอต่อปริมาณความต้องการในประเทศ ทั้งนี้ รัสเซียมีความต้องการเกลือในการทำอาหารโดยเฉลี่ย 1.3 ล้านตัน/ปี และต้องการเกลือในอุตสาหกรรมโดยเฉลี่ย 4 ล้านตัน/ปี ในขณะที่กำลังการผลิตเกลือในประเทศมีราว 3.6 ล้านตัน/ปี</p>\r\n', '2016-11-07', '-', 'ข่าวทั่วไป', '-', '', 999, '2016-11-07 01:52:33', '2016-11-07 01:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productcategorys`
--

CREATE TABLE `productcategorys` (
  `id` int(10) UNSIGNED NOT NULL,
  `productcategory_title_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productcategory_description_th` text COLLATE utf8_unicode_ci NOT NULL,
  `productcategory_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productcategory_description_en` text COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `productcategorys`
--

INSERT INTO `productcategorys` (`id`, `productcategory_title_th`, `productcategory_description_th`, `productcategory_title_en`, `productcategory_description_en`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'ผัก', 'พืชที่มนุษย์นำส่วนใดส่วนหนึ่งของพืชอาทิ ผล ใบ ราก ดอก หรือลำต้น มาประกอบอาหาร[1] ซึ่งไม่นับรวมผลไม้ ถั่ว สมุนไพร และเครื่องเทศ แต่เห็ด ซึ่งในทางชีววิทยาจัดเป็นพวกเห็ดรา ก็นับรวมเป็นผักด้วย', 'Vegetable', 'any part of a plant that is consumed by humans as food as part of a savory meal. The term vegetable is somewhat arbitrary, and largely defined through culinary and cultural tradition. It normally excludes other food derived from plants such as fruits, nuts and cereal grains, but includes seeds such as pulses. The original meaning of the word vegetable, still used in biology, was to describe all types of plant, as in the terms "vegetable kingdom" and "vegetable matter".', 1, '2016-09-18 00:05:06', '2016-09-18 00:29:59'),
(2, 'ผลไม้', ' ผลที่เกิดจากการขยายพันธุ์โดยอาศัยเพศของพืชบางชนิด ซึ่งมนุษย์สามารถรับประทานได้ และส่วนมากจะไม่ทำเป็นอาหารคาว ตัวอย่างผลไม้ เช่น ส้ม แอปเปิ้ล กล้วย มะม่วง ทุเรียน รวมถึง มะเขือเทศ ที่สามารถจัดได้ว่าเป็นทั้งผักและผลไม้. จุ๋ม', 'Fruit', 'the seed-bearing structure in flowering plants (also known as angiosperms) formed from the ovary after flowering.', 1, '2016-09-18 00:26:27', '2016-09-18 00:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_name_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `productcategory_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name_th`, `product_name_en`, `created_at`, `updated_at`, `sequence`, `productcategory_id`) VALUES
(1, 'ผักบุ้ง', 'ผักบุ้ง', '2016-11-06 06:47:08', '2016-11-06 06:47:08', 999, 1),
(2, 'คะน้า', 'คะน้า', '2016-11-06 06:47:31', '2016-11-06 06:47:31', 999, 1),
(3, 'ตำลึง', 'ตำลึง', '2016-11-06 06:47:39', '2016-11-06 06:47:39', 999, 1),
(4, 'ชะอม', 'ชะอม', '2016-11-06 06:47:49', '2016-11-06 06:47:49', 999, 1),
(5, 'ผักกาดขาว', 'ผักกาดขาว', '2016-11-06 06:48:01', '2016-11-06 06:48:01', 999, 1),
(6, 'มังคุด', 'มังคุด', '2016-11-06 06:48:37', '2016-11-06 06:48:37', 999, 2),
(7, 'ทุเรียน', 'ทุเรียน', '2016-11-06 06:48:44', '2016-11-06 06:48:44', 999, 2),
(8, 'มะม่วง', 'มะม่วง', '2016-11-06 06:48:52', '2016-11-06 06:48:52', 999, 2),
(9, 'ลำใย', 'ลำใย', '2016-11-06 06:49:01', '2016-11-06 06:49:01', 999, 2),
(10, 'ส้ม', 'ส้ม', '2016-11-06 06:49:08', '2016-11-06 06:49:08', 999, 2);

-- --------------------------------------------------------

--
-- Table structure for table `slideimages`
--

CREATE TABLE `slideimages` (
  `id` int(10) UNSIGNED NOT NULL,
  `slideimage_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slideimage_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slideimage_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slideimage_urllink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `users_firstname_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `users_lastname_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_firstname_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_lastname_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_dateofbirth` date NOT NULL,
  `users_gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `users_addressname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_district` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_mobilephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_imageprofile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_latitude` decimal(11,8) NOT NULL,
  `users_longitude` decimal(11,8) NOT NULL,
  `users_contactperson` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_membertype` enum('personal','company') COLLATE utf8_unicode_ci NOT NULL,
  `iwantto` enum('buy','sale') COLLATE utf8_unicode_ci NOT NULL,
  `users_idcard` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_qrcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_company_th` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_company_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `users_firstname_th`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `is_active`, `users_lastname_th`, `users_firstname_en`, `users_lastname_en`, `users_dateofbirth`, `users_gender`, `users_addressname`, `users_street`, `users_district`, `users_city`, `users_province`, `users_postcode`, `users_mobilephone`, `users_phone`, `users_fax`, `users_imageprofile`, `users_latitude`, `users_longitude`, `users_contactperson`, `users_membertype`, `iwantto`, `users_idcard`, `users_qrcode`, `users_taxcode`, `users_company_th`, `users_company_en`) VALUES
(2, 'ปฐมพงษ์', 'tae_pe@hotmail.com', '$2y$10$x3aLtISzECc90g/MEozWGO1T.cSxc27/pmQGzbZj.t0fTYUwzLLB.', 'YWaZw2afVa1slH0gmL4moDZ0PanqY1L2Fr0mY9AL0Vmop8U7Mm5z14WpxUxV', '2016-11-06 01:03:28', '2016-11-07 02:33:34', 1, 'ประเสริฐ', 'Prathompong', 'Prasert', '2016-11-06', 'male', '', '', '', '', '', '', '', '', '', '', '0.00000000', '0.00000000', '', 'personal', 'sale', '15799900070848', '', '', '', ''),
(5, '', 'tae_pe1@hotmail.com', '$2y$10$x3aLtISzECc90g/MEozWGO1T.cSxc27/pmQGzbZj.t0fTYUwzLLB.', 'YWaZw2afVa1slH0gmL4moDZ0PanqY1L2Fr0mY9AL0Vmop8U7Mm5z14WpxUxV', '2016-11-06 01:03:28', '2016-11-06 21:28:48', 1, '', '', '', '2016-11-06', 'male', '', '', '', '', '', '', '', '', '', '', '0.00000000', '0.00000000', '', 'company', 'sale', '', '', '1111111111111', 'มกอช', 'มกอช');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admins_password_resets`
--
ALTER TABLE `admins_password_resets`
  ADD KEY `admins_password_resets_email_index` (`email`),
  ADD KEY `admins_password_resets_token_index` (`token`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactusform`
--
ALTER TABLE `contactusform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloaddocuments`
--
ALTER TABLE `downloaddocuments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faq_faqcategory_id_foreign` (`faqcategory_id`);

--
-- Indexes for table `faqcategorys`
--
ALTER TABLE `faqcategorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `productcategorys`
--
ALTER TABLE `productcategorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_productcategory_id_foreign` (`productcategory_id`);

--
-- Indexes for table `slideimages`
--
ALTER TABLE `slideimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contactusform`
--
ALTER TABLE `contactusform`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `downloaddocuments`
--
ALTER TABLE `downloaddocuments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `faqcategorys`
--
ALTER TABLE `faqcategorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `productcategorys`
--
ALTER TABLE `productcategorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `slideimages`
--
ALTER TABLE `slideimages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_faqcategory_id_foreign` FOREIGN KEY (`faqcategory_id`) REFERENCES `faqcategorys` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_productcategory_id_foreign` FOREIGN KEY (`productcategory_id`) REFERENCES `productcategorys` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
