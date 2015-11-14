-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2015 at 11:13 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `difference`
--

CREATE TABLE IF NOT EXISTS `difference` (
  `iddifference` int(10) unsigned NOT NULL,
  `idproduct` int(10) unsigned NOT NULL,
  `idshop` int(10) unsigned NOT NULL,
  `type_money` enum('PERCENT','BATH') COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_difference` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docket`
--

CREATE TABLE IF NOT EXISTS `docket` (
  `iddocket` int(10) unsigned NOT NULL,
  `idshop` int(10) unsigned NOT NULL,
  `idregion` int(10) unsigned NOT NULL,
  `filepath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_docket` enum('รอการชำระเงิน','ชำระเงินแล้ว') COLLATE utf8_unicode_ci DEFAULT NULL,
  `money` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docket_period`
--

CREATE TABLE IF NOT EXISTS `docket_period` (
  `iddocket_period` int(10) unsigned NOT NULL,
  `idregion` int(10) unsigned NOT NULL,
  `datestart` date DEFAULT NULL,
  `datefinal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factory`
--

CREATE TABLE IF NOT EXISTS `factory` (
  `idfactory` int(10) unsigned NOT NULL,
  `name_factory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel_factory` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address_factory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_factory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `difference_amount_factory` double NOT NULL,
  `detail_factory` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `factory`
--

INSERT INTO `factory` (`idfactory`, `name_factory`, `tel_factory`, `address_factory`, `contact_factory`, `difference_amount_factory`, `detail_factory`) VALUES
(1, 'บริษัท น้ำปลาไทย จำกัด', '087-1583657', '9 จังหวัดสุพรรณบุรี', 'สมชาย', 9, '-'),
(2, 'บริษัท โลซาน จำกัด', '088-5873654', '2 จังหวัด เชียงใหม่', 'ซาน', 5, '-'),
(3, '', '', '', '', 0, ''),
(4, 'aaaaa', 'aaaa', 'aaaa', 'aaaa', 10, '222'),
(5, 'Asdasd', 'asdasd', 'sadasd', '', 10, 'asdasd'),
(6, 'บริษัท มอรเดลีซ', '088-1475632', '-', '10', 22, '22'),
(7, 'บริษัท มอรเดลีซ', 'asdasd', 'asdas', '20', 10, '80'),
(8, '', '', '', 'asdasdasdasd', 0, ''),
(9, 'qweas', 'dasd', 'sadasd', 'sadsadasd', 10, 'qwe'),
(10, 'บริษัท มอรเดลีซ', '088-1475632', '107 หมู่4', 'ฮอล', 20, '-'),
(11, 'assa', 'ssss', 'aaaa', '089-44444444', 5, '6asdasd'),
(12, 'a', 'a', 'a', 'a', 1, 'a'),
(13, 'b', 'b', 'b', 'b', 0, 'b'),
(14, 'c', 'c', 'c', 'c', 0, 'c'),
(15, 'z', 'z', 'z', 'z', 0, 'z'),
(16, 's', 's', 's', 's', 0, 's'),
(17, 'x', 'x', 'x', 'x', 0, 'x'),
(18, 'z', 'z', 'z', 'z', 0, 'z'),
(19, 'q', 'q', 'q', 'q', 0, 'q'),
(20, 'e', 'e', 'e', 'e', 0, 'e'),
(21, 'พ', 'พ', 'พ', 'พ', 0, 'พ');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `idmember` int(10) unsigned NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_member` enum('ผู้จัดการ','บัญชี','ฝ่ายขาย') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`idmember`, `name`, `lastname`, `username`, `password`, `status_member`) VALUES
(1, 'วรรณชัย', 'นารี', 'admin', 'admin', 'ผู้จัดการ'),
(2, 'กระทรวง', 'สมศรี', 'admin1', '1111', 'ผู้จัดการ'),
(3, 'jo', 'aa', '', 'aa', 'ผู้จัดการ'),
(4, 'asd', 'sad', '', 'asd', 'ผู้จัดการ'),
(5, 'asd', 'asdasd', '', 'asass', 'ผู้จัดการ'),
(6, 'asd', 'asdasd', 'sadasd', 'asass', 'ผู้จัดการ'),
(7, 'asd', 'asddd', 'ssdss', 'wwwwww', 'ผู้จัดการ'),
(8, 'asd', 'asddd', 'ssdss', 'wwwwww', 'ผู้จัดการ'),
(9, 'wadsd', 'asdsdsd', 'sssss', 'sssss', 'ผู้จัดการ'),
(10, 'wwww', 'qqqqq', 'ewq', 'asda', 'ผู้จัดการ'),
(11, 'wwww', 'qqqqq', 'ewq', 'asd', 'ผู้จัดการ'),
(12, '', '', '', '', 'ผู้จัดการ'),
(13, 'arg', 'eag', 'rg', '1234', 'ผู้จัดการ'),
(14, 'aa', 'aaa', 'q', '1234', 'ผู้จัดการ'),
(15, 'q', 'q', 'q', '1234', 'ผู้จัดการ'),
(16, 'aa', 'aa', 'aa', 'aa', 'ผู้จัดการ'),
(17, 'aa', 'aa', 'bb', '', 'ผู้จัดการ'),
(18, 'aa', 'aa', 'ss', '', 'ผู้จัดการ'),
(19, 'qq', 'qq', 'qq', 'qq', 'ผู้จัดการ'),
(20, 'ww', 'ww', 'ww', 'ww', 'ผู้จัดการ'),
(21, 'a', 'a', 'a', 'a', 'ผู้จัดการ'),
(22, 'b', 'b', 'b', 'b', 'ผู้จัดการ'),
(23, 'z', 'z', 'z', 'z', 'ผู้จัดการ'),
(24, 'w', 'w', 'w', 'wa', 'ผู้จัดการ'),
(25, 'a', 'a', 'a', 'a', 'ผู้จัดการ');

-- --------------------------------------------------------

--
-- Table structure for table `order_p`
--

CREATE TABLE IF NOT EXISTS `order_p` (
  `idorder_p` int(10) unsigned NOT NULL,
  `idshop` int(10) unsigned NOT NULL,
  `idorder_transport` int(10) unsigned NOT NULL,
  `date_order_p` date DEFAULT NULL,
  `time_order_p` time DEFAULT NULL,
  `detail_order_p` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_transport`
--

CREATE TABLE IF NOT EXISTS `order_transport` (
  `idorder_transport` int(10) unsigned NOT NULL,
  `idtransport` int(10) unsigned NOT NULL,
  `volume` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pricetransport` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `idpay` int(10) unsigned NOT NULL,
  `idtypepay` int(10) unsigned NOT NULL,
  `iddocket` int(10) unsigned NOT NULL,
  `date_pay` double DEFAULT NULL,
  `pay` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `idproduct` int(10) unsigned NOT NULL,
  `idfactory` int(10) unsigned NOT NULL,
  `name_product` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_product` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_product` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_product` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idproduct`, `idfactory`, `name_product`, `detail_product`, `code_product`, `amount_product`) VALUES
(1, 1, 'sss', 'sss', 'sss', 10);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE IF NOT EXISTS `product_order` (
  `idproduct_order` int(10) unsigned NOT NULL,
  `idorder_transport` int(10) unsigned NOT NULL,
  `idproduct` int(10) unsigned NOT NULL,
  `idorder_p` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE IF NOT EXISTS `province` (
  `idprovince` int(10) unsigned NOT NULL,
  `idregion` int(10) unsigned NOT NULL,
  `name_province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`idprovince`, `idregion`, `name_province`) VALUES
(1, 1, 'เชียงใหม่'),
(2, 1, 'เชียงราย');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `idregion` int(10) unsigned NOT NULL,
  `name_region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`idregion`, `name_region`) VALUES
(1, 'ภาคเหนือ'),
(2, 'ภาคตะวันตก'),
(3, 'ภาคกลาง'),
(4, 'ภาคใต้'),
(5, 'ภาคตะวันออก');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `idshop` int(10) unsigned NOT NULL,
  `idprovince` int(10) unsigned NOT NULL,
  `name_shop` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_shop` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_shop` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_shop` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`idshop`, `idprovince`, `name_shop`, `tel_shop`, `detail_shop`, `address_shop`) VALUES
(1, 1, 'ศรี', '087-1254875', '-', '70 หมู่ 9 ');

-- --------------------------------------------------------

--
-- Table structure for table `status_checkproduct`
--

CREATE TABLE IF NOT EXISTS `status_checkproduct` (
  `id` int(10) unsigned NOT NULL,
  `idfactory` int(10) unsigned NOT NULL,
  `idorder_p` int(10) unsigned NOT NULL,
  `status_check` enum('ตรวจสอบ','ไม่ตรวจสอบ') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `idtransport` int(10) unsigned NOT NULL,
  `name_transport` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_transport` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_transport` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`idtransport`, `name_transport`, `tel_transport`, `address_transport`) VALUES
(1, 'aa', 'aa', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `typepay`
--

CREATE TABLE IF NOT EXISTS `typepay` (
  `idtypepay` int(10) unsigned NOT NULL,
  `name_pay` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `idunit` int(10) unsigned NOT NULL,
  `idproduct` int(10) unsigned NOT NULL,
  `idsmall_unit` int(10) unsigned NOT NULL,
  `name_unit` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_unit` double DEFAULT NULL,
  `type_unit` enum('PRIMARY','SECOND') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`idunit`, `idproduct`, `idsmall_unit`, `name_unit`, `price_unit`, `type_unit`) VALUES
(5, 1, 1, 'as', 20, 'PRIMARY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `difference`
--
ALTER TABLE `difference`
  ADD PRIMARY KEY (`iddifference`), ADD KEY `reduction_FKIndex1` (`idshop`), ADD KEY `reduction_FKIndex2` (`idproduct`);

--
-- Indexes for table `docket`
--
ALTER TABLE `docket`
  ADD PRIMARY KEY (`iddocket`), ADD KEY `docket_FKIndex1` (`idregion`), ADD KEY `docket_FKIndex3` (`idshop`);

--
-- Indexes for table `docket_period`
--
ALTER TABLE `docket_period`
  ADD PRIMARY KEY (`iddocket_period`), ADD KEY `docket_period_FKIndex1` (`idregion`);

--
-- Indexes for table `factory`
--
ALTER TABLE `factory`
  ADD PRIMARY KEY (`idfactory`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idmember`);

--
-- Indexes for table `order_p`
--
ALTER TABLE `order_p`
  ADD PRIMARY KEY (`idorder_p`), ADD KEY `order_p_FKIndex1` (`idshop`), ADD KEY `order_p_FKIndex2` (`idorder_transport`);

--
-- Indexes for table `order_transport`
--
ALTER TABLE `order_transport`
  ADD PRIMARY KEY (`idorder_transport`), ADD KEY `order_transport_FKIndex1` (`idtransport`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`idpay`), ADD KEY `pay_FKIndex1` (`iddocket`), ADD KEY `pay_FKIndex2` (`idtypepay`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idproduct`), ADD KEY `product_FKIndex1` (`idfactory`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`idproduct_order`), ADD KEY `product_order_FKIndex1` (`idorder_p`), ADD KEY `product_order_FKIndex2` (`idproduct`), ADD KEY `product_order_FKIndex3` (`idorder_transport`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`idprovince`), ADD KEY `province_FKIndex1` (`idregion`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`idregion`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`idshop`), ADD KEY `shop_FKIndex1` (`idprovince`);

--
-- Indexes for table `status_checkproduct`
--
ALTER TABLE `status_checkproduct`
  ADD PRIMARY KEY (`id`), ADD KEY `status_checkproduct_FKIndex1` (`idorder_p`), ADD KEY `status_checkproduct_FKIndex2` (`idfactory`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`idtransport`);

--
-- Indexes for table `typepay`
--
ALTER TABLE `typepay`
  ADD PRIMARY KEY (`idtypepay`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`idunit`), ADD KEY `unit_FKIndex1` (`idsmall_unit`), ADD KEY `unit_FKIndex2` (`idproduct`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `difference`
--
ALTER TABLE `difference`
  MODIFY `iddifference` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `docket`
--
ALTER TABLE `docket`
  MODIFY `iddocket` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `docket_period`
--
ALTER TABLE `docket_period`
  MODIFY `iddocket_period` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `factory`
--
ALTER TABLE `factory`
  MODIFY `idfactory` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `idmember` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `order_p`
--
ALTER TABLE `order_p`
  MODIFY `idorder_p` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_transport`
--
ALTER TABLE `order_transport`
  MODIFY `idorder_transport` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
  MODIFY `idpay` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idproduct` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `idproduct_order` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `idprovince` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `idregion` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `idshop` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status_checkproduct`
--
ALTER TABLE `status_checkproduct`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `idtransport` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `typepay`
--
ALTER TABLE `typepay`
  MODIFY `idtypepay` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `idunit` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `difference`
--
ALTER TABLE `difference`
ADD CONSTRAINT `difference_ibfk_1` FOREIGN KEY (`idshop`) REFERENCES `shop` (`idshop`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `difference_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `docket`
--
ALTER TABLE `docket`
ADD CONSTRAINT `docket_ibfk_1` FOREIGN KEY (`idregion`) REFERENCES `region` (`idregion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `docket_ibfk_2` FOREIGN KEY (`idshop`) REFERENCES `shop` (`idshop`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `docket_period`
--
ALTER TABLE `docket_period`
ADD CONSTRAINT `docket_period_ibfk_1` FOREIGN KEY (`idregion`) REFERENCES `region` (`idregion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_p`
--
ALTER TABLE `order_p`
ADD CONSTRAINT `order_p_ibfk_1` FOREIGN KEY (`idshop`) REFERENCES `shop` (`idshop`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `order_p_ibfk_2` FOREIGN KEY (`idorder_transport`) REFERENCES `order_transport` (`idorder_transport`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_transport`
--
ALTER TABLE `order_transport`
ADD CONSTRAINT `order_transport_ibfk_1` FOREIGN KEY (`idtransport`) REFERENCES `transport` (`idtransport`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pay`
--
ALTER TABLE `pay`
ADD CONSTRAINT `pay_ibfk_1` FOREIGN KEY (`iddocket`) REFERENCES `docket` (`iddocket`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `pay_ibfk_2` FOREIGN KEY (`idtypepay`) REFERENCES `typepay` (`idtypepay`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idfactory`) REFERENCES `factory` (`idfactory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_order`
--
ALTER TABLE `product_order`
ADD CONSTRAINT `product_order_ibfk_1` FOREIGN KEY (`idorder_p`) REFERENCES `order_p` (`idorder_p`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `product_order_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `product_order_ibfk_3` FOREIGN KEY (`idorder_transport`) REFERENCES `order_transport` (`idorder_transport`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `province`
--
ALTER TABLE `province`
ADD CONSTRAINT `province_ibfk_1` FOREIGN KEY (`idregion`) REFERENCES `region` (`idregion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
ADD CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`idprovince`) REFERENCES `province` (`idprovince`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `status_checkproduct`
--
ALTER TABLE `status_checkproduct`
ADD CONSTRAINT `status_checkproduct_ibfk_1` FOREIGN KEY (`idorder_p`) REFERENCES `order_p` (`idorder_p`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `status_checkproduct_ibfk_2` FOREIGN KEY (`idfactory`) REFERENCES `factory` (`idfactory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
ADD CONSTRAINT `unit_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
