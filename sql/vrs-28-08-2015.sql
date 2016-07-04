-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2015 at 10:49 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_group`
--

CREATE TABLE IF NOT EXISTS `account_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `group_title` varchar(100) NOT NULL,
  `category` varchar(15) NOT NULL,
  `opening_balance` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `account_group`
--

INSERT INTO `account_group` (`id`, `branch_id`, `group_title`, `category`, `opening_balance`) VALUES
(4, 2, 'CASH', 'Assets', '0.000'),
(5, 2, 'BANK', 'Assets', '0.000'),
(6, 2, 'VEHICLE EXPENSES', 'Expense', '0.000'),
(7, 2, 'VEHICLE', 'Assets', '0.000'),
(8, 2, 'CAPITAL', 'Assets', '0.000'),
(10, 2, 'OFFICE EXPENSES', 'Expense', '0.000'),
(11, 2, 'SALES', 'Income', '0.000'),
(12, 2, 'SALES ADVANCE', 'Liabilities', '0.000');

-- --------------------------------------------------------

--
-- Stand-in structure for view `account_statement`
--
CREATE TABLE IF NOT EXISTS `account_statement` (
`transaction_id` int(11)
,`vehicle_id` int(11)
,`vehicle_no` varchar(30)
,`narration` varchar(200)
,`transaction_date` varchar(50)
,`CrAmount` decimal(11,3)
,`DrAmount` decimal(11,3)
);
-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(50) NOT NULL,
  `po_box` varchar(10) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `city` varchar(50) NOT NULL,
  `telephone` varchar(8) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `incharge` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_name`, `po_box`, `postal_code`, `city`, `telephone`, `mobile`, `email`, `incharge`) VALUES
(2, 'Al Khuwair', '2295', '112', 'Al Khuwair', '24478505', '99441645', 'admin@morningstarrentacar.com', 'Farag'),
(3, 'Seeb', '112', '112', 'Seeb', '12344321', '98988989', 'seeb@morningstarrentacar.com', 'Jishnu');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `en_name` varchar(100) NOT NULL,
  `ar_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_nationality_code` varchar(20) NOT NULL,
  `ar_nationality_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_passport_no` varchar(100) NOT NULL,
  `ar_passport_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_place_issue` varchar(100) NOT NULL,
  `ar_place_issue` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_date_issue` varchar(100) NOT NULL,
  `ar_date_issue` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_date_expiry` varchar(100) NOT NULL,
  `ar_date_expiry` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_national_id` varchar(100) NOT NULL,
  `ar_national_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_id_date_expiry` varchar(100) NOT NULL,
  `ar_id_date_expiry` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_local_address` varchar(100) NOT NULL,
  `ar_local_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_company_name` varchar(100) NOT NULL,
  `ar_company_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_mailing_address` varchar(100) NOT NULL,
  `ar_mailing_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(11) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reference_person_name` varchar(100) NOT NULL,
  `reference_person_mobile` varchar(11) NOT NULL,
  `passport_img` varchar(200) DEFAULT NULL,
  `national_id_img` varchar(200) DEFAULT NULL,
  `driving_licence_img` varchar(200) DEFAULT NULL,
  `customer_img` varchar(200) DEFAULT NULL,
  `reference_source_field` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `branch_id`, `en_name`, `ar_name`, `en_nationality_code`, `ar_nationality_code`, `en_passport_no`, `ar_passport_no`, `en_place_issue`, `ar_place_issue`, `en_date_issue`, `ar_date_issue`, `en_date_expiry`, `ar_date_expiry`, `en_national_id`, `ar_national_id`, `en_id_date_expiry`, `ar_id_date_expiry`, `en_local_address`, `ar_local_address`, `en_company_name`, `ar_company_name`, `en_mailing_address`, `ar_mailing_address`, `telephone`, `mobile_no`, `email`, `reference_person_name`, `reference_person_mobile`, `passport_img`, `national_id_img`, `driving_licence_img`, `customer_img`, `reference_source_field`) VALUES
(3, 2, 'Ahmed', 'کتگوری', 'Oman', 'کتگوری', 'L1234', 'کتگوری', 'Muscat', 'کتگوری', '01/05/2015', '01/05/2015', '01/05/2015', '01/05/2015', 'r765', 'کتگوری', '01/05/2015', '01/05/2015', 'seeb', 'کتگوری', 'mstyre', 'کتگوری', 'asasasasas', 'کتگوری', '77665544', '99889988', '123@gmail.com', 'Mohamed', '90908787', 'customer_id-3.JPG', 'customer_id-3.JPG', 'customer_id-3.JPG', 'customer_id-3.JPG', 'Website'),
(7, 2, 'Fadil', '', 'Pakistan', '', 'A88776655', '', 'Muscat', '', '02/06/2015', '', '02/07/2015', '', 'ASDD3434', '', '11/07/2015', '', 'Abc', '', 'Sastha Software LLP', '', 'sastha@test.com', '', '0942156563', '9587451230', 'sastha@test.com', 'Ahmed mansuri', '9632149580', 'passport-1.jpg', 'national_id-1.jpg', 'driving_licence-1.jpg', 'customer-1.jpg', 'Others'),
(8, 2, 'JOHN AJK KOSHY', '', 'INDIAN', '', 'K4621457', '', '', '', '', '', '', '', '', '', '', '', 'AL AMIRAT', '', 'DOLPHIN SURVEYORS & LOSS ACC', '', '', '', '', '92837549', '', '', '', '', '', '', '', '0'),
(9, 2, 'MOHAMMAD ADNAN', '', 'JORDANIAN', '', '', '', '', '', '', '', '', '', '67070155', '', '', '', 'ALKWAIR', '', 'GREEN BELT TRADING', '', '', '', '', '98588867', '', '', '', '', '', '', '', '0'),
(10, 2, 'YOUSUF ABDUNASSER MOHAMMED', '', 'SOMALI', '', '', '', '', '', '', '', '', '', '86213325', '', '', '', '', '', 'HORIZON INDUSTRIAL DEVELOPMENT CO.LLC', '', '', '', '', '93596550', '', '', '', '', 'national_id-4.jpg', 'driving_licence-4.jpg', '', '0'),
(11, 2, 'DR. MOHAN DIKSHIT', '', 'INDIAN', '', 'J4220472', '', '', '', '', '', '', '', '70816338', '', '', '', 'AL SEEB', '', 'SQU', '', '', '', '', '9960378', '', 'Dr. NASSER AL HABSI', '99441688', 'customer_id-11.jpg', '', 'customer_id-11.jpg', '', 'Mouth'),
(12, 2, 'AHMED ALI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '19480852', '', '', '', 'QURUM', '', '', '', '', '', '', '9601607', '', '', '', '', 'national_id-6.jpg', 'driving_licence-6.jpg', 'customer-6.jpg', '0'),
(13, 2, 'T. VIJAYARAGHAVAN', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '61535455', '', '', '', 'ALKWAIR', '', 'INDIAN SCHOOL, GHOBRA', '', '', '', '', '99718605', '', '', '', '', 'national_id-7.jpg', 'driving_licence-7.jpg', '', '0'),
(14, 2, 'SAYED ASAAD JAWID', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '62323999', '', '', '', 'ALKWAIR', '', '', '', '', '', '', '99603403', '', 'Dr. NASSER AL HABSI', '', '', '', '', '', '0'),
(15, 2, 'ANEESH SREENIVASAN', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '79472058', '', '', '', 'AL AMIRAT', '', 'INTISAR CORPORATION', '', '', '', '', '92604668', '', '', '', '', 'national_id-9.jpg', 'driving_licence-9.jpg', '', '0'),
(16, 2, 'MARIYAM MASKARY', '', 'OMANI', '', '', '', '', '', '', '', '', '', '2097836', '', '', '', 'AL AZAIBA', '', '', '', '', '', '', '93836987', '', '', '', '', '', '', '', '0'),
(17, 2, 'RASHID SAID NASSER AL RAWAHI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '524312', '', '', '', 'AL KWAIR', '', '', '', '', '', '', '95329090', '', '', '', '', 'national_id-11.jpg', 'driving_licence-11.jpg', '', 'Mouth'),
(18, 2, 'RAHMA SALIM HASHIM AL GHAFRI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '7310982', '', '', '', 'MADINAT QABOOS', '', 'IDG OMAN', '', '', '', '', '93541717', '', '', '', '', 'national_id-12.jpg', 'driving_licence-12.jpg', '', '0'),
(19, 2, 'ARTUR MANUEL', '', 'PORTUGUESE', '', 'N596981', '', '', '', '', '', '', '', 'L8996147', '', '', '', 'AL SEEB', '', 'NATIONAL GULF MINERALS AND MINING CO. LLC', '', '', '', '', '96178571', '', '', '', 'passport-13.jpg', '', 'driving_licence-13.jpg', '', '0'),
(20, 2, 'ROBERTO JR MAGAT SANTIAGO', '', 'PHILIPPINO', '', '', '', '', '', '', '', '', '', '77301579', '', '', '', '', '', '', '', '', '', '', '97051740', '', '', '', '', 'national_id-14.jpg', 'driving_licence-14.jpg', '', '0'),
(21, 2, 'PRAKASH KUMAR', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '61207826', '', '', '', 'AL SEEB', '', 'PDO', '', '', '', '', '99510391', '', 'ANEESH', '', 'passport-15.jpg', 'national_id-15.jpg', 'driving_licence-15.jpg', 'customer-15.jpg', 'Mouth'),
(22, 2, 'HELMY EL SAYED EL HABASHY', '', 'EGYPTIAN', '', '', '', '', '', '', '', '', '', '94636187', '', '', '', 'AL ANSAB', '', '', '', '', '', '', '94335773', '', '', '', 'passport-16.jpg', 'national_id-16.jpg', '', '', '0'),
(23, 2, 'FATHIMA ABDERABOH', '', 'JORDANIAN', '', '', '', '', '', '', '', '', '', '72767831', '', '', '', 'AL KWAIR', '', 'SCIENTIFIC COLLEGE OF DESIGN', '', '', '', '', '91451544', '', '', '', 'passport-17.jpg', 'national_id-17.jpg', '', '', '0'),
(24, 2, 'NABIL HUMAID SALIM AULLAD THANI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '10952818', '', '', '', 'AL GOBRA', '', 'AL KHALEEJI DUTY', '', '', '', '', '94692942', '', 'Dr. NASSER AL HABSI', '', 'passport-18.jpg', 'national_id-18.jpg', '', '', 'Mouth'),
(25, 2, 'AHMED SALEH IDRIS ADAM', '', 'SUDANESE', '', '', '', '', '', '', '', '', '', '61398136', '', '', '', 'DOLPHIN HOTEL', '', '', '', '', '', '', '98160069', '', '', '', '', '', '', '', '0'),
(26, 2, 'GEORGE PAUL CHALAKAL', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '62147597', '', '', '', 'ALKWAIR', '', 'DREAM HOMES', '', '', '', '', '99120014', '', '', '', 'passport-20.jpg', 'national_id-20.jpg', '', '', '0'),
(27, 2, 'MOHAMMED ASHRAF ABDUL JALEEL', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '67285616', '', '', '', 'BOUSHER', '', 'HORECA TRADING LLC', '', '', '', '', '97229822', '', 'MHD BAKIR', '', '', '', '', '', '0'),
(28, 2, 'RAMESH KUMAR', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '101043714', '', '', '', 'RUWI', '', 'AL KALBANI INTERNATIONAL INVESTMENT', '', '', '', '', '91283714', '', '', '', '', '', '', '', '0'),
(29, 2, 'ROWENA ESCOTE MARILLA', '', 'PHILIPPINO', '', '', '', '', '', '', '', '', '', '100858055', '', '', '', 'BOUSHER', '', 'MUSCAT WATCH', '', '', '', '', '94576600', '', '', '', 'passport-23.jpg', 'national_id-23.jpg', '', '', '0'),
(30, 2, 'GHULAM SHABBIR MUHAMMAD SHARIF', '', 'PAKISTANI', '', '', '', '', '', '', '', '', '', '61675399', '', '', '', 'AL AZAIBA', '', 'MORNING STAR, GHALA', '', '', '', '', '95126855', '', '', '', 'passport-24.jpg', 'national_id-24.jpg', '', '', '0'),
(31, 2, 'AHMED ABDELMONEM RAGAB MAHMOUD', '', 'EGYPTIAN', '', '', '', '', '', '', '', '', '', '74320979', '', '', '', 'AL KHOUD', '', 'NATIONAL SPECIAL PROJECTS', '', '', '', '', '91216883', '', '', '', 'passport-25.jpg', 'national_id-25.jpg', '', '', '0'),
(32, 2, 'JOSEPH SAJIN', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '91400673', '', '', '', 'WADI KABIR', '', 'SAUD BAHWAN', '', '', '', '99891259', '96391987', '', 'SHABAREESH', '', 'passport-26.jpg', 'national_id-26.jpg', '', '', '0'),
(33, 2, 'RATHEESH RAVEENDRAN NAIR', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '76673446', '', '', '', 'AL BUSTAN', '', 'CARILLION ALAWI LLC', '', '', '', '', '97664036', '', 'RAJESH', '', 'passport-27.jpg', 'national_id-27.jpg', '', '', 'Mouth'),
(34, 2, 'NOUSHAD EDAYOTH', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '100289805', '', '', '', 'AL RUSTAQ', '', 'AL SHUROOQ HYPER MARKET', '', '', '', '', '91107992', '', 'NOUSHAD', '', 'passport-28.jpg', 'national_id-28.jpg', '', '', 'Mouth'),
(35, 2, 'BAIJU U PHILIP', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '87068168', '', '', '', 'AL HAIL', '', 'ASLAN UNITED LLC', '', '', '', '', '92920081', '', '', '', 'passport-29.jpg', 'national_id-29.jpg', '', '', '0'),
(36, 2, 'NASEER NASIMUDEEN ARIFA BEEVI', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '74134105', '', '', '', 'AL HAIL', '', 'ASLAN UNITED LLC', '', '', '', '', '95334185', '', '', '', 'passport-30.jpg', 'national_id-30.jpg', '', '', '0'),
(37, 2, 'NASSER KHALFAN SAID AL JAHDAMI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '01387336', '', '', '', 'BIDBID', '', 'MORNING STAR DRIVING SCHOOL', '', '', '', '', '91436681', '', '', '', '', '', '', '', '0'),
(38, 2, 'KHAN MUHAMMAD KAMRAN KHAN MUHAMMAD AZIZ', '', 'PAKISTANI', '', '', '', '', '', '', '', '', '', '87069418', '', '', '', 'SUR', '', 'ABU ESSA AL SADI TRADING', '', '', '', '', '92171166', '', '', '', 'passport-32.jpg', 'national_id-32.jpg', '', '', '0'),
(39, 2, 'MOHAMMED HAMID FARID ADMED', '', 'BANGLADESHI', '', '', '', '', '', '', '', '', '', '86589745', '', '', '', 'GHALA', '', 'MORNING STAR, GHALA', '', '', '', '', '94169304', '', '', '', 'passport-33.jpg', 'national_id-33.jpg', '', '', '0'),
(40, 2, 'ZAHEER ABBASI MOHAMMAD SAEED KHAN', '', 'PAKISTANI', '', '', '', '', '', '', '', '', '', '61632263', '', '', '', 'GHALA', '', 'MORNING STAR, GHALA', '', '', '', '', '92353364', '', '', '', '', '', '', '', '0'),
(41, 2, 'RIZWAN ABDULKHADER', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '75500162', '', '', '', 'GHALA', '', 'MORNING STAR, GHALA', '', '', '', '', '99182560', '', '', '', 'passport-35.jpg', 'national_id-35.jpg', '', '', '0'),
(42, 2, 'KHALID IBRAHIM HASSAN KHELAWY', '', 'JORDANIAN', '', '', '', '', '', '', '', '', '', '96987067', '', '', '', 'AL HAIL', '', 'AL THAWAQATH TECHNICAL SERVICES', '', '', '', '', '92060591', '', '', '', '', '', '', '', '0'),
(43, 2, 'AHMED HASSAN ABDUL JALIL', '', 'IRAQI', '', '', '', '', '', '', '', '', '', '71919591', '', '', '', 'QURUM', '', 'KAWAS ENGINEERING', '', '', '', '', '99268218', '', 'SALIM AL AMRI', '92507199', '', '', '', '', '0'),
(44, 2, 'KHALID OBAID MUHAMMED', '', 'OMANI', '', '', '', '', '', '', '', '', '', '5271012', '', '', '', 'AL HAIL', '', '', '', '', '', '', '96507799', '', '', '', '', '', '', '', '0'),
(45, 2, 'SAID BIN HAMOOD', '', 'OMANI', '', '', '', '', '', '', '', '', '', '13177645', '', '', '', 'AL SEEB', '', 'INMA CO. OMAN LLC', '', '', '', '98981242', '99312048', '', '', '', '', '', '', '', '0'),
(46, 2, 'ABDURAZAK MANIKOTH', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '102352889', '', '', '', 'AL KHOUD', '', 'NATIONAL SPECIAL PROJECTS', '', '', '', '92348068', '95758455', '', '', '', '', '', '', '', '0'),
(47, 2, 'TALAL HUSSEIN FAWAZI', '', 'JORDANIAN', '', '', '', '', '', '', '', '', '', '100165383', '', '', '', 'AL AZAIBA', '', 'ADMIN COURT OMAN', '', '', '', '', '94613178', '', '', '', '', '', '', '', '0'),
(48, 2, 'IBRAHIM AHMAD HASAN MANSOUR', '', 'JORDANIAN', '', '', '', '', '', '', '', '', '', '62125761', '', '', '', 'ALKWAIR', '', 'INTERNATIONAL VICTORY BOW, MQ', '', '', '', '', '99330147', '', 'AREK', '', 'passport-42.jpg', 'national_id-42.jpg', '', '', '0'),
(49, 2, 'AYHAM AJAZ SULIEMAN ALLAN', '', 'JORDANIAN', '', 'M009806', '', '', '', '', '', '', '', '', '', '', '', 'AL AZAIBA', '', 'AL IBDIKARTH', '', '', '', '', '99349046', '', 'KHALEFA', '', 'passport-43.jpg', 'national_id-43.jpg', '', '', '0'),
(50, 2, 'SULTAN HAMOOD SALIM  AL HARTHY', '', 'OMANI', '', '', '', '', '', '', '', '', '', '4803246', '', '', '', 'IBRA', '', 'AL SAHARI OIL SERVICE CO. LLC', '', '', '', '', '95733034', '', '', '', '', '', '', '', '0'),
(51, 2, 'STEPHEN DAVID WOOLF', '', 'BRITISH', '', '502513250', '', '', '', '', '', '', '', '73228272', '', '', '', 'BARKA', '', 'ROYAL AL MARAYA LLC', '', '', '', '', '94630487', '', '', '', 'passport-45.jpg', 'national_id-45.jpg', '', '', '0'),
(52, 2, 'RASHID SAID NASSER AL RAWAHI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '524312', '', '', '', 'AL SEEB', '', '', '', '', '', '', '95329090', '', 'Dr. NASSER AL HABSI', '', '', '', '', '', '0'),
(53, 2, 'HANNANE MAMMER', '', 'ALGERIAN', '', '', '', '', '', '', '', '', '', '84812182', '', '', '', 'MABELA', '', 'OMAN AIR', '', '', '', '', '96451316', '', '', '', '', '', '', '', '0'),
(54, 2, 'SALWA SALIM MOHAMED AL NAAMANI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '2195524', '', '', '', 'AL SEEB', '', 'BANK DHOFAR', '', '', '', '', '96090772', '', '', '', 'passport-48.jpg', 'national_id-48.jpg', '', '', '0'),
(55, 2, 'LLOYD CASTILLO QUEVEDO', '', 'PHILIPPINO', '', '', '', '', '', '', '', '', '', '96921756', '', '', '', 'ALKWAIR', '', 'MEDIACOM, BOUSHER', '', '', '', '', '97405622', '', '', '', 'passport-49.jpg', 'national_id-49.jpg', '', '', 'Others'),
(56, 2, 'SREEJITH', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '85207649', '', '', '', 'ALKWAIR', '', 'VEC', '', '', '', '', '93243987', '', '', '', 'passport-50.jpg', 'national_id-50.jpg', '', '', '0'),
(57, 2, 'KALLOL BISWAS', '', 'INDIAN', '', '', '', '', '', '', '', '', '', '67936105', '', '', '', 'BOUSHER', '', 'ANWAAR AL IBRAJ INTERNATIONAL LLC', '', '', '', '24186744', '91963572', '', '', '', 'passport-51.jpg', 'national_id-51.jpg', '', '', '0'),
(58, 2, 'MOHAMMED AL HINAAI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '10192338', '', '', '', 'GOUBRA', '', 'HAMED TRADING LLC', '', '', '', '', '99740880', '', '', '', 'passport-52.jpg', 'national_id-52.jpg', '', '', '0'),
(59, 2, 'IJAS HUSSAIN SHAH', '', 'PAKISTANI', '', '', '', '', '', '', '', '', '', '60853038', '', '', '', 'GHALA', '', 'MORNING STAR, GHALA', '', '', '', '', '92181588', '', 'Dr. NASSER AL HABSI', '', 'passport-53.jpg', 'national_id-53.jpg', '', '', '0'),
(60, 2, 'HAJIR MARHOON KHALFAN NASSER AL MAHARBI', '', 'OMANI', '', '', '', '', '', '', '', '', '', '19053685', '', '09/02/2020', '', 'AL SEEB', '', 'KAWAS ENGINEERING', '', '', '', '', '98516000', '', 'AHMED HASSAN', '', 'passport-54.jpg', 'national_id-54.jpg', '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `garage`
--

CREATE TABLE IF NOT EXISTS `garage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `garage_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `garage`
--

INSERT INTO `garage` (`id`, `branch_id`, `garage_name`, `location`, `telephone`, `mobile_no`, `email`, `contact_person`) VALUES
(3, 2, 'Saud Bahwan Automotive LLC', 'Wattayah', '24579256', '', '', ''),
(4, 2, 'IBN Haramil Trading', 'Wadikabir', '24811846', '99434968', '', 'Shaji'),
(5, 2, 'Magic Touch', 'Bowshar', '', '99664716', '', 'Abubakkar'),
(6, 2, 'Suhail Bahwan Automotive LLC - Azaiba', 'Azaiba', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Users', 'General User'),
(3, 'sales', 'Sales User');

-- --------------------------------------------------------

--
-- Stand-in structure for view `header_detail`
--
CREATE TABLE IF NOT EXISTS `header_detail` (
`TransactionId` int(11)
,`TransactionDate` varchar(50)
,`Ledger` int(11)
,`Description` varchar(200)
,`CrAmount` decimal(10,3)
,`DrAmount` decimal(10,3)
,`vehicle_reg_no` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `income_expense`
--
CREATE TABLE IF NOT EXISTS `income_expense` (
`id` int(11)
,`vehicle_reg_no` varchar(20)
,`transaction_id` int(11)
,`brand` varchar(100)
,`description` varchar(200)
,`transaction_date` varchar(50)
,`expense` decimal(10,3)
,`income` decimal(10,3)
);
-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE IF NOT EXISTS `ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `accountgroup_id` int(11) NOT NULL,
  `opening_balance` decimal(10,3) NOT NULL,
  `closing_balance` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`id`, `branch_id`, `type`, `title`, `accountgroup_id`, `opening_balance`, `closing_balance`) VALUES
