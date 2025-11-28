-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2025 a las 02:43:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `dni`, `full_name`, `created_at`) VALUES
(1, '12345678', 'Juan Perez', '2025-11-25 19:28:42'),
(2, '87654321', 'Maria Salas', '2025-11-25 19:28:42'),
(3, '75838937', 'Alexander Piera', '2025-11-25 20:23:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL COMMENT 'Fecha y hora de inicio de la reservación',
  `end_date` datetime NOT NULL COMMENT 'Fecha y hora de fin de la reservación',
  `blocks` int(11) DEFAULT 1 COMMENT 'Número de bloques de 12 horas',
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `room_id`, `reservation_date`, `end_date`, `blocks`, `total_amount`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-04 20:36:09', '2025-12-05 08:36:09', 1, 50.00, 'pending', 'Reservación de prueba - cliente confirmará', '2025-11-28 01:36:09', '2025-11-28 01:36:09'),
(2, 2, 2, '2025-11-29 20:36:09', '2025-11-30 20:36:09', 2, 100.00, 'confirmed', 'Cliente ya confirmó su llegada', '2025-11-28 01:36:09', '2025-11-28 01:36:09'),
(3, 3, 3, '2025-11-22 20:36:09', '2025-11-23 08:36:09', 1, 50.00, 'completed', 'Cliente usó la habitación exitosamente', '2025-11-22 01:36:09', '2025-11-28 01:36:09'),
(4, 1, 4, '2025-12-07 20:36:09', '2025-12-09 08:36:09', 3, 150.00, 'cancelled', 'Cliente canceló por cambio de planes', '2025-11-28 01:36:09', '2025-11-28 01:36:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('available','occupied','maintenance') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`id`, `code`, `floor`, `description`, `price`, `status`) VALUES
(1, '101', '1', 'Habitación simple con baño privado', 80.00, 'available'),
(2, '102', '1', 'Habitación simple ventilada', 75.00, 'available'),
(3, '201', '2', 'Habitación doble con vista', 120.00, 'available'),
(4, '202', '2', 'Suite matrimonial', 180.00, 'available');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stays`
--

CREATE TABLE `stays` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stays`
--

INSERT INTO `stays` (`id`, `client_id`, `room_id`, `check_in`, `check_out`, `total_amount`, `note`) VALUES
(13, 3, 1, '2025-11-25 23:57:07', '2025-11-27 20:40:47', 960.00, 'pruba 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `created_at`) VALUES
(1, 'admin', '$2b$12$rf5b2v3t9BenBGo2v5DiW.FFEMpHIRo5iYi26VoVQeWpPQUVAAVz.', 'administrador', 'admin', '2025-11-21 23:05:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_dates` (`reservation_date`,`end_date`),
  ADD KEY `idx_room_date` (`room_id`,`reservation_date`,`end_date`);

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indices de la tabla `stays`
--
ALTER TABLE `stays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `idx_stays_checkin` (`check_in`),
  ADD KEY `idx_stays_checkout` (`check_out`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stays`
--
ALTER TABLE `stays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stays`
--
ALTER TABLE `stays`
  ADD CONSTRAINT `stays_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `stays_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
