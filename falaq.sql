-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 10:13 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `falaq`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'The Translation Gate');

-- --------------------------------------------------------

--
-- Table structure for table `contact_feedback`
--

CREATE TABLE `contact_feedback` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_feedback`
--

INSERT INTO `contact_feedback` (`id`, `name`) VALUES
(1, 'Rates for some languages'),
(2, 'Rate discussion'),
(3, 'Register on the Portal'),
(4, 'Work with freelancer only'),
(5, 'Client asked to send an e-mail'),
(6, 'Will send a test'),
(7, 'Not available in the office'),
(8, 'No need'),
(9, 'No answer');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `region`, `name`) VALUES
(234, 3, 'Albania'),
(235, 3, 'Andorra'),
(236, 3, 'Armenia'),
(237, 3, 'Austria'),
(238, 3, 'Azerbaijan'),
(239, 3, 'Belarus'),
(240, 3, 'Belgium'),
(241, 3, 'Bosnia and Herzegovina'),
(242, 3, 'Bulgaria'),
(243, 3, 'Croatia'),
(244, 3, 'Cyprus'),
(245, 3, 'Czech Republic'),
(246, 3, 'Denmark'),
(247, 3, 'Estonia'),
(248, 3, 'Finland'),
(249, 3, 'France'),
(250, 3, 'Georgia'),
(251, 3, 'Germany'),
(252, 3, 'Greece'),
(253, 3, 'Hungary'),
(254, 3, 'Iceland'),
(255, 3, 'Ireland'),
(256, 3, 'Italy'),
(257, 3, 'Latvia'),
(258, 3, 'Liechtenstein'),
(259, 3, 'Lithuania'),
(260, 3, 'Luxembourg'),
(261, 3, 'Macedonia'),
(262, 3, 'Malta'),
(263, 3, 'Moldova'),
(264, 3, 'Monaco'),
(265, 3, 'Montenegro'),
(266, 3, 'Netherlands'),
(267, 3, 'Norway'),
(268, 3, 'Poland'),
(269, 3, 'Portugal'),
(270, 3, 'Romania'),
(271, 3, 'San Marino'),
(272, 3, 'Serbia'),
(273, 3, 'Slovakia'),
(274, 3, 'Slovenia'),
(275, 3, 'Spain'),
(276, 3, 'Sweden'),
(277, 3, 'Switzerland'),
(278, 3, 'Ukraine'),
(279, 3, 'United Kingdom'),
(280, 3, 'Vatican City'),
(281, 1, 'Antigua and Barbuda'),
(282, 1, 'Bahamas'),
(283, 1, 'Barbados'),
(284, 1, 'Belize'),
(285, 1, 'Canada'),
(286, 1, 'Costa Rica'),
(287, 1, 'Cuba'),
(288, 1, 'Dominica'),
(289, 1, 'Dominican Republic'),
(290, 1, 'El Salvador'),
(291, 1, 'Grenada'),
(292, 1, 'Guatemala'),
(293, 1, 'Haiti'),
(294, 1, 'Honduras'),
(295, 1, 'Jamaica'),
(296, 1, 'Mexico'),
(297, 1, 'Nicaragua'),
(298, 1, 'Panama'),
(299, 1, 'Saint Kitts and Nevis'),
(300, 1, 'Saint Lucia'),
(301, 1, 'Saint Vincent and the Grenadines'),
(302, 1, 'Trinidad and Tobago'),
(303, 1, 'United States'),
(304, 1, 'Argentina'),
(305, 1, 'Bolivia'),
(306, 1, 'Brazil'),
(307, 1, 'Chile'),
(308, 1, 'Colombia'),
(309, 1, 'Ecuador'),
(310, 1, 'Guyana'),
(311, 1, 'Paraguay'),
(312, 1, 'Peru'),
(313, 1, 'Suriname'),
(314, 1, 'Uruguay'),
(315, 1, 'Venezuela'),
(316, 2, 'Afghanistan'),
(317, 2, 'Australia'),
(318, 2, 'Bahrain'),
(319, 2, 'Bangladesh'),
(320, 2, 'Bhutan'),
(321, 2, 'Brunei'),
(322, 2, 'Burma (Myanmar)'),
(323, 2, 'Cambodia'),
(324, 2, 'China'),
(325, 2, 'East Timor'),
(326, 2, 'India'),
(327, 2, 'Indonesia'),
(328, 2, 'Iran'),
(329, 2, 'Iraq'),
(330, 2, 'Israel'),
(331, 2, 'Japan'),
(332, 2, 'Jordan'),
(333, 2, 'Kazakhstan'),
(334, 2, 'Korea, North'),
(335, 2, 'Korea, South'),
(336, 2, 'Kuwait'),
(337, 2, 'Kyrgyzstan'),
(338, 2, 'Laos'),
(339, 2, 'Lebanon'),
(340, 2, 'Malaysia'),
(341, 2, 'Maldives'),
(342, 2, 'Mongolia'),
(343, 2, 'Nepal'),
(344, 2, 'Oman'),
(345, 2, 'Pakistan'),
(346, 2, 'Philippines'),
(347, 2, 'Qatar'),
(348, 2, 'Russian Federation'),
(349, 2, 'Saudi Arabia'),
(350, 2, 'Singapore'),
(351, 2, 'Sri Lanka'),
(352, 2, 'Syria'),
(353, 2, 'Tajikistan'),
(354, 2, 'Thailand'),
(355, 2, 'Turkey'),
(356, 2, 'Turkmenistan'),
(357, 2, 'United Arab Emirates'),
(358, 2, 'Uzbekistan'),
(359, 2, 'Vietnam'),
(360, 2, 'Yemen');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`) VALUES
(1, 'EGP'),
(2, 'USD'),
(3, 'EURO');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `website` varchar(200) NOT NULL,
  `payment` double NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` double NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `website`, `payment`, `status`, `created_by`, `created_at`) VALUES
(9, 'vodafone', 'vodafone.com', 8, 2, 3, '2018-05-12 20:14:51'),
(10, 'e-kern ', 'e-kern .com', 9, 2, 3, '2018-05-12 20:27:50'),
(11, 'test', 'test.com', 6, 1, 3, '2018-05-18 15:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `customer_contacts`
--

CREATE TABLE `customer_contacts` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `customer` int(11) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(300) NOT NULL,
  `skype_account` varchar(200) NOT NULL,
  `job_title` varchar(300) NOT NULL,
  `location` text NOT NULL,
  `comment` text NOT NULL,
  `created_by` double NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_contacts`
