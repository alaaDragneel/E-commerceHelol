-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2016 at 12:51 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `Adv_ID` int(11) NOT NULL,
  `company_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `Adv_content` text CHARACTER SET latin1 NOT NULL,
  `adsImage` varchar(255) CHARACTER SET latin1 NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`Adv_ID`, `company_name`, `email`, `Adv_content`, `adsImage`, `userID`) VALUES
(1, 'samsung', 'samsung@samsungcom', 'this is the new phones from us', '22940_anime_scenery.jpg', 4),
(2, 'sony', 'sony@sony.com', 'this is our ads', 'playstation-4-logo-wallpaper-wallpaper-4.jpg', 4),
(3, 'sony', 'sony@sony.com', 'this is our ads', 'playstation-4-logo-wallpaper-wallpaper-4.jpg', 4),
(4, 'pepsy', 'pepsy@pepsy.pepsy', 'pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy pepsy', 'snapshot20160619082251.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Cat_ID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_ID`, `Name`, `Date`, `UserID`) VALUES
(5, 'mobiles', '2016-08-03', 1),
(6, 'labtops', '2016-08-11', 1),
(10, 'electroinics', '2016-08-12', 1),
(12, 'tv', '2016-08-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `contactUs_ID` int(11) NOT NULL,
  `Name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `message` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `ID` int(11) NOT NULL,
  `Username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `Email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Content` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`ID`, `Username`, `Email`, `Content`) VALUES
(2, 'mohamed', '0', 'mohamed zayed is good');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `offerPrice` float NOT NULL,
  `offername` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `offerPrice`, `offername`, `product_id`) VALUES
(6, 50, 'The New Mobiles Has a Min Charge 75%', 2),
(7, 20, 'The New Mobiles Has a Min Charge 20$', 8),
(8, 15, 'The New Mobiles Has a Min Charge 100%', 15),
(10, 50, 'The New Mobiles Has a Min Charge50%', 27),
(13, 76, 'The New play station Has a Min Charge 30%', 30);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `model_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Details` text CHARACTER SET latin1 NOT NULL COMMENT 'details about the product',
  `price` float NOT NULL,
  `Date` date NOT NULL,
  `Image` varchar(500) CHARACTER SET latin1 NOT NULL COMMENT 'product Image',
  `groupId` int(11) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL,
  `Cat_ID` int(11) DEFAULT NULL,
  `subCatId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `model_name`, `Details`, `price`, `Date`, `Image`, `groupId`, `userId`, `Cat_ID`, `subCatId`) VALUES
(2, 'Samsung Note 7', 'this is our new Samsung phone', 3000, '2016-08-09', '1001973_1042415199115147_8293448645308946531_n.jpg', 1, 2, 5, 1),
(8, 'Samsung Note 5', 'this is the note 5', 35200, '2016-08-11', 'galaxy-note5_gallery_left-perspective_black_s3.png', 1, 4, 5, 2),
(15, 'sony eperia z5', 'our new phone', 3000, '2016-08-12', '1044_1092643174092349_1756376243938499730_n.jpg', 1, 2, 5, 2),
(26, 'testproduct', 'asdsada', 2000, '2016-08-17', '54545.jpg', 1, 2, 10, 5),
(27, 'sasmung s7', 'this is our new mobile', 5000, '2016-08-17', '12241747_414375758756150_2611962092478941331_n.jpg', 1, 2, 12, 11),
(29, 'product test', 'this is he new tets', 1200, '2016-08-20', '7d8c3e2c659bf7b9c7edffdced7fdc561459069695_full[1].jpg', 1, 4, 6, 7),
(30, 'Play Station 4', 'the new play station with the new logo', 3210, '2016-08-21', 'playstation-4-logo-wallpaper-wallpaper-4.jpg', 1, 4, NULL, NULL),
(31, 'Apple laptop', 'this is the new laptob from apple', 12000, '2016-08-22', 'laptop.jpg', 1, 4, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(11) NOT NULL,
  `ratingLike` int(11) NOT NULL,
  `ratingDisLike` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`ratingId`, `ratingLike`, `ratingDisLike`, `userId`, `product_id`) VALUES
(1, 0, 1, 2, 8),
(2, 0, 1, 4, 2),
(3, 0, 1, 2, 15),
(4, 1, 0, 4, 15),
(5, 1, 0, 2, 2),
(6, 1, 0, 2, 29),
(7, 0, 1, 4, 8),
(8, 1, 0, 4, 29),
(9, 1, 0, 4, 31),
(10, 1, 0, 4, 30);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_basket`
--

CREATE TABLE `shopping_basket` (
  `basket_ID` int(11) NOT NULL,
  `Product_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shopping_basket`
--

INSERT INTO `shopping_basket` (`basket_ID`, `Product_id`, `UserID`) VALUES
(18, 15, 3),
(24, 15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `subCatId` int(11) NOT NULL,
  `subCatName` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `Cat_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`subCatId`, `subCatName`, `Cat_ID`) VALUES
(1, 'samsung', 5),
(2, 'sony', 5),
(3, 'hp', 6),
(4, 'dell', 6),
(5, 'apple', 10),
(6, 'appleIphone', 6),
(7, 'samsung', 6),
(10, 'samsung', 12),
(11, 'sony', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `National_ID` varchar(14) CHARACTER SET latin1 NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `userImg` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Rate` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `National_ID`, `username`, `Email`, `Password`, `userImg`, `Rate`, `GroupID`) VALUES
(1, '6666', 'alaa', 'alaa@alaa.com', '6666', '1044_1092643174092349_1756376243938499730_n.jpg', 0, 0),
(2, '6666', 'mohamed', 'mohamed@alaa.net', '6666', '21604_1039747829381884_3542145519186229239_n.jpg', 2, 2),
(3, '123123123', 'zayed', 'zayed@zayed.com', '123123', '22940_anime_scenery.jpg', 0, 4),
(4, '6666', 'Alaa Dragneel', 'moaalaa@yahoo.com', '6666', '7d8c3e2c659bf7b9c7edffdced7fdc561459069695_full[1].jpg', 2, 3),
(5, '6666', 'android', 'ad@ad.com', '6666', '12279003_877347249049198_8426161785246109759_n.jpg', 0, 3),
(6, '856446665599', 'alaaMoh', 'alaa@alaa.com', '3333', 'snapshot20160514140753.jpg', 0, 0),
(8, '66666666666666', 'moaalaa', 'aaaa@aaaa.com', '66666', 'snapshot20160514140753.jpg', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `whishlist`
--

CREATE TABLE `whishlist` (
  `wishId` int(11) NOT NULL,
  `Product_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `whishlist`
--

INSERT INTO `whishlist` (`wishId`, `Product_id`, `UserID`) VALUES
(20, 8, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`Adv_ID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`contactUs_ID`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `subCatId` (`subCatId`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingId`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  ADD PRIMARY KEY (`basket_ID`),
  ADD KEY `Product_id` (`Product_id`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subCatId`),
  ADD KEY `Cat_ID` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD PRIMARY KEY (`wishId`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `Product_id` (`Product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `Adv_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Cat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `contactUs_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  MODIFY `basket_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subCatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `whishlist`
--
ALTER TABLE `whishlist`
  MODIFY `wishId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subCatId`) REFERENCES `subcategories` (`subCatId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`Cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shopping_basket`
--
ALTER TABLE `shopping_basket`
  ADD CONSTRAINT `shopping_basket_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `shopping_basket_ibfk_2` FOREIGN KEY (`Product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`Cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD CONSTRAINT `whishlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `whishlist_ibfk_2` FOREIGN KEY (`Product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
