-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2020 at 12:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaizen`
--

-- --------------------------------------------------------

--
-- Table structure for table `changebles`
--

CREATE TABLE `changebles` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `changebles`
--

INSERT INTO `changebles` (`id`, `name`) VALUES
(1, 'Конструкция изделия'),
(2, 'Применяемая техника'),
(3, 'Инструменты'),
(4, 'Технология производства'),
(5, 'Организация производственного процесса');

-- --------------------------------------------------------

--
-- Table structure for table `chiefs`
--

CREATE TABLE `chiefs` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(56) NOT NULL,
  `family` varchar(56) NOT NULL,
  `father` varchar(56) NOT NULL,
  `department` int(5) UNSIGNED NOT NULL,
  `id_pos` int(5) UNSIGNED NOT NULL,
  `mail` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chiefs`
--

INSERT INTO `chiefs` (`id`, `name`, `family`, `father`, `department`, `id_pos`, `mail`, `phone`, `password`, `role`) VALUES
(0, 'Игорь', 'Суров', 'Алексеевич', 3, 1, 'surov@gmail.com', '89955561957', '$2y$10$EFg4eeutuEbL7l.HP1d9L.g1KRMH78SY/fpdmpWygM22LrBdHT6QK', 2),
(1956, 'Андрей', 'Котов', 'Викторович', 2, 1, 'makos@gmail.com', '89963361956', '$2y$10$XlqwpcrssYNRjleS4G/MWeTOIJKg56kgIlKIB.pW4B0npUTvGoixu', 2),
(1957, 'Данияр', 'Зарипов', 'Наилевич', 1, 0, 'ma3aukos@gmail.com', '89963361957', '$2y$10$mUH5W3Le2sTSxRnHOMWrWeInfFn9bQeXY1/IQOq1mJkbB.3RnPmci', 1),
(2324, 'Дмитрий', 'Кунгуров', 'Олегович', 4, 1, 'kungur@gmail.com', '89664552324', '$2y$10$xCabXE0Ltfhkzb5az6d5PO4GtZUYcSOmhrU0jM9knggO6mioSNVka', 2),
(2450, 'Владимир', 'Марьянко', 'Викторович', 1, 1, 'circum@mail.ru', '88553302450', '$2y$10$4.qdKb493meyw5mlEQlPEO4.11mpKUNqrIQXKmUs/exfu1ZJncC8u', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chief_img`
--

CREATE TABLE `chief_img` (
  `id` int(5) UNSIGNED NOT NULL,
  `id_chief` int(5) UNSIGNED NOT NULL,
  `id_status` int(5) UNSIGNED NOT NULL,
  `extension` varchar(5) NOT NULL DEFAULT 'jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chief_img`
--

INSERT INTO `chief_img` (`id`, `id_chief`, `id_status`, `extension`) VALUES
(1, 1957, 8, 'jpg'),
(2, 2450, 8, 'jpg'),
(4, 2324, 8, 'jpg'),
(13, 0, 8, 'jpg'),
(37, 1956, 8, 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(5) NOT NULL,
  `text` text NOT NULL,
  `idea` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `idea`) VALUES
(3, 'Описание и ожидаемый эффект повторяются.', 8),
(4, 'Опишите положительный эффект подробнее', 9);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(56) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`) VALUES
(1, 'Руководство', 'Главный отдел управления организацией'),
(2, 'IT-отдел', 'Занимается разработкой информационных систем и прикладных программ'),
(3, 'Бухгалтерия', 'Ведет бухгалтерский учет предприятия'),
(4, 'Отдел мобильной разработки', 'Занимается разработкой программ для мобильных устройств');

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE `ideas` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `sphere` int(5) UNSIGNED NOT NULL,
  `problem` text NOT NULL,
  `description` text NOT NULL,
  `reciever` int(5) UNSIGNED NOT NULL,
  `sender` int(5) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` int(5) UNSIGNED NOT NULL DEFAULT 1,
  `changeble` int(5) UNSIGNED NOT NULL,
  `benefit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `name`, `sphere`, `problem`, `description`, `reciever`, `sender`, `date`, `status`, `changeble`, `benefit`) VALUES
(4, 'Использование платформы для разработки мобильных приложений', 1, 'Ручная разработка дешевых приложений', 'Наш отдел использует те же инструменты для разработки простых приложений, что и для сложных. Из-за этого на их разработку расходуется примерно то же количество времени, что и на разработку более дорогих приложений. Использование платформы для создания мобильных приложений Appery.io упростит произодство низкостоящих приложений и позволит увеличить количество выполненных работ.', 2324, 7788, '2020-06-04 00:00:00', 4, 3, 'Экономия времени и ресурсов при разработке дешевых мобильных приложений, увеличение количества разработок и выполненных заказов.'),
(8, 'Менеджмент кабелей и проводов', 3, 'Скопление открытых проводов', 'На предприятии используется большое количество проводной техники. Отсутствие менеджмента приводит к повреждению кабелей. Это может привести к коротким замыканиям и даже ставит под угрозу безопасность работников.', 2450, 7788, '2020-06-10 00:00:00', 2, 3, 'Благодаря закрытости проводов, подключенных к ПК, уменьшится вероятность повредить их'),
(9, 'Обеспечение компьютеров SSD накопителями', 1, '      Отсутствие SSD и низкая скорость работы ПК    ', '        SSD -- это накопители данных, скорость чтения и записи у которых намного выше ныне используемых HDD. Внедрение SSD в наши компьютеры позволит сократить скорости загрузки и работы операционной системы, а также избавит нас от проблем в виде лагов и тормозов при работе с данными.      ', 2450, 3556, '2020-05-14 00:00:00', 3, 2, 'Будет лучше'),
(12, 'Ввести бенчмаркинг на предприятие', 4, 'Отсутствие нормирования труда', 'Бенчмаркинг - один из наименее трудозатратных и наиболее точных методов нормирования труда. Это функциональное сравнение своего опыта с одной или более передовыми компаниями в одной отрасли. Сравнивая себя с конкурентами, мы будем более отчетливо понимать и в последствии исправлять свои недостатки.', 2450, 5685, '2020-06-14 22:27:13', 2, 5, 'Исправление неочевидных недостатков компании'),
(13, 'Организация системы документооборота', 2, 'Долгое время подготовки, проверки и отражение в учете первичных учетных документов.', 'Необходимо разбить весь процесс документооборота на самостоятельные завершенные по смыслу микро-участки. После этого станет понятно, какие из документов и на каком этапе могут быть созданы, а затем переданы для дальнейшего использования другими подразделениями.', 2450, 4522, '2020-06-14 23:17:07', 1, 4, 'Бухгалтерская служба в установленные сроки получит учетные документы, оформленные по всем правилам, содержащие обязательные реквизиты и подписи ответственных лиц.'),
(14, 'Использование Android Microbenchmark Harness', 1, 'Неточные замеры производительности приложений', 'AMH - тест производительности, замеряющий скорость выполнения конкретных скриптов и алгоритмов. Внедрив данную систему в наше производство, мы сможем добиться гораздо более точных результатов с информацией о работоспособности наших приложений. Это позволит нам максимально грамотно оптимизировать приложения и избежать лагов и тормозов.', 2324, 2211, '2020-06-14 23:38:18', 2, 4, 'Улучшенная производительность конечных продуктов');

-- --------------------------------------------------------

--
-- Table structure for table `ideas_img`
--

CREATE TABLE `ideas_img` (
  `id` int(5) UNSIGNED NOT NULL,
  `idea` int(5) UNSIGNED NOT NULL,
  `file` text NOT NULL,
  `extension` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ideas_img`
--

INSERT INTO `ideas_img` (`id`, `idea`, `file`, `extension`) VALUES
(7, 4, '3-4-app', 'png'),
(8, 4, '3-4-Ann', 'png'),
(11, 8, '3-8-76am', 'docx'),
(16, 8, '3-8-0LB6', 'png'),
(20, 14, '2211-14-i4mb', 'docx');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `description`) VALUES
(3, 'Проектирование', 'Шаблон организации для дипломного проекта Зарипова Данияра');

