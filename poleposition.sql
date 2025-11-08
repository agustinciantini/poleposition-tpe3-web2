-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 01:02 AM
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
-- Database: `poleposition`
--

-- --------------------------------------------------------

--
-- Table structure for table `carreras`
--

CREATE TABLE `carreras` (
  `carrera_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `vueltas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carreras`
--

INSERT INTO `carreras` (`carrera_id`, `fecha`, `vueltas`) VALUES
(8, '2025-10-24', 25),
(9, '2025-11-02', 56),
(10, '2025-10-30', 24);

-- --------------------------------------------------------

--
-- Table structure for table `pilotos`
--

CREATE TABLE `pilotos` (
  `piloto_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pilotos`
--

INSERT INTO `pilotos` (`piloto_id`, `nombre`, `apellido`, `foto`) VALUES
(1, 'Agustin', 'Ciantini', NULL),
(21, 'Martin', 'Larrosa', '68f6b5740f759_Screenshot 2025-10-20 191901.jpg'),
(22, 'Juan', 'Riestra', '68f6b71f4308d_piloto4.jpg'),
(23, 'Alan', 'Gomez', '68f6b7b0eeda2_piloto5.jpg'),
(24, 'Lucio', 'Lopez', '68f6b97bb3b36_piloto3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `resultados`
--

CREATE TABLE `resultados` (
  `resultado_id` int(11) NOT NULL,
  `piloto_id` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  `tiempo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resultados`
--

INSERT INTO `resultados` (`resultado_id`, `piloto_id`, `carrera_id`, `posicion`, `tiempo`) VALUES
(13, 21, 8, 1, '01:42:30'),
(14, 1, 8, 2, '01:42:46'),
(15, 24, 9, 1, '01:56:54'),
(16, 1, 9, 2, '01:56:50'),
(17, 23, 9, 3, '01:59:20'),
(18, 22, 9, 4, '02:15:24'),
(19, 1, 10, 1, '01:24:34'),
(20, 21, 10, 2, '01:25:32'),
(21, 24, 10, 3, '01:26:45'),
(22, 23, 10, 4, '01:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `username`, `pass`) VALUES
(3, 'webadmin', '$2y$10$MpaqutvRqh1Pub4IIERIIeJiFaFGpKwlclvjd.zHfUKhNsuxkdhlu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`carrera_id`);

--
-- Indexes for table `pilotos`
--
ALTER TABLE `pilotos`
  ADD PRIMARY KEY (`piloto_id`);

--
-- Indexes for table `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`resultado_id`),
  ADD KEY `fk_resultados_carrera` (`carrera_id`),
  ADD KEY `fk_piloto_id` (`piloto_id`) USING BTREE;

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carreras`
--
ALTER TABLE `carreras`
  MODIFY `carrera_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pilotos`
--
ALTER TABLE `pilotos`
  MODIFY `piloto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `resultados`
--
ALTER TABLE `resultados`
  MODIFY `resultado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `fk_resultados_carrera` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`carrera_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultados_piloto` FOREIGN KEY (`piloto_id`) REFERENCES `pilotos` (`piloto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
