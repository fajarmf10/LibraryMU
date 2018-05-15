-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2018 at 02:50 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_daftar` (IN `p_username` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_fullname` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN
	IF NOT EXISTS(SELECT 1 FROM users WHERE email = p_email) THEN
		IF NOT EXISTS(SELECT 1 FROM users WHERE p_username = username) THEN
			INSERT INTO users(username, email, fullname, password, type)
			VALUES	(p_username, p_email, p_fullname, MD5(p_password), 'user');
			SELECT 0, 'pendaftaran sukses!';
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

DELIMITER ;

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
  `type` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `fullname`, `password`, `type`) VALUES
(1, 'fajarmf', 'admin@fajarmf.com', 'Fajar Maulana Firdaus', 'baf101f077548923d3625174b9a10de1', 'admin'),
(2, 'user1', 'user1@gmail.com', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
