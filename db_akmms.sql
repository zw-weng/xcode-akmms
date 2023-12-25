-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2023 at 04:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_akmms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_advertising`
--

CREATE TABLE `tb_advertising` (
  `item_id` varchar(10) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_desc` varchar(100) NOT NULL,
  `item_cost` float(6,2) NOT NULL,
  `item_qty` int(4) NOT NULL,
  `item_category_id` int(2) NOT NULL,
  `item_price` float(6,2) NOT NULL,
  `edit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_construction`
--

CREATE TABLE `tb_construction` (
  `material_id` varchar(10) NOT NULL,
  `material_name` varchar(50) NOT NULL,
  `material_desc` varchar(100) NOT NULL,
  `material_cost` float(6,2) NOT NULL,
  `material_unit` varchar(20) NOT NULL,
  `extra_rate` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `cust_id` varchar(10) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_phone` varchar(20) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_street` varchar(50) NOT NULL,
  `cust_postcode` int(7) NOT NULL,
  `cust_city` varchar(20) NOT NULL,
  `cust_state` int(20) NOT NULL,
  `cust_country` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_deliveryorder`
--

CREATE TABLE `tb_deliveryorder` (
  `delivery_id` varchar(10) NOT NULL,
  `order_id` varchar(10) NOT NULL,
  `quotation_id` varchar(10) NOT NULL,
  `do_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `invoice_id` varchar(10) NOT NULL,
  `invoice_amount_payable` double(10,2) DEFAULT NULL,
  `invoice_balance` double(10,2) DEFAULT NULL,
  `invoice_upfront` double(10,2) DEFAULT NULL,
  `order_id` varchar(10) NOT NULL,
  `quotation_id` varchar(10) NOT NULL,
  `delivery_id` varchar(10) NOT NULL,
  `invoice_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_itemcategory`
--

CREATE TABLE `tb_itemcategory` (
  `item_category_id` int(2) NOT NULL,
  `item_category_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderstatus`
--

CREATE TABLE `tb_orderstatus` (
  `order_status_id` int(2) NOT NULL,
  `order_status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `payment_id` int(10) NOT NULL,
  `payment_amount` float(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymentstatus`
--

CREATE TABLE `tb_paymentstatus` (
  `payment_status_id` int(2) NOT NULL,
  `payment_status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymentterm`
--

CREATE TABLE `tb_paymentterm` (
  `payment_term_id` int(2) NOT NULL,
  `payment_term_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymenttype`
--

CREATE TABLE `tb_paymenttype` (
  `payment_type_id` int(2) NOT NULL,
  `payment_type_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_price`
--

CREATE TABLE `tb_price` (
  `item_price` float(6,2) NOT NULL,
  `item_date` datetime NOT NULL,
  `item_id` varchar(10) NOT NULL,
  `markup_rate` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotation`
--

CREATE TABLE `tb_quotation` (
  `quotation_id` varchar(10) NOT NULL,
  `cust_id` varchar(10) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_street` varchar(50) NOT NULL,
  `client_postcode` int(7) NOT NULL,
  `client_city` varchar(20) NOT NULL,
  `client_state` varchar(20) NOT NULL,
  `client_country` varchar(30) NOT NULL,
  `item_id` varchar(10) DEFAULT NULL,
  `material_id` varchar(10) DEFAULT NULL,
  `product_price` float(6,2) NOT NULL,
  `product_desc` text NOT NULL,
  `quantity` int(5) NOT NULL,
  `dic` float(5,2) DEFAULT NULL,
  `disc_amount` float(10,2) DEFAULT NULL,
  `tax_code` varchar(50) DEFAULT NULL,
  `tax_amount` float(10,2) DEFAULT NULL,
  `total` float(10,2) NOT NULL,
  `grand_total` float(10,2) NOT NULL,
  `quotation_type_id` int(2) NOT NULL,
  `quotation_status_id` int(2) NOT NULL,
  `payment_term_id` int(2) NOT NULL,
  `quotation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotationstatus`
--

CREATE TABLE `tb_quotationstatus` (
  `quotation_status_id` int(2) NOT NULL,
  `quotation_status_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotationtype`
--

CREATE TABLE `tb_quotationtype` (
  `quotation_type_id` int(2) NOT NULL,
  `quotation_type_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_salesorder`
--

CREATE TABLE `tb_salesorder` (
  `order_id` varchar(10) NOT NULL,
  `staff_incharge` varchar(100) NOT NULL,
  `remark` text DEFAULT NULL,
  `payment_status_id` varchar(10) NOT NULL,
  `payment_type_id` varchar(10) NOT NULL,
  `payment_id` varchar(10) NOT NULL,
  `order_status_id` varchar(10) NOT NULL,
  `quotation_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` varchar(10) NOT NULL,
  `user_ic` varchar(15) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `u_fName` varchar(50) NOT NULL,
  `u_lName` varchar(50) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_position` varchar(50) NOT NULL,
  `type_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_ic`, `user_pwd`, `u_fName`, `u_lName`, `user_phone`, `user_email`, `user_address`, `user_position`, `type_id`) VALUES
('chloe1234', '030917140923', '1234', 'Chloe', 'Yau', '017-1095-3367', 'neozhengweng@gmail.com', 'Lot 88, Kg. Teluk Kemang, 71000, Port Dickson, Negeri Sembilan', 'Manager', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_usertype`
--

CREATE TABLE `tb_usertype` (
  `type_id` int(2) NOT NULL,
  `type_desc` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_usertype`
--

INSERT INTO `tb_usertype` (`type_id`, `type_desc`) VALUES
(1, 'staff'),
(2, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_advertising`
--
ALTER TABLE `tb_advertising`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_category_id` (`item_category_id`),
  ADD KEY `item_price` (`item_price`,`edit_date`);

--
-- Indexes for table `tb_construction`
--
ALTER TABLE `tb_construction`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `tb_deliveryorder`
--
ALTER TABLE `tb_deliveryorder`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `quotation_id` (`quotation_id`);

--
-- Indexes for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `delivery_id` (`delivery_id`);

--
-- Indexes for table `tb_itemcategory`
--
ALTER TABLE `tb_itemcategory`
  ADD PRIMARY KEY (`item_category_id`);

--
-- Indexes for table `tb_orderstatus`
--
ALTER TABLE `tb_orderstatus`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tb_paymentstatus`
--
ALTER TABLE `tb_paymentstatus`
  ADD PRIMARY KEY (`payment_status_id`);

--
-- Indexes for table `tb_paymentterm`
--
ALTER TABLE `tb_paymentterm`
  ADD PRIMARY KEY (`payment_term_id`);

--
-- Indexes for table `tb_paymenttype`
--
ALTER TABLE `tb_paymenttype`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `tb_price`
--
ALTER TABLE `tb_price`
  ADD PRIMARY KEY (`item_price`,`item_date`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `tb_quotation`
--
ALTER TABLE `tb_quotation`
  ADD PRIMARY KEY (`quotation_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `quotation_type_id` (`quotation_type_id`),
  ADD KEY `quotation_status_id` (`quotation_status_id`),
  ADD KEY `payment_term_id` (`payment_term_id`);

--
-- Indexes for table `tb_quotationstatus`
--
ALTER TABLE `tb_quotationstatus`
  ADD PRIMARY KEY (`quotation_status_id`);

--
-- Indexes for table `tb_quotationtype`
--
ALTER TABLE `tb_quotationtype`
  ADD PRIMARY KEY (`quotation_type_id`);

--
-- Indexes for table `tb_salesorder`
--
ALTER TABLE `tb_salesorder`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `payment_status_id` (`payment_status_id`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `order_status_id` (`order_status_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `tb_usertype`
--
ALTER TABLE `tb_usertype`
  ADD PRIMARY KEY (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
