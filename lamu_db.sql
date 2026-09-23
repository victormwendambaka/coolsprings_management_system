-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 07:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lamu db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `EmailId` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Name`, `EmailId`, `MobileNumber`, `Password`, `updationDate`) VALUES
(1, 'admin', 'Administrator', 'test@gmail.com', 111511562, 'f925916e2754e5e03f75dd58a5733251', '2025-07-01 11:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(100) DEFAULT NULL,
  `ToDate` varchar(100) DEFAULT NULL,
  `Comment` mediumtext DEFAULT NULL,
  `roomsbooked` int(100) NOT NULL,
  `totalprice` int(100) NOT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `CancelledBy` varchar(5) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`BookingId`, `PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `roomsbooked`, `totalprice`, `RegDate`, `status`, `CancelledBy`, `UpdationDate`) VALUES
(1, 1, 'mojo@gmail.com', '2025-07-03', '2025-07-05', 'book', 1, 13000, '2025-07-03 08:07:00', 1, NULL, '2025-07-03 08:08:22'),
(2, 2, 'mwangi@gmail.com', '2025-07-05', '2025-07-07', 'i want a room for two couples kindly', 2, 48000, '2025-07-04 14:23:59', 2, 'a', '2025-07-04 14:33:26'),
(3, 2, 'mwangi@gmail.com', '2025-07-05', '2025-07-07', 'i want a room for two couples kindly', 2, 0, '2025-07-04 14:27:17', 1, NULL, '2025-07-04 14:33:03'),
(4, 7, 'chrispo@gmail.com', '2025-07-15', '2025-07-22', 'A room for me and the boys', 1, 24500, '2025-07-04 14:29:58', 1, NULL, '2025-07-04 14:33:48'),
(5, 10, 'chrispo@gmail.com', '2025-07-18', '2025-07-20', 'Hope its worth it', 2, 40000, '2025-07-04 14:31:04', 1, NULL, '2025-07-04 14:33:41'),
(6, 5, 'anastacia@gmail.com', '2025-07-30', '2025-07-31', 'its time ', 1, 7999, '2025-07-04 14:38:23', 2, 'a', '2025-07-04 14:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblissues`
--

CREATE TABLE `tblissues` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `Issue` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminremarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblissues`
--

INSERT INTO `tblissues` (`id`, `UserEmail`, `Issue`, `Description`, `PostingDate`, `AdminRemark`, `AdminremarkDate`) VALUES
(12, 'anastacia@gmail.com', 'Refund', 'i have an emergency', '2025-07-04 14:41:09', 'okay no problem you will receive a refund in 24 hours', '2025-07-04 14:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `type`, `detail`) VALUES
(1, 'terms', '																				<p align=\"justify\"><span style=\"color: rgb(153, 0, 0); font-size: small; font-weight: 700;\">terms and condition page</span></p>\r\n										\r\n										'),
(2, 'privacy', '<p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">1. Data Collection:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">We collect personal details (name, contact, payment info) and non-personal data (cookies, IP) for bookings and service improvements.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">2. Data Use:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Used for reservations, communication, analytics, and legal compliance. Never sold to third parties.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">3. Data Sharing:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Shared only with necessary service providers (hotels, tour operators) or if required by Kenyan law.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">4. Security:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Encrypted transactions, secure servers, and access controls protect your information.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">5. Your Rights:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Access, correct, or delete your data under Kenya’s&nbsp;<span style=\"font-weight: 600;\">Data Protection Act (2019)</span>. Opt out of marketing anytime.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">6. Cookies:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Used for functionality and analytics; disable via browser settings if preferred.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">7. Contact:</span></p><ul style=\"margin: 13.716px 0px; padding-left: 27.432px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif; font-size: 16.002px;\"><li><p class=\"ds-markdown-paragraph\" style=\"font-size: 16.002px; line-height: 28.575px; margin-bottom: 0px !important;\">Questions? Email&nbsp;<span style=\"font-weight: 600;\">[Your Contact]</span>&nbsp;or call&nbsp;<span style=\"font-weight: 600;\">[Your Number]</span>.</p></li></ul><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><span style=\"font-weight: 600;\">By using our system, you agree to this policy.</span></p><p class=\"ds-markdown-paragraph\" style=\"margin-top: 13.716px; margin-bottom: 13.716px; font-size: 16.002px; line-height: 28.575px; color: rgb(64, 64, 64); font-family: quote-cjk-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Noto Sans&quot;, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, Oxygen, &quot;Open Sans&quot;, sans-serif;\"><em>(Full policy available&nbsp;<a target=\"_blank\" rel=\"noreferrer\" style=\"color: rgb(59, 130, 246); transition-duration: 0.2s; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-property: box-shadow; border-radius: 6.858px; border-width: 2px 3px; border-style: solid; border-color: rgba(255, 255, 255, 0); margin-left: -3px; margin-right: -3px; position: relative;\">here</a>&nbsp;for detailed terms.)</em></p>'),
(3, 'aboutus', '																				<div><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px; text-align: justify; font-weight: bold;\">Welcome to CoolSpring Tourism Management System!!!</span></div><span style=\"font-family: &quot;courier new&quot;;\"><span style=\"color: rgb(0, 0, 0); font-size: 15px; text-align: justify;\">Since then, our courteous and committed team members have always ensured a pleasant and enjoyable tour for the clients. This arduous effort has enabled TMS to be recognized as a dependable Travel Solutions provider with three offices Delhi.</span><span style=\"color: rgb(80, 80, 80); font-size: 13px;\">&nbsp;We have got packages to suit the discerning traveler\'s budget and savor. Book your dream vacation online. Supported quality and proposals of our travel consultants, we have a tendency to welcome you to decide on from holidays packages and customize them according to your plan.</span></span>\r\n										\r\n										'),
(11, 'contact', '																														<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Address------J-890 Dwarka House Allsops Nairobi-110096</span>\r\n										<div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contact Us ---254111511562</span></div><div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\"><br></span></div>');

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `rooms` int(23) NOT NULL,
  `PackageDetails` mediumtext DEFAULT NULL,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `rooms`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Lamu Breeze Guest House', 'Family Package', 'Shela, Lamu Island, Kenya', 6500, 'Free Pickup and Drop from Manda Airport,  Rooftop Swahili Lounge with Ocean View,  Complimentary Breakfast,  Wi-Fi and Room Service,  Walking Distance to the Beach,  Guided Town Tour Included.', 10, 'Lamu Breeze Guest House is a Swahili-style retreat nestled in the quiet alleys of Shela Village. Ideal for families seeking a peaceful, culturally immersive experience. This package includes airport transfers, breakfast, and a guided heritage tour of Old Lamu Town. The house features spacious rooms, a sea-facing rooftop, and access to water sports on request.', 'room-7.jpg', '2025-07-03 07:58:25', '2025-07-03 08:07:00'),
(2, 'DIANI SEA RESORT', 'Honeymoon Package', 'Diani Beach, Kenya', 12000, 'Private Beachfront Villa  Sunset Dinner on the Beach  Couples Spa Treatment  Complimentary Champagne  Free Wi-Fi  Airport Transfers Included', 6, 'A romantic getaway at a luxurious beachfront villa in Diani. Enjoy private dinners, spa treatments, and breathtaking ocean views. Perfect for couples celebrating their love.', 'diani.jpg', '2025-07-04 05:38:38', '2025-07-04 14:44:40'),
(3, 'Old Town Explorer', 'Cultural Adventure Package', 'Lamu Old Town', 8500, 'Guided Historical Tours  Donkey Ride Experience  Swahili Cooking Class  Rooftop Terrace  Free Wi-Fi', 9, 'Immerse yourself in Lamu\'s UNESCO-listed Old Town with curated cultural activities.', 'old town.jpg', '2025-07-04 05:52:11', '2025-07-04 06:11:35'),
(4, 'Lamu Breeze Family', 'Family Package', 'Shela, Lamu', 13000, 'Spacious Family Rooms  , Kid-Friendly Beach Access , ', 12, ' A stress-free family vacation in a Swahili-style guesthouse near calm beaches.\r\nComplimentary Airport Transfers  ,\r\n Guided Town Tour,\r\n Board Games & Books \r\n', 'diamond-beach-village.jpg', '2025-07-04 05:58:00', '2025-07-04 06:13:35'),
(5, 'Lamu Serenity', 'Yoga & Wellness Escape', 'Manda Island, Lamu', 7999, 'Daily Yoga on the Beach  ', 5, 'Rejuvenate with holistic wellness programs amid Lamu\'s tranquil shores.\r\nOrganic Swahili Meals  \r\nSpa Treatments  \r\nSilent Sunset Meditation  \r\nKayak Rentals', 'yoga.jpg', '2025-07-04 06:04:58', '2025-07-04 14:44:40'),
(6, 'Test@123', 'Specialty Package', 'Lamu Old Town', 7500, 'Art Workshop Space ,  Swahili Calligraphy Lessons  , Rooftop Studio with Natural Light', 3, 'A haven for artists and writers inspired by Lamu\'s vibrant culture.\r\nGallery Visits\r\nCurated Local Artist Meetups\r\n\r\n', 'lamu palace hotel.jpg', '2025-07-04 06:28:40', NULL),
(7, 'Lamu Backpackers', 'Budget Package', 'Lamu Old Town', 3500, 'Shared Courtyard Hangout ,  Free Walking Tour   ,  Cheap Bike Rentals ,   24/7 Security   ,   Local Food Discounts', 9, 'Affordable social accommodation in the heart of Lamu\'s historic lanes.', 'shared hotel.jpg', '2025-07-04 08:16:32', '2025-07-04 14:44:40'),
(8, 'Lamu Angler', 'Activity Package', 'Lamu Waterfront', 11200, 'Deep-Sea Fishing Trips ,   Seafood Cooking Demo  ,  Sunset BBQ on the Beach,    Fish Market Tour ,   Boat Rental Discounts', 4, 'For fishing enthusiasts and foodies craving Lamu\'s famous seafood.', 'fishin hotel.jpg', '2025-07-04 08:20:36', NULL),
(9, 'Lamu Moonlight', 'Luxury Honeymoon', 'Private Beach, Manda', 26000, 'Private Beach Dinner,    Four-Poster Swahili Bed ,    Couples Massage,   Champagne Arrival,    Personal Butler', 3, 'Ultimate privacy and luxury for newlyweds on a secluded Lamu beach.', 'luxury honeymoon.jpg', '2025-07-04 08:24:06', NULL),
(10, 'Lamu Cultural Fest', 'Event Package', 'Lamu Town', 10000, 'VIP Festival Access ,   Traditional Dance Shows,    Donkey Race Tickets ,   Swahili Banquet ,   Guided Festival Tours', 14, 'Experience Lamu\'s famous festivals (e.g., Lamu Cultural Week) in style.', 'lamu culture.jpg', '2025-07-04 08:27:43', '2025-07-04 14:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `EmailId` varchar(70) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `MobileNumber`, `EmailId`, `Password`, `RegDate`, `UpdationDate`) VALUES
(1, 'Peter mwangi', '0712345678', 'mwangi@gmail.com', '93279e3308bdbbeed946fc965017f67a', '2025-07-03 10:53:31', NULL),
(2, 'Chrispo murara', '0709908909', 'chrispo@gmail.com', '2467d3744600858cc9026d5ac6005305', '2025-07-03 10:56:26', NULL),
(3, 'Angela Nyambura', '0781122333', 'angela@gmail.com', '01c96beddb172095388e43835bdb7145', '2025-07-03 10:57:54', NULL),
(4, 'Rosa Orora', '0790900977', 'rosa@gmail.com', '7718c4d9cc11736f566e6bd41e965eb7', '2025-07-03 11:00:06', NULL),
(5, 'Taditi liban', '0776612312', 'taditi@gmail.com', '888e931d6360ee143df0d552f955299a', '2025-07-03 11:03:22', NULL),
(6, 'nancy macharia', '0736668900', 'nancy@gmail.com', '21ef05aed5af92469a50b35623d52101', '2025-07-03 11:04:59', NULL),
(7, 'anastacia ngule', '0732112312', 'anastacia@gmail.com', '6299b4bf69960e53b6d9a0bd27342660', '2025-07-03 11:06:39', NULL),
(8, 'john mbithi', '0791121390', 'john@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2025-07-03 11:08:43', NULL),
(9, 'lee muuo', '0766211310', 'lee@gmail.com', '3f1dbc417664139dda097bcd516ceeed', '2025-07-03 11:10:50', NULL),
(10, 'ron baraka', '0767632812', 'ron@gmail.com', '4ba8f7c208d44791f5c04708b2fa18e9', '2025-07-03 11:12:35', NULL),
(11, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2025-07-04 14:41:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissues`
--
ALTER TABLE `tblissues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `EmailId_2` (`EmailId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblissues`
--
ALTER TABLE `tblissues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
