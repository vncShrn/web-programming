-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2017 at 06:59 PM
-- Server version: 5.5.49-log
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `AUTHOR_ID` int(5) NOT NULL,
  `NAME` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`AUTHOR_ID`, `NAME`) VALUES
(120, 'ABC'),
(121, 'Alexander  Rosenberg'),
(124, 'Craig D. Shimasaki'),
(123, 'David E. Goldberg'),
(115, 'David M Schwartz'),
(128, 'David Spencer'),
(116, 'Greg K Tang '),
(112, 'J K Rowling'),
(122, 'James B Kaler'),
(114, 'Jon F Scieszka '),
(113, 'Kate'),
(126, 'Kenneth H Rosen'),
(117, 'Loreen J Leedy'),
(125, 'Louise Barrett Derr'),
(118, 'Nick Page'),
(119, 'Phyllis G  Curott');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `ISBN` varchar(20) NOT NULL DEFAULT '',
  `TITLE` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `PUBLISHER` varchar(15) NOT NULL,
  `EDITION` varchar(10) DEFAULT NULL,
  `YEAR` year(4) DEFAULT NULL,
  `COVER_IMG` varchar(30) DEFAULT NULL,
  `CHECK_OUT_POLICY` int(3) DEFAULT '90',
  `COPIES` int(3) DEFAULT '1',
  `AVAILABLE` int(3) DEFAULT '1',
  `CATEG_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `TITLE`, `DESCRIPTION`, `PUBLISHER`, `EDITION`, `YEAR`, `COVER_IMG`, `CHECK_OUT_POLICY`, `COPIES`, `AVAILABLE`, `CATEG_ID`) VALUES
('111111111', 'Harry Potter and the Deathly Hallows', 'Harry Potter, a boy who learns on his eleventh birthday that he is the orphaned son of two powerful wizards and possesses unique magical powers of his own.', 'Dream', 'Second', 2009, 'fiction4.jpg', 5, 0, 0, 3),
('111111112', 'Happy Maths - Maths for fun', 'Learn maths very easily. Perfect book for beginners', 'KP Publication', 'First', 2006, 'math1.jpg', 30, 4, 4, 2),
('111111113', 'The Dark Night of Shed', 'The Dark Night of the Shed: Men, the midlife crisis, spirituality - and sheds', 'Hodder &amp; St', 'Third', 2004, 'fiction1.jpg', 30, 5, 5, 3),
('111111114', 'Book of Shadows', 'A Book of Shadows is a book containing religious texts and instructions for magical rituals found.', ' Inner Light Gl', 'Second', 2015, 'fiction2.jpg', 30, 10, 10, 3),
('111111115', 'First Magnitude - A book of the bright Sky', 'First magnitude stars are the brightest stars in the night sky', 'FM Publishers', 'Second', 2015, 'science4.jpg', 30, 7, 7, 1),
('111111117', 'But is it Science?', 'Book for Philosophical Science', 'BP Publication', 'First', 2008, 'science3.jpg', 30, 5, 5, 1),
('111111121', 'Experiencing Bible Science - A lab book for the young at Heart', 'the Bible makes about science is not only true but crucial', 'CP Publisher', 'First', 2004, 'science1.jpg', 30, 20, 20, 1),
('111111122', 'Common Core Math', 'Easy to solve math problems', 'VS Publishers', 'First', 2010, 'math2.jpg', 30, 15, 13, 2),
('11111113', 'Discrete Mathematics and its Applications', 'Book with around 1000 solved examples', 'KSV Publishers', 'First', 2005, 'math4.jpg', 30, 4, 4, 2),
('111111134', 'Entrepreneur Engineer', 'Best book for engineers who wants to be an entrepreneur', 'EE Publisher', 'First', 2001, 'engineering1.jpg', 30, 10, 10, 5),
('121212121', 'KMcDermott Libert Middle School Math', 'Study Math like never before!', 'ABC Publishers', 'First', 2007, 'math3.jpg', 30, 15, 15, 2),
('121212131', 'Cryptography engineering- Design Principles and Practical Applications', 'Book for Cryptography lovers', 'CMP Publication', 'First', 2007, 'engineering2.jpg', 30, 15, 15, 5),
('123111100', 'Harry Potter and the Philosopher Stone', 'Harry Potter and the Philosopher Stone is the first novel in the Harry Potter series and J. K. Rowling debut novel, first published in 1997 by Bloomsbury', 'Dream', 'First', 2011, 'hp1.jpg', 5, 2, 2, 3),
('123123123', 'Harry Potter and the Prisoner of Azkaban', 'Title Harry Potter and the Chamber of Secrets is the third novel in the Harry Potter series, written by J. K. Rowling.escription', 'Dream', 'First', 2009, 'hp3.jpg', 30, 5, 5, 3),
('12344411', 'The Musical Theatre Writer', 'A survival guide for a theatre writer', 'Paperworks', 'First', 1988, 'music-1.jpg', 10, 2, 2, 6),
('123444111', 'The Musical Theatre Writer', 'A survival guide for a theatre writer', 'Paperworks', 'First', 1988, 'music-1.jpg', 10, 2, 2, 6),
('123444112', 'The Classical Guitar', 'Guitar lessons', 'Paperworks', 'First', 1988, 'music-2.jpg', 10, 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE IF NOT EXISTS `book_author` (
  `ISBN` varchar(20) NOT NULL,
  `AUTHOR_ID` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`ISBN`, `AUTHOR_ID`) VALUES
('111111111', 112),
('123111100', 112),
('123123123', 112),
('111111112', 114),
('111111122', 115),
('121212121', 117),
('111111113', 118),
('111111114', 119),
('111111117', 121),
('111111115', 122),
('111111134', 123),
('121212131', 124),
('111111121', 125),
('11111113', 126),
('123444111', 128),
('123444112', 128);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CATEG_ID` int(11) NOT NULL,
  `NAME` varchar(45) NOT NULL,
  `LOCATION_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CATEG_ID`, `NAME`, `LOCATION_ID`) VALUES