-- --------------------------------------------------------

--
-- Table structure for table `organization_img`
--

CREATE TABLE `organization_img` (
  `id` int(5) UNSIGNED NOT NULL,
  `file` varchar(11) NOT NULL,
  `extension` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization_img`
--

INSERT INTO `organization_img` (`id`, `file`, `extension`) VALUES
(2, 'Lineage_OS', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`) VALUES
(0, ' Администратор'),
(1, 'Руководитель'),
(2, 'Разработчик'),
(3, 'Тимлид'),
(4, 'Дизайнер'),
(5, 'Бухгалтер');

-- --------------------------------------------------------

--
-- Table structure for table `profile_img`
--

CREATE TABLE `profile_img` (
  `id` int(5) UNSIGNED NOT NULL,
  `id_user` int(5) UNSIGNED NOT NULL,
  `id_status` int(5) UNSIGNED NOT NULL DEFAULT 7,
  `extension` varchar(5) NOT NULL DEFAULT 'jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_img`
--

INSERT INTO `profile_img` (`id`, `id_user`, `id_status`, `extension`) VALUES
(5, 7788, 8, 'jpg'),
(6, 5685, 8, 'jpg'),
(7, 4522, 8, 'jpg'),
(8, 2211, 8, 'jpg'),
(10, 1231, 8, 'jpg'),
(11, 3556, 8, 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Руководитель отдела'),
(3, 'Работник');

-- --------------------------------------------------------

--
-- Table structure for table `spheres`
--

CREATE TABLE `spheres` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spheres`
--

INSERT INTO `spheres` (`id`, `name`) VALUES
(1, 'Информационные технологии'),
(2, 'Финансово-экономическая деятельность'),
(3, 'Охрана труда и промышленная безопасность'),
(4, 'Политика компании');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Рассматривается администратором '),
(2, 'Рассматривается получателем'),
(3, 'Отправлено на доработку'),
(4, 'Одобрено'),
(5, 'Отказано'),
(7, 'Без фото'),
(8, 'С фото');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(56) NOT NULL,
  `family` varchar(56) NOT NULL,
  `father` varchar(56) NOT NULL,
  `department` int(5) UNSIGNED NOT NULL,
  `id_pos` int(5) UNSIGNED NOT NULL,
  `mail` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` text NOT NULL,
  `role` int(5) UNSIGNED NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `family`, `father`, `department`, `id_pos`, `mail`, `phone`, `password`, `role`) VALUES
(1231, 'Александр', 'Вилисов', 'Георгиевич', 2, 2, 'wes@gmail.com', '89963361323', '$2y$10$xJinl0pfOEDh.yzJQ4ZI7OfE7wIbnjekTejYs7j1yZ4tIV1osgi1W', 3),
(2211, 'Александра', 'Кост', 'Игоревна', 4, 4, 'kost@gmail.com', '89994562211', '$2y$10$2MszNr7.sSE.P9MdNHU6juczUcBpR76.yzHNYVkwbB7Re3ldnCdL.', 3),
(3556, 'Константин', 'Тростенюк ', 'Максимович', 2, 2, 'trost@gmail.com', '89655423656', '$2y$10$MSpZYi6.1pEqhUzb4xtS9uxy2fgmzGfwprKyXoUfuFKVohSYn1Xk.', 3),
(4522, 'Дмитрий', 'Бурдуков', 'Ильич', 3, 5, 'burduk@gmail.com', '89175624522', '$2y$10$2eUFp0zIauTjC9SciS.94ecnRoZL7d0pWLWJYw4bZn42U9FxJExha', 3),
(5685, 'Максим', 'Кулаков', 'Васильевич', 3, 5, 'kulakov@gmail.com', '8917235685', '$2y$10$Nzq8xNYcqjAzr.JfWdFxyubJ1ustIF1O6nH6KytLzXKr4wCseoJuK', 3),
(7788, 'Василий', 'Гальперов', 'Иванович', 4, 4, 'galp@mail.ru', '84561237788', '$2y$10$VwBPcuZKQZDQnbo4te3TCORoLGx.zSrQZEi.vd8BLYv3LzKSg2oD2', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `changebles`
--
ALTER TABLE `changebles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chiefs`
--
ALTER TABLE `chiefs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`),
  ADD KEY `department` (`department`),
  ADD KEY `role_2` (`role`),
  ADD KEY `Id_pos` (`id_pos`);

--
-- Indexes for table `chief_img`
--
ALTER TABLE `chief_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chief` (`id_chief`,`id_status`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idea` (`idea`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ideas`
--
ALTER TABLE `ideas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reciever` (`reciever`,`sender`,`status`),
  ADD KEY `sphere` (`sphere`),
  ADD KEY `changeble` (`changeble`),
  ADD KEY `status` (`status`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `ideas_img`
--
ALTER TABLE `ideas_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idea` (`idea`),
  ADD KEY `idea_2` (`idea`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_img`
--
ALTER TABLE `organization_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_img`
--
ALTER TABLE `profile_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`,`id_status`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spheres`
--
ALTER TABLE `spheres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`,`role`),
  ADD KEY `role` (`role`),
  ADD KEY `Id_pos` (`id_pos`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `changebles`
--
ALTER TABLE `changebles`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chief_img`
--
ALTER TABLE `chief_img`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ideas`
--
ALTER TABLE `ideas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ideas_img`
--
ALTER TABLE `ideas_img`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organization_img`
--
ALTER TABLE `organization_img`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile_img`
--
ALTER TABLE `profile_img`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `spheres`
--
ALTER TABLE `spheres`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chiefs`
--
ALTER TABLE `chiefs`
  ADD CONSTRAINT `chiefs_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `chiefs_ibfk_2` FOREIGN KEY (`department`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `chiefs_ibfk_3` FOREIGN KEY (`Id_pos`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `chiefs_ibfk_4` FOREIGN KEY (`id_pos`) REFERENCES `positions` (`id`);

--
-- Constraints for table `chief_img`
--
ALTER TABLE `chief_img`
  ADD CONSTRAINT `chief_img_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `chief_img_ibfk_3` FOREIGN KEY (`id_chief`) REFERENCES `chiefs` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`idea`) REFERENCES `ideas` (`id`);

--
-- Constraints for table `ideas`
--
ALTER TABLE `ideas`
  ADD CONSTRAINT `ideas_ibfk_1` FOREIGN KEY (`sphere`) REFERENCES `spheres` (`id`),
  ADD CONSTRAINT `ideas_ibfk_2` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `ideas_ibfk_3` FOREIGN KEY (`changeble`) REFERENCES `changebles` (`id`),
  ADD CONSTRAINT `ideas_ibfk_4` FOREIGN KEY (`sender`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ideas_ibfk_5` FOREIGN KEY (`reciever`) REFERENCES `chiefs` (`id`);

--
-- Constraints for table `ideas_img`
--
ALTER TABLE `ideas_img`
  ADD CONSTRAINT `ideas_img_ibfk_1` FOREIGN KEY (`idea`) REFERENCES `ideas` (`id`);

--
-- Constraints for table `profile_img`
--
ALTER TABLE `profile_img`
  ADD CONSTRAINT `profile_img_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `profile_img_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`department`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`Id_pos`) REFERENCES `positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