(4, 2, 'Income', 'CASH', 4, '0.000', '0.000'),
(5, 2, 'Income', 'PETTY CASH', 4, '0.000', '0.000'),
(6, 2, 'Income', 'MISCELLANEOUS', 11, '0.000', '0.000'),
(7, 2, 'Expenditure', 'RENT', 10, '0.000', '0.000'),
(8, 2, 'Expenditure', 'ELECTRICITY', 10, '0.000', '0.000'),
(9, 2, 'Expenditure', 'WATER', 10, '0.000', '0.000'),
(10, 2, 'Expenditure', 'STATIONARY', 10, '0.000', '0.000'),
(11, 2, 'Income', 'DEPOSIT', 12, '0.000', '0.000'),
(13, 2, 'Income', 'RENTAL CHARGES', 11, '0.000', '0.000'),
(14, 2, 'Expenditure', 'INSURANCE', 6, '0.000', '0.000'),
(15, 2, 'Expenditure', 'REGISTRATION', 6, '0.000', '0.000'),
(18, 2, 'Income', 'BANK MUSCAT', 5, '0.000', '0.000'),
(20, 2, 'Income', 'DR.NASSER', 8, '0.000', '0.000'),
(21, 2, 'Expenditure', 'Jishnu Puliyankot', 9, '0.000', '0.000'),
(22, 2, 'Income', 'SAID AL HABSI', 8, '0.000', '0.000'),
(23, 2, 'Income', 'Sami Al Kharousi', 9, '0.000', '0.000'),
(25, 2, 'Expenditure', 'DEPOSIT RETURN', 12, '0.000', '0.000'),
(26, 2, 'Expenditure', 'RENTAL CHARGES RETURN', 11, '0.000', '0.000'),
(27, 2, 'Income', 'EXTRA KM', 11, '0.000', '0.000'),
(28, 2, 'Expenditure', 'Saud Bahwan Automotive LLC', 6, '0.000', '0.000'),
(29, 2, 'Expenditure', 'IBN Haramil Trading', 6, '0.000', '0.000'),
(30, 2, 'Expenditure', 'Magic Touch', 6, '0.000', '0.000'),
(31, 2, 'Expenditure', 'FUEL', 6, '0.000', '0.000'),
(32, 2, 'Expenditure', 'TYRE PUNCTURE', 6, '0.000', '0.000'),
(35, 2, 'Expenditure', 'SERVICE', 7, '0.000', '0.000'),
(36, 2, 'Expenditure', 'REPAIRS AND MAINTENANCE', 7, '0.000', '0.000'),
(37, 2, 'Expenditure', 'PHONE RECHARGE', 10, '0.000', '0.000'),
(38, 2, 'Expenditure', 'SALARY', 10, '0.000', '0.000');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_voucher_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `payment_voucher_date` varchar(12) NOT NULL,
  `payment_ledger` varchar(15) NOT NULL,
  `vehicle_id` varchar(30) DEFAULT NULL,
  `invoice_no` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `payment_amount` decimal(10,3) NOT NULL,
  `description` varchar(200) NOT NULL,
  `mode_of_payment` varchar(20) NOT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`payment_voucher_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_voucher_no`, `branch_id`, `payment_voucher_date`, `payment_ledger`, `vehicle_id`, `invoice_no`, `rental_id`, `payment_amount`, `description`, `mode_of_payment`, `status`) VALUES
