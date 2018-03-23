-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2018 at 01:06 PM
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
-- Database: `demo_codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_quantity` varchar(20) NOT NULL,
  `prod_price` varchar(20) NOT NULL,
  `prod_stock` varchar(20) NOT NULL,
  `prod_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_quantity`, `prod_price`, `prod_stock`, `prod_image`) VALUES
(1, 'Test', '12', '12', '12', '15206858219L4m5ip.jpg'),
(8, 'asas', '1212', '121212', '1212', '1520686525pro3.png'),
(16, 'asd', 'asdasd', 'asdas', 'dasdasd', '1520686951pro2 .jpeg'),
(17, 'asas', '1212', '2121', '212', '1520923255pro2 .jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_firstname` varchar(100) NOT NULL,
  `u_lastname` varchar(100) NOT NULL,
  `u_email` varchar(150) NOT NULL,
  `u_password` varchar(200) NOT NULL,
  `u_phone` varchar(20) NOT NULL,
  `u_profile` text NOT NULL,
  `u_about` text NOT NULL,
  `u_auth` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-Normal, 1-Gplus, 2-FB'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_firstname`, `u_lastname`, `u_email`, `u_password`, `u_phone`, `u_profile`, `u_about`, `u_auth`) VALUES
(1, 'Rajesh', 'Mudaliar', 'rajeshmudaliar1126@gmail.com', '', '9876543210', '1521790457_image.jpg', '', '1'),
(2, 'Kalpesh', 'Patel', 'k4kalpesh125@gmail.com', '', '', '1521790514_image.jpg', '', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
