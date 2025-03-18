-- noinspection SqlNoDataSourceInspectionForFile

INSERT INTO `frs_drivers` (`id`, `first_name`, `last_name`, `address`, `contact`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 'Juan', 'Dela Cruz', 'Bayombong, Nueva Vizcaya', '09171234567', b'0', 1, NULL),
(2, 'Pedro', 'Santos', 'Solano, Nueva Vizcaya', '09172345678', b'0', 1, NULL),
(3, 'Maria', 'Gonzales', 'Bambang, Nueva Vizcaya', '09173456789', b'0', 1, NULL),
(4, 'Luis', 'Reyes', 'Bagabag, Nueva Vizcaya', '09174567890', b'0', 1, NULL),
(5, 'Ana', 'Torres', 'Diadi, Nueva Vizcaya', '09175678901', b'0', 1, NULL),
(6, 'Carlos', 'Lopez', 'Quezon, Nueva Vizcaya', '09176789012', b'0', 1, NULL),
(7, 'Sofia', 'Martinez', 'Villaverde, Nueva Vizcaya', '09177890123', b'0', 1, NULL),
(8, 'Miguel', 'Garcia', 'Aritao, Nueva Vizcaya', '09178901234', b'0', 1, NULL),
(9, 'Elena', 'Fernandez', 'Dupax del Norte, Nueva Vizcaya', '09179012345', b'0', 1, NULL),
(10, 'Jose', 'Ramirez', 'Kasibu, Nueva Vizcaya', '09170123456', b'0', 1, NULL);

INSERT INTO `frs_ejeeps` (`id`, `plate`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 'ABC 123', b'0', 1, 1),
(2, 'XYZ 789', b'0', 1, 1),
(3, 'DEF 456', b'0', 1, 1),
(4, 'GHI 101', b'0', 1, 1),
(5, 'JKL 202', b'0', 1, 1);

INSERT INTO `frs_collections` (`id`, `driver_id`, `ejeep_id`, `route_id`, `date`, `amount`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 1, '2024-01-05', 1500, b'0', 1, NULL),
(2, 2, 2, 1, '2024-01-10', 1200, b'0', 1, NULL),
(3, 3, 3, 1, '2024-01-15', 1300, b'0', 1, NULL),
(4, 4, 4, 1, '2024-01-20', 1400, b'0', 1, NULL),
(5, 5, 5, 1, '2024-01-25', 1100, b'0', 1, NULL),
(6, 6, 1, 1, '2024-02-01', 1600, b'0', 1, NULL),
(7, 7, 2, 1, '2024-02-05', 1700, b'0', 1, NULL),
(8, 8, 3, 1, '2024-02-10', 1800, b'0', 1, NULL),
(9, 9, 4, 1, '2024-02-15', 1900, b'0', 1, NULL),
(10, 10, 5, 1, '2024-02-20', 2000, b'0', 1, NULL),
(11, 1, 1, 1, '2024-03-01', 1500, b'0', 1, NULL),
(12, 2, 2, 1, '2024-03-05', 1200, b'0', 1, NULL),
(13, 3, 3, 1, '2024-03-10', 1300, b'0', 1, NULL),
(14, 4, 4, 1, '2024-03-15', 1400, b'0', 1, NULL),
(15, 5, 5, 1, '2024-03-20', 1100, b'0', 1, NULL),
(16, 6, 1, 1, '2024-04-01', 1600, b'0', 1, NULL),
(17, 7, 2, 1, '2024-04-05', 1700, b'0', 1, NULL),
(18, 8, 3, 1, '2024-04-10', 1800, b'0', 1, NULL),
(19, 9, 4, 1, '2024-04-15', 1900, b'0', 1, NULL),
(20, 10, 5, 1, '2024-04-20', 2000, b'0', 1, NULL),
(21, 1, 1, 1, '2024-05-01', 1500, b'0', 1, NULL),
(22, 2, 2, 1, '2024-05-05', 1200, b'0', 1, NULL),
(23, 3, 3, 1, '2024-05-10', 1300, b'0', 1, NULL),
(24, 4, 4, 1, '2024-05-15', 1400, b'0', 1, NULL),
(25, 5, 5, 1, '2024-05-20', 1100, b'0', 1, NULL),
(26, 6, 1, 1, '2024-06-01', 1600, b'0', 1, NULL),
(27, 7, 2, 1, '2024-06-05', 1700, b'0', 1, NULL),
(28, 8, 3, 1, '2024-06-10', 1800, b'0', 1, NULL),
(29, 9, 4, 1, '2024-06-15', 1900, b'0', 1, NULL),
(30, 10, 5, 1, '2024-06-20', 2000, b'0', 1, NULL);

