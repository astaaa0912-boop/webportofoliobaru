-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 07:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portofoliopbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `dosen_id` int(11) DEFAULT NULL,
  `skor` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `waktu_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `waktu` datetime NOT NULL,
  `link_proyek` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `nilai` int(3) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `dosen_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `judul`, `jurusan`, `deskripsi`, `waktu`, `link_proyek`, `gambar`, `nilai`, `feedback`, `dosen_id`, `created_at`) VALUES
(14, 18, 'Presentasi proyek baru', 'Teknik Informatika', 'qwertyui', '2026-01-04 17:03:00', NULL, '1767521043.jpg', NULL, NULL, NULL, '2026-01-04 10:04:03'),
(15, 18, 'Presentasi proyek baru', 'Teknik Informatika', 'zxsdfghjk\r\n', '2026-01-04 17:14:00', NULL, '1767521684.jpg', NULL, NULL, NULL, '2026-01-04 10:14:44'),
(16, 18, 'Presentasi proyek baru', 'Teknik Informatika', 'asdfgh', '2026-01-04 17:15:00', NULL, '1767521734.jpg', NULL, NULL, NULL, '2026-01-04 10:15:34'),
(17, 18, 'Presentasi proyek baruyyui', 'Teknik Informatika', 'ljkhfgdtfhk', '2026-01-04 17:17:00', NULL, '1767521909.jpg', NULL, NULL, NULL, '2026-01-04 10:18:29'),
(18, 18, 'proyek 2', 'Teknik Mesin', 'wreyjm', '2026-01-04 17:20:00', 'https://youtu.be/olCMOpeG_BY?si=Go5DjWGobNo2rjOp gambaran vidio demonya', '1767522041.jpg', 60, 'bagus', 21, '2026-01-04 10:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim_nidn` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('mahasiswa','dosen','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nim_nidn`, `password`, `role`, `created_at`) VALUES
(16, 'ADMIN', 'admin123', 'admin0912', 'admin', '2026-01-04 09:18:01'),
(18, 'DEFANNY ZIKRY LALELA', '3312511139', '$2y$10$OV1JHDZ84wp1H4uw6OjV8eeYTOx86YsdEtV2q.KJ7UxQTW5jFDOA.', 'mahasiswa', '2026-01-04 09:19:39'),
(20, 'Cyntis Lasmi Andesti', '33125111399', '$2y$10$DafLhEJfyCzdcbqGFoXANe4BXM4mbIPNcOQQ27XBTx3Gi6w/xBT/K', 'dosen', '2026-01-04 10:36:30'),
(21, 'Cyntis Lasmi Andesti', '12345', '$2y$10$NqF57FemMx/D0y.oUUr1Xu.Xkv0ctRk6uB4.kwZWdlyQHtlCf2Cx2', 'dosen', '2026-01-04 12:45:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_dosen` (`dosen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim_nidn` (`nim_nidn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_dosen` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
