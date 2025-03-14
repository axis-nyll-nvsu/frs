-- noinspection SqlNoDataSourceInspectionForFile

CREATE TABLE `frs_categories` (
    `id` int(11) NOT NULL,
    `description` varchar(50) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

INSERT INTO `frs_categories` (`id`, `description`, `deleted`, `created_by`, `updated_by`) VALUES
(1, 'Amortization', b'0', 1, NULL),
(2, 'Register per Unit', b'0', 1, NULL),
(3, 'Maintenance & Repair', b'0', 1, NULL),
(4, 'Insurance', b'0', 1, NULL),
(5, 'Driver Salary', b'0', 1, NULL),
(6, 'Utilities - Electric Bill', b'0', 1, NULL),
(7, 'Utilities - Water Bill', b'0', 1, NULL),
(8, 'Office Supplies', b'0', 1, NULL);

CREATE TABLE `frs_collections` (
    `id` int(11) NOT NULL,
    `driver_id` int(11) NOT NULL,
    `ejeep_id` int(11) NOT NULL,
    `route_id` int(11) NOT NULL,
    `date` date NOT NULL,
    `amount` double(10,0) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

CREATE TABLE `frs_drivers` (
    `id` int(11) NOT NULL,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `address` varchar(100) NOT NULL,
    `contact` varchar(25) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

CREATE TABLE `frs_ejeeps` (
    `id` int(11) NOT NULL,
    `plate` varchar(20) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) NOT NULL
);

CREATE TABLE `frs_expenses` (
    `id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `description` varchar(250) NOT NULL,
    `amount` double NOT NULL,
    `date` date NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

CREATE TABLE `frs_routes` (
    `id` int(11) NOT NULL,
    `description` varchar(50) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

INSERT INTO `frs_routes` (`id`, `description`, `deleted`, `created_by`) VALUES
    (1, 'Bayombong - Solano', b'0', 1);

CREATE TABLE `frs_salaries` (
    `id` int(11) NOT NULL,
    `driver_id` int(11) NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `collection` double NOT NULL,
    `amount` double NOT NULL,
    `paid` bit(1) NOT NULL DEFAULT b'0',
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL
);

CREATE TABLE `frs_trail` (
    `id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `description` varchar(100) NOT NULL,
    `date` datetime NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `frs_users` (
    `id` int(11) NOT NULL,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `password` char(32) NOT NULL,
    `type` int(1) NOT NULL,
    `image` varchar(100) NOT NULL,
    `address` varchar(100) NOT NULL,
    `contact` varchar(25) NOT NULL,
    `deleted` bit(1) NOT NULL DEFAULT b'0'
);

INSERT INTO `frs_users` (`id`, `first_name`, `last_name`, `email`, `password`, `type`, `image`, `address`, `contact`, `deleted`) VALUES
(1, 'Charlene', 'Dela Cruz', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 0, 'default.png', 'Bayombong, Nueva Vizcaya', '09170202020', b'0');

ALTER TABLE `frs_categories`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_categories_createdby` (`created_by`),
    ADD KEY `fk_categories_updatedby` (`updated_by`);

ALTER TABLE `frs_collections`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_collections_ejeepid` (`ejeep_id`),
    ADD KEY `fk_collections_routeid` (`route_id`),
    ADD KEY `fk_collections_createdby` (`created_by`),
    ADD KEY `fk_collections_updatedby` (`updated_by`);

ALTER TABLE `frs_drivers`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_drivers_createdby` (`created_by`),
    ADD KEY `fk_drivers_updatedby` (`updated_by`);

ALTER TABLE `frs_ejeeps`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_ejeeps_createdby` (`created_by`),
    ADD KEY `fk_ejeeps_updatedby` (`updated_by`);

ALTER TABLE `frs_expenses`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_expenses_createdby` (`created_by`),
    ADD KEY `fk_expenses_updatedby` (`updated_by`),
    ADD KEY `fk_expenses_categoryid` (`category_id`);

ALTER TABLE `frs_routes`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_routes_createdby` (`created_by`),
    ADD KEY `fk_routes_updatedby` (`updated_by`);

ALTER TABLE `frs_salaries`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_salaries_createdby` (`created_by`),
    ADD KEY `fk_salaries_updateby` (`updated_by`),
    ADD KEY `fk_salaries_driverid` (`driver_id`);

ALTER TABLE `frs_trail`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_trail_userid` (`user_id`);

ALTER TABLE `frs_users`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `frs_categories`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `frs_collections`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_drivers`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_ejeeps`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_expenses`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_routes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `frs_salaries`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_trail`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `frs_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `frs_categories`
    ADD CONSTRAINT `fk_categories_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_categories_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_collections`
    ADD CONSTRAINT `fk_collections_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_collections_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_collections_ejeepid` FOREIGN KEY (`ejeep_id`) REFERENCES `frs_ejeeps` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_collections_routeid` FOREIGN KEY (`route_id`) REFERENCES `frs_routes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_collections_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_drivers`
    ADD CONSTRAINT `fk_drivers_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_drivers_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_ejeeps`
    ADD CONSTRAINT `fk_ejeeps_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_ejeeps_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_expenses`
    ADD CONSTRAINT `fk_expenses_categoryid` FOREIGN KEY (`category_id`) REFERENCES `frs_categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_expenses_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_expenses_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_routes`
    ADD CONSTRAINT `fk_routes_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_routes_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_salaries`
    ADD CONSTRAINT `fk_salaries_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_salaries_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_salaries_updateby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `frs_trail`
    ADD CONSTRAINT `fk_trail_userid` FOREIGN KEY (`user_id`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;