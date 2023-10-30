-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Eki 2023, 20:07:35
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `school`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `t_classes`
--

CREATE TABLE `t_classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `t_classes`
--

INSERT INTO `t_classes` (`id`, `class_name`, `class_teacher_id`) VALUES
(3, 'Zayotem', 12),
(4, '2023 Yavuzlar', 21);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `t_classes_students`
--

CREATE TABLE `t_classes_students` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `t_classes_students`
--

INSERT INTO `t_classes_students` (`id`, `student_id`, `class_id`) VALUES
(7, 10, 3),
(8, 11, 3),
(9, 20, 4),
(10, 18, 4),
(11, 19, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `t_exams`
--

CREATE TABLE `t_exams` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_score` tinyint(4) NOT NULL,
  `exam_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `t_exams`
--

INSERT INTO `t_exams` (`id`, `student_id`, `lesson_id`, `class_id`, `exam_score`, `exam_date`) VALUES
(12, 10, 5, 3, 67, '2023-10-09 06:47:01'),
(13, 11, 5, 3, 67, '2023-10-09 06:47:09'),
(17, 18, 7, 4, 13, '2023-10-09 07:07:25'),
(18, 19, 7, 4, 45, '2023-10-09 07:07:30'),
(19, 20, 7, 4, 55, '2023-10-09 07:07:35'),
(20, 20, 6, 4, 24, '2023-10-09 07:07:41'),
(21, 18, 6, 4, 56, '2023-10-09 07:07:45'),
(22, 19, 6, 4, 87, '2023-10-09 07:07:50');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `t_lessons`
--

CREATE TABLE `t_lessons` (
  `id` int(11) NOT NULL,
  `teacher_user_id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `t_lessons`
--

INSERT INTO `t_lessons` (`id`, `teacher_user_id`, `lesson_name`) VALUES
(5, 17, 'JS'),
(6, 21, 'Etik hacker'),
(7, 16, 'CSS');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `surname`, `username`, `password`, `role`, `created_at`) VALUES
(8, 'admin', 'admin', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$Y3ZvSUR1aG0xYmZqNHBlQw$f5DJ2Vsh3k/nUhFLNQvxl4KZPwtjgwF85JWM3WdLlYw', 'admin', '2023-10-09 07:09:18'),
(10, 'student 2', 's2', 's2', '$argon2id$v=19$m=65536,t=4,p=1$MHY2LjRpVkJEclpHZThuUA$f63eW16zlmXNnHR2gRhhUYv21Hpe7y7MYw7a5ol5mtg', 'student', '2023-10-09 06:40:10'),
(11, 'student 3', 's3', 's3', '$argon2id$v=19$m=65536,t=4,p=1$ZUxlZU9qcFI3blU4YjMvaw$wG5XHinMrqKo28QRv4oh79l4Ds5CiVKjF5jBgCoWBlM', 'student', '2023-10-09 06:40:05'),
(12, 'Zteacher', 't1', 't1', '$argon2id$v=19$m=65536,t=4,p=1$c00xWS4uT2FwenN2Nm5ydw$sAIrC/ozK0dQXCBQuwYvfpPqZKRyRzV7rxbJqtsOvtw', 'teacher', '2023-10-09 06:40:59'),
(14, 'PHP', 'temp', 'PHP Hocasi', '$argon2id$v=19$m=65536,t=4,p=1$Y0VCL1NCSy9laDQyZ1NOaw$HOUJwIZ1z1rND5p2dMQCDWYXbDmArOKpK4IEcuIIIao', 'teacher', '2023-10-09 06:45:24'),
(15, 'HTML', 'temp', 'HTML Hocasi', '$argon2id$v=19$m=65536,t=4,p=1$N3hxU0UveUJoay5HM2J2YQ$yVdUxQFzRsIcERtKuLtVpYPaMtB+6Q0EIxWvMhA3Xbo', 'teacher', '2023-10-09 06:45:38'),
(16, 'CSS', 'temp', 'CSS Hocasi', '$argon2id$v=19$m=65536,t=4,p=1$czJJNC84TXdEOWtYWHJpLg$SnBEHL2fgSAWitdjEPn1jBhSElQXN2IIXaEBOb+8Uxk', 'teacher', '2023-10-09 06:46:04'),
(17, 'JS', 'temp', 'JS Hocasi', '$argon2id$v=19$m=65536,t=4,p=1$YWFreklJSmZ2MzF1WmZCVw$brvZbQVyzNBKAXwle6ePbYWqYP36G3dNASjg4Tqd/KE', 'teacher', '2023-10-09 06:46:17'),
(18, 'Berkay', 's1', 'ss1', '$argon2id$v=19$m=65536,t=4,p=1$dk1qVzRkRkdsRlJGS1dmbg$2HkxQc7KFk8VzfoMXrK3KwTx1ZsZwMlnX2Ak86BdtfA', 'student', '2023-10-09 07:03:31'),
(19, 'Bora', 'ss2', 'ss2', '$argon2id$v=19$m=65536,t=4,p=1$SU16b1RCNmVVRlN2VFVZNg$JmQa2RaP0+YD0v/JMTJNcxC2oZFU9SpX6A1IdDD46ck', 'student', '2023-10-09 07:03:40'),
(20, 'Yavuz', 'ss3', 'ss3', '$argon2id$v=19$m=65536,t=4,p=1$T0NoMjNKUG1DN2dTWkdIYg$3BDscOnr193/KdloOOvwJzLnjBR64HvAs76gr0TpMTI', 'student', '2023-10-09 07:04:11'),
(21, 'Selim', 't2', 'Yavuzlar', '$argon2id$v=19$m=65536,t=4,p=1$ZmxnZVQ2Q2hpU3dKaENLaw$XQx6hT+swL6MGhnpzS4ROJGUMMveM51NJYeMd1rdGI4', 'teacher', '2023-10-09 07:04:28');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `t_classes`
--
ALTER TABLE `t_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_teacher_id` (`class_teacher_id`);

--
-- Tablo için indeksler `t_classes_students`
--
ALTER TABLE `t_classes_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Tablo için indeksler `t_exams`
--
ALTER TABLE `t_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Tablo için indeksler `t_lessons`
--
ALTER TABLE `t_lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_user_id` (`teacher_user_id`);

--
-- Tablo için indeksler `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `t_classes`
--
ALTER TABLE `t_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `t_classes_students`
--
ALTER TABLE `t_classes_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `t_exams`
--
ALTER TABLE `t_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `t_lessons`
--
ALTER TABLE `t_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `t_classes`
--
ALTER TABLE `t_classes`
  ADD CONSTRAINT `t_classes_ibfk_1` FOREIGN KEY (`class_teacher_id`) REFERENCES `t_users` (`id`);

--
-- Tablo kısıtlamaları `t_classes_students`
--
ALTER TABLE `t_classes_students`
  ADD CONSTRAINT `t_classes_students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `t_users` (`id`),
  ADD CONSTRAINT `t_classes_students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `t_classes` (`id`);

--
-- Tablo kısıtlamaları `t_exams`
--
ALTER TABLE `t_exams`
  ADD CONSTRAINT `t_exams_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `t_users` (`id`),
  ADD CONSTRAINT `t_exams_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `t_lessons` (`id`),
  ADD CONSTRAINT `t_exams_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `t_classes` (`id`);

--
-- Tablo kısıtlamaları `t_lessons`
--
ALTER TABLE `t_lessons`
  ADD CONSTRAINT `t_lessons_ibfk_1` FOREIGN KEY (`teacher_user_id`) REFERENCES `t_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
