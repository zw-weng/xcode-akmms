-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 04:14 PM
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
  `item_id` int(5) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_desc` text NOT NULL,
  `item_cost` float(6,2) NOT NULL,
  `item_qty` int(5) NOT NULL,
  `markup_rate` float(5,2) NOT NULL,
  `item_price` float(6,2) NOT NULL,
  `item_category_id` int(2) NOT NULL,
  `item_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_advertising`
--

INSERT INTO `tb_advertising` (`item_id`, `item_name`, `item_desc`, `item_cost`, `item_qty`, `markup_rate`, `item_price`, `item_category_id`, `item_status`) VALUES
(1, 'Book', 'Two color', 200.15, 4, 0.00, 200.15, 1, 1),
(2, 'Poster', 'A2 size poster', 10.00, 7, 0.00, 10.02, 1, 1),
(6, 'Bunting', 'Large', 50.00, 45, 30.00, 65.00, 1, 1),
(7, 'banner', 'color a3 size', 20.00, 20, 0.45, 29.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_alert`
--

CREATE TABLE `tb_alert` (
  `alert_id` int(5) NOT NULL,
  `min_value` int(2) NOT NULL,
  `alert_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_alert`
--

INSERT INTO `tb_alert` (`alert_id`, `min_value`, `alert_count`) VALUES
(1, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_civil`
--

CREATE TABLE `tb_civil` (
  `c_id` int(8) NOT NULL,
  `c_state` varchar(50) NOT NULL,
  `c_district` varchar(50) NOT NULL,
  `c_rate` float(5,2) NOT NULL,
  `c_group` varchar(100) NOT NULL,
  `c_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_civil`
--

INSERT INTO `tb_civil` (`c_id`, `c_state`, `c_district`, `c_rate`, `c_group`, `c_status`) VALUES
(0, 'Kedah', 'Kota Setar', 10.00, 'kurang dari 16km', 1),
(2, 'Kelantan', 'Kota Bharu', 40.00, 'kurang dari 16km', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_construction`
--

CREATE TABLE `tb_construction` (
  `material_id` int(5) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `material_desc` text NOT NULL,
  `material_cost` float(8,2) NOT NULL,
  `material_unit` varchar(50) NOT NULL,
  `material_category_id` int(2) NOT NULL,
  `material_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_construction`
--

INSERT INTO `tb_construction` (`material_id`, `material_name`, `material_desc`, `material_cost`, `material_unit`, `material_category_id`, `material_status`) VALUES
(8, 'kayu', 'kayu 15 meter', 53.00, 'batang', 1, 1),
(9, 'kayu', 'kayu 15 meter', 10.00, 'batang', 1, 1),
(11, 'Pendawaian', 'Bi-metallic connector', 141.80, 'satu', 2, 1),
(14, 'wire', 'kayu 14', 20.00, 'batang', 2, 1),
(15, 'Pengasing', 'dwi kutub jenis satu fasa, bertebat penuh, 20A', 73.40, 'satu', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `cust_id` int(5) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_phone` varchar(20) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_street` varchar(50) NOT NULL,
  `cust_postcode` int(7) NOT NULL,
  `cust_city` varchar(20) NOT NULL,
  `cust_state` varchar(50) NOT NULL,
  `cust_country` varchar(50) NOT NULL,
  `cust_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`cust_id`, `cust_name`, `cust_phone`, `cust_email`, `cust_street`, `cust_postcode`, `cust_city`, `cust_state`, `cust_country`, `cust_status`) VALUES
(9, 'John Doe', '1234567890', 'johndoe@example.com', '123 Main St', 123456, 'Kulai', 'Johor', 'Malaysia', 0),
(10, 'Jane Smith', '0987654321', 'janesmith@example.com', '456 Elm St', 654321, 'Johor Bahru', 'Johor', 'Malaysia', 1),
(11, 'Alice Johnson', '1122334455', 'alicejohnson@example.com', '789 Oak St', 789123, 'Kuala Lumpur', 'Kuala Lumpur', 'Malaysia', 1),
(12, 'Bob Williams', '5566778899', 'bobwilliams@example.com', '321 Pine St', 987654, 'George Town', 'Penang', 'Malaysia', 1),
(20, 'Klinik Kesihatan Daerah Segamat', '01610952345', 'kkdsegamat@yahoo.com.my', 'Jalan Muar', 85000, 'Segamat', 'Johor', 'Malaysia', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_deliveryorder`
--

CREATE TABLE `tb_deliveryorder` (
  `delivery_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `quotation_id` int(5) NOT NULL,
  `do_date` date NOT NULL,
  `product_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_deliveryorder`
--

INSERT INTO `tb_deliveryorder` (`delivery_id`, `order_id`, `quotation_id`, `do_date`, `product_id`) VALUES
(105, 100, 100, '2023-12-04', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_electric`
--

CREATE TABLE `tb_electric` (
  `e_district` varchar(50) NOT NULL,
  `e_group` varchar(100) NOT NULL,
  `e_rate` float(5,2) NOT NULL,
  `e_state` varchar(50) NOT NULL,
  `e_id` int(8) NOT NULL,
  `e_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_electric`
--

INSERT INTO `tb_electric` (`e_district`, `e_group`, `e_rate`, `e_state`, `e_id`, `e_status`) VALUES
('Muar', 'kurang dari 16km', 40.00, 'Johor', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `invoice_id` int(5) NOT NULL,
  `invoice_amount_payable` double(10,2) DEFAULT NULL,
  `invoice_balance` double(10,2) DEFAULT NULL,
  `invoice_upfront` double(10,2) DEFAULT NULL,
  `order_id` int(5) NOT NULL,
  `quotation_id` int(5) NOT NULL,
  `delivery_id` int(5) NOT NULL,
  `invoice_date` date NOT NULL,
  `product_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_invoice`
--

INSERT INTO `tb_invoice` (`invoice_id`, `invoice_amount_payable`, `invoice_balance`, `invoice_upfront`, `order_id`, `quotation_id`, `delivery_id`, `invoice_date`, `product_id`) VALUES
(110, 1200.00, 600.00, 200.00, 100, 100, 105, '2023-12-22', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_itemcategory`
--

CREATE TABLE `tb_itemcategory` (
  `item_category_id` int(2) NOT NULL,
  `item_category_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_itemcategory`
--

INSERT INTO `tb_itemcategory` (`item_category_id`, `item_category_desc`) VALUES
(1, 'Printing & Advertising'),
(2, 'Services');

-- --------------------------------------------------------

--
-- Table structure for table `tb_materialcategory`
--

CREATE TABLE `tb_materialcategory` (
  `material_category_id` int(2) NOT NULL,
  `material_category_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_materialcategory`
--

INSERT INTO `tb_materialcategory` (`material_category_id`, `material_category_desc`) VALUES
(1, 'Civil'),
(2, 'Electric');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderstatus`
--

CREATE TABLE `tb_orderstatus` (
  `order_status_id` int(2) NOT NULL,
  `order_status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_orderstatus`
--

INSERT INTO `tb_orderstatus` (`order_status_id`, `order_status_desc`) VALUES
(0, 'Newly Generated'),
(1, 'Cancelled'),
(2, 'Delivery Order Generated'),
(3, 'Invoice issued'),
(4, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `payment_id` int(5) NOT NULL,
  `payment_amount` float(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_proof` blob NOT NULL,
  `order_id` int(5) NOT NULL,
  `payment_status` int(2) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `payment_type_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_payment`
--

INSERT INTO `tb_payment` (`payment_id`, `payment_amount`, `payment_date`, `payment_proof`, `order_id`, `payment_status`, `client_name`, `payment_type_id`) VALUES
(1, NULL, '2024-01-15 00:00:00', 0x433a5c78616d70705c6874646f63735c616b6d6d732f75706c6f6164732f5175697a33622e706466, 100, 1, 'ali', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymentstatus`
--

CREATE TABLE `tb_paymentstatus` (
  `payment_status_id` int(2) NOT NULL,
  `payment_status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_paymentstatus`
--

INSERT INTO `tb_paymentstatus` (`payment_status_id`, `payment_status_desc`) VALUES
(1, 'Unpaid'),
(2, 'Partially paid'),
(3, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymentterm`
--

CREATE TABLE `tb_paymentterm` (
  `payment_term_id` int(2) NOT NULL,
  `payment_term_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_paymentterm`
--

INSERT INTO `tb_paymentterm` (`payment_term_id`, `payment_term_desc`) VALUES
(1, 'LO'),
(2, 'CASH'),
(3, 'CIA'),
(4, 'Net 30'),
(5, 'Net 14'),
(6, 'Stage Payment');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paymenttype`
--

CREATE TABLE `tb_paymenttype` (
  `payment_type_id` int(2) NOT NULL,
  `payment_type_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_paymenttype`
--

INSERT INTO `tb_paymenttype` (`payment_type_id`, `payment_type_desc`) VALUES
(1, 'Cash'),
(2, 'Online Banking'),
(3, 'E-Wallet'),
(4, 'Credit card'),
(5, 'Debit Card');

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `product_id` int(255) NOT NULL,
  `item_id` int(5) DEFAULT NULL,
  `material_id` int(5) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float(6,2) NOT NULL,
  `product_qty` int(5) NOT NULL,
  `disc` float(5,2) DEFAULT NULL,
  `disc_amount` float(6,2) DEFAULT NULL,
  `tax_code` varchar(20) DEFAULT NULL,
  `tax_amount` float(6,2) DEFAULT NULL,
  `product_subtotal` float(6,2) NOT NULL,
  `quotation_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `item_id`, `material_id`, `product_name`, `product_price`, `product_qty`, `disc`, `disc_amount`, `tax_code`, `tax_amount`, `product_subtotal`, `quotation_id`) VALUES
(1, 2, NULL, 'Book printing', 30.00, 2, 0.00, NULL, NULL, NULL, 60.00, 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotation`
--

CREATE TABLE `tb_quotation` (
  `quotation_id` int(5) NOT NULL,
  `cust_id` int(5) NOT NULL,
  `grand_total` float(12,2) NOT NULL,
  `quotation_status_id` int(2) NOT NULL,
  `payment_term_id` int(2) NOT NULL,
  `quotation_date` date NOT NULL,
  `product_id` int(5) NOT NULL,
  `quotation_type_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_quotation`
--

INSERT INTO `tb_quotation` (`quotation_id`, `cust_id`, `grand_total`, `quotation_status_id`, `payment_term_id`, `quotation_date`, `product_id`, `quotation_type_id`) VALUES
(100, 9, 60.00, 1, 2, '2023-12-12', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotationstatus`
--

CREATE TABLE `tb_quotationstatus` (
  `quotation_status_id` int(2) NOT NULL,
  `quotation_status_desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_quotationstatus`
--

INSERT INTO `tb_quotationstatus` (`quotation_status_id`, `quotation_status_desc`) VALUES
(1, 'Approved'),
(2, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tb_quotationtype`
--

CREATE TABLE `tb_quotationtype` (
  `quotation_type_id` int(2) NOT NULL,
  `quotation_type_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_quotationtype`
--

INSERT INTO `tb_quotationtype` (`quotation_type_id`, `quotation_type_desc`) VALUES
(1, 'Advertising'),
(2, 'Construction');

-- --------------------------------------------------------

--
-- Table structure for table `tb_salesorder`
--

CREATE TABLE `tb_salesorder` (
  `order_id` int(5) NOT NULL,
  `staff_incharge` varchar(100) NOT NULL,
  `remark` text DEFAULT NULL,
  `payment_status_id` int(2) NOT NULL,
  `payment_id` int(5) NOT NULL,
  `order_status_id` int(2) NOT NULL,
  `quotation_id` int(5) NOT NULL,
  `inventory_updated` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_salesorder`
--

INSERT INTO `tb_salesorder` (`order_id`, `staff_incharge`, `remark`, `payment_status_id`, `payment_id`, `order_status_id`, `quotation_id`, `inventory_updated`) VALUES
(100, 'neo', 'havent pay yet', 3, 1, 3, 100, 1);

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
  `type_id` int(2) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `acc_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_ic`, `user_pwd`, `u_fName`, `u_lName`, `user_phone`, `user_email`, `type_id`, `verify_token`, `acc_status`) VALUES
('akmad123', '07910705234', '$2y$10$Kc8ZmsNzngYvTLSKK.TdSuuUnSFcvI1qnv3c.HnAewZlVCBBJJ8VC', 'Akmad', 'Raju', '01110952318', 'ali@gmail.com', 2, '', 1),
('chloe1234', '970421072992', '$2y$10$yeS/AUN37Q6h73KGfwZ1L.k0B7dUlHhPWRJIrExMhmMAHhgncC6uG', 'Chloe', 'Yau', '0126772316', 'neozhengweng@gmail.com', 2, '9e435c5611a080b4cc9e02290acb21edfunda', 1),
('hanhan03', '030917148978', '$2y$10$QGNZQc2p3l3pNlDC8mG1BuyBXfmc/FKcojufbCKfp8vTjzZlyXfUG', 'Han', 'Han', '0126772353', 'neoweng@graduate.utm.my', 2, '6289ce126b55b7296145ba35eef8b335funda', 0),
('liza07', '040717050093', '$2y$10$K/jOCs70gPo3HusgPCgHZexjak4ZgM4rTGQjut1W3wcJF6OQVacH6', 'Liza', 'Nurul', '0126772334', 'tiewshen@graduate.utm.my', 1, '0ac73e6bc12cab5639742a85f9694929funda', 1);

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
(1, 'Staff'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_advertising`
--
ALTER TABLE `tb_advertising`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_category_id` (`item_category_id`);

--
-- Indexes for table `tb_alert`
--
ALTER TABLE `tb_alert`
  ADD PRIMARY KEY (`alert_id`);

--
-- Indexes for table `tb_civil`
--
ALTER TABLE `tb_civil`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tb_construction`
--
ALTER TABLE `tb_construction`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `materialcategory_id` (`material_category_id`),
  ADD KEY `material_category_id` (`material_category_id`);

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
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tb_electric`
--
ALTER TABLE `tb_electric`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tb_itemcategory`
--
ALTER TABLE `tb_itemcategory`
  ADD PRIMARY KEY (`item_category_id`);

--
-- Indexes for table `tb_materialcategory`
--
ALTER TABLE `tb_materialcategory`
  ADD PRIMARY KEY (`material_category_id`);

--
-- Indexes for table `tb_orderstatus`
--
ALTER TABLE `tb_orderstatus`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `payment_type_id` (`payment_type_id`);

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
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `itemproduct_id` (`item_id`,`material_id`),
  ADD KEY `materialproduct_id` (`material_id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `tb_quotation`
--
ALTER TABLE `tb_quotation`
  ADD PRIMARY KEY (`quotation_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `quotation_status_id` (`quotation_status_id`),
  ADD KEY `payment_term_id` (`payment_term_id`),
  ADD KEY `quotation_type_id` (`quotation_type_id`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_advertising`
--
ALTER TABLE `tb_advertising`
  MODIFY `item_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_alert`
--
ALTER TABLE `tb_alert`
  MODIFY `alert_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_civil`
--
ALTER TABLE `tb_civil`
  MODIFY `c_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_construction`
--
ALTER TABLE `tb_construction`
  MODIFY `material_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `cust_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_deliveryorder`
--
ALTER TABLE `tb_deliveryorder`
  MODIFY `delivery_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `tb_electric`
--
ALTER TABLE `tb_electric`
  MODIFY `e_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  MODIFY `invoice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
  MODIFY `payment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_quotation`
--
ALTER TABLE `tb_quotation`
  MODIFY `quotation_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tb_salesorder`
--
ALTER TABLE `tb_salesorder`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_advertising`
--
ALTER TABLE `tb_advertising`
  ADD CONSTRAINT `tb_advertising_ibfk_1` FOREIGN KEY (`item_category_id`) REFERENCES `tb_itemcategory` (`item_category_id`);

--
-- Constraints for table `tb_construction`
--
ALTER TABLE `tb_construction`
  ADD CONSTRAINT `tb_construction_ibfk_1` FOREIGN KEY (`material_category_id`) REFERENCES `tb_materialcategory` (`material_category_id`);

--
-- Constraints for table `tb_deliveryorder`
--
ALTER TABLE `tb_deliveryorder`
  ADD CONSTRAINT `tb_deliveryorder_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `tb_quotation` (`quotation_id`),
  ADD CONSTRAINT `tb_deliveryorder_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `tb_salesorder` (`order_id`);

--
-- Constraints for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD CONSTRAINT `tb_invoice_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_salesorder` (`order_id`),
  ADD CONSTRAINT `tb_invoice_ibfk_2` FOREIGN KEY (`quotation_id`) REFERENCES `tb_quotation` (`quotation_id`),
  ADD CONSTRAINT `tb_invoice_ibfk_3` FOREIGN KEY (`delivery_id`) REFERENCES `tb_deliveryorder` (`delivery_id`);

--
-- Constraints for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD CONSTRAINT `tb_product_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `tb_advertising` (`item_id`),
  ADD CONSTRAINT `tb_product_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `tb_construction` (`material_id`);

--
-- Constraints for table `tb_quotation`
--
ALTER TABLE `tb_quotation`
  ADD CONSTRAINT `tb_quotation_ibfk_2` FOREIGN KEY (`quotation_status_id`) REFERENCES `tb_quotationstatus` (`quotation_status_id`),
  ADD CONSTRAINT `tb_quotation_ibfk_3` FOREIGN KEY (`payment_term_id`) REFERENCES `tb_paymentterm` (`payment_term_id`),
  ADD CONSTRAINT `tb_quotation_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `tb_customer` (`cust_id`);

--
-- Constraints for table `tb_salesorder`
--
ALTER TABLE `tb_salesorder`
  ADD CONSTRAINT `tb_salesorder_ibfk_1` FOREIGN KEY (`order_status_id`) REFERENCES `tb_orderstatus` (`order_status_id`),
  ADD CONSTRAINT `tb_salesorder_ibfk_2` FOREIGN KEY (`payment_status_id`) REFERENCES `tb_paymentstatus` (`payment_status_id`),
  ADD CONSTRAINT `tb_salesorder_ibfk_4` FOREIGN KEY (`payment_id`) REFERENCES `tb_payment` (`payment_id`),
  ADD CONSTRAINT `tb_salesorder_ibfk_5` FOREIGN KEY (`quotation_id`) REFERENCES `tb_quotation` (`quotation_id`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tb_usertype` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
