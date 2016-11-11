-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2016 at 02:58 AM
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
(1, 'admin admin', 'ppraserts@gmail.com', '$2y$10$RqioPwsdr0I.C01EyrulAe6Ari8.rSQR6MNyFGmHYZblpXGMfEBlu', 'W', 'EPnK5aoNba2cfY6PlaN3QPXEi77yx4PtkA5INgVG3SiD6K1Vu0PNdmiV20c7', '2016-09-12 03:16:24', '2016-11-10 08:39:20');

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

--
-- Dumping data for table `contactusform`
--

INSERT INTO `contactusform` (`id`, `contactusform_name`, `contactusform_surname`, `contactusform_email`, `contactusform_phone`, `contactusform_file`, `contactusform_subject`, `contactusform_messagebox`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'tae_pe@hotmail.com', '1234', '', 'test', 'test', '2016-11-10 08:22:04', '2016-11-10 08:22:04');

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
-- Table structure for table `iwantto`
--

CREATE TABLE `iwantto` (
  `id` int(10) UNSIGNED NOT NULL,
  `iwantto` enum('buy','sale') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'buy',
  `product_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_description` text COLLATE utf8_unicode_ci NOT NULL,
  `guarantee` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_showprice` tinyint(1) NOT NULL DEFAULT '0',
  `volumn` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product1_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product2_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product3_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `productstatus` enum('open','soldout','close') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `pricerange_start` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pricerange_end` decimal(10,2) NOT NULL DEFAULT '0.00',
  `volumnrange_start` decimal(10,2) NOT NULL DEFAULT '0.00',
  `volumnrange_end` decimal(10,2) NOT NULL DEFAULT '0.00',
  `units` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `productcategorys_id` int(10) UNSIGNED DEFAULT NULL,
  `products_id` int(10) UNSIGNED DEFAULT NULL,
  `users_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `iwantto`
--

INSERT INTO `iwantto` (`id`, `iwantto`, `product_title`, `product_description`, `guarantee`, `price`, `is_showprice`, `volumn`, `product1_file`, `product2_file`, `product3_file`, `productstatus`, `pricerange_start`, `pricerange_end`, `volumnrange_start`, `volumnrange_end`, `units`, `city`, `province`, `productcategorys_id`, `products_id`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'sale', 'ผักบุ้งบ้านนา', 'ผักบุ้งมีชื่อเรียกอื่นว่าผักทอดยอด เป็นอาหารเพื่อสุขภาพที่เรามักจะคุ้นเคยกันมาตลอดว่ามีส่วนช่วยในการบำรุงสายตา แต่จริง ๆ แล้วผักชนิดนี้ยังมีประโยชน์มากกว่านั้น เพราะอุดมไปด้วยวิตามินและแร่ธาตุที่สำคัญ ๆ\n\nแต่ก่อนจะไปรู้ถึงประโยชน์มาดูกันก่อนว่าผักบุ้งที่นิยมนำมาใช้รับประทานนั้นมีสายพันธุ์อะไรบ้าง ซึ่งในประเทศไทยจะแบ่งออกเป็น 2 สายพันธุ์หลัก ๆ คือ ผักบุ้งไทยและผักบุ้งจีน สำหรับผักบุ้งไทยเป็นผักบุ้งสายพันธุ์ธรรมชาติที่ขึ้นเองตามแม่น้ำลำคลอง ซึ่งจะมียางมากกว่าผักบุ้งจีน ส่วนผักบุ้งจีนเป็นพันธุ์ที่นำเข้ามาจากต่างประเทศ (แต่ปลูกได้เองแล้วที่เมืองไทย) โดยส่วนมากที่นิยมปลูกขายก็คือผักบุ้งจีน เพราะลำต้นค่อนข้างขาว ใบเขียวอ่อน ดอกขาว มียางน้อยกว่าผักบุ้งไทย จึงได้รับความนิยมในการรับประทานมากกว่าผักบุ้งไทยนั่นเอง\n\nในผักบุ้ง 100 กรัมจะให้พลังงาน 22 กิโลแคลอรี ประกอบด้วยเส้นใย วิตามิน และแร่ธาตุอื่น ๆ อีกด้วย เช่น วิตามินเอ วิตามินซี วิตามินบี 1 วิตามินบี 2 วิตามินบี 3 ธาตุแคลเซียม ธาตุฟอสฟอรัส ธาตุเหล็ก เป็นต้น ผักบุ้งไทยนั้นจะมีวิตามินซีสูงและสรรพคุณทางยามากกว่าผักบุ้งจีน แต่จะมีแคลเซียมและเบตาแคโรทีน (วิตามินเอที่ช่วยบำรุงสายตา) น้อยกว่าผักบุ้งจีน หากรับประทานสด ๆ ได้ จะทำให้คุณค่าของวิตามินและแร่ธาตุเหล่านี้ไม่เสียไปกับความร้อนอีกด้วย\n\nผู้ที่เป็นโรคความดันโลหิตต่ำนั้นควรหลีกเลี่ยงการรับประทานผักบุ้ง เพราะผักบุ้งมีคุณสมบัติไปช่วยลดความดันโลหิต จะทำให้ความดันยิ่งต่ำลงไปใหญ่ อาจจะก่อให้เกิดอาการเป็นตะคริวได้ง่ายและบ่อยขึ้น ทำให้ร่างกายอ่อนแอ\n\nประโยชน์ของผักบุ้ง\nประโยชน์ของผักบุ้งข้อแรกคือมีส่วนช่วยให้ผิวพรรณเปล่งปลั่งสดใส มีน้ำมีนวล\nมีสารต่อต้านอนุมูลอิสระ ช่วยในการชะลอวัย ความแก่ชรา และชะลอการเกิดริ้วรอยแห่งวัย\nมีส่วนช่วยป้องกันการเกิดหรือลดอัตราการเกิดของโรคมะเร็งได้\nช่วยบำรุงสายตา รักษาอาการตาต้อ ตาฝ้าฟาง ตาแดง สายตาสั้น อาการคันนัยน์ตาบ่อย ๆ\nช่วยบำรุงธาตุ\nสรรพคุณของผักบุ้งต้นสดของผักบุ้งใช้เป็นยาดับร้อน แก้อาการร้อนใน\nต้นสดของผักบุ้งช่วยในการบำรุงโลหิต\nช่วยเสริมสร้างศักยภาพในด้านความจำและการเรียนรู้ให้ดีขึ้น\nยอดผักบุ้งช่วยแก้โรคประสาท\nช่วยแก้อาการเหงื่อออกมาก (รากผักบุ้ง)\nมีส่วนช่วยลดระดับน้ำตาลในเลือด ป้องกันการเกิดโรคเบาหวาน\nช่วยแก้อาการปวดศีรษะ อ่อนเพลีย\nต้นสดของผักบุ้งไทยต้นขาวช่วยบำรุงกระดูกและฟัน\nช่วยแก้อาการเหงือกบวม\nช่วยรักษาแผลร้อนในในปาก ด้วยการนำผักบุ้งสดมาผสมเกลือ อมไว้ในปากประมาณ 2 นาที วันละ 2 ครั้ง\nฟันเป็นรูปวด ให้ใช้รากสด 120 กรัม ผสมกับน้ำส้มสายชู คั้นเอาน้ำมาบ้วนปาก\nใช้แก้อาการไอเรื้อรัง (รากผักบุ้ง)\nแก้เลือดกำเดาไหลออกมากผิดปกติ ด้วยการใช้ต้นสดมาตำผสมน้ำตาลทรายแล้วนำมาชงน้ำร้อนดื่ม\nใช้แก้โรคหืด (รากผักบุ้ง)\nช่วยป้องกันการเกิดโรคกระเพาะอาหาร\nช่วยป้องกันการเกิดโรคแผลในกระเพาะอาหารจากผลของยาแอสไพริน\nช่วยป้องกันโรคท้องผูก\nยอดผักบุ้งมีส่วนช่วยแก้อาการเสื่อมสมรรถภาพ\nช่วยทำความสะอาดของเสียที่ตกค้างในลำไส้\nผักบุ้งจีนมีฤทธิ์ช่วยในการขับปัสสาวะ แก้ปัสสาวะเหลือง\nช่วยแก้อาการปัสสาวะเป็นเลือด ถ่ายออกมาเป็นเลือด ด้วยการใช้ลำต้นคั้นนำน้ำมาผสมกับน้ำผึ้งดื่ม\nช่วยแก้หนองใน ด้วยการใช้ลำต้นคั้นนำน้ำมาผสมกับน้ำผึ้งดื่ม\nช่วยแก้ริดสีดวงทวาร ด้วยการใช้ต้นสด 1 กิโล / น้ำ 1 ลิตร นำมาต้มให้เละ เอากากทิ้งแล้วใส่น้ำตาลทรายขาว 120 กรัม แล้วเคี่ยวจนข้นหนืด รับประทานครั้งละ 90 กรัม วันละ 2 ครั้ง เช้าและเย็น\nช่วยแก้อาการตกขาวมากของสตรี (รากผักบุ้ง)\nผักบุ้งรสเย็นมีสรรพคุณช่วยถอนพิษเบื่อเมา\nรากผักบุ้งรสจืดเฝื่อนมีสรรพคุณช่วยถอนพิษสำแดง\nผักบุ้งขาวหรือผักบุ้งจีนช่วยให้เจริญอาหาร\nช่วยต่อต้านเชื้อแบคทีเรีย\nช่วยแก้อาการฟกช้ำ (ผักบุ้งไทยต้นขาว)\nดอกของผักบุ้งไทยต้นขาวใช้เป็นยาแก้กลากเกลื้อน\nใช้ถอนพิษจากแมลงสัตว์กัดต่อย (ผักบุ้งไทยต้นขาว)\nแก้แผลมีหนองช้ำ ด้วยการใช้ต้นสดต้มน้ำให้เดือดนาน ๆ ทิ้งไว้พออุ่นแล้วเอาน้ำล้างแผลวันละครั้ง\nช่วยแก้พิษตะขาบกัด ด้วยการใช้ต้นสดเติมเกลือ นำมาตำแล้วพอกบริเวณที่ถูกกัด\nต้นสดของผักบุ้งไทยต้นขาวใช้รักษาแผลไฟไหม้ น้ำร้อนลวก\nต้นสดของผักบุ้งไทยต้นขาวช่วยลดการอักเสบ อาการปวดบวม\nช่วยขับสารพิษออกจากร่างกาย\nใช้บำบัดรักษาผู้ป่วยยาเสพติดหรือผู้ที่ได้รับสารพิษต่าง ๆ เช่น เกษตรกร เป็นต้น\nนำมาใช้ในการประกอบอาหารอย่างหลากหลาย ไม่ว่าจะผัด แกง ดอง ได้หมด เช่น ผัดผักบุ้งไฟแดง ส้มตำ แกงส้ม แกงเทโพ ยําผักบุ้งกรอบ เป็นต้น\nผักบุ้งนำมาใช้เป็นอาหารสัตว์ได้เหมือนกัน เช่น หมู เป็ด ไก่ ปลา เป็นต้น (มีหลายคนเข้าใจผิดว่ากระต่ายชอบกินผักบุ้ง แต่ความจริงแล้วไม่ใช่เลย เพราะอาจจะทำให้ท้องเสียได้ เพราะผักบุ้งมียาง ยกเว้นกระต่ายโต ถ้าจะให้กินไม่ควรให้บ่อยและให้ทีละนิด)\nผักบุ้ง ประโยชน์ข้อสุดท้ายนิยมนำมาแปรรูปเป็นผลิตภัณฑ์ต่าง ๆ เช่น ผักบุ้งแคปซูล ผงผักบุ้ง เป็นต้น', '', '10.00', 0, '1.00', '\\upload\\products\\11111\\shutterstock_166543490.jpg', '', '', 'open', '0.00', '0.00', '0.00', '0.00', 'กำ', 'เขตหลักสี่', 'กรุงเทพมหานคร', 1, 1, 2, '2016-11-09 17:00:00', '2016-11-09 17:00:00'),
(2, 'sale', 'คะน้าสวยๆ', 'คะน้าสวยๆ', '', '15.00', 0, '1.00', '\\upload\\products\\33333\\Chinese-font-b-Kale-b-font-Seed-200-Seeds-Of-Each-Pack-Brassica-Alboglabra-Cabbage-Mustard.jpg', '', '', 'open', '0.00', '0.00', '0.00', '0.00', 'กำ', 'เมืองนนทบุรี', 'นนทบุรี', 1, 2, 2, '2016-11-09 17:00:00', '2016-11-09 17:00:00'),
(3, 'sale', 'คะน้าบ้านนา', 'คะน้าบ้านนา', '', '13.00', 0, '1.00', '\\upload\\products\\44444\\h1.jpg', '', '', 'open', '0.00', '0.00', '0.00', '0.00', 'กำ', 'เมือง', 'เชียงใหม่', 1, 2, 2, '2016-11-09 17:00:00', '2016-11-09 17:00:00'),
(4, 'sale', 'ตำลึงปลูกเอง', 'ตำลึงปลูกเอง', '', '11.00', 0, '1.00', '\\upload\\products\\22222\\iStock_000043212934_Small.jpg', '', '', 'open', '0.00', '0.00', '0.00', '0.00', 'กำ', 'เมือง', 'เชียงใหม่', 1, 3, 2, '2016-11-09 17:00:00', '2016-11-09 17:00:00'),
(20, 'sale', 'ผักกาดขาว', '<p><strong>ผักกาดขาว&nbsp;</strong>มีชื่อเรียกอื่นว่า&nbsp;ผักกาดขาวปลี, แปะฉ่าย, แปะฉ่ายลุ้ย เป็นต้น</p>\r\n\r\n<p>สายพันธุ์ผักกาดขาวที่นิยมปลูกมีอยู่ 3 พันธุ์ คือ พันธุ์เข้าปลียาว (ลักษณะสูง เป็นรูปไข่), พันธุ์เข้าปลีกลมแน่น (ลักษณะสั้น อ้วนกลม) และพันธุ์เข้าปลีหลวมหรือไม่ห่อปลี (ปลูกได้ทั่วไป เช่น ผักกาดขาวธรรมดา ผักกาดขาวใหญ่)</p>\r\n\r\n<p>คุณค่าทางโภชนาการของผักกาดขาว 100 กรัม มีน้ำ 91.7 กรัม, กรดอะมิโน, โปรตีน 0.6 กรัม, คาร์โบไฮเดรต 5.7 กรัม, เส้นใย 0.8 กรัม, แคโรทีน 0.02 มิลลิกรัม, วิตามินบี 1 0.02 มิลลิกรัม, วิตามินบี 2 0.04 มิลลิกรัม, วิตามินซี 30 มิลลิกรัม, ธาตุแคลเซียม 49 มิลลิกรัม, ธาตุฟอสฟอรัส 34 มิลลิกรัม, ธาตุเหล็ก 0.5 มิลลิกรัม, ธาตุโพแทสเซียม 196 มิลลิกรัม, ธาตุซิลิกอน 0.024 มิลลิกรัม, ธาตุแมงกานีส 1.26 มิลลิกรัม, ธาตุทองแดง 0.21 มิลลิกรัม, ธาตุสังกะสี 3.21 มิลลิกรัม, ธาตุโมลิบดีนัม 0.125 มิลลิกรัม, ธาตุโบรอน 2.07 มิลลิกรัม, กรดนิโคตินิค (Nicotinic acid) 0.5 มิลลิกรัม</p>\r\n\r\n<p>ผักกาดขาวเป็นผักที่มีเส้นใยสูงมาก โดยเส้นใยที่ว่านี้เป็นเส้นใยที่ไม่ละลายน้ำ แต่จะพองตัวเมื่อมีน้ำ จึงมีความสามารถในการอุ้มน้ำได้เป็นอย่างดี ซึ่งการอุ้มน้ำได้ดีนี้จะช่วยเพิ่มปริมาตรของกากอาหาร ช่วยกระตุ้นการเคลื่อนไหวของลำไส้ ทำให้กากอาหารอ่อนนุ่ม ขับถ่ายสะดวก และยังช่วยแก้อาการท้องผูกอีกด้วย นอกจากนี้ยังช่วยเพิ่มความหนืด ทำให้ไม่ถูกย่อยได้ง่าย ช่วยดูดซับและแลกเปลี่ยนประจุ จึงช่วยป้องกันและกำจัดสารอนุมูลอิสระในร่างกาย ช่วยดึงเอาสารพิษที่ปนเปื้อนในอาหารที่รับประทาน ช่วยลดความหมักหมมของลำไส้ จึงมีผลทำให้ช่วยลดความเสี่ยงของการเกิดโรคมะเร็งลำไส้ได้เป็นอย่างดี !</p>\r\n\r\n<p>สำหรับสรรพคุณช่วยป้องกันโรคมะเร็งลำไส้นั้น ปัจจุบันยังไม่ทราบขนาดของเส้นใยอาหารที่ต้องรับประทานอย่างแน่นอน แต่ในสหรัฐฯ ได้กำหนดให้เพศชายวัยสูงอายุ ควรบริโภคเส้นใยอาหารประมาณ 18 กรัมต่อวัน และสำหรับวัยหนุ่มสาวควรรับประทาน 20-25 กรัมต่อวัน และการรับประทานที่มากกว่าปริมาณที่กำหนดก็ไม่ได้ช่วยลดอัตราความเสี่ยงของการเกิดโรคมะเร็งแต่อย่างใด แต่จะช่วยทำให้ระบบขับถ่ายทำงานได้ดีมากขึ้น อย่างเช่นในเรื่องของการขับถ่าย แก้อาการท้องผูก เป็นต้น</p>\r\n', '', '100.00', 0, '10.00', 'upload/products/1478829411/_.JPG', '', '', 'open', '0.00', '0.00', '0.00', '0.00', 'กำ', 'เขตจตุจักร', 'กรุงเทพมหานคร', 1, 5, 2, '2016-11-10 18:56:52', '2016-11-10 18:56:52');

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
(1, 'ตลาดเกษตรอินทรีย์', 'สินค้าเกษตรปลอดสารพิษ', 'ตลาดเกษตรอินทรีย์', 'สินค้าเกษตรปลอดสารพิษ', 'upload/market/1478246940/01.jpg', 1, '2016-09-24 20:43:03', '2016-11-10 08:38:18'),
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
(24, '2016_11_07_062218_create_news_table', 6),
(26, '2016_11_10_043218_create_iwantto_table', 7);

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
(2, 'ปฐมพงษ์', 'tae_pe@hotmail.com', '$2y$10$VrmXotJEJWwEH7A1NSMhn.eaQyJfyA43GsN65EKpYtO3HG5HvFX4m', 'kHG3aN1wCwdwhenIXES6sIg04NmaiSxmeAEfBV1TopbAnPJ6KoHRyy0cTOS2', '2016-11-06 01:03:28', '2016-11-10 17:09:47', 1, 'ประเสริฐ', 'Prathompong', 'Prasert', '2016-11-06', 'male', 'เลขที่ 50', 'ถนนพหลโยธิน', 'แขวงลาดยาว', 'เขตจตุจักร', 'กรุงเทพมหานคร', '10900', '', '+662- 561-2277', '', 'upload/imageprofiles/1478822987/Mens-short-hairstyle-7.jpg', '13.75272466', '100.50292369', '', 'personal', 'sale', '15799900070848', '', '', '', ''),
(6, 'เจตพร', 'tae_pe1@hotmail.com', '$2y$10$VrmXotJEJWwEH7A1NSMhn.eaQyJfyA43GsN65EKpYtO3HG5HvFX4m', 'FmXzZ02VyewYFAkYY1voNXYlgNIjAdd5yicXBUM0MzCsce9L9Hu5VHpqidEM', '2016-11-06 01:03:28', '2016-11-10 16:33:23', 1, 'หมาดสกุล', 'JETTAPORN', 'MADSAKUL', '2016-11-06', 'male', 'เลขที่ 50', 'ถนนพหลโยธิน', 'แขวงลาดยาว', 'เขตจตุจักร', 'กรุงเทพมหานคร', '10900', '', '+662- 561-2277', '', 'upload/imageprofiles/1478820481/Cool-haircut-for-men-1.jpg', '13.75272466', '100.50292369', '', 'personal', 'buy', '15799900070848', '', '', '', '');

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
-- Indexes for table `iwantto`
--
ALTER TABLE `iwantto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iwantto_productcategorys_id_foreign` (`productcategorys_id`),
  ADD KEY `iwantto_products_id_foreign` (`products_id`),
  ADD KEY `iwantto_users_id_foreign` (`users_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- AUTO_INCREMENT for table `iwantto`
--
ALTER TABLE `iwantto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
-- Constraints for table `iwantto`
--
ALTER TABLE `iwantto`
  ADD CONSTRAINT `iwantto_productcategorys_id_foreign` FOREIGN KEY (`productcategorys_id`) REFERENCES `productcategorys` (`id`),
  ADD CONSTRAINT `iwantto_products_id_foreign` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `iwantto_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_productcategory_id_foreign` FOREIGN KEY (`productcategory_id`) REFERENCES `productcategorys` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