INSERT INTO `frs_expenses` (`id`, `category_id`, `description`, `amount`, `date`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 3, 'Tire replacement for e-jeep ABC 123', 2000, '2024-01-05', b'0', 1, NULL),
(2, 4, 'Annual insurance for e-jeep XYZ 789', 5000, '2024-01-10', b'0', 1, NULL),
(3, 6, 'Electric bill for January 2024', 1500, '2024-01-15', b'0', 1, NULL),
(4, 7, 'Water bill for January 2024', 800, '2024-01-20', b'0', 1, NULL),
(5, 8, 'Office supplies for January 2024', 500, '2024-01-25', b'0', 1, NULL),
(6, 3, 'Brake repair for e-jeep DEF 456', 1200, '2024-02-01', b'0', 1, NULL),
(7, 4, 'Insurance renewal for e-jeep GHI 101', 4500, '2024-02-05', b'0', 1, NULL),
(8, 6, 'Electric bill for February 2024', 1600, '2024-02-10', b'0', 1, NULL),
(9, 7, 'Water bill for February 2024', 850, '2024-02-15', b'0', 1, NULL),
(10, 8, 'Office supplies for February 2024', 600, '2024-02-20', b'0', 1, NULL),
(11, 3, 'Engine repair for e-jeep JKL 202', 3000, '2024-03-01', b'0', 1, NULL),
(12, 4, 'Insurance for e-jeep ABC 123', 4800, '2024-03-05', b'0', 1, NULL),
(13, 6, 'Electric bill for March 2024', 1700, '2024-03-10', b'0', 1, NULL),
(14, 7, 'Water bill for March 2024', 900, '2024-03-15', b'0', 1, NULL),
(15, 8, 'Office supplies for March 2024', 700, '2024-03-20', b'0', 1, NULL),
(16, 3, 'Battery replacement for e-jeep XYZ 789', 2500, '2024-04-01', b'0', 1, NULL),
(17, 4, 'Insurance for e-jeep DEF 456', 4700, '2024-04-05', b'0', 1, NULL),
(18, 6, 'Electric bill for April 2024', 1800, '2024-04-10', b'0', 1, NULL),
(19, 7, 'Water bill for April 2024', 950, '2024-04-15', b'0', 1, NULL),
(20, 8, 'Office supplies for April 2024', 800, '2024-04-20', b'0', 1, NULL),
(21, 3, 'Transmission repair for e-jeep GHI 101', 3500, '2024-05-01', b'0', 1, NULL),
(22, 4, 'Insurance for e-jeep JKL 202', 4900, '2024-05-05', b'0', 1, NULL),
(23, 6, 'Electric bill for May 2024', 1900, '2024-05-10', b'0', 1, NULL),
(24, 7, 'Water bill for May 2024', 1000, '2024-05-15', b'0', 1, NULL),
(25, 8, 'Office supplies for May 2024', 900, '2024-05-20', b'0', 1, NULL),
(26, 3, 'Suspension repair for e-jeep ABC 123', 2800, '2024-06-01', b'0', 1, NULL),
(27, 4, 'Insurance for e-jeep XYZ 789', 4600, '2024-06-05', b'0', 1, NULL),
(28, 6, 'Electric bill for June 2024', 2000, '2024-06-10', b'0', 1, NULL),
(29, 7, 'Water bill for June 2024', 1050, '2024-06-15', b'0', 1, NULL),
(30, 8, 'Office supplies for June 2024', 1000, '2024-06-20', b'0', 1, NULL);


INSERT INTO `frs_salaries` (`id`, `driver_id`, `rate_id`, `date`, `collection`, `salary`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 1, 1, '2024-01-05', 1500, 270, b'0', 1, NULL),
(2, 2, 1, '2024-01-10', 1200, 216, b'0', 1, NULL),
(3, 3, 1, '2024-01-15', 1300, 234, b'0', 1, NULL),
(4, 4, 1, '2024-01-20', 1400, 252, b'0', 1, NULL),
(5, 5, 1, '2024-01-25', 1100, 198, b'0', 1, NULL),
(6, 6, 1, '2024-02-01', 1600, 288, b'0', 1, NULL),
(7, 7, 1, '2024-02-05', 1700, 306, b'0', 1, NULL),
(8, 8, 1, '2024-02-10', 1800, 324, b'0', 1, NULL),
(9, 9, 1, '2024-02-15', 1900, 342, b'0', 1, NULL),
(10, 10, 1, '2024-02-20', 2000, 360, b'0', 1, NULL),
(11, 1, 1, '2024-03-01', 1500, 270, b'0', 1, NULL),
(12, 2, 1, '2024-03-05', 1200, 216, b'0', 1, NULL),
(13, 3, 1, '2024-03-10', 1300, 234, b'0', 1, NULL),
(14, 4, 1, '2024-03-15', 1400, 252, b'0', 1, NULL),
(15, 5, 1, '2024-03-20', 1100, 198, b'0', 1, NULL),
(16, 6, 1, '2024-04-01', 1600, 288, b'0', 1, NULL),
(17, 7, 1, '2024-04-05', 1700, 306, b'0', 1, NULL),
(18, 8, 1, '2024-04-10', 1800, 324, b'0', 1, NULL),
(19, 9, 1, '2024-04-15', 1900, 342, b'0', 1, NULL),
(20, 10, 1, '2024-04-20', 2000, 360, b'0', 1, NULL),
(21, 1, 1, '2024-05-01', 1500, 270, b'0', 1, NULL),
(22, 2, 1, '2024-05-05', 1200, 216, b'0', 1, NULL),
(23, 3, 1, '2024-05-10', 1300, 234, b'0', 1, NULL),
(24, 4, 1, '2024-05-15', 1400, 252, b'0', 1, NULL),
(25, 5, 1, '2024-05-20', 1100, 198, b'0', 1, NULL),
(26, 6, 1, '2024-06-01', 1600, 288, b'0', 1, NULL),
(27, 7, 1, '2024-06-05', 1700, 306, b'0', 1, NULL),
(28, 8, 1, '2024-06-10', 1800, 324, b'0', 1, NULL),
(29, 9, 1, '2024-06-15', 1900, 342, b'0', 1, NULL),
(30, 10, 1, '2024-06-20', 2000, 360, b'0', 1, NULL);