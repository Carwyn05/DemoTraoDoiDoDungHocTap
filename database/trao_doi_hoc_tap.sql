-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th10 13, 2026 lúc 02:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `trao_doi_hoc_tap`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucvatpham`
--

CREATE TABLE `danhmucvatpham` (
  `maDanhMuc` int(11) NOT NULL,
  `tenDanhMuc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucvatpham`
--

INSERT INTO `danhmucvatpham` (`maDanhMuc`, `tenDanhMuc`) VALUES
(1, 'Giáo trình'),
(2, 'Dụng cụ học tập'),
(3, 'Tài liệu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaodich`
--

CREATE TABLE `giaodich` (
  `maGD` int(11) NOT NULL,
  `maTin` int(11) NOT NULL,
  `maNguoiMua` int(11) NOT NULL,
  `maNguoiBan` int(11) NOT NULL,
  `soTien` decimal(10,0) DEFAULT 0,
  `phuongThucTT` enum('tien_mat','chuyen_khoan') DEFAULT 'tien_mat',
  `trangThai` enum('cho_xac_nhan','da_thanh_toan') DEFAULT 'da_thanh_toan',
  `ngayThanhToan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanhtin`
--

CREATE TABLE `hinhanhtin` (
  `maAnh` int(11) NOT NULL,
  `maTin` int(11) NOT NULL,
  `duongDan` varchar(255) NOT NULL,
  `thuTu` int(11) NOT NULL DEFAULT 1,
  `ngayTao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monhoc`
--

CREATE TABLE `monhoc` (
  `maMon` int(11) NOT NULL,
  `tenMon` varchar(100) NOT NULL,
  `maNganh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `monhoc`
--

INSERT INTO `monhoc` (`maMon`, `tenMon`, `maNganh`) VALUES
(1, 'Giải tích 1', 3),
(2, 'Đại số tuyến tính', 3),
(3, 'Lập trình web', 9),
(4, 'Cấu trúc dữ liệu và giải thuật', 9),
(5, 'Văn học Việt Nam hiện đại', 4),
(6, 'Ngữ pháp Tiếng Anh', 5),
(7, 'Vật lý đại cương', 6),
(8, 'Hóa học đại cương', 7),
(9, 'Sinh học đại cương', 8),
(10, 'Tâm lý học đại cương', 11),
(11, 'Giáo dục học Mầm non', 1),
(12, 'Phương pháp dạy học Tiểu học', 2),
(13, 'Đồ dùng học tập chung', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nganh`
--

CREATE TABLE `nganh` (
  `maNganh` int(11) NOT NULL,
  `tenNganh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nganh`
--

INSERT INTO `nganh` (`maNganh`, `tenNganh`) VALUES
(1, 'Giáo dục Mầm non'),
(2, 'Giáo dục Tiểu học'),
(3, 'Sư phạm Toán học'),
(4, 'Sư phạm Ngữ văn'),
(5, 'Sư phạm Tiếng Anh'),
(6, 'Sư phạm Vật lý'),
(7, 'Sư phạm Hóa học'),
(8, 'Sư phạm Sinh học'),
(9, 'Sư phạm Tin học'),
(10, 'Sư phạm Lịch sử - Địa lý'),
(11, 'Tâm lý học Giáo dục'),
(12, 'Dùng chung (đồ dùng không theo ngành cụ thể)');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `maND` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matKhau` varchar(255) NOT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `vaiTro` enum('sinh_vien','admin') DEFAULT 'sinh_vien',
  `ngayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`maND`, `hoTen`, `email`, `matKhau`, `sdt`, `vaiTro`, `ngayTao`) VALUES
(1, 'Admin', 'admin@example.com', '$2b$12$TdM.0HMeW.1Cergcr/5LH.x6d4HKVWoRmIrEGqsWK13llrETs885K', NULL, 'admin', '2026-10-16 07:15:07'),
(2, 'Nguyễn Văn A', 'sinhvien@example.com', '$2b$12$hiAOJ52PMLioO5kJ2x8U1.V9UgtASf2bo7rrFIdo/Y8znPSYHGBe6', NULL, 'sinh_vien', '2026-10-16 07:15:07'),
(3, 'Carwyn Boo', 'vothithanhngan2k5@gmail.com', '$2y$10$4.Ik1X.y1ieyyKPoRFC0meyIPWB5g.XXf40HspUvzdUqP3OgT9hFu', '0823629346', 'sinh_vien', '2026-11-06 07:29:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `maQuyen` int(11) NOT NULL,
  `tenQuyen` varchar(60) NOT NULL,
  `nhan` varchar(100) NOT NULL,
  `nhomChucNang` varchar(40) NOT NULL,
  `moTa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tindang`
--

CREATE TABLE `tindang` (
  `maTin` int(11) NOT NULL,
  `tieuDe` varchar(200) NOT NULL,
  `moTa` text DEFAULT NULL,
  `tinhTrang` varchar(50) DEFAULT NULL,
  `hinhThuc` enum('ban','tang','trao_doi') DEFAULT 'trao_doi',
  `gia` decimal(10,0) DEFAULT 0,
  `namPhienBan` varchar(20) DEFAULT NULL,
  `diaDiemGiaoDich` varchar(150) DEFAULT NULL,
  `ngayDang` datetime DEFAULT current_timestamp(),
  `trangThai` enum('cho_duyet','da_duyet','da_trao_doi','tu_choi') DEFAULT 'cho_duyet',
  `maND` int(11) NOT NULL,
  `maMon` int(11) NOT NULL,
  `maDanhMuc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `maVaiTro` int(11) NOT NULL,
  `tenVaiTro` varchar(30) NOT NULL,
  `nhan` varchar(60) NOT NULL,
  `moTa` varchar(255) DEFAULT NULL,
  `laHeThong` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro_quyen`
--

CREATE TABLE `vaitro_quyen` (
  `maVaiTro` int(11) NOT NULL,
  `maQuyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `danhmucvatpham`
--
ALTER TABLE `danhmucvatpham`
  ADD PRIMARY KEY (`maDanhMuc`);

--
-- Chỉ mục cho bảng `giaodich`
--
ALTER TABLE `giaodich`
  ADD PRIMARY KEY (`maGD`),
  ADD KEY `maTin` (`maTin`),
  ADD KEY `maNguoiMua` (`maNguoiMua`),
  ADD KEY `maNguoiBan` (`maNguoiBan`);

--
-- Chỉ mục cho bảng `hinhanhtin`
--
ALTER TABLE `hinhanhtin`
  ADD PRIMARY KEY (`maAnh`),
  ADD KEY `idx_hinhanhtin_matTin` (`maTin`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`maMon`),
  ADD KEY `maNganh` (`maNganh`);

--
-- Chỉ mục cho bảng `nganh`
--
ALTER TABLE `nganh`
  ADD PRIMARY KEY (`maNganh`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`maND`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`maQuyen`),
  ADD UNIQUE KEY `uq_quyen_ten` (`tenQuyen`);

--
-- Chỉ mục cho bảng `tindang`
--
ALTER TABLE `tindang`
  ADD PRIMARY KEY (`maTin`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maMon` (`maMon`),
  ADD KEY `maDanhMuc` (`maDanhMuc`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`maVaiTro`),
  ADD UNIQUE KEY `uq_vaitro_ten` (`tenVaiTro`);

--
-- Chỉ mục cho bảng `vaitro_quyen`
--
ALTER TABLE `vaitro_quyen`
  ADD PRIMARY KEY (`maVaiTro`,`maQuyen`),
  ADD KEY `fk_vtq_quyen` (`maQuyen`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danhmucvatpham`
--
ALTER TABLE `danhmucvatpham`
  MODIFY `maDanhMuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `giaodich`
--
ALTER TABLE `giaodich`
  MODIFY `maGD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hinhanhtin`
--
ALTER TABLE `hinhanhtin`
  MODIFY `maAnh` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  MODIFY `maMon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `nganh`
--
ALTER TABLE `nganh`
  MODIFY `maNganh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `quyen`
--
ALTER TABLE `quyen`
  MODIFY `maQuyen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tindang`
--
ALTER TABLE `tindang`
  MODIFY `maTin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `maVaiTro` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `giaodich`
--
ALTER TABLE `giaodich`
  ADD CONSTRAINT `giaodich_ibfk_1` FOREIGN KEY (`maTin`) REFERENCES `tindang` (`maTin`),
  ADD CONSTRAINT `giaodich_ibfk_2` FOREIGN KEY (`maNguoiMua`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `giaodich_ibfk_3` FOREIGN KEY (`maNguoiBan`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng buộc cho bảng `hinhanhtin`
--
ALTER TABLE `hinhanhtin`
  ADD CONSTRAINT `fk_hinhanhtin_tindang` FOREIGN KEY (`maTin`) REFERENCES `tindang` (`maTin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD CONSTRAINT `monhoc_ibfk_1` FOREIGN KEY (`maNganh`) REFERENCES `nganh` (`maNganh`);

--
-- Các ràng buộc cho bảng `tindang`
--
ALTER TABLE `tindang`
  ADD CONSTRAINT `tindang_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `tindang_ibfk_2` FOREIGN KEY (`maMon`) REFERENCES `monhoc` (`maMon`),
  ADD CONSTRAINT `tindang_ibfk_3` FOREIGN KEY (`maDanhMuc`) REFERENCES `danhmucvatpham` (`maDanhMuc`);

--
-- Các ràng buộc cho bảng `vaitro_quyen`
--
ALTER TABLE `vaitro_quyen`
  ADD CONSTRAINT `fk_vtq_quyen` FOREIGN KEY (`maQuyen`) REFERENCES `quyen` (`maQuyen`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vtq_vaitro` FOREIGN KEY (`maVaiTro`) REFERENCES `vaitro` (`maVaiTro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
