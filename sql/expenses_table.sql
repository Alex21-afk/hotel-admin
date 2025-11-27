-- Tabla para registrar gastos
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ejemplo de inserciones:
-- INSERT INTO expenses (amount, category, description, expense_date) VALUES (150.00, 'Suministros', 'Compra de productos', '2025-01-15');
-- INSERT INTO expenses (amount, category, description, expense_date) VALUES (230.50, 'Mantenimiento', 'Reparación aire', '2025-02-10');