--

INSERT INTO `customer_contacts` (`id`, `name`, `customer`, `phone`, `email`, `skype_account`, `job_title`, `location`, `comment`, `created_by`, `created_at`) VALUES
(3, 'El-shehaby', 9, '01158233977', 'mohamed@vodafone.com', 'mohamed.elshehaby.skype', 'manager', 'location', '', 3, '2018-05-12'),
(4, 'test', 10, '0625656566', 'test@test.com', 'test', 'sadjk asdjh', 'test', '', 3, '2018-05-12'),
(5, 'test voda', 9, 'test voda', 'testvoda@test.com', 'test voda', 'test voda', 'test voda', '', 3, '2018-05-22'),
(6, 'Customer', 11, 'customer', 'customer@customer.com', 'New Contact', 'manager', 'customer', '', 3, '2018-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `customer_fuzzy`
--

CREATE TABLE `customer_fuzzy` (
  `id` int(11) NOT NULL,
  `prcnt` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `priceList` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_fuzzy`
--

INSERT INTO `customer_fuzzy` (`id`, `prcnt`, `value`, `priceList`) VALUES
(58, '100%', 50, 13),
(59, '99-95%', 30, 13),
(60, '94-85%', 40, 13),
(61, '84-75%', 20, 13);

-- --------------------------------------------------------

--
-- Table structure for table `customer_leads`
--

CREATE TABLE `customer_leads` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `address` varchar(300) NOT NULL,
  `comment` varchar(300) NOT NULL,
  `source` varchar(200) NOT NULL,
  `alias_email` varchar(200) NOT NULL,
  `approved` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approve_date` datetime NOT NULL,
  `created_by` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_leads`
--

INSERT INTO `customer_leads` (`id`, `customer`, `status`, `region`, `brand`, `country`, `type`, `address`, `comment`, `source`, `alias_email`, `approved`, `approved_by`, `approve_date`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 9, 0, 3, 1, 249, 1, '', '', 'facebook', '', 1, 0, '0000-00-00 00:00:00', 3, '2018-05-12 20:15:40', '0000-00-00 00:00:00'),
(6, 10, 0, 1, 1, 303, 2, '', '', 'Website', '', 1, 0, '0000-00-00 00:00:00', 3, '2018-05-12 20:28:33', '0000-00-00 00:00:00'),
(7, 11, 0, 2, 1, 317, 1, '', '', 'facebook', '', 1, 0, '0000-00-00 00:00:00', 3, '2018-05-18 15:00:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_pm`
--

CREATE TABLE `customer_pm` (
  `id` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `pm` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_pm`
--

INSERT INTO `customer_pm` (`id`, `lead`, `pm`, `customer`, `created_at`, `created_by`) VALUES
(1, 5, 5, 9, '0000-00-00 00:00:00', 0),
(2, 6, 5, 10, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_price_list`
--

CREATE TABLE `customer_price_list` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `product_line` varchar(200) NOT NULL,
  `currency` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `rate` decimal(5,4) NOT NULL,
  `comment` text NOT NULL,
  `file` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_price_list`
--

INSERT INTO `customer_price_list` (`id`, `customer`, `lead`, `product_line`, `currency`, `source`, `target`, `service`, `subject`, `unit`, `rate`, `comment`, `file`, `created_by`, `created_at`) VALUES
(13, 10, 6, 'fff', 2, 2, 17, 8, 1, 1, '0.9000', '', '', 3, '2018-05-24 14:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `customer_sam`
--

CREATE TABLE `customer_sam` (
  `id` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `sam` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_sam`
--

INSERT INTO `customer_sam` (`id`, `lead`, `sam`, `customer`, `created_at`, `created_by`) VALUES
(2, 5, 3, 9, '0000-00-00 00:00:00', 0),
(3, 6, 3, 10, '0000-00-00 00:00:00', 0),
(4, 7, 3, 11, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_status`
--

CREATE TABLE `customer_status` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_status`
--

INSERT INTO `customer_status` (`id`, `name`) VALUES
(1, 'Lead'),
(2, 'Relead'),
(3, 'Current'),
(4, 'Idle'),
(5, 'Prospect'),
(6, 'Dead');

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`id`, `name`) VALUES
(1, 'Direct'),
(2, 'MLV');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `name`) VALUES
(1, 'Advertising'),
(2, 'Agriculture'),
(3, 'Automotive'),
(4, 'Business General'),
(5, 'Child Care'),
(6, 'Computer'),
(7, 'Cosmetic'),
(8, 'Doc Formatting'),
(9, 'Economy, Finance, Banking'),
(10, 'Education & Training'),
(11, 'Electronics'),
(12, 'Engineering'),
(13, 'Fashion'),
(14, 'Financial'),
(15, 'Games'),
(16, 'Hardware'),
(17, 'Health Care'),
(18, 'Human Resources'),
(19, 'Industrial'),
(20, 'Information Technology (IT)'),
(21, 'Internet'),
(22, 'Legal'),
(23, 'Marketing'),
(24, 'Mathematics'),
(25, 'Medical'),
(26, 'Military'),
(27, 'Mobile'),
(28, 'Oil & Natural Gas'),
(29, 'Patent'),
(30, 'Politics & Political Science'),
(31, 'Science (General)'),
(32, 'Software'),
(33, 'Sports'),
(34, 'Technical'),
(35, 'Telecommunications'),
(36, 'Tourism, Travel'),
(37, 'Translation'),
(38, 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `icon`) VALUES
(1, 'Administration', 'fa fa-users'),
(2, 'Customers Mangement', 'fa fa-users'),
(3, 'Sales', 'fa fa-money'),
(4, 'Projects', 'fa fa-briefcase');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'Abkhazian '),
(2, 'Acoli'),
(3, 'Afar'),
(4, 'Afrikaans'),
(5, 'Akan'),
(6, 'Albanian'),
(7, 'Amharic'),
(8, 'Arabic'),
(9, 'Aramic'),
(10, 'Armenian'),
(11, 'Assamese'),
(12, 'Assyrian'),
(13, 'Azerbaijani'),
(14, 'Badini'),
(15, 'Balochi'),
(16, 'Bambara'),
(17, 'Bamileke languages'),
(18, 'Banda'),
(19, 'Basque'),
(20, 'Belarusian'),
(21, 'Bemba'),
(22, 'Bengali'),
(23, 'Berber'),
(24, 'Bhojpuri'),
(25, 'Bihari'),
(26, 'Bilen'),
(27, 'bobo'),
(28, 'Bolivian'),
(29, 'Bosnian'),
(30, 'Brazilian'),
(31, 'Bulgarian'),
(32, 'Burmese'),
(33, 'Cebuano'),
(34, 'Chechen'),
(35, 'Chichewa'),
(36, 'Chin'),
(37, 'Chinese'),
(38, 'Chuukese '),
(39, 'Cornish'),
(40, 'Creole'),
(41, 'Creoles & Pidgins (Portuguese-based Other)'),
(42, 'Creoles & Pidgins (French-based Other)'),
(43, 'Croatian'),
(44, 'Czech'),
(45, 'Danish'),
(46, 'Dari'),
(47, 'Dhivehi'),
(48, 'Dinka'),
(49, 'Dogri'),
(50, 'Dutch'),
(51, 'Dzongkha'),
(52, 'Edo'),
(53, 'English '),
(54, 'Estonian'),
(55, 'Ewe'),
(56, 'Fanti (Fante)'),
(57, 'Farsi'),
(58, 'Fijian'),
(59, 'Finnish'),
(60, 'Flemish'),
(61, 'French '),
(62, 'Fula'),
(63, 'Fulani'),
(64, 'Ga'),
(65, 'Gacilian'),
(66, 'Gaelic/Irish'),
(67, 'Garhwali'),
(68, 'Ge\'ez '),
(69, 'Georgian'),
(70, 'German'),
(71, 'Greek'),
(72, 'Greenlandic'),
(73, 'Gujarati'),
(74, 'Hahka'),
(75, 'Haitian Creole'),
(76, 'Hakha'),
(77, 'Hakha China'),
(78, 'Hamong'),
(79, 'Hausa'),
(80, 'Hebrew'),
(81, 'Hiligaynon'),
(82, 'Hindi'),
(83, 'Hmong'),
(84, 'Hong kong'),
(85, 'Hungarian'),
(86, 'Icelandic'),
(87, 'Igbo'),
(88, 'Ilocano'),
(89, 'Iloko'),
(90, 'Indonesian'),
(91, 'Irish'),
(92, 'IsiSwati'),
(93, 'Isoko'),
(94, 'Italian'),
(95, 'Japanese'),
(96, 'Kabyle'),
(97, 'Kachin'),
(98, 'Kamba'),
(99, 'Kannada'),
(100, 'Karen'),
(101, 'Karenni'),
(102, 'Kashin'),
(103, 'Kashmiri'),
(104, 'Kazakh'),
(105, 'Khmer'),
(106, 'Kikuyu'),
(107, 'Kinyarawanda'),
(108, 'Kirghiz'),
(109, 'Kirundi'),
(110, 'Kongo'),
(111, 'Korean'),
(112, 'Krygyz(Kirgiz)'),
(113, 'Kunama'),
(114, 'Kurdish'),
(115, 'Kyrgyz'),
(116, 'Lai'),
(117, 'Lao'),
(118, 'Latvian'),
(119, 'Lingala'),
(120, 'Lithuanian'),
(121, 'Lu Mien'),
(122, 'Lugandan'),
(123, 'Luo'),
(124, 'Luxembourgish/ Luxembourg '),
(125, 'Macedonian'),
(126, 'Maithili'),
(127, 'Malagasy'),
(128, 'Malay'),
(129, 'Malayalam'),
(130, 'Maltese'),
(131, 'Mandarin'),
(132, 'Mandingo'),
(133, 'Maori'),
(134, 'Marathi'),
(135, 'Marshallese'),
(136, 'Masai'),
(137, 'Mauritian'),
(138, 'Mayan (Mam)'),
(139, 'Mien'),
(140, 'Mindat'),
(141, 'Moldavian'),
(142, 'Mongolian'),
(143, 'Montenegrin'),
(144, 'Ndebele'),
(145, 'NdebeleNorth'),
(146, 'NdebeleSouth'),
(147, 'Nepali'),
(148, 'Nigerian'),
(149, 'Northern'),
(150, 'Northern Sami'),
(151, 'Northern Sotho'),
(152, 'Norwegian'),
(153, 'Nuer'),
(154, 'Nyanja'),
(155, 'Oromo'),
(156, 'Panjabi'),
(157, 'Pashto'),
(158, 'Polish'),
(159, 'Portuguese'),
(160, 'Punjabi'),
(161, 'Romanian'),
(162, 'Russian'),
(163, 'Samoan'),
(164, 'Sanskrit'),
(165, 'Santali'),
(166, 'Serbian'),
(167, 'Sesotho'),
(168, 'Shona'),
(169, 'Simple English'),
(170, 'Sindhi'),
(171, 'Sinhala /Sinhalese'),
(172, 'SiSwati (Swazi)'),
(173, 'Slovak'),
(174, 'Slovenian'),
(175, 'Somali'),
(176, 'Sotho'),
(177, 'Spanish'),
(178, 'Sukuma'),
(179, 'Sundanese'),
(180, 'Swahili'),
(181, 'Swedish'),
(182, 'Tagalog'),
(183, 'Tajik'),
(184, 'Tamil'),
(185, 'Tatar'),
(186, 'Tausug'),
(187, 'Tedim'),
(188, 'Telugu'),
(189, 'Thai'),
(190, 'Tibetan'),
(191, 'Tigre'),
(192, 'Tigrinya'),
(193, 'Tongan'),
(194, 'Trukese'),
(195, 'Tshiluba'),
(196, 'Tsonga'),
(197, 'Tswana'),
(198, 'Tumbuka'),
(199, 'Turkish'),
(200, 'Turkman'),
(201, 'Turkmen'),
(202, 'Twi'),
(203, 'Uighur'),
(204, 'Ukrainian'),
(205, 'Urdu'),
(206, 'Uyghur'),
(207, 'Uzbek'),
(208, 'Verdean'),
(209, 'Vietnamese'),
(210, 'Visayan'),
(211, 'Welsh'),
(212, 'Western Krahn'),
(213, 'Wolof'),
(214, 'Xhosa'),
(215, 'Yakan'),
(216, 'Yiddish'),
(217, 'Yoruba'),
(218, 'Zaghawa'),
(219, 'Zokhua'),
(220, 'Zulu');

-- --------------------------------------------------------

--
-- Table structure for table `logger`
--

CREATE TABLE `logger` (
  `id` double NOT NULL,
  `screen` double DEFAULT NULL,
  `table_name` text NOT NULL,
  `transaction_id_name` varchar(255) NOT NULL,
  `transaction_id` double NOT NULL,
  `data` longtext,
  `type` tinyint(4) DEFAULT NULL,
  `parent` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `groups` int(11) NOT NULL,
  `screen` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `follow` int(11) NOT NULL,
  `add` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  `view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`) VALUES
(1, 1, 1, 1, 0, 1, 1, 1, 1),
(2, 1, 2, 1, 0, 1, 1, 1, 1),
(3, 1, 3, 1, 0, 1, 1, 1, 1),
(4, 1, 4, 1, 0, 1, 0, 0, 1),
(5, 1, 5, 1, 0, 0, 1, 0, 1),
(7, 1, 7, 1, 0, 1, 0, 0, 1),
(8, 1, 6, 1, 0, 0, 0, 1, 1),
(9, 1, 8, 1, 0, 0, 1, 0, 1),
(12, 1, 9, 1, 0, 0, 0, 1, 1),
(13, 2, 10, 1, 2, 1, 1, 1, 1),
(14, 2, 11, 1, 0, 1, 0, 0, 1),
(17, 2, 12, 1, 0, 0, 1, 0, 1),
(18, 2, 13, 1, 0, 0, 0, 1, 1),
(19, 2, 14, 1, 2, 1, 1, 1, 1),
(20, 2, 15, 1, 2, 1, 0, 0, 1),
(21, 2, 14, 3, 1, 1, 1, 1, 2),
(22, 2, 10, 3, 1, 1, 1, 1, 1),
(23, 2, 11, 3, 0, 1, 0, 0, 1),
(24, 2, 12, 3, 1, 0, 1, 0, 1),
(25, 2, 13, 3, 0, 0, 0, 1, 1),
(26, 2, 15, 3, 1, 1, 0, 0, 2),
(27, 2, 16, 1, 2, 0, 1, 0, 1),
(28, 2, 16, 3, 1, 0, 1, 0, 2),
(29, 2, 17, 1, 2, 0, 0, 1, 1),
(30, 2, 17, 3, 1, 0, 0, 1, 2),
(31, 2, 18, 1, 2, 1, 1, 1, 1),
(32, 2, 18, 3, 1, 1, 1, 1, 2),
(33, 2, 19, 1, 2, 1, 1, 1, 1),
(34, 2, 19, 3, 1, 1, 1, 1, 2),
(35, 2, 20, 1, 2, 1, 0, 0, 1),
(36, 2, 20, 3, 1, 1, 1, 1, 2),
(37, 2, 21, 1, 2, 0, 1, 0, 1),
(38, 2, 22, 1, 2, 0, 0, 1, 1),
(39, 2, 21, 3, 1, 0, 1, 0, 2),
(40, 2, 22, 3, 1, 0, 0, 1, 2),
(41, 3, 23, 3, 1, 1, 1, 1, 2),
(42, 3, 23, 1, 2, 1, 1, 1, 1),
(43, 3, 24, 1, 2, 1, 0, 0, 1),
(44, 3, 24, 3, 1, 1, 0, 0, 2),
(45, 3, 25, 3, 1, 1, 1, 1, 2),
(46, 3, 26, 3, 1, 1, 1, 1, 2),
(47, 3, 27, 3, 1, 1, 1, 1, 2),
(48, 3, 28, 3, 1, 1, 1, 1, 2),
(49, 3, 29, 3, 1, 1, 0, 0, 2),
(50, 2, 30, 3, 1, 0, 1, 0, 2),
(51, 2, 31, 3, 1, 0, 0, 1, 2),
(52, 2, 32, 3, 1, 1, 0, 0, 2),
(53, 3, 33, 3, 1, 0, 1, 0, 2),
(54, 3, 34, 3, 1, 0, 0, 1, 2),
(55, 3, 35, 3, 1, 0, 1, 0, 2),
(56, 3, 36, 3, 1, 0, 0, 1, 2),
(57, 4, 37, 2, 1, 1, 1, 1, 2),
(58, 4, 37, 1, 2, 1, 1, 1, 1),
(59, 2, 10, 2, 1, 0, 0, 0, 1),
(60, 3, 28, 1, 2, 1, 1, 1, 1),
(61, 3, 35, 1, 2, 0, 1, 0, 1),
(62, 4, 38, 2, 1, 1, 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `opportunity` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `customer` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `price_list` int(11) NOT NULL,
  `volume` double NOT NULL,
  `created_by` double NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `opportunity`, `code`, `name`, `customer`, `lead`, `price_list`, `volume`, `created_by`, `created_at`) VALUES
(3, 1, 'PM-3-US', 'Test', 10, 6, 13, 1000, 5, '2018-05-26 16:02:04'),
(4, NULL, 'PM-4-US', 'Test 2', 10, 6, 13, 80, 5, '2018-05-26 16:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE `project_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

--
-- Dumping data for table `project_status`
--

INSERT INTO `project_status` (`id`, `name`) VALUES
(1, 'Won'),
(2, 'Lost'),
(3, 'Open'),
(4, 'Chancelled'),
(5, 'Postponed');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `abbreviations` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `abbreviations`) VALUES
(1, 'Americas', 'US'),
(2, 'APAC', 'AS'),
(3, 'Europe', 'EU');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'PM'),
(3, 'Sales'),
(10, 'Marketing Manager');

