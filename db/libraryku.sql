-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2018 at 08:44 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libraryku`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_books` ()  BEGIN
	IF(SELECT count(*) as `count` FROM `books` HAVING `count` > 0) THEN
		SELECT
    		*
    	FROM
      		`libraryku`.`books`
        WHERE
        	1;
		ELSE
			SELECT -1, 'Stok buku kosong';
   	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_counttoday` ()  NO SQL
BEGIN
	IF(SELECT count(*) as `count` FROM `books` HAVING `count` > 0) THEN
		SELECT
    		count(*) as jumlah
    	FROM
      		`libraryku`.`books`
        WHERE
        	DATE(`created_at`) = CURDATE()
        ORDER BY
        	`created_at`
        ASC;
		ELSE
			SELECT -1, 'Stok buku kosong';
   	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_daftar` (IN `p_username` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_fullname` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN
	IF NOT EXISTS(SELECT 1 FROM users WHERE email = p_email) THEN
		IF NOT EXISTS(SELECT 1 FROM users WHERE p_username = username) THEN
			INSERT INTO users(username, email, fullname, password, type)
			VALUES	(p_username, p_email, p_fullname, MD5(p_password), 'user');
			SELECT 0, 'Pendaftaran sukses! Silahkan Login!';
		ELSE
			SELECT -2, 'username sudah ada';
		END IF;
	ELSE
		SELECT -1, 'pendaftaran gagal! email sudah digunakan';
	END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `p_uname` VARCHAR(32), IN `p_password` VARCHAR(32))  BEGIN
	IF EXISTS(SELECT 1 FROM users WHERE p_uname = username) THEN
		IF EXISTS(SELECT 2 FROM users WHERE MD5(p_password) = password AND p_uname = username) THEN
			SELECT 0, (SELECT id FROM users WHERE p_uname = username) AS userid, (SELECT username FROM users WHERE p_uname = username) AS username, (SELECT fullname FROM users WHERE p_uname=username) AS name, (SELECT type FROM users WHERE p_uname=username) AS usertype;
		ELSE
			SELECT -2,'Password salah';
		END IF;
	ELSE
		SELECT -1,'Username tidak ada';
	END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_today` ()  BEGIN
	IF(SELECT count(*) as `count` FROM `books` HAVING `count` > 0) THEN
		SELECT
    		`title`, `category`, `created_at`, `count`, `type`, `path`
    	FROM
      		`libraryku`.`books`
        WHERE
        	DATE(`created_at`) = CURDATE()
        ORDER BY
        	`created_at`
        ASC;
		ELSE
			SELECT -1, 'Stok buku kosong';
   	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_trending` ()  BEGIN
	IF(SELECT count(*) as `count` FROM `books` HAVING `count` > 0) THEN
    	SELECT
        	`title`, `category`, `created_at`, `count`, `type`, `path`
        FROM
        	`libraryku`.`books`
        ORDER BY
        	`count`
        DESC LIMIT
        	10;
		ELSE
			SELECT -1, 'Pencarian tidak tersedia!';
   	END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL,
  `quiz` tinyint(1) NOT NULL,
  `type` enum('pdf','epub') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `category`, `path`, `created_at`, `count`, `quiz`, `type`) VALUES
(1, 'Advanced Machine Learning with Python', 'Machine Learning', 'advanced-machine-learning-with-python.pdf', '2018-05-17 13:00:31', 22, 0, 'pdf'),
(2, 'Android Programming for Beginners', 'Android', 'android-programming-for-beginners.pdf', '2018-05-16 13:00:59', 124, 0, 'pdf'),
(3, 'Python Data Science Handbook', 'Data Science', 'python-data-science-handbook.epub', '2018-05-16 14:21:57', 513, 0, 'epub'),
(4, 'Advanced Machine Learning with Python1', 'Machine Learning', 'advanced-machine-learning-with-python1.pdf', '2018-05-16 13:00:31', 31, 0, 'pdf'),
(5, 'Android Programming for Beginners1', 'Android', 'android-programming-for-beginners1.pdf', '2018-05-16 13:00:59', 11, 0, 'pdf'),
(6, 'Python Data Science Handbook1', 'Data Science', 'python-data-science-handbook1.epub', '2018-05-16 14:21:57', 12, 0, 'epub'),
(43, 'Advanced Machine Learning with Python11', 'Machine Learning', 'advanced-machine-learning-with-python111.pdf', '2018-05-16 13:00:31', 42, 0, 'pdf'),
(44, 'Android Programming for Beginners11', 'Android', 'android-programming-for-beginners111.pdf', '2018-05-16 13:00:59', 42, 0, 'pdf'),
(45, 'Python Data Science Handbook11', 'Data Science', 'python-data-science-handbook111.epub', '2018-05-16 14:21:57', 24, 0, 'epub'),
(46, 'Advanced Machine Learning with Python11', 'Machine Learning', 'advanced-machine-learning-with-python11.pdf', '2018-05-16 13:00:31', 51, 0, 'pdf'),
(47, 'Android Programming for Beginners11', 'Android', 'android-programming-for-beginners11.pdf', '2018-05-16 13:00:59', 125, 0, 'pdf'),
(48, 'Python Data Science Handbook11', 'Data Science', 'python-data-science-handbook11.epub', '2018-05-16 14:21:57', 44, 0, 'epub');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboards`
--

CREATE TABLE `leaderboards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `month` enum('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` enum('user','admin') NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `fullname`, `password`, `type`, `last_login`) VALUES
(1, 'fajarmf', 'admin@fajarmf.com', 'Fajar Maulana Firdaus', 'baf101f077548923d3625174b9a10de1', 'admin', NULL),
(2, 'user1', 'user1@gmail.com', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 'user', NULL),
(5, 'jihaders', 'jihad@masjid.co', 'remajamasjid', 'f01e06ba9e11fec4f94adad1e89a531b', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_UNIQUE` (`path`) USING BTREE;

--
-- Indexes for table `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaderboards`
--
ALTER TABLE `leaderboards`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