(38, 2, '01/08/2015', '4', '7899 T', 0, 0, '1.000', 'Fuel for 7899 T to go to Ghala by Zahir after duty', 'CASH', 'A'),
(39, 2, '02/08/2015', '4', '6522 TB', 0, 0, '1.000', 'Fuel for 6522 T to go to Ghala by Zahir after duty', 'CASH', 'A'),
(40, 2, '02/08/2015', '4', '8338 TB', 0, 0, '1.000', 'Fuel for 8338 T to go to Wadi Kabir for service', 'CASH', 'A'),
(41, 2, '02/08/2015', '4', '4412 TA', 0, 0, '170.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(42, 2, '02/08/2015', '4', '7333 TB', 0, 0, '20.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(43, 2, '02/08/2015', '4', '4600 TA', 0, 0, '190.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(44, 2, '02/08/2015', '4', '100 TA', 0, 0, '95.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(45, 2, '03/08/2015', '4', '0', 0, 0, '31.000', 'Car washing for the month of July', 'CASH', 'A'),
(46, 2, '03/08/2015', '4', '7899 T', 0, 0, '15.000', 'Breakdow recovery charge for 7899 T', 'CASH', 'A'),
(47, 2, '02/08/2015', '4', '8338 TB', 0, 0, '10.000', 'Service car 8338 TB', 'CASH', 'A'),
(48, 2, '03/08/2015', '4', '3738 TB', 0, 0, '28.000', 'Disk Drum', 'CASH', 'A'),
(49, 2, '03/08/2015', '4', '3738 TB', 0, 0, '13.000', 'Breakpad changing to 3838 T', 'CASH', 'A'),
(50, 2, '09/08/2015', '4', '0', 0, 0, '5.000', 'Recharge phone 94688874', 'CASH', 'A'),
(51, 2, '08/08/2015', '4', '0', 0, 0, '150.000', 'Balance Salary for the month of July', 'CASH', 'A'),
(52, 2, '06/08/2015', '4', '3738 TB', 0, 0, '1.000', 'PETROL TO GO TO GHALA AFTER DUTY', 'CASH', 'A'),
(53, 2, '03/08/2015', '4', '3738 TB', 0, 0, '13.000', 'Breakpad Change', 'CASH', 'A'),
(54, 2, '05/08/2015', '4', '0', 34, 34, '50.000', 'DEPOSIT RETURN TO HANANE MAMMAR', 'CASH', 'A'),
(55, 2, '05/08/2015', '4', '8338 TB', 0, 0, '190.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(56, 2, '04/08/2015', '4', '8338 TB', 0, 0, '140.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(57, 2, '04/08/2015', '4', '7333 TB', 0, 0, '50.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(58, 2, '04/08/2015', '4', '6698 TB', 0, 0, '220.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(59, 2, '04/08/2015', '4', '8338 TB', 0, 0, '50.000', 'DEPOSITED IN BANK', 'CASH', 'A'),
(60, 2, '04/08/2015', '4', '100 TA', 0, 0, '3.000', 'PETROL TO GO TO WADI KABIR TO SEARCH TYRE', 'CASH', 'A'),
(61, 2, '04/08/2015', '4', '100 TA', 0, 0, '25.000', 'TYRE PURCHASED', 'CASH', 'A'),
(62, 2, '03/08/2015', '4', '100 TA', 0, 0, '2.000', 'PETROL TO GO TO GOUBRA, GHALA, WADI KABIR', 'CASH', 'A');

-- --------------------------------------------------------

--
-- Stand-in structure for view `payment_view`
--
CREATE TABLE IF NOT EXISTS `payment_view` (
`payment_voucher_no` int(11)
,`branch_id` int(11)
,`payment_voucher_date` date
,`payment_ledger` varchar(15)
,`vehicle_id` varchar(30)
,`invoice_no` int(11)
,`rental_id` int(11)
,`payment_amount` decimal(10,3)
,`description` varchar(200)
,`mode_of_payment` varchar(20)
,`status` char(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `pdc`
--

CREATE TABLE IF NOT EXISTS `pdc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `date_issue` varchar(12) NOT NULL,
  `date_cheque` varchar(12) NOT NULL,
  `cheque_no` varchar(10) NOT NULL,
  `bank_ref` varchar(50) NOT NULL,
  `party_favouring` varchar(100) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `amount` decimal(10,3) NOT NULL,
  `bank_account_no` varchar(16) NOT NULL,
  `vehicle_no` varchar(10) NOT NULL,
  `payment_from_date` varchar(20) NOT NULL,
  `payment_to_date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pdc`
--

INSERT INTO `pdc` (`id`, `branch_id`, `date_issue`, `date_cheque`, `cheque_no`, `bank_ref`, `party_favouring`, `reason`, `amount`, `bank_account_no`, `vehicle_no`, `payment_from_date`, `payment_to_date`) VALUES
(6, 2, '10/08/2015', '10/08/2015', '54828113', 'Bank Muscat', 'Saud Bahwan Automotive LLC', 'PDC for Yaris 5391 T', '147.000', '0435008086510025', '5391 T', '10/08/2015', '10/07/2017'),
(11, 2, '12/08/2015', '12/08/2015', '54790704', 'Bank Muscat', 'Suhail Bahwan Automobiles LLC', 'PDC for Altima 8843 TB', '196.000', '0435008086510025', '8843 TB', '12/08/2015', '12/04/2019'),
(16, 2, '13/08/2015', '13/08/2015', '54828112', 'Bank Muscat', 'OTE', 'PDC for Chevrolet 5279 T', '332.000', '0435008086510025', '5279 T', '13/08/2015', '13/07/2018'),
(17, 2, '13/08/2015', '13/09/2015', '54828111', 'Bank Muscat', 'OTE', 'PDC for Chevrolet 5394 T', '332.000', '0435008086510025', '5394 T', '13/08/2015', '13/07/2018');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE IF NOT EXISTS `quotation_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `engine_capacity` varchar(20) DEFAULT NULL,
  `model_year` int(11) NOT NULL,
  `daily_rate` decimal(10,3) NOT NULL,
  `weekly_rate` decimal(10,3) NOT NULL,
  `monthly_rate` decimal(10,3) NOT NULL,
  `insurance_type` varchar(50) DEFAULT NULL,
  `breakdown_recovery` varchar(10) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_header`
--

CREATE TABLE IF NOT EXISTS `quotation_header` (
  `quotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `quotation_date` varchar(20) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `validity_upto` int(11) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Accepted',
  PRIMARY KEY (`quotation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE IF NOT EXISTS `receipts` (
  `receipt_voucher_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `receipt_voucher_date` varchar(12) NOT NULL,
  `reciept_ledger` varchar(15) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `receipt_amount` decimal(10,3) NOT NULL,
  `description` varchar(200) NOT NULL,
  `mode_of_receipt` varchar(20) NOT NULL,
  `status` char(1) DEFAULT NULL,
  PRIMARY KEY (`receipt_voucher_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_voucher_no`, `branch_id`, `receipt_voucher_date`, `reciept_ledger`, `invoice_no`, `rental_id`, `receipt_amount`, `description`, `mode_of_receipt`, `status`) VALUES
(24, 2, '29/07/2015', '13', 4, 4, '230.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(25, 2, '29/07/2015', '11', 2, 2, '50.000', 'Towards DEPOSIT', 'CASH', 'A'),
(26, 2, '30/07/2015', '20', 0, 0, '500.000', 'Towards petty cash from Dr.Nasser', 'CASH', 'A'),
(27, 2, '30/07/2015', '22', 0, 0, '300.000', 'towards general expenses from Said Al Habsi', 'CASH', 'A'),
(28, 2, '30/07/2015', '13', 9, 9, '45.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(29, 2, '30/07/2015', '13', 7, 7, '120.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(30, 2, '30/07/2015', '13', 8, 8, '45.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(31, 2, '30/07/2015', '13', 3, 3, '20.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(32, 2, '07/07/2015', '13', 17, 17, '150.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(33, 2, '14/05/2015', '13', 19, 19, '560.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(34, 2, '12/07/2015', '13', 21, 21, '150.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(35, 2, '11/07/2015', '13', 22, 22, '150.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(36, 2, '20/06/2015', '13', 24, 24, '320.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(37, 2, '21/06/2015', '13', 24, 24, '30.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(38, 2, '21/07/2015', '13', 25, 25, '110.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(39, 2, '28/07/2015', '13', 25, 25, '80.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(40, 2, '27/06/2015', '13', 26, 26, '170.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(41, 2, '30/07/2015', '13', 27, 27, '170.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(42, 2, '30/07/2015', '13', 28, 28, '20.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(43, 2, '05/07/2015', '13', 29, 29, '180.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(44, 2, '22/07/2015', '13', 30, 30, '110.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(45, 2, '28/07/2015', '13', 32, 32, '260.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(46, 2, '12/07/2015', '13', 34, 34, '150.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(47, 2, '15/07/2015', '13', 35, 35, '190.000', 'Towards RENTAL CHARGES', 'CHEQUE', 'A'),
(48, 2, '28/07/2015', '13', 35, 35, '400.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(49, 2, '28/07/2015', '13', 36, 36, '240.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(50, 2, '04/08/2015', '13', 37, 37, '220.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(51, 2, '02/08/2015', '13', 38, 38, '100.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(52, 2, '04/08/2015', '13', 28, 28, '50.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(53, 2, '05/08/2015', '13', 18, 18, '190.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(54, 2, '13/08/2015', '13', 40, 40, '60.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(55, 2, '13/08/2015', '11', 40, 40, '20.000', 'Towards DEPOSIT', 'CASH', 'A'),
(56, 2, '15/08/2015', '13', 41, 41, '105.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(57, 2, '15/08/2015', '11', 41, 41, '50.000', 'Towards DEPOSIT', 'CASH', 'A'),
(58, 2, '17/08/2015', '13', 42, 42, '35.000', 'Towards RENTAL CHARGES', 'CASH', 'A'),
(59, 2, '17/08/2015', '11', 42, 42, '100.000', 'Towards DEPOSIT', 'CASH', 'A');

-- --------------------------------------------------------

--
-- Stand-in structure for view `receipt_view`
--
CREATE TABLE IF NOT EXISTS `receipt_view` (
`receipt_voucher_no` int(11)
,`branch_id` int(11)
,`receipt_voucher_date` date
,`reciept_ledger` varchar(15)
,`invoice_no` int(11)
,`rental_id` int(11)
,`receipt_amount` decimal(10,3)
,`description` varchar(200)
,`mode_of_receipt` varchar(20)
,`status` char(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `rental_pickup`
--

CREATE TABLE IF NOT EXISTS `rental_pickup` (
  `rental_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_rental` varchar(50) DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `rental_type` varchar(20) NOT NULL,
  `rent_amount` decimal(10,3) NOT NULL,
  `deposit_amount` decimal(10,3) DEFAULT NULL,
  `expected_return_date` varchar(20) DEFAULT NULL,
  `pickup_from_place` varchar(50) DEFAULT NULL,
  `drop_off_place` varchar(50) DEFAULT NULL,
  `km_allowed` int(11) DEFAULT NULL,
  `extra_km_rate` decimal(10,3) DEFAULT NULL,
  `km_reading_out` int(11) DEFAULT NULL,
  `km_reading_in` int(11) DEFAULT NULL,
  `fuel_level` varchar(100) NOT NULL,
  `gps_km` int(11) DEFAULT NULL,
  `actual_km` int(11) DEFAULT NULL,
  `total_km` int(11) DEFAULT NULL,
  PRIMARY KEY (`rental_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `rental_pickup`
--

INSERT INTO `rental_pickup` (`rental_id`, `branch_id`, `customer_id`, `date_rental`, `vehicle_id`, `rental_type`, `rent_amount`, `deposit_amount`, `expected_return_date`, `pickup_from_place`, `drop_off_place`, `km_allowed`, `extra_km_rate`, `km_reading_out`, `km_reading_in`, `fuel_level`, `gps_km`, `actual_km`, `total_km`) VALUES
(17, 2, 42, '04/07/2015', 36, 'Monthly', '150.000', '0.000', '03/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 197075, 0, 'Quarter', 0, 0, 0),
(18, 2, 43, '28/06/2015', 16, 'Monthly', '190.000', '50.000', '28/07/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 126413, 0, 'Quarter', 0, 0, 0),
(19, 2, 44, '04/06/2015', 17, 'Monthly', '560.000', '50.000', '12/10/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 119146, 0, 'Quarter', 0, 0, 0),
(20, 2, 45, '08/07/2015', 11, 'Monthly', '190.000', '50.000', '07/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 28550, 0, 'Quarter', 0, 0, 0),
(21, 2, 28, '12/07/2015', 26, 'Monthly', '150.000', '50.000', '11/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 248020, 0, 'Quarter', 0, 0, 0),
(22, 2, 27, '08/07/2015', 25, 'Monthly', '150.000', '50.000', '07/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 303500, 0, 'Quarter', 0, 0, 0),
(23, 2, 16, '29/07/2015', 3, 'Monthly', '66.667', '165.000', '28/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 23854, 0, 'Quarter', 0, 0, 0),
(24, 2, 11, '21/06/2015', 1, 'Monthly', '350.000', '0.000', '20/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 48350, 0, 'GT Quarter', 0, 0, 0),
(25, 2, 46, '22/07/2015', 24, 'Monthly', '190.000', '0.000', '20/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 37042, 0, 'Quarter', 0, 0, 0),
(26, 2, 14, '29/06/2015', 18, 'Monthly', '170.000', '0.000', '29/07/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 31726, 0, 'Quarter', 0, 0, 0),
(27, 2, 47, '29/07/2015', 12, 'Monthly', '170.000', '0.000', '28/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 37310, 0, 'LT Quarter', 0, 0, 0),
(28, 2, 48, '30/07/2015', 27, 'Daily', '108.000', '0.000', '08/08/2015', 'Al Khuwair', 'Al Khuwair', 200, '0.050', 187880, 0, 'LT Quarter', 0, 0, 0),
(29, 2, 49, '05/07/2015', 13, 'Monthly', '220.000', '0.000', '04/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 23178, 0, 'Quarter', 0, 0, 0),
(30, 2, 29, '22/07/2015', 28, 'Monthly', '110.000', '50.000', '13/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 148829, 0, 'Quarter', 0, 0, 0),
(31, 2, 50, '13/07/2015', 7, 'Monthly', '750.000', '0.000', '12/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.100', 0, 0, 'Quarter', 0, 0, 0),
(32, 2, 51, '28/07/2015', 4, 'Monthly', '260.000', '0.000', '27/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.100', 11015, 0, 'LT Half', 0, 0, 0),
(33, 2, 52, '27/07/2015', 21, 'Monthly', '0.000', '0.000', '26/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 0, 0, 'Quarter', 0, 0, 0),
(34, 2, 53, '06/07/2015', 5, 'Monthly', '180.000', '50.000', '05/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 87184, 0, 'Quarter', 0, 0, 0),
(35, 2, 31, '15/07/2015', 35, 'Monthly', '230.000', '50.000', '14/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 396, 0, 'Quarter', 0, 0, 0),
(36, 2, 54, '28/07/2015', 31, 'Monthly', '240.000', '0.000', '27/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 1890, 0, 'Quarter', 0, 0, 0),
(37, 2, 49, '04/08/2015', 10, 'Monthly', '220.000', '0.000', '03/09/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 19118, 0, 'Quarter', 0, 0, 0),
(38, 2, 55, '28/07/2015', 20, 'Monthly', '190.000', '50.000', '27/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 49993, 0, 'Quarter', 0, 0, 0),
(39, 2, 43, '28/07/2015', 16, 'Monthly', '190.000', '50.000', '31/08/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 132179, 0, 'Quarter', 0, 0, 0),
(40, 2, 56, '13/08/2015', 27, 'Weekly', '60.000', '20.000', '20/08/2015', 'Al Khuwair', 'Al Khuwair', 1200, '0.050', 188369, 0, 'Quarter', 0, 0, 0),
(41, 2, 57, '15/08/2015', 13, 'Weekly', '105.000', '50.000', '25/08/2015', 'Al Khuwair', 'Al Khuwair', 1200, '0.050', 25948, 0, 'Quarter', 0, 0, 0),
(42, 2, 58, '17/08/2015', 14, 'Daily', '35.000', '100.000', '18/08/2015', 'Al Khuwair', 'Al Khuwair', 200, '0.800', 35616, 0, 'Quarter', 0, 0, 0),
(43, 2, 59, '17/08/2015', 22, 'Monthly', '250.000', '0.000', '16/09/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 48958, 0, 'Quarter', 0, 0, 0),
(44, 2, 60, '19/08/2015', 5, 'Daily', '360.000', '0.000', '18/09/2015', 'Al Khuwair', 'Al Khuwair', 4800, '0.050', 88452, 0, 'GT Quarter', 0, 0, 0),
(45, 2, 9, '21/08/2015', 3, 'Daily', '72.000', '50.000', '27/08/2015', 'Al Khuwair', 'Al Khuwair', 200, '0.050', 25600, NULL, 'Quarter', 0, 0, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rental_pickup_view`
--
CREATE TABLE IF NOT EXISTS `rental_pickup_view` (
`rental_id` int(11)
,`date_rental` date
,`Cust_Name` varchar(100)
,`VehicleNo` varchar(20)
,`rental_type` varchar(20)
,`expected_return_date` date
,`return_date` date
,`km_extra_rate` decimal(10,3)
,`total_rent_charges` decimal(10,3)
,`discount` decimal(10,3)
,`net_amount` decimal(10,3)
);
-- --------------------------------------------------------

--
-- Table structure for table `rental_return`
--

CREATE TABLE IF NOT EXISTS `rental_return` (
  `rental_id` int(11) NOT NULL AUTO_INCREMENT,
  `pickup_date` varchar(20) DEFAULT NULL,
  `return_date` varchar(12) DEFAULT NULL,
  `km_in` int(11) DEFAULT NULL,
  `km_used` int(11) DEFAULT NULL,
  `km_extra_used` int(11) DEFAULT NULL,
  `km_extra_rate` decimal(10,3) DEFAULT NULL,
  `total_rented_days` int(11) DEFAULT NULL,
  `rate_per_day` decimal(10,3) DEFAULT NULL,
  `total_rent_charges` decimal(10,3) DEFAULT NULL,
  `fuel_level` varchar(20) DEFAULT NULL,
  `fuel_refil_charges` decimal(10,3) DEFAULT NULL,
  `traffic_fine` decimal(10,3) DEFAULT NULL,
  `additional_driver_charges` decimal(10,3) DEFAULT NULL,
  `chauffer_charges` decimal(10,3) DEFAULT NULL,
  `additional_insurance` decimal(10,3) DEFAULT NULL,
  `pai_charges` decimal(10,3) DEFAULT NULL,
  `misc_charges` decimal(10,3) DEFAULT NULL,
  `deduction` int(11) DEFAULT NULL,
  `discount_type` int(11) NOT NULL DEFAULT '0',
  `discount` decimal(10,3) DEFAULT NULL,
  `invoice_no` int(11) NOT NULL,
  `invoice_date` varchar(20) DEFAULT NULL,
  `invoice_status` varchar(20) NOT NULL,
  `gps_km` int(11) DEFAULT NULL,
  `actual_km` int(11) DEFAULT NULL,
  `total_km` int(11) DEFAULT NULL,
  `net_amount` decimal(10,3) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'incomplete',
  PRIMARY KEY (`rental_id`),
  UNIQUE KEY `invoice_no` (`invoice_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `rental_return`
--

INSERT INTO `rental_return` (`rental_id`, `pickup_date`, `return_date`, `km_in`, `km_used`, `km_extra_used`, `km_extra_rate`, `total_rented_days`, `rate_per_day`, `total_rent_charges`, `fuel_level`, `fuel_refil_charges`, `traffic_fine`, `additional_driver_charges`, `chauffer_charges`, `additional_insurance`, `pai_charges`, `misc_charges`, `deduction`, `discount_type`, `discount`, `invoice_no`, `invoice_date`, `invoice_status`, `gps_km`, `actual_km`, `total_km`, `net_amount`, `remarks`, `status`) VALUES
(17, '04/07/2015', '13/08/2015', 200000, 2925, 0, '0.000', 40, '5.667', '200.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 1, '10.000', 17, '', 'Paid', 0, 0, 0, '190.000', '', 'completed'),
(18, '28/06/2015', '28/07/2015', 0, -126413, 0, '0.000', 30, '8.333', '190.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 18, '', 'Paid', 0, 0, 0, '190.000', NULL, 'completed'),
(19, '04/06/2015', '12/10/2015', 0, -119146, 0, '0.000', 130, '5.667', '650.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 19, '', '', 0, 0, 0, '650.000', NULL, 'incomplete'),
(20, '08/07/2015', '07/08/2015', 0, -28550, 0, '0.000', 30, '7.333', '190.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 20, '', '', 0, 0, 0, '190.000', NULL, 'incomplete'),
(21, '12/07/2015', '11/08/2015', 0, -248020, 0, '0.000', 30, '5.000', '150.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 21, '', '', 0, 0, 0, '150.000', NULL, 'incomplete'),
(22, '08/07/2015', '07/08/2015', 0, -303500, 0, '0.000', 30, '5.000', '165.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 22, '', 'Paid', 0, 0, 0, '165.000', '', 'completed'),
(23, '29/07/2015', '08/08/2015', 23990, 136, 0, '0.000', 10, '6.667', '120.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '20.000', 23, '', 'Paid', 0, 0, 0, '96.000', NULL, 'completed'),
(24, '21/06/2015', '20/08/2015', 0, -48350, 0, '0.000', 60, '6.667', '350.000', 'GT Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 24, '', '', 0, 0, 0, '350.000', NULL, 'incomplete'),
(25, '22/07/2015', '20/08/2015', 0, -37042, 0, '0.000', 29, '8.333', '190.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 25, '', '', 0, 0, 0, '190.000', NULL, 'incomplete'),
(26, '29/06/2015', '29/07/2015', 0, -31726, 0, '0.000', 30, '8.333', '170.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 26, '', '', 0, 0, 0, '170.000', NULL, 'incomplete'),
(27, '29/07/2015', '28/08/2015', 0, -37310, 0, '0.000', 30, '7.333', '170.000', 'LT Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 27, '', '', 0, 0, 0, '170.000', NULL, 'incomplete'),
(28, '30/07/2015', '08/08/2015', 188373, 493, 0, '0.000', 9, '12.000', '108.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 1, '38.000', 28, '', 'Paid', 0, 0, 0, '70.000', NULL, 'completed'),
(29, '05/07/2015', '04/08/2015', 25701, 2523, 0, '0.000', 30, '7.333', '220.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 1, '40.000', 29, '', 'Paid', 0, 0, 0, '180.000', NULL, 'completed'),
(30, '22/07/2015', '13/08/2015', 0, -148829, 0, '0.000', 22, '5.667', '150.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 30, '', '', 0, 0, 0, '150.000', NULL, 'incomplete'),
(31, '13/07/2015', '12/08/2015', 0, 0, 0, '0.000', 30, '23.333', '750.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 31, '', '', 0, 0, 0, '750.000', NULL, 'incomplete'),
(32, '28/07/2015', '27/08/2015', 0, -11015, 0, '0.000', 30, '20.000', '260.000', 'LT Half', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 32, '', '', 0, 0, 0, '260.000', NULL, 'incomplete'),
(33, '27/07/2015', '26/08/2015', 0, 0, 0, '0.000', 30, '8.333', '0.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 33, '', '', 0, 0, 0, '0.000', NULL, 'incomplete'),
(34, '06/07/2015', '05/08/2015', 88405, 1221, 0, '0.000', 30, '6.000', '180.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 180, 0, '0.000', 34, '', 'Paid', 0, 0, 0, '0.000', NULL, 'completed'),
(35, '15/07/2015', '14/08/2015', 0, -396, 0, '0.000', 30, '8.333', '230.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 35, '', '', 0, 0, 0, '230.000', NULL, 'incomplete'),
(36, '28/07/2015', '27/08/2015', 0, -1890, 0, '0.000', 30, '8.333', '240.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 36, '', '', 0, 0, 0, '240.000', NULL, 'incomplete'),
(37, '04/08/2015', '03/09/2015', 0, -19118, 0, '0.000', 30, '8.667', '220.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 37, '', '', 0, 0, 0, '220.000', NULL, 'incomplete'),
(38, '28/07/2015', '27/08/2015', 0, -49993, 0, '0.000', 30, '8.333', '190.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 38, '', '', 0, 0, 0, '190.000', NULL, 'incomplete'),
(39, '28/07/2015', '31/08/2015', 0, -132179, 0, '0.000', 34, '8.333', '190.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 39, '', '', 0, 0, 0, '190.000', NULL, 'incomplete'),
(40, '13/08/2015', '20/08/2015', 0, -188369, 0, '0.000', 7, '8.571', '60.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 40, '', '', 0, 0, 0, '60.000', NULL, 'incomplete'),
(41, '15/08/2015', '25/08/2015', 0, -25948, 0, '0.000', 10, '11.429', '105.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 41, '', '', 0, 0, 0, '105.000', NULL, 'incomplete'),
(42, '17/08/2015', '18/08/2015', 36033, 417, 217, '22.000', 1, '35.000', '35.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 1, '7.000', 42, '', 'Paid', 0, 0, 0, '0.000', NULL, 'completed'),
(43, '17/08/2015', '16/09/2015', 0, -48958, 0, '0.000', 30, '8.333', '250.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 43, '', '', 0, 0, 0, '250.000', NULL, 'incomplete'),
(44, '19/08/2015', '18/09/2015', 0, -88452, 0, '0.000', 30, '6.000', '130.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 0, '0.000', 44, '', '', 0, 0, 0, '130.000', NULL, 'incomplete'),
(45, '21/08/2015', '', 0, -25600, 0, '0.000', 6, '12.000', '72.000', 'Quarter', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 0, 1, '0.000', 45, '', '', 0, 0, 0, '72.000', NULL, 'incomplete');

-- --------------------------------------------------------

--
-- Stand-in structure for view `rental_return_view`
--
CREATE TABLE IF NOT EXISTS `rental_return_view` (
`rental_id` int(11)
,`vehicle_reg_no` varchar(20)
,`pickup_date` date
,`return_date` date
,`total_rented_days` int(11)
,`km_used` int(11)
,`km_extra_used` int(11)
,`rate_per_day` decimal(10,3)
,`total_rent_charges` decimal(10,3)
,`km_extra_rate` decimal(10,3)
,`discount` decimal(10,3)
,`net_amount` decimal(10,3)
);
-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `default_branch_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE IF NOT EXISTS `transaction_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `voucher_type` varchar(10) NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `ledger_no` int(11) NOT NULL,
  `dr_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `cr_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `voucher_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=243 ;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `voucher_type`, `voucher_no`, `ledger_no`, `dr_amount`, `cr_amount`, `voucher_status`) VALUES
(137, 69, 'C', 32, 4, '150.000', '0.000', 1),
(138, 69, 'D', 32, 13, '0.000', '150.000', 1),
(139, 70, 'C', 33, 4, '560.000', '0.000', 1),
(140, 70, 'D', 33, 13, '0.000', '560.000', 1),
(141, 71, 'C', 34, 4, '150.000', '0.000', 1),
(142, 71, 'D', 34, 13, '0.000', '150.000', 1),
(143, 72, 'C', 35, 4, '150.000', '0.000', 1),
(144, 72, 'D', 35, 13, '0.000', '150.000', 1),
(145, 73, 'C', 36, 4, '320.000', '0.000', 1),
(146, 73, 'D', 36, 13, '0.000', '320.000', 1),
(147, 74, 'C', 37, 4, '30.000', '0.000', 1),
(148, 74, 'D', 37, 13, '0.000', '30.000', 1),
(149, 75, 'C', 38, 4, '110.000', '0.000', 1),
(150, 75, 'D', 38, 13, '0.000', '110.000', 1),
(151, 76, 'C', 39, 4, '80.000', '0.000', 1),
(152, 76, 'D', 39, 13, '0.000', '80.000', 1),
(153, 77, 'C', 40, 4, '170.000', '0.000', 1),
(154, 77, 'D', 40, 13, '0.000', '170.000', 1),
(155, 78, 'C', 41, 4, '170.000', '0.000', 1),
(156, 78, 'D', 41, 13, '0.000', '170.000', 1),
(157, 79, 'C', 42, 4, '20.000', '0.000', 1),
(158, 79, 'D', 42, 13, '0.000', '20.000', 1),
(159, 80, 'C', 43, 4, '180.000', '0.000', 1),
(160, 80, 'D', 43, 13, '0.000', '180.000', 1),
(161, 81, 'C', 44, 4, '110.000', '0.000', 1),
(162, 81, 'D', 44, 13, '0.000', '110.000', 1),
(163, 82, 'C', 45, 4, '260.000', '0.000', 1),
(164, 82, 'D', 45, 13, '0.000', '260.000', 1),
(165, 83, 'C', 46, 4, '150.000', '0.000', 1),
(166, 83, 'D', 46, 13, '0.000', '150.000', 1),
(167, 84, 'C', 47, 4, '190.000', '0.000', 1),
(168, 84, 'D', 47, 13, '0.000', '190.000', 1),
(169, 85, 'C', 48, 4, '400.000', '0.000', 1),
(170, 85, 'D', 48, 13, '0.000', '400.000', 1),
(171, 86, 'C', 49, 4, '240.000', '0.000', 1),
(172, 86, 'D', 49, 13, '0.000', '240.000', 1),
(173, 87, 'D', 38, 31, '1.000', '0.000', 1),
(174, 87, 'C', 38, 4, '0.000', '1.000', 1),
(175, 88, 'D', 39, 31, '1.000', '0.000', 1),
(176, 88, 'C', 39, 4, '0.000', '1.000', 1),
(177, 89, 'D', 40, 31, '1.000', '0.000', 1),
(178, 89, 'C', 40, 4, '0.000', '1.000', 1),
(179, 90, 'C', 50, 4, '220.000', '0.000', 1),
(180, 90, 'D', 50, 13, '0.000', '220.000', 1),
(181, 91, 'D', 41, 18, '170.000', '0.000', 1),
(182, 91, 'C', 41, 4, '0.000', '170.000', 1),
(183, 92, 'D', 42, 18, '20.000', '0.000', 1),
(184, 92, 'C', 42, 4, '0.000', '20.000', 1),
(185, 93, 'D', 43, 18, '190.000', '0.000', 1),
(186, 93, 'C', 43, 4, '0.000', '190.000', 1),
(187, 94, 'D', 44, 18, '95.000', '0.000', 1),
(188, 94, 'C', 44, 4, '0.000', '95.000', 1),
(189, 95, 'D', 45, 6, '31.000', '0.000', 1),
(190, 95, 'C', 45, 4, '0.000', '31.000', 1),
(191, 96, 'D', 46, 6, '15.000', '0.000', 1),
(192, 96, 'C', 46, 4, '0.000', '15.000', 1),
(193, 97, 'D', 47, 35, '10.000', '0.000', 1),
(194, 97, 'C', 47, 4, '0.000', '10.000', 1),
(195, 98, 'D', 48, 36, '28.000', '0.000', 1),
(196, 98, 'C', 48, 4, '0.000', '28.000', 1),
(197, 99, 'D', 49, 36, '13.000', '0.000', 1),
(198, 99, 'C', 49, 4, '0.000', '13.000', 1),
(199, 100, 'C', 51, 4, '100.000', '0.000', 1),
(200, 100, 'D', 51, 13, '0.000', '100.000', 1),
(201, 101, 'C', 52, 4, '50.000', '0.000', 1),
(202, 101, 'D', 52, 13, '0.000', '50.000', 1),
(203, 102, 'C', 53, 4, '190.000', '0.000', 1),
(204, 102, 'D', 53, 13, '0.000', '190.000', 1),
(205, 103, 'D', 50, 37, '5.000', '0.000', 1),
(206, 103, 'C', 50, 4, '0.000', '5.000', 1),
(207, 104, 'D', 51, 38, '150.000', '0.000', 1),
(208, 104, 'C', 51, 4, '0.000', '150.000', 1),
(209, 105, 'D', 52, 31, '1.000', '0.000', 1),
(210, 105, 'C', 52, 4, '0.000', '1.000', 1),
(211, 106, 'D', 53, 36, '13.000', '0.000', 1),
(212, 106, 'C', 53, 4, '0.000', '13.000', 1),
(213, 107, 'D', 54, 25, '50.000', '0.000', 1),
(214, 107, 'C', 54, 4, '0.000', '50.000', 1),
(215, 108, 'D', 55, 18, '190.000', '0.000', 1),
(216, 108, 'C', 55, 4, '0.000', '190.000', 1),
(217, 109, 'D', 56, 18, '140.000', '0.000', 1),
(218, 109, 'C', 56, 4, '0.000', '140.000', 1),
(219, 110, 'D', 57, 18, '50.000', '0.000', 1),
(220, 110, 'C', 57, 4, '0.000', '50.000', 1),
(221, 111, 'D', 58, 18, '220.000', '0.000', 1),
(222, 111, 'C', 58, 4, '0.000', '220.000', 1),
(223, 112, 'D', 59, 18, '50.000', '0.000', 1),
(224, 112, 'C', 59, 4, '0.000', '50.000', 1),
(225, 113, 'D', 60, 31, '3.000', '0.000', 1),
(226, 113, 'C', 60, 4, '0.000', '3.000', 1),
(227, 114, 'D', 61, 36, '25.000', '0.000', 1),
(228, 114, 'C', 61, 4, '0.000', '25.000', 1),
(229, 115, 'D', 62, 31, '2.000', '0.000', 1),
(230, 115, 'C', 62, 4, '0.000', '2.000', 1),
(231, 116, 'C', 54, 4, '60.000', '0.000', 1),
(232, 116, 'D', 54, 13, '0.000', '60.000', 1),
(233, 117, 'C', 55, 4, '20.000', '0.000', 1),
(234, 117, 'D', 55, 11, '0.000', '20.000', 1),
(235, 118, 'C', 56, 4, '105.000', '0.000', 1),
(236, 118, 'D', 56, 13, '0.000', '105.000', 1),
(237, 119, 'C', 57, 4, '50.000', '0.000', 1),
(238, 119, 'D', 57, 11, '0.000', '50.000', 1),
(239, 120, 'C', 58, 4, '35.000', '0.000', 1),
(240, 120, 'D', 58, 13, '0.000', '35.000', 1),
(241, 121, 'C', 59, 4, '100.000', '0.000', 1),
(242, 121, 'D', 59, 11, '0.000', '100.000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_header`
--

CREATE TABLE IF NOT EXISTS `transaction_header` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_reg_no` varchar(30) DEFAULT NULL,
  `transaction_date` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,3) NOT NULL,
  `voucher_no` int(11) NOT NULL,
  `voucher_date` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `cheque_no` int(11) DEFAULT NULL,
  `cheque_date` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `from_account` varchar(50) NOT NULL,
  `to_account` varchar(50) NOT NULL,
  `narration` varchar(200) NOT NULL,
  `transaction_ref` varchar(50) NOT NULL,
  `voucher_status` char(1) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

--
-- Dumping data for table `transaction_header`
--

INSERT INTO `transaction_header` (`transaction_id`, `vehicle_id`, `vehicle_reg_no`, `transaction_date`, `type`, `amount`, `voucher_no`, `voucher_date`, `mode`, `cheque_no`, `cheque_date`, `bank_name`, `from_account`, `to_account`, `narration`, `transaction_ref`, `voucher_status`) VALUES
(69, 36, NULL, '01/08/2015', 'R', '150.000', 32, '07/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(70, 17, NULL, '01/08/2015', 'R', '560.000', 33, '14/05/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(71, 26, NULL, '01/08/2015', 'R', '150.000', 34, '12/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(72, 25, NULL, '01/08/2015', 'R', '150.000', 35, '11/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(73, 1, NULL, '01/08/2015', 'R', '320.000', 36, '20/06/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(74, 1, NULL, '01/08/2015', 'R', '30.000', 37, '21/06/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(75, 24, NULL, '01/08/2015', 'R', '110.000', 38, '21/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(76, 24, NULL, '01/08/2015', 'R', '80.000', 39, '28/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(77, 18, NULL, '01/08/2015', 'R', '170.000', 40, '27/06/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(78, 12, NULL, '01/08/2015', 'R', '170.000', 41, '30/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(79, 27, NULL, '01/08/2015', 'R', '20.000', 42, '30/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(80, 13, NULL, '01/08/2015', 'R', '180.000', 43, '05/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(81, 28, NULL, '01/08/2015', 'R', '110.000', 44, '22/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(82, 4, NULL, '01/08/2015', 'R', '260.000', 45, '28/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(83, 5, NULL, '01/08/2015', 'R', '150.000', 46, '12/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(84, 35, NULL, '01/08/2015', 'R', '190.000', 47, '15/07/2015', 'CHEQUE', 55012301, '28/07/2015', 'BANK MUSCAT', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(85, 35, NULL, '01/08/2015', 'R', '400.000', 48, '28/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(86, 31, NULL, '01/08/2015', 'R', '240.000', 49, '28/07/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(87, 0, '7899 T', '03/08/2015', 'P', '1.000', 38, '01/08/2015', 'CASH', 0, '', '', '31', '4', 'Fuel for 7899 T to go to Ghala by Zahir after duty', '', '1'),
(88, 0, '6522 TB', '03/08/2015', 'P', '1.000', 39, '02/08/2015', 'CASH', 0, '', '', '31', '4', 'Fuel for 6522 T to go to Ghala by Zahir after duty', '', '1'),
(89, 0, '8338 TB', '03/08/2015', 'P', '1.000', 40, '02/08/2015', 'CASH', 0, '', '', '31', '4', 'Fuel for 8338 T to go to Wadi Kabir for service', '', '1'),
(90, 10, NULL, '06/08/2015', 'R', '220.000', 50, '04/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(91, 0, '4412 TA', '06/08/2015', 'P', '170.000', 41, '02/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(92, 0, '7333 TB', '06/08/2015', 'P', '20.000', 42, '02/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(93, 0, '4600 TA', '06/08/2015', 'P', '190.000', 43, '02/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(94, 0, '100 TA', '06/08/2015', 'P', '95.000', 44, '02/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(95, 0, '0', '06/08/2015', 'P', '31.000', 45, '03/08/2015', 'CASH', 0, '', '', '6', '4', 'Car washing for the month of July', '', '1'),
(96, 0, '7899 T', '06/08/2015', 'P', '15.000', 46, '03/08/2015', 'CASH', 0, '', '', '6', '4', 'Breakdow recovery charge for 7899 T', '', '1'),
(97, 0, '8338 TB', '06/08/2015', 'P', '10.000', 47, '02/08/2015', 'CASH', 0, '', '', '35', '4', 'Service car 8338 TB', '', '1'),
(98, 0, '3738 TB', '06/08/2015', 'P', '28.000', 48, '03/08/2015', 'CASH', 0, '', '', '36', '4', 'Disk Drum', '', '1'),
(99, 0, '3738 TB', '06/08/2015', 'P', '13.000', 49, '03/08/2015', 'CASH', 0, '', '', '36', '4', 'Breakpad changing to 3838 T', '', '1'),
(100, 20, NULL, '08/08/2015', 'R', '100.000', 51, '02/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(101, 27, NULL, '08/08/2015', 'R', '50.000', 52, '04/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(102, 16, NULL, '08/08/2015', 'R', '190.000', 53, '05/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(103, 0, '0', '09/08/2015', 'P', '5.000', 50, '09/08/2015', 'CASH', 0, '', '', '37', '4', 'Recharge phone 94688874', '', '1'),
(104, 0, '0', '09/08/2015', 'P', '150.000', 51, '08/08/2015', 'CASH', 0, '', '', '38', '4', 'Balance Salary for the month of July', '', '1'),
(105, 0, '3738 TB', '09/08/2015', 'P', '1.000', 52, '06/08/2015', 'CASH', 0, '', '', '31', '4', 'PETROL TO GO TO GHALA AFTER DUTY', '', '1'),
(106, 0, '3738 TB', '09/08/2015', 'P', '13.000', 53, '03/08/2015', 'CASH', 0, '', '', '36', '4', 'Breakpad Change', '', '1'),
(107, 5, '0', '09/08/2015', 'P', '50.000', 54, '05/08/2015', 'CASH', 0, '', '', '25', '4', 'DEPOSIT RETURN TO HANANE MAMMAR', '', '1'),
(108, 0, '8338 TB', '09/08/2015', 'P', '190.000', 55, '05/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(109, 0, '8338 TB', '09/08/2015', 'P', '140.000', 56, '04/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(110, 0, '7333 TB', '09/08/2015', 'P', '50.000', 57, '04/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(111, 0, '6698 TB', '09/08/2015', 'P', '220.000', 58, '04/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(112, 0, '8338 TB', '09/08/2015', 'P', '50.000', 59, '04/08/2015', 'CASH', 0, '', '', '18', '4', 'DEPOSITED IN BANK', '', '1'),
(113, 0, '100 TA', '09/08/2015', 'P', '3.000', 60, '04/08/2015', 'CASH', 0, '', '', '31', '4', 'PETROL TO GO TO WADI KABIR TO SEARCH TYRE', '', '1'),
(114, 0, '100 TA', '09/08/2015', 'P', '25.000', 61, '04/08/2015', 'CASH', 0, '', '', '36', '4', 'TYRE PURCHASED', '', '1'),
(115, 0, '100 TA', '09/08/2015', 'P', '2.000', 62, '03/08/2015', 'CASH', 0, '', '', '31', '4', 'PETROL TO GO TO GOUBRA, GHALA, WADI KABIR', '', '1'),
(116, 27, NULL, '19/08/2015', 'R', '60.000', 54, '13/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(117, 27, NULL, '19/08/2015', 'R', '20.000', 55, '13/08/2015', 'CASH', 0, '', '', '11', '4', 'Towards DEPOSIT', '', '1'),
(118, 13, NULL, '19/08/2015', 'R', '105.000', 56, '15/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(119, 13, NULL, '19/08/2015', 'R', '50.000', 57, '15/08/2015', 'CASH', 0, '', '', '11', '4', 'Towards DEPOSIT', '', '1'),
(120, 14, NULL, '19/08/2015', 'R', '35.000', 58, '17/08/2015', 'CASH', 0, '', '', '13', '4', 'Towards RENTAL CHARGES', '', '1'),
(121, 14, NULL, '19/08/2015', 'R', '100.000', 59, '17/08/2015', 'CASH', 0, '', '', '11', '4', 'Towards DEPOSIT', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_image` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `user_image`) VALUES
(1, '127.0.0.1', 'administrator', 'UtT2p4GUEa/UltF2yangu.248ba13470fd2e03b7', '', 'dhavalthakor28691@gmail.com', '', NULL, NULL, 'I2KdOy8FIqhHmvqXdRfLY.', 1268889823, 1440406232, 1, 'Dhaval', 'Thakor', 'vakratunda system', '0', 'user-1.jpg'),
(2, '127.0.0.1', 'milansoni', '6XyBJdnqVGJzS50l7tkkiu54266301b940ce6dc0', NULL, 'milan@gmail.com', NULL, NULL, NULL, NULL, 1431413588, 1431435577, 1, 'milan', 'soni', 'vakratunda system', '7878787878', ''),
(3, '223.185.185.60', 'mari ponniah', 'Qb4WDjYOD91iLFESf97rSe49624155b8a71ccdce', NULL, 'ponniahmaari@gmail.com', NULL, NULL, NULL, 'YnEQkCJVMHttI1XhACzdYO', 1431674625, 1440059051, 1, 'MARI', 'PONNIAH', 'Sastha Software Solutions LLP', '9047030898', 'user-3.png'),
(4, '85.154.125.72', 'nasser al habsi', 'ap0yzqAICzGm5fD7jL7rv.1f50e37ce6c4cfeeaf', NULL, 'nasser@hotmail.com', NULL, NULL, NULL, 'ERnl7XojKYzSD.o.WPr7Eu', 1434157141, 1438449564, 1, 'Nasser', 'Al Habsi', 'Morning Star Rent A Car', '99441688', 'user-3.png'),
(5, '85.154.125.72', 'jishnu p', 'oUk4mhb6u8PEzNlxXV7d8u4624dd55ffcdbbf45d', NULL, 'jishnupuliyankot@gmail.com', NULL, NULL, NULL, NULL, 1434157686, 1439986569, 1, 'Jishnu', 'Puliyankot', 'Morning Star Rent A Car', '96643768', 'user-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(25, 1, 1),
(24, 2, 2),
(27, 3, 1),
(31, 4, 1),
(30, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `vehicle_reg_no` varchar(20) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `finance_company` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `trans_type` varchar(10) NOT NULL,
  `vehicle_type` varchar(20) NOT NULL,
  `model` varchar(100) NOT NULL,
  `model_year` varchar(20) NOT NULL,
  `reg_expiry_date` varchar(100) NOT NULL,
  `insurance_type` varchar(20) NOT NULL,
  `breakdown_recovery` varchar(10) DEFAULT NULL,
  `insurance_company` varchar(100) NOT NULL,
  `insurance_expiry_date` varchar(20) NOT NULL,
  `vehicle_availibility` varchar(20) NOT NULL,
  `image` varchar(200) NOT NULL,
  `seating_capacity` varchar(10) NOT NULL,
  `engine_capacity` varchar(100) NOT NULL,
  `daily_rate` decimal(10,3) NOT NULL,
  `weekly_rate` decimal(10,3) NOT NULL,
  `month_rate` decimal(10,3) NOT NULL,
  `extra_km` decimal(10,3) DEFAULT NULL,
  `vehicle_cost` decimal(10,3) DEFAULT NULL,
  `gps_id` varchar(100) NOT NULL,
  `fuel_type` varchar(10) NOT NULL,
  `date_fleet_inclusion` varchar(20) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `branch_id`, `vehicle_reg_no`, `owner_id`, `finance_company`, `brand`, `trans_type`, `vehicle_type`, `model`, `model_year`, `reg_expiry_date`, `insurance_type`, `breakdown_recovery`, `insurance_company`, `insurance_expiry_date`, `vehicle_availibility`, `image`, `seating_capacity`, `engine_capacity`, `daily_rate`, `weekly_rate`, `month_rate`, `extra_km`, `vehicle_cost`, `gps_id`, `fuel_type`, `date_fleet_inclusion`, `remarks`) VALUES
(1, 2, '2381 TB', 2, 'United Finance', 'CHEVROLET/AVEO', 'Automatic', 'Saloon Car', 'CHEVROLET/AVEO', '2013', '01/05/2020', 'Comprehensive', 'yes', 'New India Insurance', '31/12/2015', 'Rented', 'vehicle-1.png', '5', '1.2', '12.000', '70.000', '200.000', '0.050', NULL, '2381 TB', 'Petrol', '05/01/2013', 'Test'),
(3, 2, '2382 TB', 2, '', 'CHEVROLET/AVEO', 'Automatic', 'Saloon Car', 'CHEVROLET/AVEO', '2013', '', 'Comprehensive', 'yes', '', '', 'Rented', '', '5', '1.4', '12.000', '70.000', '200.000', '0.050', NULL, '2382 TB', 'Petrol', '', ''),
(4, 2, '200 TA', 2, '', 'MITSUBISHI/OUTLANDER', 'Automatic', '4 x 4', 'MITSUBISHI/OUTLANDER', '2015', '', 'Comprehensive', 'yes', 'New India Insurance', '', 'Rented', '', '7', '2.4', '30.000', '210.000', '600.000', '0.100', NULL, '200 TA', 'Petrol', '', ''),
(5, 2, '8308 TB', 4, '', 'NISSAN/SUNNY', 'Automatic', 'Saloon Car', 'NISSAN/SUNNY', '2011', '', 'Comprehensive', 'yes', 'New India Insurance', '', 'Available', '', '5', '1.6', '12.000', '75.000', '180.000', '0.050', '0.000', '8308 TB', 'Petrol', '', ''),
(6, 2, '8843 TB', 2, '', 'NISSAN/ALTIMA', 'Automatic', 'Saloon Car', 'NISSAN/ALTIMA', '2015', '16/06/2015', 'Comprehensive', 'yes', 'New India Insurance', '', 'Repair', '', '5', '2.5', '24.000', '120.000', '280.000', '0.050', NULL, '', 'Petrol', '', ''),
(7, 2, '177 TB', 2, '', 'NISSAN/PATROL', 'Automatic', '4 x 4', 'NISSAN/PATROL', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '01/05/2015', 'Rented', '', '7', '5.6', '45.000', '315.000', '700.000', '0.100', NULL, '177 TB', 'Petrol', '', ''),
(8, 2, '6521 TB', 3, '', 'NISSAN/SENTRA', 'Automatic', 'Saloon Car', 'NISSAN/SENTRA', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '', 'Available', '', '5', '1.6', '17.000', '95.000', '260.000', '0.050', '0.000', '6521 TB', 'Petrol', '', ''),
(9, 2, '6522 TB', 2, '', 'NISSAN/SENTRA', 'Automatic', 'Saloon Car', 'NISSAN/SENTRA', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '29/10/2015', 'Available', '', '5', '1.0', '17.000', '95.000', '260.000', '0.050', NULL, '6522 TB', 'Petrol', '', ''),
(10, 2, '6698 TB', 4, '', 'NISSAN/SENTRA', 'Automatic', 'Saloon Car', 'NISSAN/SENTRA', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '15/11/2015', 'Rented', '', '5', '1.6', '17.000', '95.000', '260.000', '0.050', '0.000', '6698 TB', 'Petrol', '', ''),
(11, 2, '2149 TB', 2, '', 'NISSAN/SUNNY', 'Automatic', 'Saloon Car', 'NISSAN/SUNNY', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '05/04/2016', 'Rented', '', '5', '1.5', '14.000', '80.000', '220.000', '0.050', NULL, '2149 TB', 'Petrol', '', ''),
(12, 2, '4412 TA', 2, '', 'NISSAN/SUNNY', 'Automatic', 'Saloon Car', 'NISSAN/SUNNY', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '05/04/2016', 'Rented', '', '5', '1.5', '14.000', '80.000', '220.000', '0.050', NULL, '4412 TA', 'Petrol', '', ''),
(13, 2, '4904 TB', 4, '', 'NISSAN/SUNNY', 'Automatic', 'Saloon Car', 'NISSAN/SUNNY', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '01/05/2015', 'Rented', '', '5', '1.5', '14.000', '80.000', '220.000', '0.050', '0.000', '4904 TB', 'Petrol', '', ''),
(14, 2, '100 TA', 2, '', 'NISSAN/XTERRA', 'Automatic', '4 x 4', 'NISSAN/XTERRA', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '20/07/2015', 'Available', '', '5', '4.0', '35.000', '210.000', '650.000', '0.100', NULL, '100 TA', 'Petrol', '20/06/2015', 'Test'),
(16, 2, '8338 TB', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2010', '', 'Comprehensive', 'yes', 'New India Insurance', '04/02/2016', 'Rented', '', '5', '1.6', '16.000', '90.000', '250.000', '0.050', NULL, '8338 TB', 'Petrol', '', ''),
(17, 2, '8666 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2010', '', 'Comprehensive', 'yes', 'New India Insurance', '24/02/2016', 'Rented', '', '5', '1.3', '12.000', '70.000', '170.000', '0.050', NULL, '8666 TB', 'Petrol', '', ''),
(18, 2, '2366 TB', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2013', '', 'Comprehensive', 'yes', 'New India Insurance', '23/11/2015', 'Rented', '', '5', '1.6', '16.000', '90.000', '250.000', '0.050', NULL, '2366 TB', 'Petrol', '', ''),
(19, 2, '3738 TB', 3, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2008', '', 'Comprehensive', 'yes', 'New India Insurance', '02/04/2016', 'Available', '', '5', '1.6', '14.000', '80.000', '220.000', '0.050', '0.000', '3738 TB', 'Petrol', '', ''),
(20, 2, '4600 TA', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2013', '', 'Comprehensive', 'yes', 'New India Insurance', '11/05/2015', 'Rented', '', '5', '1.6', '16.000', '90.000', '250.000', '0.050', NULL, '4600 TA', 'Petrol', '', ''),
(21, 2, '7898 T', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2013', '', 'Comprehensive', 'yes', 'New India Insurance', '10/07/2015', 'Rented', '', '5', '1.6', '16.000', '90.000', '250.000', '0.050', NULL, '7898 T', 'Petrol', '19/06/2015', ''),
(22, 2, '7899 T', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2013', '', 'Comprehensive', 'yes', 'New India Insurance', '10/07/2015', 'Rented', '', '5', '1.6', '16.000', '90.000', '250.000', '0.050', NULL, '7899 T', 'Petrol', '', ''),
(23, 2, '6697 TB', 2, '', 'TOYOTA/COROLLA', 'Automatic', 'Saloon Car', 'TOYOTA/COROLLA', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '18/11/2015', 'Available', '', '5', '1.6', '18.000', '100.000', '270.000', '0.050', NULL, '6697 TB', 'Petrol', '', ''),
(24, 2, '1584 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2014', '', 'Comprehensive', 'yes', 'New India Insurance', '11/11/2015', 'Rented', '', '5', '1.5', '15.000', '90.000', '250.000', '0.050', NULL, '1584 TB', 'Petrol', '', ''),
(25, 2, '2383 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2008', '', 'Comprehensive', 'yes', 'New India Insurance', '20/11/2015', 'Available', '', '5', '1.3', '12.000', '60.000', '150.000', '0.050', NULL, '2383 TB', 'Petrol', '', ''),
(26, 2, '2442 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2008', '', 'Comprehensive', 'yes', 'New India Insurance', '04/01/2016', 'Rented', '', '5', '1.3', '12.000', '60.000', '150.000', '0.050', NULL, '2442 TB', 'Petrol', '', ''),
(27, 2, '7333 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2008', '', 'Comprehensive', 'yes', 'New India Insurance', '02/12/2015', 'Rented', '', '5', '1.3', '12.000', '60.000', '150.000', '0.050', NULL, '7333 TB', 'Petrol', '', ''),
(28, 2, '7423 TB', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2010', '24/11/20105', 'Comprehensive', 'yes', 'New India Insurance', '24/11/20105', 'Rented', '', '5', '1.3', '12.000', '70.000', '170.000', '0.050', NULL, '7423 TB', 'Petrol', '', ''),
(31, 2, '5279 T', 2, '', 'CHEVROLET/CRUZE', 'Automatic', 'Saloon Car', 'CHEVROLET/CRUZE', '2015', '30/06/2016', 'Comprehensive', 'yes', 'NEW INDIA ASSURANCE', '29/10/2015', 'Rented', '', '4', '1.8', '16.000', '90.000', '250.000', '0.050', '0.000', '', 'Petrol', '', ''),
(34, 2, '5391 T', 2, '', 'TOYOTA/YARIS', 'Automatic', 'Saloon Car', 'TOYOTA/YARIS', '2015', '30/06/2016', 'Comprehensive', 'yes', 'NEW INDIA ASSURANCE', '29/10/2015', 'Available', '', '4', '1.3', '14.000', '80.000', '220.000', '0.050', '0.000', '', 'Petrol', '', ''),
(35, 2, '5394 T', 2, '', 'CHEVROLET/CRUZE', 'Automatic', 'Saloon Car', 'CHEVROLET/CRUZE', '2015', '30/06/2016', 'Comprehensive', 'yes', 'NEW INDIA ASSURANCE', '29/10/2015', 'Rented', '', '4', '1.8', '16.000', '90.000', '250.000', '0.050', '0.000', '', 'Petrol', '', ''),
(36, 2, '7433 TB', 2, '', '', 'Automatic', 'Saloon Car', '', '2010', '', 'Comprehensive', 'yes', 'NEW INDIA ASSURANCE', '', 'Available', '', '5', '1.3', '12.000', '60.000', '170.000', '0.050', '0.000', '7433 TB', 'Petrol', '', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vehicle_expense`
--
CREATE TABLE IF NOT EXISTS `vehicle_expense` (
`id` int(11)
,`vehicle_reg_no` varchar(20)
,`transaction_id` int(11)
,`brand` varchar(100)
,`description` varchar(200)
,`transaction_date` varchar(50)
,`expense` decimal(10,3)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vehicle_income`
--
CREATE TABLE IF NOT EXISTS `vehicle_income` (
`id` int(11)
,`vehicle_reg_no` varchar(20)
,`transaction_id` int(11)
,`brand` varchar(100)
,`description` varchar(200)
,`transaction_date` varchar(50)
,`income` decimal(10,3)
);
-- --------------------------------------------------------

--
-- Table structure for table `vehicle_owner`
--

CREATE TABLE IF NOT EXISTS `vehicle_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_abbrev` varchar(100) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vehicle_owner`
--

INSERT INTO `vehicle_owner` (`id`, `company_abbrev`, `company_name`, `name`, `mobile_no`, `email`) VALUES
(2, 'MSRC', 'Morning Star Rent A Car', 'Dr. Nasser Al Habsi', '99991111', 'nasser@hotmail.com'),
(3, 'Said', 'Said Al Habsi', 'Said Al Habsi', '96348262', 'said@morningstarrentacar.com'),
(4, 'Sami', 'Sami Al Kharousi', 'Sami Al Kharousi', '99383272', 'samik@squ.edu.om');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_service`
--

CREATE TABLE IF NOT EXISTS `vehicle_service` (
  `service_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `date_service` varchar(20) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `service_required` varchar(50) NOT NULL,
  `km_at_service` int(11) NOT NULL,
  `voucher_date` varchar(20) NOT NULL,
  `garage_id` int(11) NOT NULL,
  `vehicle_cost` decimal(10,3) DEFAULT NULL,
  `service_done` varchar(50) NOT NULL,
  `service_amount` decimal(10,3) NOT NULL,
  `sparepart_dealer_charges` decimal(10,3) NOT NULL,
  `sparepart_shop_charges` decimal(10,3) NOT NULL,
  `labour_charges` decimal(10,3) NOT NULL,
  `date_serviceout` varchar(20) NOT NULL,
  `washing_charge` decimal(10,3) NOT NULL,
  `observation` text,
  PRIMARY KEY (`service_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vehicle_service`
--

INSERT INTO `vehicle_service` (`service_no`, `branch_id`, `vehicle_id`, `date_service`, `service_type`, `service_required`, `km_at_service`, `voucher_date`, `garage_id`, `vehicle_cost`, `service_done`, `service_amount`, `sparepart_dealer_charges`, `sparepart_shop_charges`, `labour_charges`, `date_serviceout`, `washing_charge`, `observation`) VALUES
(1, 2, 6, '06/08/2015', '10000km', 'test', 100, '', 3, NULL, 'no', '100.000', '50.000', '300.000', '100.000', '', '51.000', 'test');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vehicle_service_view`
--
CREATE TABLE IF NOT EXISTS `vehicle_service_view` (
`service_no` int(11)
,`branch_id` int(11)
,`vehicle_id` int(11)
,`date_service` date
,`service_type` varchar(20)
,`service_required` varchar(50)
,`km_at_service` int(11)
,`voucher_date` date
,`garage_id` int(11)
,`vehicle_cost` decimal(10,3)
,`service_done` varchar(50)
,`service_amount` decimal(10,3)
,`sparepart_dealer_charges` decimal(10,3)
,`sparepart_shop_charges` decimal(10,3)
,`labour_charges` decimal(10,3)
,`date_serviceout` date
,`washing_charge` decimal(10,3)
,`observation` text
);
-- --------------------------------------------------------

--
-- Structure for view `account_statement`
--
DROP TABLE IF EXISTS `account_statement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `account_statement` AS select `transaction_header`.`transaction_id` AS `transaction_id`,`transaction_header`.`vehicle_id` AS `vehicle_id`,`transaction_header`.`vehicle_reg_no` AS `vehicle_no`,`transaction_header`.`narration` AS `narration`,`transaction_header`.`transaction_date` AS `transaction_date`,if((`transaction_header`.`type` = 'R'),`transaction_header`.`amount`,(`transaction_header`.`amount` * 0)) AS `CrAmount`,if((`transaction_header`.`type` = 'P'),`transaction_header`.`amount`,(`transaction_header`.`amount` * 0)) AS `DrAmount` from `transaction_header`;

-- --------------------------------------------------------

--
-- Structure for view `header_detail`
--
DROP TABLE IF EXISTS `header_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `header_detail` AS select `transaction_detail`.`transaction_id` AS `TransactionId`,`transaction_header`.`transaction_date` AS `TransactionDate`,`transaction_detail`.`ledger_no` AS `Ledger`,`transaction_header`.`narration` AS `Description`,`transaction_detail`.`cr_amount` AS `CrAmount`,`transaction_detail`.`dr_amount` AS `DrAmount`,if((`transaction_header`.`vehicle_id` = 0),`transaction_header`.`vehicle_reg_no`,(select `vehicle`.`vehicle_reg_no` from `vehicle` where (`vehicle`.`id` = `transaction_header`.`vehicle_id`))) AS `vehicle_reg_no` from (`transaction_detail` join `transaction_header` on((`transaction_detail`.`transaction_id` = `transaction_header`.`transaction_id`)));

-- --------------------------------------------------------

--
-- Structure for view `income_expense`
--
DROP TABLE IF EXISTS `income_expense`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `income_expense` AS select `vehicle_income`.`id` AS `id`,`vehicle_income`.`vehicle_reg_no` AS `vehicle_reg_no`,`vehicle_income`.`transaction_id` AS `transaction_id`,`vehicle_income`.`brand` AS `brand`,`vehicle_income`.`description` AS `description`,`vehicle_income`.`transaction_date` AS `transaction_date`,0.000 AS `expense`,`vehicle_income`.`income` AS `income` from `vehicle_income` union select `vehicle_expense`.`id` AS `id`,`vehicle_expense`.`vehicle_reg_no` AS `vehicle_reg_no`,`vehicle_expense`.`transaction_id` AS `transaction_id`,`vehicle_expense`.`brand` AS `brand`,`vehicle_expense`.`description` AS `description`,`vehicle_expense`.`transaction_date` AS `transaction_date`,`vehicle_expense`.`expense` AS `expense`,0.000 AS `income` from `vehicle_expense`;

-- --------------------------------------------------------

--
-- Structure for view `payment_view`
--
DROP TABLE IF EXISTS `payment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `payment_view` AS select `payments`.`payment_voucher_no` AS `payment_voucher_no`,`payments`.`branch_id` AS `branch_id`,str_to_date(`payments`.`payment_voucher_date`,'%d/%m/%Y') AS `payment_voucher_date`,`payments`.`payment_ledger` AS `payment_ledger`,`payments`.`vehicle_id` AS `vehicle_id`,`payments`.`invoice_no` AS `invoice_no`,`payments`.`rental_id` AS `rental_id`,`payments`.`payment_amount` AS `payment_amount`,`payments`.`description` AS `description`,`payments`.`mode_of_payment` AS `mode_of_payment`,`payments`.`status` AS `status` from `payments`;

-- --------------------------------------------------------

--
-- Structure for view `receipt_view`
--
DROP TABLE IF EXISTS `receipt_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `receipt_view` AS select `receipts`.`receipt_voucher_no` AS `receipt_voucher_no`,`receipts`.`branch_id` AS `branch_id`,str_to_date(`receipts`.`receipt_voucher_date`,'%d/%m/%Y') AS `receipt_voucher_date`,`receipts`.`reciept_ledger` AS `reciept_ledger`,`receipts`.`invoice_no` AS `invoice_no`,`receipts`.`rental_id` AS `rental_id`,`receipts`.`receipt_amount` AS `receipt_amount`,`receipts`.`description` AS `description`,`receipts`.`mode_of_receipt` AS `mode_of_receipt`,`receipts`.`status` AS `status` from `receipts`;

-- --------------------------------------------------------

--
-- Structure for view `rental_pickup_view`
--
DROP TABLE IF EXISTS `rental_pickup_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rental_pickup_view` AS select `rental_pickup`.`rental_id` AS `rental_id`,str_to_date(`rental_pickup`.`date_rental`,'%d/%m/%Y') AS `date_rental`,`customer`.`en_name` AS `Cust_Name`,`vehicle`.`vehicle_reg_no` AS `VehicleNo`,`rental_pickup`.`rental_type` AS `rental_type`,str_to_date(`rental_pickup`.`expected_return_date`,'%d/%m/%Y') AS `expected_return_date`,str_to_date(`rental_return`.`return_date`,'%d/%m/%Y') AS `return_date`,`rental_return`.`km_extra_rate` AS `km_extra_rate`,`rental_return`.`total_rent_charges` AS `total_rent_charges`,`rental_return`.`discount` AS `discount`,`rental_return`.`net_amount` AS `net_amount` from ((((`rental_pickup` join `rental_return` on((`rental_return`.`rental_id` = `rental_pickup`.`rental_id`))) join `customer` on((`customer`.`id` = `rental_pickup`.`customer_id`))) join `vehicle` on((`vehicle`.`id` = `rental_pickup`.`vehicle_id`))) join `branch` on((`branch`.`id` = `rental_pickup`.`branch_id`))) order by `rental_pickup`.`rental_id`;

-- --------------------------------------------------------

--
-- Structure for view `rental_return_view`
--
DROP TABLE IF EXISTS `rental_return_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rental_return_view` AS select `rental_return`.`rental_id` AS `rental_id`,`vehicle`.`vehicle_reg_no` AS `vehicle_reg_no`,str_to_date(`rental_return`.`pickup_date`,'%d/%m/%Y') AS `pickup_date`,str_to_date(`rental_return`.`return_date`,'%d/%m/%Y') AS `return_date`,`rental_return`.`total_rented_days` AS `total_rented_days`,`rental_return`.`km_used` AS `km_used`,`rental_return`.`km_extra_used` AS `km_extra_used`,`rental_return`.`rate_per_day` AS `rate_per_day`,`rental_return`.`total_rent_charges` AS `total_rent_charges`,`rental_return`.`km_extra_rate` AS `km_extra_rate`,`rental_return`.`discount` AS `discount`,`rental_return`.`net_amount` AS `net_amount` from ((`rental_return` join `rental_pickup` on((`rental_pickup`.`rental_id` = `rental_return`.`rental_id`))) join `vehicle` on((`vehicle`.`id` = `rental_pickup`.`vehicle_id`)));

-- --------------------------------------------------------

--
-- Structure for view `vehicle_expense`
--
DROP TABLE IF EXISTS `vehicle_expense`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vehicle_expense` AS select `vehicle`.`id` AS `id`,`vehicle`.`vehicle_reg_no` AS `vehicle_reg_no`,`transaction_header`.`transaction_id` AS `transaction_id`,`vehicle`.`brand` AS `brand`,`transaction_header`.`narration` AS `description`,`transaction_header`.`transaction_date` AS `transaction_date`,`transaction_detail`.`dr_amount` AS `expense` from (((`transaction_header` join `transaction_detail` on((`transaction_detail`.`transaction_id` = `transaction_header`.`transaction_id`))) join `ledger` on((`ledger`.`id` = `transaction_detail`.`ledger_no`))) join `vehicle` on((`vehicle`.`vehicle_reg_no` = `transaction_header`.`vehicle_reg_no`))) where (`ledger`.`id` not in (25,26,13,4,5,6,18));

-- --------------------------------------------------------

--
-- Structure for view `vehicle_income`
--
DROP TABLE IF EXISTS `vehicle_income`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vehicle_income` AS select `vehicle`.`id` AS `id`,`vehicle`.`vehicle_reg_no` AS `vehicle_reg_no`,`transaction_header`.`transaction_id` AS `transaction_id`,`vehicle`.`brand` AS `brand`,`transaction_header`.`narration` AS `description`,`transaction_header`.`transaction_date` AS `transaction_date`,`transaction_detail`.`cr_amount` AS `income` from (((`transaction_header` join `transaction_detail` on((`transaction_detail`.`transaction_id` = `transaction_header`.`transaction_id`))) join `ledger` on((`ledger`.`id` = `transaction_detail`.`ledger_no`))) join `vehicle` on((`vehicle`.`id` = `transaction_header`.`vehicle_id`))) where (`ledger`.`id` = 13);

-- --------------------------------------------------------

--
-- Structure for view `vehicle_service_view`
--
DROP TABLE IF EXISTS `vehicle_service_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vehicle_service_view` AS select `vehicle_service`.`service_no` AS `service_no`,`vehicle_service`.`branch_id` AS `branch_id`,`vehicle_service`.`vehicle_id` AS `vehicle_id`,str_to_date(`vehicle_service`.`date_service`,'%d/%m/%Y') AS `date_service`,`vehicle_service`.`service_type` AS `service_type`,`vehicle_service`.`service_required` AS `service_required`,`vehicle_service`.`km_at_service` AS `km_at_service`,str_to_date(`vehicle_service`.`voucher_date`,'%d/%m/%Y') AS `voucher_date`,`vehicle_service`.`garage_id` AS `garage_id`,`vehicle_service`.`vehicle_cost` AS `vehicle_cost`,`vehicle_service`.`service_done` AS `service_done`,`vehicle_service`.`service_amount` AS `service_amount`,`vehicle_service`.`sparepart_dealer_charges` AS `sparepart_dealer_charges`,`vehicle_service`.`sparepart_shop_charges` AS `sparepart_shop_charges`,`vehicle_service`.`labour_charges` AS `labour_charges`,str_to_date(`vehicle_service`.`date_serviceout`,'%d/%m/%Y') AS `date_serviceout`,`vehicle_service`.`washing_charge` AS `washing_charge`,`vehicle_service`.`observation` AS `observation` from `vehicle_service`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