(1, 'Science', 1),
(2, 'Mathematics', 2),
(3, 'Fiction', 3),
(5, 'Engineering', 5),
(6, 'Music', 6);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE IF NOT EXISTS `loans` (
  `LOAN_ID` int(11) NOT NULL,
  `ISBN` varchar(20) NOT NULL DEFAULT '',
  `NET_ID` varchar(20) NOT NULL DEFAULT '',
  `BORROWED_DATE` date NOT NULL,
  `DUE_DATE` date NOT NULL,
  `RETURNED_DATE` date DEFAULT NULL,
  `FINE_AMT` float DEFAULT NULL,
  `IS_FINE_PAID` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`LOAN_ID`, `ISBN`, `NET_ID`, `BORROWED_DATE`, `DUE_DATE`, `RETURNED_DATE`, `FINE_AMT`, `IS_FINE_PAID`) VALUES
(9, '111111114', 'vxc152130', '2017-04-10', '2017-04-21', '2017-04-23', 10, 0),
(10, '111111122', 'ksv160130', '2017-04-26', '2017-05-26', NULL, 0, 0),
(12, '111111122', 'vxc152130', '2017-04-26', '2017-05-26', '2017-04-26', 0, 0);

--
-- Triggers `loans`
--
DELIMITER $$
CREATE TRIGGER `loans_AFTER_INSERT` AFTER INSERT ON `loans`
 FOR EACH ROW BEGIN
    UPDATE BOOK SET AVAILABLE= AVAILABLE-1 WHERE BOOK.ISBN= NEW.ISBN;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `loans_AFTER_UPDATE` AFTER UPDATE ON `loans`
 FOR EACH ROW BEGIN
  IF (OLD.RETURNED_DATE IS NULL AND NEW.RETURNED_DATE IS NOT NULL) THEN
    UPDATE BOOK SET AVAILABLE= AVAILABLE+1 WHERE BOOK.ISBN= NEW.ISBN;
  END IF;
  IF ( NEW.FINE_AMT > OLD.FINE_AMT) THEN
    UPDATE USER SET BALANCE = BALANCE+NEW.FINE_AMT WHERE USER.NET_ID= NEW.NET_ID;
  END IF;  
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `LOCATION_ID` int(11) NOT NULL,
  `FLOOR` int(2) DEFAULT NULL,
  `AISLE` int(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LOCATION_ID`, `FLOOR`, `AISLE`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `NET_ID` varchar(20) NOT NULL DEFAULT '',
  `FNAME` varchar(20) NOT NULL,
  `LNAME` varchar(20) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `PHONE` int(10) NOT NULL,
  `PWD` varchar(100) NOT NULL,
  `IS_ADMIN` tinyint(1) NOT NULL,
  `BALANCE` float DEFAULT NULL,
  `IS_BAL_PAID` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`NET_ID`, `FNAME`, `LNAME`, `EMAIL`, `PHONE`, `PWD`, `IS_ADMIN`, `BALANCE`, `IS_BAL_PAID`) VALUES
('admin', 'Admin', '', 'johnsmith@gmail.com', 2144334433, 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 0, 1),
('ksv160130', 'Kajol', 'Patel', 'ksv160130@utdallas.edu', 2133344433, '6367c48dd193d56ea7b0baad25b19455e529f5ee', 0, 0, 0),
('vxc152130', 'Vincy', 'Shrine', 'vxc123450@utdallas.edu', 2144311123, '6367c48dd193d56ea7b0baad25b19455e529f5ee', 0, 10, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`AUTHOR_ID`),
  ADD UNIQUE KEY `NAME_UNIQUE` (`NAME`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `FK_LOC_ID_idx` (`CATEG_ID`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`ISBN`,`AUTHOR_ID`),
  ADD KEY `FK_AUTHOR_ID_idx` (`AUTHOR_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CATEG_ID`),
  ADD UNIQUE KEY `NAME_UNIQUE` (`NAME`),
  ADD KEY `FK_LOC_ID_idx` (`LOCATION_ID`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`LOAN_ID`,`ISBN`,`NET_ID`),
  ADD KEY `fk_1_idx` (`ISBN`),
  ADD KEY `fk_2_idx` (`NET_ID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LOCATION_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`NET_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `AUTHOR_ID` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CATEG_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `LOAN_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LOCATION_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `FK_CATEG_ID` FOREIGN KEY (`CATEG_ID`) REFERENCES `category` (`CATEG_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `FK_AUTHOR_ID` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `author` (`AUTHOR_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_ISBN` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_LOC_ID` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_2` FOREIGN KEY (`NET_ID`) REFERENCES `user` (`NET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
