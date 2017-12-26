-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2017 at 05:20 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalum_timber`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_id` int(5) NOT NULL,
  `buyer_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `registered_date` date NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_contact`
--

CREATE TABLE `buyer_contact` (
  `contact_id` int(8) NOT NULL,
  `buyer_id` int(5) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cross_section`
--

CREATE TABLE `cross_section` (
  `cross_section_id` int(4) NOT NULL,
  `height` decimal(6,3) NOT NULL,
  `width` decimal(6,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(8) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL,
  `registered_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_contact`
--

CREATE TABLE `customer_contact` (
  `contact_id` int(9) NOT NULL,
  `cutomer_id` int(8) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `page_id` int(3) NOT NULL,
  `page_name` varchar(25) NOT NULL,
  `page_url` varchar(50) NOT NULL DEFAULT '#',
  `icon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `page_name`, `page_url`, `icon`) VALUES
(1, 'Users', '#', 'fa fa-users'),
(2, 'Customers', '#', 'fa fa-male'),
(3, 'Sales', 'sales.php', 'fa fa-usd');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `type_id` int(4) NOT NULL,
  `cross_section_id` int(4) NOT NULL,
  `price` decimal(10,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(1) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `privilage_level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `privilage_level`) VALUES
(0, 'admin', 0),
(1, 'manager', 1),
(2, 'cashier', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role_to_page`
--

CREATE TABLE `role_to_page` (
  `role_id` int(1) NOT NULL,
  `page_id` int(3) NOT NULL,
  `page_order` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_to_page`
--

INSERT INTO `role_to_page` (`role_id`, `page_id`, `page_order`) VALUES
(0, 1, 0),
(0, 2, 1),
(0, 3, 2),
(1, 1, 0),
(1, 2, 1),
(1, 3, 2),
(2, 2, 0),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_page`
--

CREATE TABLE `sub_page` (
  `page_id` int(3) NOT NULL,
  `sub_page_id` int(1) NOT NULL,
  `sub_page_url` varchar(30) DEFAULT NULL,
  `sub_page_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_page`
--

INSERT INTO `sub_page` (`page_id`, `sub_page_id`, `sub_page_url`, `sub_page_name`) VALUES
(1, 1, 'create_user.php', 'Create Users'),
(1, 2, 'viewUsers.php', 'Users'),
(2, 1, 'createCustomers.php', 'Add Customers'),
(2, 2, 'viewCustomers.php', 'Customers');

-- --------------------------------------------------------

--
-- Table structure for table `timber_type`
--

CREATE TABLE `timber_type` (
  `type_id` int(4) NOT NULL,
  `timber_name` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role_id` int(1) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `national_id` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `role_id`, `first_name`, `last_name`, `national_id`, `password`, `deleted`) VALUES
(1, 'admin', 'admin@gmail.com', 0, 'admin', 'superadmin', '482684512v', '17c4520f6cfd1ab53d8745e84681eb49', 0),
(2, 'manager01', 'manager01@gmail.com', 1, 'kumara', 'sangakkara', '591462589v', '46a65a40464ebc431a23f7268cdfc3ce', 0),
(3, 'cashier1', 'cashier1@gmail.com', 2, 'Kusal', 'Mendis', '951482659v', '2d489f46d6f528f0a609fdd058d00b79', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE `user_contact` (
  `contact_id` int(6) NOT NULL,
  `user_id` int(4) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `buyer_contact`
--
ALTER TABLE `buyer_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `cross_section`
--
ALTER TABLE `cross_section`
  ADD PRIMARY KEY (`cross_section_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_contact`
--
ALTER TABLE `customer_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_to_page`
--
ALTER TABLE `role_to_page`
  ADD KEY `page_id` (`page_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `sub_page`
--
ALTER TABLE `sub_page`
  ADD PRIMARY KEY (`page_id`,`sub_page_id`);

--
-- Indexes for table `timber_type`
--
ALTER TABLE `timber_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_contact`
--
ALTER TABLE `user_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `buyer_contact`
--
ALTER TABLE `buyer_contact`
  MODIFY `contact_id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cross_section`
--
ALTER TABLE `cross_section`
  MODIFY `cross_section_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_contact`
--
ALTER TABLE `customer_contact`
  MODIFY `contact_id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `timber_type`
--
ALTER TABLE `timber_type`
  MODIFY `type_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_contact`
--
ALTER TABLE `user_contact`
  MODIFY `contact_id` int(6) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer_contact`
--
ALTER TABLE `buyer_contact`
  ADD CONSTRAINT `buyer_contact_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`);

--
-- Constraints for table `customer_contact`
--
ALTER TABLE `customer_contact`
  ADD CONSTRAINT `customer_contact_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `role_to_page`
--
ALTER TABLE `role_to_page`
  ADD CONSTRAINT `role_to_page_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `role_to_page_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `page` (`page_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `user_contact`
--
ALTER TABLE `user_contact`
  ADD CONSTRAINT `user_contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
