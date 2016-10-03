-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2016 at 03:45 AM
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
(1, '<p>Test</p>\r\n', '<p>Test</p>\r\n', '2016-09-25 03:43:03', '2016-09-25 03:43:03');

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
(1, '<p>Test</p>\r\n', '<p>Test</p>\r\n', '13.75863382', '100.47357534', '2016-09-28 08:15:41', '2016-09-28 09:13:21');

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

--
-- Dumping data for table `contactusform`
--

INSERT INTO `contactusform` (`id`, `contactusform_name`, `contactusform_surname`, `contactusform_email`, `contactusform_phone`, `contactusform_file`, `contactusform_subject`, `contactusform_messagebox`, `created_at`, `updated_at`) VALUES
(4, 'ปฐมพงษ์', 'ประเสริฐ', 'ppraserts@gmail.com', '0954525444', '', 'แจ้งปัญหาการใช้งานระบบ', 'แจ้งปัญหาการใช้งานระบบ', '2016-09-28 23:21:16', '2016-09-24 23:21:16');

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

--
-- Dumping data for table `downloaddocuments`
--

INSERT INTO `downloaddocuments` (`id`, `downloaddocument_title_th`, `downloaddocument_description_th`, `downloaddocument_title_en`, `downloaddocument_description_en`, `downloaddocument_file`, `sequence`, `created_at`, `updated_at`) VALUES
(3, 'เอกสารโครงการ1', '<p>เอกสารโครงการ1</p>\r\n', 'Document Project1', '<p>Document Project1</p>\r\n', 'upload/documents/1474784476/GMOM_srs.doc.doc', 999, '2016-09-24 23:21:16', '2016-09-24 23:21:16');

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
(1, 'สินค้า', 'พบกับคำถามพบบ่อยและบทความน่ารู้เกี่ยวกับบริการหลัก AIS GSM และ One-2-Call ', 'Product', 'AIS GSM and One-2-Call ', 999, '2016-09-29 07:17:54', '2016-09-29 07:17:54'),
(2, 'บริการ', 'บริการเสริมต่างๆ จากเอไอเอสมีอะไรบ้าง และให้ประโยชน์อย่างไร เรามีคำตอบให้ที่นี่', 'Service', 'Service', 999, '2016-09-29 07:20:31', '2016-09-29 07:20:31');

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

--
-- Dumping data for table `medias`
--

INSERT INTO `medias` (`id`, `media_name_en`, `media_name_th`, `media_urllink`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'Interstellar – Building A Black Hole – Official Warner Bros.', 'Interstellar – Building A Black Hole – Official Warner Bros.', 'https://www.youtube.com/embed/MfGfZwQ_qaY', 999, '2016-10-02 09:44:38', '2016-10-02 09:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_09_12_000000_create_productcategory_table', 2),
('2016_09_12_000000_create_downloaddocument_table', 5),
('2016_09_12_000000_create_slideimage_table', 6),
('2016_09_12_000000_create_aboutus_table', 7),
('2016_09_12_000000_create_contactus_table', 8),
('2016_09_12_000000_create_contactusform_table', 9),
('2016_09_12_000000_create_faqcategory_table', 10),
('2016_09_12_000000_create_faq_table', 11),
('2016_09_12_000000_create_media_table', 12),
('2016_10_02_151847_add_column_to_users', 13);

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
(1, 'ผัก', 'พืชที่มนุษย์นำส่วนใดส่วนหนึ่งของพืชอาทิ ผล ใบ ราก ดอก หรือลำต้น มาประกอบอาหาร[1] ซึ่งไม่นับรวมผลไม้ ถั่ว สมุนไพร และเครื่องเทศ แต่เห็ด ซึ่งในทางชีววิทยาจัดเป็นพวกเห็ดรา ก็นับรวมเป็นผักด้วย', 'Vegetable', 'any part of a plant that is consumed by humans as food as part of a savory meal. The term vegetable is somewhat arbitrary, and largely defined through culinary and cultural tradition. It normally excludes other food derived from plants such as fruits, nuts and cereal grains, but includes seeds such as pulses. The original meaning of the word vegetable, still used in biology, was to describe all types of plant, as in the terms "vegetable kingdom" and "vegetable matter".', 1, '2016-09-18 07:05:06', '2016-09-18 07:29:59'),
(2, 'ผลไม้', ' ผลที่เกิดจากการขยายพันธุ์โดยอาศัยเพศของพืชบางชนิด ซึ่งมนุษย์สามารถรับประทานได้ และส่วนมากจะไม่ทำเป็นอาหารคาว ตัวอย่างผลไม้ เช่น ส้ม แอปเปิ้ล กล้วย มะม่วง ทุเรียน รวมถึง มะเขือเทศ ที่สามารถจัดได้ว่าเป็นทั้งผักและผลไม้. จุ๋ม', 'Fruit', 'the seed-bearing structure in flowering plants (also known as angiosperms) formed from the ovary after flowering.', 1, '2016-09-18 07:26:27', '2016-09-18 07:30:16');

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

--
-- Dumping data for table `slideimages`
--

INSERT INTO `slideimages` (`id`, `slideimage_name`, `slideimage_file`, `slideimage_type`, `slideimage_urllink`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'Slide1', 'upload/slides/1474794620/5607fe8879e4fd269e88387e8cb30b7e.jpg.jpg', 'AS', 'http://www.google.com', 999, '2016-09-25 02:10:20', '2016-09-25 02:10:20');

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
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
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
  `users_membertype` enum('personal','company') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `users_firstname_th`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`, `is_active`, `users_lastname_th`, `users_firstname_en`, `users_lastname_en`, `users_dateofbirth`, `users_gender`, `users_addressname`, `users_street`, `users_district`, `users_city`, `users_province`, `users_postcode`, `users_mobilephone`, `users_phone`, `users_fax`, `users_imageprofile`, `users_latitude`, `users_longitude`, `users_contactperson`, `users_membertype`) VALUES
(1, 'ปฐมพงษ์', 'ppraserts@gmail.com', '$2y$10$RqioPwsdr0I.C01EyrulAe6Ari8.rSQR6MNyFGmHYZblpXGMfEBlu', 'PuVCdNjI6AAnACyRh143hg0hpExIwOsc2sHZwhDuvtMBRnzwqM4Wb1QCjEVw', '2016-09-12 10:16:24', '2016-10-02 10:35:35', 1, 1, 'ประเสริฐ', 'Prathompong', 'Prasert', '0000-00-00', 'male', '', '', '', '', '', '', '0954524555', '', '', '', '0.00000000', '0.00000000', '', 'personal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `medias`
--
ALTER TABLE `medias`
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
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contactusform`
--
ALTER TABLE `contactusform`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `downloaddocuments`
--
ALTER TABLE `downloaddocuments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `faqcategorys`
--
ALTER TABLE `faqcategorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `productcategorys`
--
ALTER TABLE `productcategorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `slideimages`
--
ALTER TABLE `slideimages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_faqcategory_id_foreign` FOREIGN KEY (`faqcategory_id`) REFERENCES `faqcategorys` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
