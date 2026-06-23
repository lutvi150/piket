-- --------------------------------------------------------
-- Host:                         103.15.226.176
-- Server version:               10.6.25-MariaDB-cll-lve-log - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table teamclov_demo_8.absensi
CREATE TABLE IF NOT EXISTS `absensi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `jumlah_siswa` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.absensi: ~0 rows (approximately)
DELETE FROM `absensi`;

-- Dumping structure for table teamclov_demo_8.check_absensi
CREATE TABLE IF NOT EXISTS `check_absensi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_absensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.check_absensi: ~0 rows (approximately)
DELETE FROM `check_absensi`;

-- Dumping structure for table teamclov_demo_8.guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL DEFAULT 'L',
  `foto` text DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT '',
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guru_id_user_unique` (`id_user`),
  UNIQUE KEY `guru_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.guru: ~34 rows (approximately)
DELETE FROM `guru`;
INSERT INTO `guru` (`id`, `id_user`, `nama_guru`, `nip`, `jenis_kelamin`, `foto`, `golongan`, `jabatan`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
	(87, 89, 'NOPRIZAL, M. Pd', '197711092006041006', 'P', NULL, 'III.d', 'KEPALA MADRASAH', '-', '-', '2026-04-15 02:21:37', '2026-04-15 02:21:37'),
	(88, 90, 'FITRA DONI GEMINTARYA, S.A.P', '197506142005011006', 'P', NULL, 'III.a', 'KAUR TU MADRASAH', '-', '-', '2026-04-15 02:21:37', '2026-04-15 02:21:37'),
	(89, 91, 'RIZA PUSPITA SARI, S. Pd', '197607142006042019', 'P', NULL, 'IV.b', 'WAKA. KURIKULUM', '-', '-', '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(90, 92, 'ABRIS TRI PUTRA, S.Si', '199202152019031017', 'P', NULL, 'III.b', 'WAKA. SISWA', '-', '-', '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(91, 93, 'ADRISMAN, S. Pd.I', '197705312007101003', 'P', NULL, 'III.c', 'WAKA. SARPRAS', '-', '-', '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(92, 94, 'RAHMATULLAH, S. Pd, M.Pd', '198004262005011004', 'P', NULL, 'IV.b', 'WAKA. HUMAS', '-', '-', '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(93, 95, 'FIFIAN RUBIANTI N, S.Ag', '197602182009012006', 'P', NULL, 'III.d', 'BENDAHARA', '-', '-', '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(94, 96, 'HERLINA,S.Pd', '197003141997032003', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(95, 97, 'YUSMAINI, S.Pd', '197005081999032002', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(96, 98, 'Dra. HENDRAYENTI', '196708211997032002', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(97, 99, 'HARNEWI B, S.Pd', '197105071996032002', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(98, 100, 'GUSMALINDA, S. Pd. BIO', '197008141994032001', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(99, 101, 'TUTI HARYATI, S. Pd', '196910121998032003', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(100, 102, 'NURHAPIZAH, S. Pd', '196611201992032003', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(101, 103, 'GEMA WIYARTI, M.Pd', '196902151997032002', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(102, 104, 'MARNIETY, S. Pd', '197106042005012005', 'P', NULL, 'IV.b', 'GURU', '-', '-', '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(103, 105, 'DESNIATI, M.Pd', '197507302007012013', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(104, 106, 'FITRI YENTI, S.Pd', '197111222006042005', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(105, 107, 'SITI AIDA, S. Pd', '196802041993032004', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(106, 108, 'EVINIARTI, S. Ag', '196912031993032003', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(107, 109, 'ZONDRA, S. Pd', '197403262005011003', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(108, 110, 'AFRINALITA, S. Pd', '196904062006042001', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(109, 111, 'SRI MULYANI , S.Pd', '197207032005012002', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(110, 112, 'HARTATI, S. Pd', '197409162000122001', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(111, 113, 'FIDDIA WATY, S. Pd', '197711122005012009', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(112, 114, 'FEBRESTI, S. Pd', '197302121998032001', 'P', NULL, 'IV.a', 'GURU', '-', '-', '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(113, 115, 'USWATUN HASANAH, S.Pd.I M. Pd', '198412182009012013', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(114, 116, 'VIVI YASTIKA SARI, S.Pd', '196904182005012007', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(115, 117, 'MARIANIS, S. Ag', '197103222007012014', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(116, 118, 'MUSNIATI, S. Pd', '197406042007012019', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(117, 119, 'SRI MIRAWATI, S. Pd. I', '198008192007102003', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(118, 120, 'NURLAILI, S.HI', '198003082007102003', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(119, 121, 'ASNELI WARDINI, SHI, S. Pd. I', '197912082007102006', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(120, 122, 'ZALMI, S. Pd', '196711122005011005', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(121, 123, 'GUSNITA, S. Ag', '197108242007102001', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(122, 124, 'NURIDA, S. Pd', '197602102007102003', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(123, 125, 'RAHMI ARFIYENTI, S. Pd', '197104292007102002', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(124, 126, 'NUDDI SYARIF, S. Si', '197602052007011016', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(125, 127, 'HAFNITA SUKMAWATI, S. Pd', '197212162007012009', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(126, 128, 'DAHLENA, M.Pd', '197612132009012004', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(127, 129, 'MUHAMMAD ISNAINI,S.Pd.I', '197608022005011006', 'P', NULL, 'III.d', 'GURU', '-', '-', '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(128, 130, 'SRI YANTI, S.Pd', '197801192007102003', 'P', NULL, 'III.c', 'GURU', '-', '-', '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(129, 131, 'RAMA YULISDA, S. Ag', '197605012014112006', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(130, 132, 'SUSMANTI, S.Pd', '198308062014112002', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(131, 133, 'RAHMI YULIA, S.Pd', '198507132019032014', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(132, 134, 'SRI NOVIA ALIM, S.Pd.I', '198503022019032012', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(133, 135, 'MUTIARA ANGELINA, S.Pd', '199707312019032002', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(134, 136, 'KUNTUM ALMA LANY, S.Pd', '199108202019032020', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(135, 137, 'AMETADEVI TRESIA, S.Pd', '198501022019032015', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(136, 138, 'RISA DWITA PUTRI, S.Pd', '198907012019032012', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(137, 139, 'INDRI RAHMAWATI, S.Pd', '199008172019032029', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(138, 140, 'ELIN NOFIA JUMESA, S.Pd', '199511102019032017', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(139, 141, 'BENNY WAHYUDI, S.KOM', '198405262019031005', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(140, 142, 'ROZA IDA YANI, S.Pd', '198901132019032012', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(141, 143, 'IMALDA IFRIANI, S.Pd.I', '198908272019032019', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(142, 144, 'ALMASRI PUTRA, S.Pd', '199108232019031015', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(143, 145, 'TRI SUCI PRIMA AMELIA PUTRI, S.Pd', '198705052019032013', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(144, 146, 'NITTO WILIAM, S.KOM', '199007272019031011', 'P', NULL, 'III.b', 'GURU', '-', '-', '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(145, 147, 'ZAINAL, S.Pd', '197611182023211002', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(146, 148, 'RINI AMELIA, S.KOM', '198505142023212032', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(147, 149, 'YUWENDI ZARLI, S.Pd', '197809142023212015', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(148, 150, 'ARJUN RIANI ASTUTI, S. Pd. I', '198206232023212024', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(149, 151, 'AFRILINITA, S.Pd', '199304192023212039', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(150, 152, 'SILVIA, S.Pd', '197805232023212012', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(151, 153, 'IQBAL ARIF, S.Pd', '198802232023211015', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(152, 154, 'DARWIMAH, S. Pd', '197101062007102002', 'P', NULL, 'III.d', 'PEGAWAI', '-', '-', '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(153, 155, 'DESMALIDAR, S.A.P', '196804172014112002', 'P', NULL, 'III.a', 'PEGAWAI', '-', '-', '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(154, 156, 'MONDRA SEPNITON, SS', '198109062025211009', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(155, 157, 'DONA GUSTIA, S. Pd. I', '198508212025212012', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(156, 158, 'ISHAQ HALIM, S. Ag', '197001012025211011', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(157, 159, 'IHSAN, M.Pd', '197408122025211010', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(158, 160, 'DILLA OKTAVIANA, S. Pd', '198710212025212003', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(159, 161, 'SYUKRIADI, SS', '198410072025211004', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(160, 162, 'SYAFRIZAL, S. Pd. I', '198401202025211004', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(161, 163, 'RANI WAHYUNI, S. Pd', '198102192025212005', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(162, 164, 'YUTNITA, S.Pd', '198309022025212001', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(163, 165, 'DORI EKA PUTRA, S.Pd', '198712172025211002', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(164, 166, 'MUHAMMAD IKHSAN, S.Pd', '199009292025211020', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(165, 167, 'LIA APRIANI, S. Pd. I', '199304132025212013', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(166, 168, 'RICE MAI YUNI, S.Pd', '199505302025212018', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(167, 169, 'GUSNELI, S,Pd', '197202102025212005', 'P', NULL, 'IX', 'GURU', '-', '-', '2026-04-15 02:21:56', '2026-04-15 02:21:56');

-- Dumping structure for table teamclov_demo_8.jadwal_piket
CREATE TABLE IF NOT EXISTS `jadwal_piket` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_guru` bigint(20) unsigned NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_piket_id_guru_foreign` (`id_guru`),
  CONSTRAINT `jadwal_piket_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.jadwal_piket: ~0 rows (approximately)
DELETE FROM `jadwal_piket`;

-- Dumping structure for table teamclov_demo_8.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) NOT NULL,
  `id_guru` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`),
  KEY `kelas_id_guru_foreign` (`id_guru`),
  CONSTRAINT `kelas_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.kelas: ~5 rows (approximately)
DELETE FROM `kelas`;
INSERT INTO `kelas` (`id`, `nama_kelas`, `id_guru`, `created_at`, `updated_at`) VALUES
	(1, 'IX.1', NULL, '2026-03-25 01:43:31', '2026-04-08 07:19:08'),
	(2, 'IX.2', NULL, '2026-03-25 01:44:38', '2026-04-08 07:19:16'),
	(4, 'IX.3', NULL, '2026-04-08 07:59:24', '2026-04-08 07:59:24'),
	(6, 'IX.4', NULL, '2026-04-08 08:02:47', '2026-04-08 08:02:47'),
	(8, 'IX.5', NULL, '2026-04-08 08:03:49', '2026-04-08 08:03:49');

-- Dumping structure for table teamclov_demo_8.mapel
CREATE TABLE IF NOT EXISTS `mapel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.mapel: ~14 rows (approximately)
DELETE FROM `mapel`;
INSERT INTO `mapel` (`id`, `nama_mapel`, `created_at`, `updated_at`) VALUES
	(4, 'AL-QUR\'AN HADIST', '2026-05-16 05:05:39', '2026-05-16 05:05:39'),
	(5, 'AKIDAH AKHLAK', '2026-05-16 05:05:45', '2026-05-16 05:05:45'),
	(6, 'FIQIH', '2026-05-16 05:05:50', '2026-05-16 05:05:50'),
	(7, 'SKI', '2026-05-16 05:05:58', '2026-05-16 05:05:58'),
	(8, 'BAHASA INDONESIA', '2026-05-16 05:06:04', '2026-05-16 05:06:04'),
	(9, 'BAHASA INGGRIS', '2026-05-16 05:06:10', '2026-05-16 05:06:10'),
	(10, 'BAHASA ARAB', '2026-05-16 05:06:15', '2026-05-16 05:06:15'),
	(11, 'MATEMATIKA', '2026-05-16 05:06:20', '2026-05-16 05:06:20'),
	(12, 'IPA', '2026-05-16 05:06:28', '2026-05-16 05:06:28'),
	(13, 'IPS', '2026-05-16 05:06:32', '2026-05-16 05:06:32'),
	(14, 'SENI BUDAYA', '2026-05-16 05:06:38', '2026-05-16 05:06:38'),
	(15, 'INFORMATIKA', '2026-05-16 05:06:43', '2026-05-16 05:06:43'),
	(16, 'PKN', '2026-05-16 05:07:29', '2026-05-16 05:07:29'),
	(17, 'PENJASORKES', '2026-05-16 05:07:37', '2026-05-16 05:07:37');

-- Dumping structure for table teamclov_demo_8.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.migrations: ~2 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2026_03_25_075804_create_pikets_table', 1),
	(3, '2026_04_08_123814_jadwal_piket', 2);

-- Dumping structure for table teamclov_demo_8.piket
CREATE TABLE IF NOT EXISTS `piket` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.piket: ~0 rows (approximately)
DELETE FROM `piket`;

-- Dumping structure for table teamclov_demo_8.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_siswa` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL DEFAULT 'L',
  `id_kelas` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_nisn_unique` (`nisn`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.siswa: ~3 rows (approximately)
DELETE FROM `siswa`;
INSERT INTO `siswa` (`id`, `nama_siswa`, `nisn`, `jenis_kelamin`, `id_kelas`, `created_at`, `updated_at`) VALUES
	(1, 'Ahmad Rizky Pratama', '0045123456', 'L', 1, '2026-03-25 04:44:44', '2026-03-25 04:44:44'),
	(2, 'Dimas Saputra', '0045123457', 'L', 1, '2026-03-25 04:52:00', '2026-03-25 04:52:00'),
	(3, 'Fajar Nugroho', '0045123458', 'L', 1, '2026-03-25 04:52:57', '2026-03-25 04:52:57');

-- Dumping structure for table teamclov_demo_8.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table teamclov_demo_8.users: ~42 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$2MVLtdWaWVusG1KKOxuUdOG5peACsErLFisoLPus9AIXGG6Ga/1Di', 'admin', NULL, '2026-01-28 16:09:47', '2026-01-28 16:09:47'),
	(2, 'Guru', 'guru@gmail.com', NULL, '$2y$12$tfVQRVeJKEXuIzO7RlkLxObF5jLjFMvgHaqGIGLlwkkw3noRCryJq', 'guru', NULL, '2026-01-28 16:09:47', '2026-01-28 16:09:47'),
	(4, 'DINY MAULINA', 'viradiana40@gmail.com', NULL, '$2y$12$bEBmHh2K3Vg9w2OYuM8akeOP8Ihtx8BDq3C7kvpAqly8XKEx1Dz8O', 'guru', NULL, '2026-04-06 07:52:00', '2026-04-06 07:52:00'),
	(89, 'NOPRIZAL, M. Pd', 'guru69def6316ae3d@gmail.com', NULL, '$2y$12$f09dY58R3GThZ0.OmjqWw.q1Ju2GOcc/1ajJfECLhteLLvdbd9hDi', 'guru', NULL, '2026-04-15 02:21:37', '2026-04-15 02:21:37'),
	(90, 'FITRA DONI GEMINTARYA, S.A.P', 'guru69def631a65f3@gmail.com', NULL, '$2y$12$5BqNIbQNlDlwY09E3EKjze2bnK9ryDKnID.fbeEbYfrq/MZYsxPyW', 'guru', NULL, '2026-04-15 02:21:37', '2026-04-15 02:21:37'),
	(91, 'RIZA PUSPITA SARI, S. Pd', 'guru69def631e384b@gmail.com', NULL, '$2y$12$uy7G.RW07aRL4EhlRLLhS.77vgIPCDmKhX9F5b9AYcfkZUIsV3.M2', 'guru', NULL, '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(92, 'ABRIS TRI PUTRA, S.Si', 'guru69def6322916b@gmail.com', NULL, '$2y$12$FkHUp4E7TsrnTHnjS/uRY.KxAfNWrK9eMmZJsdSRs.rsOLyAjSAv6', 'guru', NULL, '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(93, 'ADRISMAN, S. Pd.I', 'guru69def63261a9e@gmail.com', NULL, '$2y$12$4pjHU2q0jS/SXaWE6Q6lwegrf3p1n6FFBLJTl6aeD0vNXDC5fctmq', 'guru', NULL, '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(94, 'RAHMATULLAH, S. Pd, M.Pd', 'guru69def632995d2@gmail.com', NULL, '$2y$12$nwiS7tHD8WktDcOZ5Ih4CecoxRjxqsbKjxqTvX.PZH6SNVE.9uVvW', 'guru', NULL, '2026-04-15 02:21:38', '2026-04-15 02:21:38'),
	(95, 'FIFIAN RUBIANTI N, S.Ag', 'guru69def632d0717@gmail.com', NULL, '$2y$12$vH6DegKlH2wzFMTq7gIvUeayFjNzUeClX4QifMqZ2L5muprTTnhmS', 'guru', NULL, '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(96, 'HERLINA,S.Pd', 'guru69def633150a3@gmail.com', NULL, '$2y$12$Fu/zXF7guN4CnoubO/zzpOMdkE0v6J9AnuXCr2S0KQfIXVh7ppaYO', 'guru', NULL, '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(97, 'YUSMAINI, S.Pd', 'guru69def6334fb10@gmail.com', NULL, '$2y$12$zXIODduyrT.7cqUKm25xGespO1oVR6Q4Wfw00PJ6wTPlBkpCJECge', 'guru', NULL, '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(98, 'Dra. HENDRAYENTI', 'guru69def6338a173@gmail.com', NULL, '$2y$12$c3LELqWP78bG7lpfoegBo.ZZ45ULsPdbcAPzYcZZ2keq0kDb1sTVy', 'guru', NULL, '2026-04-15 02:21:39', '2026-04-15 02:21:39'),
	(99, 'HARNEWI B, S.Pd', 'guru69def633c20ec@gmail.com', NULL, '$2y$12$WowStYDRlBGG7XKB.Ti5zuIauXSvkJFBW1b70fU7Pbc5M8eXmohKW', 'guru', NULL, '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(100, 'GUSMALINDA, S. Pd. BIO', 'guru69def634070ee@gmail.com', NULL, '$2y$12$JyvEXxX0jSsgj.9H9HF/Q.ziH4YTtmB8LKRO6PNwNMTAq.xiGloH6', 'guru', NULL, '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(101, 'TUTI HARYATI, S. Pd', 'guru69def63440357@gmail.com', NULL, '$2y$12$Dh0dbxQ1ZsinJ0pav1o2LOdFxzG9IunjWszSOcVzP8A70Ej.nllvO', 'guru', NULL, '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(102, 'NURHAPIZAH, S. Pd', 'guru69def63477639@gmail.com', NULL, '$2y$12$Bx1qit1ewyILp2cbATdUveVXg6PgBX..8zPClwo7xs5mJOO2SN3.C', 'guru', NULL, '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(103, 'GEMA WIYARTI, M.Pd', 'guru69def634ad217@gmail.com', NULL, '$2y$12$9OWxPkDi9cF6cA6j6NS0B.4yv0E90To/WiTv1yfRlD2AhczOvT6aS', 'guru', NULL, '2026-04-15 02:21:40', '2026-04-15 02:21:40'),
	(104, 'MARNIETY, S. Pd', 'guru69def634e2c88@gmail.com', NULL, '$2y$12$I8XKzhG.YwXMicKU0SP.c.JnYLZHatcdeSzpqjZY7KAkc9TXSuiJu', 'guru', NULL, '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(105, 'DESNIATI, M.Pd', 'guru69def63524615@gmail.com', NULL, '$2y$12$9nuUCnKDbP.25zpnw/XLQewfSiJ7kRhwqwGDiLWq.VbK2Jcornr8y', 'guru', NULL, '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(106, 'FITRI YENTI, S.Pd', 'guru69def6355c4f1@gmail.com', NULL, '$2y$12$BOcr2PYTY/DmlTB5qdoeiO.4h9.mQfMPnTNNHJgikRVaazn5LxL1G', 'guru', NULL, '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(107, 'SITI AIDA, S. Pd', 'guru69def635956fe@gmail.com', NULL, '$2y$12$iE.kBG4f0CB5Vi/Z3.xUAuf9FjANzwTCsWciZ8247e4TEJO6.u.fu', 'guru', NULL, '2026-04-15 02:21:41', '2026-04-15 02:21:41'),
	(108, 'EVINIARTI, S. Ag', 'guru69def635d1518@gmail.com', NULL, '$2y$12$V.Utad5VagJo7PvWeoQteevijGklcB7JK7TffP2wQ.PQwtCcJi1xy', 'guru', NULL, '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(109, 'ZONDRA, S. Pd', 'guru69def63618751@gmail.com', NULL, '$2y$12$l3RL42mC0PTqI1BPvGPCDOVHKHkJx0tnuPFAf37F4vbAKurNysgTq', 'guru', NULL, '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(110, 'AFRINALITA, S. Pd', 'guru69def63650a68@gmail.com', NULL, '$2y$12$CqaICoNGIZCj3lw0QY0sy.b/K/gknuTBMU4xZG6NL.2ur/i0p/SZG', 'guru', NULL, '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(111, 'SRI MULYANI , S.Pd', 'guru69def63688e3f@gmail.com', NULL, '$2y$12$zjAoKGTwQFiupJzt7K6ATOp68p9TsAKZqJ29jbkP6YB65gbo5s6fa', 'guru', NULL, '2026-04-15 02:21:42', '2026-04-15 02:21:42'),
	(112, 'HARTATI, S. Pd', 'guru69def636bfe84@gmail.com', NULL, '$2y$12$qiZjM5yZw6nnbaLMHxsU7eLUgLzsE9jaJPQOwjryP51RwOGIKTbdO', 'guru', NULL, '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(113, 'FIDDIA WATY, S. Pd', 'guru69def637035fc@gmail.com', NULL, '$2y$12$2Wb98h5WR0oUpYu8Og7V9O8Lidlp/FMCUzG9iDL/xetXjLVKkJdyK', 'guru', NULL, '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(114, 'FEBRESTI, S. Pd', 'guru69def6373d537@gmail.com', NULL, '$2y$12$KpQ6A.B6f3QKEblA/xOXheTkxvJEoEd0Q3Sngb5HSx.CjA4XC0..e', 'guru', NULL, '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(115, 'USWATUN HASANAH, S.Pd.I M. Pd', 'guru69def63776417@gmail.com', NULL, '$2y$12$FWoPY8Rt/8j3rt9nU7yCHeooK6GEZbQVRJrCh4SrbzFyhCCeumniW', 'guru', NULL, '2026-04-15 02:21:43', '2026-04-15 02:21:43'),
	(116, 'VIVI YASTIKA SARI, S.Pd', 'guru69def637b9c5c@gmail.com', NULL, '$2y$12$SHHGFZin2S.ieBpxUXmM1.Nt9hInSsXTh9/sH4HRTYBtS4F4j/J56', 'guru', NULL, '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(117, 'MARIANIS, S. Ag', 'guru69def63808918@gmail.com', NULL, '$2y$12$Wy5ALL61bSTrIGfrpfkIYurbC8fKsU92iPPxM4lS/lgiczPcbfrvO', 'guru', NULL, '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(118, 'MUSNIATI, S. Pd', 'guru69def63845853@gmail.com', NULL, '$2y$12$v28P8PITbYpPDN3ykKWVze/LHeE1cDIFOJPwuXs.xkJUj32jcTz3W', 'guru', NULL, '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(119, 'SRI MIRAWATI, S. Pd. I', 'guru69def63885bfc@gmail.com', NULL, '$2y$12$o2Q0d0WvZHqPwVv8KLt7oenQ3GfLXHZ22GExS6NuAiHbRlXedAkN.', 'guru', NULL, '2026-04-15 02:21:44', '2026-04-15 02:21:44'),
	(120, 'NURLAILI, S.HI', 'guru69def638c373a@gmail.com', NULL, '$2y$12$1EWYe.4jyXxn3/gA6ZT2OO3hyq36Ai9rW0GY0Ng8hCliT5xO50avy', 'guru', NULL, '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(121, 'ASNELI WARDINI, SHI, S. Pd. I', 'guru69def639089f2@gmail.com', NULL, '$2y$12$y.Okmc8w01/Sw3RQW1PoeO8ttn7JcN/O3m8NsAbNdS2srw7Vnesz6', 'guru', NULL, '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(122, 'ZALMI, S. Pd', 'guru69def6393e886@gmail.com', NULL, '$2y$12$jv8yPGPBTjSAOaP7yGxVKePnMre.XocaLOY2c0cd9rdBcy.tXiM2G', 'guru', NULL, '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(123, 'GUSNITA, S. Ag', 'guru69def639760ce@gmail.com', NULL, '$2y$12$5CoclWnD8WTZkylJQDiWUuXj4eyzuOtsqmKqXQb4wBSj3GnXk5Dxy', 'guru', NULL, '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(124, 'NURIDA, S. Pd', 'guru69def639ad0ee@gmail.com', NULL, '$2y$12$WXUAQ8k8kMZ5ek6wr5fgiutDOD8/YFfGn4ahSAqn88btXIl3Njlga', 'guru', NULL, '2026-04-15 02:21:45', '2026-04-15 02:21:45'),
	(125, 'RAHMI ARFIYENTI, S. Pd', 'guru69def639e50ae@gmail.com', NULL, '$2y$12$1QOlO6ggLeZsFaJZjR7i8.adj/N3fH0ZNyXMQTe20kflnjL8LQWZy', 'guru', NULL, '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(126, 'NUDDI SYARIF, S. Si', 'guru69def63a2e677@gmail.com', NULL, '$2y$12$Mx4eHDxPRS8BQECclDJyHezHVrjlDwTJ3DvIUaQzxj18owbN6V4ii', 'guru', NULL, '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(127, 'HAFNITA SUKMAWATI, S. Pd', 'guru69def63a67196@gmail.com', NULL, '$2y$12$OY2gqzIqv/a.ZGsSDrNl1ue6XcmgyJbuj5uqA2gdJiQ99FwhK5mv2', 'guru', NULL, '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(128, 'DAHLENA, M.Pd', 'guru69def63a9f30e@gmail.com', NULL, '$2y$12$KpeNI51VCSNeUMMAewhMSufM4rhylmyU27I8UPygZz.ykPQWB/u2y', 'guru', NULL, '2026-04-15 02:21:46', '2026-04-15 02:21:46'),
	(129, 'MUHAMMAD ISNAINI,S.Pd.I', 'guru69def63ad5dea@gmail.com', NULL, '$2y$12$GtHG0eND.5pJmA6C8k1RkOQUZMfKfwBH4ps8wmOZ0daNCI4vUd6bO', 'guru', NULL, '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(130, 'SRI YANTI, S.Pd', 'guru69def63b1a596@gmail.com', NULL, '$2y$12$s8BCAuHPeM5t7xT/BVoO.elucLNgxrYzhUgo9vV3XIYRogZKFl17u', 'guru', NULL, '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(131, 'RAMA YULISDA, S. Ag', 'guru69def63b52851@gmail.com', NULL, '$2y$12$QNrZohZua9zdlAJGQLyCxOFWGVUJ1G6CjYyVnjvlJ3fuhpLX5Ps5S', 'guru', NULL, '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(132, 'SUSMANTI, S.Pd', 'guru69def63b8b32e@gmail.com', NULL, '$2y$12$SgC1rzC45TR1RnQ5Isw3uu1Yosc6BaxuljYQ2i62wwy9stSQ1GlJK', 'guru', NULL, '2026-04-15 02:21:47', '2026-04-15 02:21:47'),
	(133, 'RAHMI YULIA, S.Pd', 'guru69def63bc1e71@gmail.com', NULL, '$2y$12$8R73AubMefUuYyOrmVuHN.cPQboSP0NAmadRVYS5oXRoqTnJVYWIq', 'guru', NULL, '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(134, 'SRI NOVIA ALIM, S.Pd.I', 'guru69def63c05a08@gmail.com', NULL, '$2y$12$dtNxL3Dwe.fUMXZZKpFi4eHDefvCRtrehTJwB7kCPpMmrkDiEBzU.', 'guru', NULL, '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(135, 'MUTIARA ANGELINA, S.Pd', 'guru69def63c3e067@gmail.com', NULL, '$2y$12$H/Ll/Dj8UyBFiJfnMv3QKuQKuEW59UtM9M7EJCho7YE0wkrbScoua', 'guru', NULL, '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(136, 'KUNTUM ALMA LANY, S.Pd', 'guru69def63c746ef@gmail.com', NULL, '$2y$12$UaR4Y/DRaQK2It7EJxcxY.hSamzikZZRMFRO/ggOcaCtvVITBS9De', 'guru', NULL, '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(137, 'AMETADEVI TRESIA, S.Pd', 'guru69def63caaceb@gmail.com', NULL, '$2y$12$tv/9wEy1picx0QtE9b.5/.RbkYQhKuXuY2T6SbQmC7tlYgto32yce', 'guru', NULL, '2026-04-15 02:21:48', '2026-04-15 02:21:48'),
	(138, 'RISA DWITA PUTRI, S.Pd', 'guru69def63ce1694@gmail.com', NULL, '$2y$12$Y064ebt8fmWdhAXRSTn/X.tHFK8iH0VQQb1cBtyvFdQl4oLWCW4WS', 'guru', NULL, '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(139, 'INDRI RAHMAWATI, S.Pd', 'guru69def63d24e6e@gmail.com', NULL, '$2y$12$P29xoxk0RRYWIJwFP/ZJJum51dQSP9MrqNlSzKDFBamXap9OTeX3S', 'guru', NULL, '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(140, 'ELIN NOFIA JUMESA, S.Pd', 'guru69def63d5b396@gmail.com', NULL, '$2y$12$d05FkbzWwzpKhXVXynO0xuAycKiNn722uvbblcmcnDT7RTVJV3n5.', 'guru', NULL, '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(141, 'BENNY WAHYUDI, S.KOM', 'guru69def63d93004@gmail.com', NULL, '$2y$12$7eyV56YQiNEUnXLJpZHI8.G2SsxpwoX1QVPGvh.CD00FSVGo.il1y', 'guru', NULL, '2026-04-15 02:21:49', '2026-04-15 02:21:49'),
	(142, 'ROZA IDA YANI, S.Pd', 'guru69def63dca7f4@gmail.com', NULL, '$2y$12$KcNlmNj1YuXvqKP4e.R/euAob7s7w7JINnv5ZQR6G1Pu0XY9I8t66', 'guru', NULL, '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(143, 'IMALDA IFRIANI, S.Pd.I', 'guru69def63e0db8f@gmail.com', NULL, '$2y$12$qnGMIhDBX7JngAO365gF8u3ylYxG7hOsv3yr6DqGkVbdv5wGGBPIy', 'guru', NULL, '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(144, 'ALMASRI PUTRA, S.Pd', 'guru69def63e499c8@gmail.com', NULL, '$2y$12$Pt7sYauLzhUZOjOBWeJaleYGgq.FQCOPjaV5c11vPrPUnmll8KWmG', 'guru', NULL, '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(145, 'TRI SUCI PRIMA AMELIA PUTRI, S.Pd', 'guru69def63e8255b@gmail.com', NULL, '$2y$12$5rz3w64AaG1.KdgalzFf.OT.lRDFelEQT4aslT4jCGnbGFfxgT0AC', 'guru', NULL, '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(146, 'NITTO WILIAM, S.KOM', 'guru69def63ebb7f6@gmail.com', NULL, '$2y$12$Y0mjjeZNFUlIJY.uQjqZcuO0YU2pvmMrSC11uMaAQZXAyYpLOwMwu', 'guru', NULL, '2026-04-15 02:21:50', '2026-04-15 02:21:50'),
	(147, 'ZAINAL, S.Pd', 'guru69def63ef3846@gmail.com', NULL, '$2y$12$0.DpphLPJ3VK18mLZYThv.yx2abV20BPUj2Y/dcyI5VNzcmGEqvHm', 'guru', NULL, '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(148, 'RINI AMELIA, S.KOM', 'guru69def63f3773d@gmail.com', NULL, '$2y$12$cSvx3JT9KnKBdYNpsM8A2.9S.2yz.ixAr45JedOVBR6CsoyL.Wq2u', 'guru', NULL, '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(149, 'YUWENDI ZARLI, S.Pd', 'guru69def63f7076e@gmail.com', NULL, '$2y$12$LUnIPSO/ox66VW3JtLuZXe9FOFOhm55HtPnWY7WQm8ambqXnxKR8u', 'guru', NULL, '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(150, 'ARJUN RIANI ASTUTI, S. Pd. I', 'guru69def63fa6a22@gmail.com', NULL, '$2y$12$FQkGxjf940HYF.2/.xT82.uxk9YsFADYMQsEcsp4Z9MAZhbTp4/A6', 'guru', NULL, '2026-04-15 02:21:51', '2026-04-15 02:21:51'),
	(151, 'AFRILINITA, S.Pd', 'guru69def63fdd674@gmail.com', NULL, '$2y$12$DP3.DqF.M1EEQJ0O7K0BGOJ3bKCbXa7TErFBl2bbuYJtZHrYhe/Ju', 'guru', NULL, '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(152, 'SILVIA, S.Pd', 'guru69def64024488@gmail.com', NULL, '$2y$12$/xhaxXH/UE40PXBIKzVKV.H8LmfG871mVWOAItlezSWZM79Q2UI1W', 'guru', NULL, '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(153, 'IQBAL ARIF, S.Pd', 'guru69def640627f7@gmail.com', NULL, '$2y$12$bJUVcYNQlye9lvf5zC0UnO9IpGijIr36TBzv9u0BOVgXuB22zJ11S', 'guru', NULL, '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(154, 'DARWIMAH, S. Pd', 'guru69def640a3b79@gmail.com', NULL, '$2y$12$CW2MBPOQQ2ZAlc01DdTa.e1sQxs9GXdB8GrLGDdR9W.0V22Crs8sS', 'guru', NULL, '2026-04-15 02:21:52', '2026-04-15 02:21:52'),
	(155, 'DESMALIDAR, S.A.P', 'guru69def640e3160@gmail.com', NULL, '$2y$12$ejWWQyBKZz67qc71xp.qp.UBDMRVcb1iIhLjJs66zoSDEP4hCSuwu', 'guru', NULL, '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(156, 'MONDRA SEPNITON, SS', 'guru69def6412ff56@gmail.com', NULL, '$2y$12$NhcchRUVNALBuC7lkptdeut/5qK3NytCAcUybXWrH6ODq906D8AHe', 'guru', NULL, '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(157, 'DONA GUSTIA, S. Pd. I', 'guru69def641708ac@gmail.com', NULL, '$2y$12$vdMKwqbI9lrzzyTbPFT9COOj4N5qn5wRVB7hVPOZF4gcMr02/Ny8K', 'guru', NULL, '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(158, 'ISHAQ HALIM, S. Ag', 'guru69def641b1c44@gmail.com', NULL, '$2y$12$FfmgUP/V9kfiHUy/TqSA1.4xbYaWETbWCf2GhXTxvvcU6IqKPqpue', 'guru', NULL, '2026-04-15 02:21:53', '2026-04-15 02:21:53'),
	(159, 'IHSAN, M.Pd', 'guru69def641f2cf1@gmail.com', NULL, '$2y$12$7VeNGmVBbjf.zrHTH6kbUuxS9ONspu62UktMHeo6zRaGHCON4SPZe', 'guru', NULL, '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(160, 'DILLA OKTAVIANA, S. Pd', 'guru69def64240e55@gmail.com', NULL, '$2y$12$RgM9u6LqClkA1SB5cp4CB.E2yCH4ZW3c.POcfnQneYHXjo6.x0AtK', 'guru', NULL, '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(161, 'SYUKRIADI, SS', 'guru69def64285299@gmail.com', NULL, '$2y$12$.aAXb0j0Rm6G/PQSf5u.1uWnKrMEQrzSfo8DtmHTLjaPEEdzW2d7a', 'guru', NULL, '2026-04-15 02:21:54', '2026-04-15 02:21:54'),
	(162, 'SYAFRIZAL, S. Pd. I', 'guru69def642c6428@gmail.com', NULL, '$2y$12$dhmuTB8wgQ2H51J5aci5yO2RNXLv6FNSnY9yv8Y9apXbiWWN60.0G', 'guru', NULL, '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(163, 'RANI WAHYUNI, S. Pd', 'guru69def6431698c@gmail.com', NULL, '$2y$12$38EFgNZN7jFPEM7mrL9CfOW/d4Ebtv6K9.kVUGdZt6e6fVMELYZJm', 'guru', NULL, '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(164, 'YUTNITA, S.Pd', 'guru69def6435cad9@gmail.com', NULL, '$2y$12$J7AtGkIad6Z9t.eQiaxVj.VH8mcQM4ss8VTC./d.IWVXPkz28IZrK', 'guru', NULL, '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(165, 'DORI EKA PUTRA, S.Pd', 'guru69def6439ea9b@gmail.com', NULL, '$2y$12$7WBzD7lWeD5L7Bz3XD35uupW3lYqHaX55OHv.wQCCMfWRDslfAe1q', 'guru', NULL, '2026-04-15 02:21:55', '2026-04-15 02:21:55'),
	(166, 'MUHAMMAD IKHSAN, S.Pd', 'guru69def643db1cf@gmail.com', NULL, '$2y$12$AJCd48LahHTtuq/O0rlRXOhAoxtSK6mVRAlMERV9mPyFtWAJAUh9y', 'guru', NULL, '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(167, 'LIA APRIANI, S. Pd. I', 'guru69def64427749@gmail.com', NULL, '$2y$12$WaRDiY1Obx55LAblcO4z6uLgI0DjgY0ltQiUlP0nqHL0ojliKaCM6', 'guru', NULL, '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(168, 'RICE MAI YUNI, S.Pd', 'guru69def6446a5bb@gmail.com', NULL, '$2y$12$eVdITUeWi4hDW9lPTKyhV.qeeGlCHpKZSXK4SKYDjBZulvwh4uYO6', 'guru', NULL, '2026-04-15 02:21:56', '2026-04-15 02:21:56'),
	(169, 'GUSNELI, S,Pd', 'guru69def644ad5c9@gmail.com', NULL, '$2y$12$EuMLQTk.kjGEp.Okg6FPHOzZntg4FqxaGAiN4LsTS6Srut/O7C42G', 'guru', NULL, '2026-04-15 02:21:56', '2026-04-15 02:21:56');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