-- --------------------------------------------------------

--
-- Table structure for table `sales_activity`
--

CREATE TABLE `sales_activity` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `contact_method` int(11) NOT NULL,
  `call_update` varchar(200) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rolled_in` int(11) NOT NULL,
  `pm` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_activity`
--

INSERT INTO `sales_activity` (`id`, `customer`, `lead`, `contact_method`, `call_update`, `contact_id`, `status`, `rolled_in`, `pm`, `feedback`, `comment`, `created_by`, `created_at`) VALUES
(6, 9, 5, 1, '', 3, 1, 2, 0, '1', '', 3, '2018-05-12 20:18:10'),
(7, 9, 5, 1, '', 5, 1, 1, 0, '7', '', 3, '2018-05-12 20:18:55'),
(10, 11, 7, 1, '', 6, 1, 1, 5, '1', '', 3, '2018-05-22 15:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `sales_follow_up`
--

CREATE TABLE `sales_follow_up` (
  `id` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `follow_up` datetime NOT NULL,
  `comment` text NOT NULL,
  `call_status` int(11) NOT NULL,
  `new_hitting` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_follow_up`
--

INSERT INTO `sales_follow_up` (`id`, `sales`, `follow_up`, `comment`, `call_status`, `new_hitting`, `created_by`, `created_at`) VALUES
(2, 9, '2018-05-15 17:50:00', 'asdasdad', 2, '2018-05-16 16:45:00', 3, '2018-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `sales_opportunity`
--

CREATE TABLE `sales_opportunity` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `lead` int(11) NOT NULL,
  `contact_method` int(11) NOT NULL,
  `project_status` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `project_code` varchar(200) NOT NULL,
  `price_list` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `tool` int(11) NOT NULL,
  `follow_up` datetime NOT NULL,
  `notes` varchar(300) NOT NULL,
  `your_comment` text NOT NULL,
  `new_follow_up` datetime NOT NULL,
  `comment` text NOT NULL,
  `assigned` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_at` datetime NOT NULL,
  `saved` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_opportunity`
--

INSERT INTO `sales_opportunity` (`id`, `customer`, `lead`, `contact_method`, `project_status`, `contact_id`, `project_name`, `project_code`, `price_list`, `volume`, `tool`, `follow_up`, `notes`, `your_comment`, `new_follow_up`, `comment`, `assigned`, `assigned_by`, `assigned_at`, `saved`, `created_by`, `created_at`) VALUES
(1, 10, 6, 1, 1, 4, 'Test', 'PM-1-US', 13, 1000, 13, '2018-05-24 14:35:00', '', '', '0000-00-00 00:00:00', '', 1, 3, '2018-05-24 14:38:31', 1, 3, '2018-05-24 14:36:21');

-- --------------------------------------------------------

--
-- Table structure for table `screen`
--

CREATE TABLE `screen` (
  `id` int(11) NOT NULL,
  `groups` int(11) NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `screen`
--

INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES
(1, 1, 'Users', 'admin/users', 1),
(2, 1, 'Role', 'admin/role', 1),
(3, 1, 'Permission', 'admin/permission', 1),
(4, 1, 'Add Role', 'admin/addRole', 0),
(5, 1, 'Edit Role', 'admin/editRole', 0),
(6, 1, 'Delete Role', 'admin/deleteRole', 0),
(7, 1, 'Add Permission', 'admin/addPermission', 0),
(8, 1, 'Edit Permission', 'admin/editPermission', 0),
(9, 1, 'Delete Permission', 'admin/deletePermission', 0),
(10, 2, 'Customers', 'customer/\r\n', 1),
(11, 2, 'Add Customers', 'customer/addCustomer', 0),
(12, 2, 'Edit Customers', 'customer/editCustomer', 0),
(13, 2, 'Delete Customers', 'customer/deleteCustomer', 0),
(14, 2, 'Customer Leads', 'customer/leads', 1),
(15, 2, 'Add Leads', 'customer/addLead', 0),
(16, 2, 'Edit Lead', 'customer/editLead', 0),
(17, 2, 'Delete Lead', 'customer/deleteLead', 0),
(18, 2, 'Customer Price List', 'customer/priceList', 1),
(19, 2, 'Lead Contacts', 'customer/leadContacts', 0),
(20, 2, 'Add Lead Contacts', 'customer/addLeadContacts', 0),
(21, 2, 'Edit Lead Contacts', 'customer/editLeadContacts', 0),
(22, 2, 'Delete Lead Contacts', 'customer/deleteLeadContacts', 0),
(23, 3, 'Sales Activity', 'sales/salesActivity', 1),
(24, 3, 'Add Sales Activity', 'sales/addSalesActivity', 0),
(25, 3, 'Follow Up', 'sales/followUp', 0),
(26, 3, 'Add Follow Up', 'sales/addFollowUp', 0),
(27, 3, 'Add PriceList', 'customer/addPriceList', 0),
(28, 3, 'Opportunities', 'sales/opportunity', 1),
(29, 3, 'Add Opportunity', 'sales/addOpportunity', 0),
(30, 2, 'Edit Customer PriceList', 'customer/editPriceList', 0),
(31, 2, 'Delete Customer PriceList', 'customer/deletePriceList', 0),
(32, 2, 'Add Bulk PriceList', 'customer/addBulkPriceList', 0),
(33, 3, 'Edit Sales Activity', 'sales/editSalesActivity', 0),
(34, 3, 'Delete Sales Activity', 'sales/deleteSalesActivity', 0),
(35, 3, 'Edit Opportunity', 'sales/editOpportunity', 0),
(36, 3, 'Delete Opportunity', 'sales/deleteOpportunity', 0),
(37, 4, 'View Projects', 'projects/', 1),
(38, 4, 'Add Project', 'projects/addProject', 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `parent`) VALUES
(1, 'Translation', 0),
(2, 'Translation ', 1),
(3, 'Translation & Editing', 1),
(4, 'Translation& editing &proofreading', 1),
(5, 'Revision', 1),
(6, 'proofreading', 1),
(7, 'LSO', 1),
(8, 'QA', 1),
(9, 'Test', 1),
(10, 'Transcription', 0),
(11, 'with Time coding ', 10),
(12, 'without Time coding ', 10),
(13, 'Voice over ', 0),
(14, 'Studio ', 13),
(15, 'Non Studio', 13),
(16, 'Interpreting', 0),
(17, 'Simultaneous', 16),
(18, 'Consecutive', 16),
(19, 'Localization Engineering ', 0),
(20, 'Help Engineering', 19),
(21, 'Flash Engineering ', 19),
(22, 'Conversion', 19),
(23, 'Desktop Publishing ', 0),
(24, 'DTP ', 23),
(25, 'QC', 23),
(26, 'Trans- creation ', 0),
(27, 'Trans-creation ', 26),
(28, 'MTPE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id`, `name`, `parent`) VALUES
(1, 'Across', 0),
(2, 'Alchemy Catalyst', 0),
(3, 'DejaVu', 0),
(4, 'Helium', 0),
(5, 'Idiom', 0),
(6, 'Loc Studio', 0),
(7, 'MemoQ', 0),
(8, 'Memsource', 0),
(9, 'Nokia NTR tool', 0),
(10, 'Olifant', 0),
(11, 'Omega T', 0),
(12, 'SDL Passolo', 0),
(13, ' - Passolo 2011', 12),
(14, '- Passolo 2015', 12),
(15, ' -  Passolo 2016', 12),
(16, 'SDL Studio', 0),
(17, '- Trados Studio 2007', 16),
(18, '- Trados Studio 2009', 16),
(19, '- Trados Studio 2011', 16),
(20, '- Trados Studio 2014', 16),
(21, '- Trados Studio 2015', 16),
(22, 'Transit', 0),
(23, '- NXT', 22),
(24, ' - XV', 22),
(25, 'Transit Satellite', 0),
(26, 'Translation Workspace', 0),
(27, 'Word fast', 0),
(28, 'XLIFF', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`) VALUES
(1, 'Hour'),
(2, 'Word'),
(3, 'Page'),
(4, 'Minimum Charge');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(300) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `admin_type` int(11) NOT NULL,
  `image` varchar(300) NOT NULL,
  `phone` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `ps` varchar(300) NOT NULL,
  `abbreviations` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `admin_type`, `image`, `phone`, `region_id`, `creation_date`, `modify_date`, `ps`, `abbreviations`, `role`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@ttg.com', '21232f297a57a5a743894a0e4a801fc3', 0, '', 0, 0, '0000-00-00', '0000-00-00', '', 'admin', 1, 1),
(3, 'sales 1', 'sales 1', 'sales 1', 'sales1@ttg.com', '21232f297a57a5a743894a0e4a801fc3', 0, '', 0, 0, '0000-00-00', '0000-00-00', '', 'S1', 3, 1),
(4, 'sales 2', 'sales 2', 'sales 2', 'sales2@ttg.com', '21232f297a57a5a743894a0e4a801fc3', 0, '', 0, 0, '0000-00-00', '0000-00-00', '', 'S2', 3, 1),
(5, 'pm', 'pm', 'pm', 'pm@ttg.com', '21232f297a57a5a743894a0e4a801fc3', 0, '', 0, 0, '0000-00-00', '0000-00-00', '', 'PM', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_fuzzy`
--
ALTER TABLE `customer_fuzzy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_leads`
--
ALTER TABLE `customer_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_pm`
--
ALTER TABLE `customer_pm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_price_list`
--
ALTER TABLE `customer_price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_sam`
--
ALTER TABLE `customer_sam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_status`
--
ALTER TABLE `customer_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logger`
--
ALTER TABLE `logger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_activity`
--
ALTER TABLE `sales_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_follow_up`
--
ALTER TABLE `sales_follow_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_opportunity`
--
ALTER TABLE `sales_opportunity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screen`
--
ALTER TABLE `screen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_fuzzy`
--
ALTER TABLE `customer_fuzzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `customer_leads`
--
ALTER TABLE `customer_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `customer_pm`
--
ALTER TABLE `customer_pm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_price_list`
--
ALTER TABLE `customer_price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `customer_sam`
--
ALTER TABLE `customer_sam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_status`
--
ALTER TABLE `customer_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;
--
-- AUTO_INCREMENT for table `logger`
--
ALTER TABLE `logger`
  MODIFY `id` double NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales_activity`
--
ALTER TABLE `sales_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales_follow_up`
--
ALTER TABLE `sales_follow_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sales_opportunity`
--
ALTER TABLE `sales_opportunity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `screen`
--
ALTER TABLE `screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
