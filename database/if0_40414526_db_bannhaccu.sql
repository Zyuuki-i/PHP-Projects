-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: sql101.infinityfree.com
-- Thời gian đã tạo: Th12 14, 2025 lúc 03:53 AM
-- Phiên bản máy phục vụ: 11.4.7-MariaDB
-- Phiên bản PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `if0_40414526_db_bannhaccu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_dat_hang`
--

CREATE TABLE `chi_tiet_don_dat_hang` (
  `ma_ddh` int(11) NOT NULL,
  `ma_sp` char(10) NOT NULL,
  `soluong` int(11) NOT NULL,
  `gia` decimal(18,2) NOT NULL,
  `thanhtien` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_dat_hang`
--

INSERT INTO `chi_tiet_don_dat_hang` (`ma_ddh`, `ma_sp`, `soluong`, `gia`, `thanhtien`) VALUES
(1, 'SP01', 2, '2500000.00', '4500000.00'),
(2, 'SP02', 1, '18000000.00', '17100000.00'),
(3, 'SP01', 1, '2500000.00', '2500000.00'),
(3, 'SP03', 9, '300000.00', '2700000.00'),
(3, 'SP05', 4, '120000.00', '480000.00'),
(3, 'SP08', 3, '450000.00', '1350000.00'),
(4, 'SP07', 1, '120000000.00', '120000000.00'),
(5, 'SP04', 1, '12500000.00', '12500000.00'),
(6, 'SP06', 1, '15000000.00', '15000000.00'),
(7, 'SP09', 1, '19000000.00', '19000000.00'),
(8, 'SP02', 1, '18000000.00', '18000000.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `ma_nd` int(11) NOT NULL,
  `ma_sp` char(10) NOT NULL,
  `noidung` varchar(500) DEFAULT NULL,
  `sosao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_gia`
--

INSERT INTO `danh_gia` (`ma_nd`, `ma_sp`, `noidung`, `sosao`) VALUES
(1, 'SP01', 'Âm thanh rất hay, dễ chơi', 5),
(1, 'SP02', 'Cảm giác chất âm không hợp, khó chơi', 3),
(1, 'SP03', 'Giá rẻ, dễ thổi cho người mới học', 5),
(2, 'SP02', 'Đàn tốt, chất lượng cao nhưng hơi nặng', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_dat_hang`
--

CREATE TABLE `don_dat_hang` (
  `ma_ddh` int(11) NOT NULL,
  `ma_nd` int(11) NOT NULL,
  `ma_nv` char(10) DEFAULT NULL,
  `diachi` varchar(255) NOT NULL,
  `ngaydat` datetime NOT NULL DEFAULT current_timestamp(),
  `tongtien` decimal(18,2) DEFAULT NULL,
  `trangthai` varchar(50) NOT NULL,
  `tt_thanhtoan` varchar(50) DEFAULT 'Chưa thanh toán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_dat_hang`
--

INSERT INTO `don_dat_hang` (`ma_ddh`, `ma_nd`, `ma_nv`, `diachi`, `ngaydat`, `tongtien`, `trangthai`, `tt_thanhtoan`) VALUES
(1, 1, 'NV_01', 'Hà Nội', '2025-11-12 00:00:00', '4500000.00', 'Hoàn thành', 'Đã thanh toán'),
(2, 2, NULL, 'TP. Hồ Chí Minh', '2025-11-06 00:00:00', '17100000.00', 'Đang xử lý', 'Chưa thanh toán'),
(3, 1, 'NV_01', 'Hà Nội', '2025-09-05 00:00:00', '5250000.00', 'Hoàn thành', 'Đã thanh toán'),
(4, 2, 'NV_01', 'TP. Hồ Chí Minh', '2025-09-20 00:00:00', '120000000.00', 'Đã hủy', 'Chưa thanh toán'),
(5, 1, 'NV_02', 'Đà Nẵng', '2025-10-10 00:00:00', '12500000.00', 'Hoàn thành', 'Đã thanh toán'),
(6, 2, NULL, 'Hà Nội', '2025-10-28 00:00:00', '15000000.00', 'Đang xử lý', 'Chưa thanh toán'),
(7, 1, 'NV_02', 'Cần Thơ', '2025-11-01 00:00:00', '19000000.00', 'Hoàn thành', 'Đã thanh toán'),
(8, 2, NULL, 'Hải Phòng', '2025-11-25 00:00:00', '18000000.00', 'Đang xử lý', 'Chưa thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh`
--

CREATE TABLE `hinh` (
  `ma_hinh` int(11) NOT NULL,
  `ma_sp` char(10) NOT NULL,
  `tenhinh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hinh`
--

INSERT INTO `hinh` (`ma_hinh`, `ma_sp`, `tenhinh`) VALUES
(1, 'SP01', 'SP1_12112025.jpg'),
(2, 'SP01', 'GuitarClassicC40.png'),
(3, 'SP01', 'SP1_13112025.jpg'),
(4, 'SP02', 'PianoDienPX-S1000.png'),
(5, 'SP03', 'SaotrucViet.png'),
(6, 'SP04', 'TrongJazzSet.png'),
(7, 'SP05', 'DaydanDAddario.png'),
(8, 'SP06', 'GuitarDienStrat.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_san_pham`
--

CREATE TABLE `loai_san_pham` (
  `ma_loai` char(10) NOT NULL,
  `tenloai` varchar(50) NOT NULL,
  `mota` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_san_pham`
--

INSERT INTO `loai_san_pham` (`ma_loai`, `tenloai`, `mota`) VALUES
('accessory', 'Phụ kiện', 'Dây đàn, bao đàn, chân đàn...'),
('drum', 'Trống', 'Trống điện tử, trống jazz'),
('flute', 'Sáo', 'Sáo trúc, sáo mèo và các loại sáo khác'),
('guitar', 'Guitar', 'Các loại đàn guitar'),
('piano', 'Piano', 'Đàn piano điện và cơ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `ma_nd` int(11) NOT NULL,
  `tennd` varchar(100) NOT NULL,
  `matkhau` varchar(32) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `hinh` varchar(255) DEFAULT NULL,
  `trangthai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ma_nd`, `tennd`, `matkhau`, `sdt`, `diachi`, `email`, `hinh`, `trangthai`) VALUES
(1, 'Lê Minh Hoàng', '123456', '0988000333', 'Hà Nội', 'customer1@zyuuki.vn', NULL, 1),
(2, 'Nguyễn Thu Trang', '123456', '0988000444', 'TP. Hồ Chí Minh', 'customer2@zyuuki.vn', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `ma_nv` char(10) NOT NULL,
  `tennv` varchar(100) NOT NULL,
  `matkhau` varchar(32) NOT NULL,
  `phai` tinyint(1) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `hinh` varchar(255) DEFAULT NULL,
  `trangthai` tinyint(1) NOT NULL,
  `ma_vt` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhan_vien`
--

INSERT INTO `nhan_vien` (`ma_nv`, `tennv`, `matkhau`, `phai`, `sdt`, `email`, `diachi`, `hinh`, `trangthai`, `ma_vt`) VALUES
('NV_01', 'Trần Văn Nam', '123456', 1, '0912000111', 'staff1@zyuuki.vn', 'Hà Nội', NULL, 1, 'Staff'),
('NV_02', 'Phạm Thị Linh', '123456', 0, '0912000222', 'staff2@zyuuki.vn', 'TP. Hồ Chí Minh', NULL, 1, 'Staff'),
('QL_01', 'Lê Văn Đạt', '123456', 1, '0869347040', 'admin@zyuuki.vn', 'Lâm Đồng', NULL, 1, 'Admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nha_san_xuat`
--

CREATE TABLE `nha_san_xuat` (
  `ma_nsx` char(10) NOT NULL,
  `tennsx` varchar(50) NOT NULL,
  `diachi` varchar(200) DEFAULT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nha_san_xuat`
--

INSERT INTO `nha_san_xuat` (`ma_nsx`, `tennsx`, `diachi`, `sdt`, `email`) VALUES
('casio', 'Casio', 'Nhật Bản', '0811122233', 'support@casio.jp'),
('fender', 'Fender', 'Mỹ', '0800345678', 'info@fender.com'),
('meilan', 'MeiLan', 'Trung Quốc', '0869988776', 'info@meilan.cn'),
('vicfirth', 'Vic Firth', 'Mỹ', '0899123456', 'contact@vicfirth.com'),
('yamaha', 'Yamaha', 'Nhật Bản', '0845123456', 'contact@yamaha.jp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `ma_sp` char(10) NOT NULL,
  `tensp` varchar(100) NOT NULL,
  `ma_nsx` char(10) DEFAULT NULL,
  `ma_loai` char(10) DEFAULT NULL,
  `giasp` decimal(18,2) NOT NULL,
  `soluongton` int(11) DEFAULT 0,
  `mota` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`ma_sp`, `tensp`, `ma_nsx`, `ma_loai`, `giasp`, `soluongton`, `mota`) VALUES
('SP01', 'Guitar Classic C40', 'yamaha', 'guitar', '2500000.00', 20, 'Guitar gỗ phù hợp cho người mới học'),
('SP02', 'Piano Dien PX-S1000', 'casio', 'piano', '18000000.00', 5, 'Dòng piano điện cao cấp của Casio'),
('SP03', 'Sáo trúc Việt', 'meilan', 'flute', '300000.00', 50, 'Sáo trúc truyền thống âm thanh ấm áp'),
('SP04', 'Trống Jazz Set', 'fender', 'drum', '12500000.00', 3, 'Bộ trống dành cho biểu diễn sân khấu'),
('SP05', 'Dây đàn DAddario', 'fender', 'accessory', '120000.00', 100, 'Dây đàn thay thế chất lượng cao'),
('SP06', 'Guitar Điện Strat', 'fender', 'guitar', '15000000.00', 15, 'Guitar điện Fender nổi tiếng'),
('SP07', 'Piano Cơ U1', 'yamaha', 'piano', '120000000.00', 12, 'Piano cơ Yamaha cao cấp'),
('SP08', 'Bao Đàn Guitar Dày', 'yamaha', 'accessory', '450000.00', 40, 'Bao đàn chất lượng cao, chống sốc'),
('SP09', 'Trống Điện DTX', 'yamaha', 'drum', '19000000.00', 7, 'Bộ trống điện tử Yamaha'),
('SP10', 'Dùi Trống 5A', 'vicfirth', 'accessory', '250000.00', 80, 'Dùi trống Vic Firth phổ thông'),
('SP11', 'Guitar Acoustic FG800M', 'yamaha', 'guitar', '5800000.00', 12, 'Guitar Acoustic tầm trung của Yamaha, âm thanh cân bằng, mặt gỗ Mahogany.'),
('SP12', 'Đàn Ukulele Soprano', 'meilan', 'guitar', '650000.00', 35, 'Ukulele gỗ tự nhiên, size Soprano, âm thanh vui tươi, dễ học.'),
('SP13', 'Keyboard CT-S300', 'casio', 'piano', '4200000.00', 22, 'Keyboard điện tử Casio, 61 phím cảm ứng lực, phù hợp cho người mới.'),
('SP14', 'Metronome cơ học', 'vicfirth', 'accessory', '750000.00', 64, 'Máy đập nhịp cơ học cổ điển, hỗ trợ luyện tập tiết tấu chính xác.'),
('SP15', 'Harmonica Diatonic', 'yamaha', 'flute', '400000.00', 34, 'Kèn Harmonica 10 lỗ Diatonic, tone C, dễ sử dụng.'),
('SP16', 'Amplifier Guitar 10W', 'fender', 'accessory', '2800000.00', 43, 'Amply nhỏ gọn Fender cho guitar điện, công suất 10W, có hiệu ứng Distortion.'),
('SP17', 'Piano Điện CDP-S150', 'casio', 'piano', '14500000.00', 63, 'Dòng piano điện mỏng nhẹ của Casio, 88 phím có độ nặng.'),
('SP18', 'Sáo Recorder Baroque', 'meilan', 'flute', '180000.00', 47, 'Sáo nhựa Recorder hệ thống Baroque, thích hợp cho giáo dục âm nhạc.'),
('SP19', 'Trống Cajun box', 'fender', 'drum', '3500000.00', 36, 'Trống Cajon làm bằng gỗ bạch dương, âm trầm và âm snare rõ ràng.'),
('SP20', 'Dây Micro Canon', 'vicfirth', 'accessory', '300000.00', 53, 'Dây cáp micro XLR dài 3m, chất lượng truyền tín hiệu tốt.'),
('SP21', 'Guitar Acoustic F310', 'yamaha', 'guitar', '3200000.00', 28, 'Mẫu đàn Acoustic phổ biến, âm thanh vang, rất được ưa chuộng.'),
('SP22', 'Piano Điện P-125', 'yamaha', 'piano', '19500000.00', 45, 'Piano điện Yamaha P-Series, âm thanh Pure CF, gọn và mạnh mẽ.'),
('SP23', 'Trống Lắc Tambourine', 'meilan', 'accessory', '150000.00', 0, 'Nhạc cụ gõ Tambourine, vỏ nhựa, chuông kim loại, âm thanh sáng.'),
('SP24', 'Bộ Dây Đàn Piano', 'yamaha', 'accessory', '1200000.00', 0, 'Bộ dây đàn piano cơ thay thế, chất liệu thép cao cấp.'),
('SP25', 'Sáo Flute Bạc', 'yamaha', 'flute', '8500000.00', 23, 'Sáo Flute tiêu chuẩn, thân mạ bạc, âm thanh trong trẻo, chuyên nghiệp.'),
('SP26', 'Giá Đỡ Nhạc Đa Năng', 'vicfirth', 'accessory', '550000.00', 0, 'Chân đỡ nhạc bằng thép, có thể điều chỉnh độ cao, gấp gọn.'),
('SP27', 'Guitar Điện Telecaster', 'fender', 'guitar', '17000000.00', 0, 'Guitar điện Fender Telecaster, âm thanh twang đặc trưng, thiết kế cổ điển.'),
('SP28', 'Piano Cơ B1', 'yamaha', 'piano', '80000000.00', 0, 'Piano cơ Yamaha B-series, nhỏ gọn, phù hợp cho căn hộ.'),
('SP29', 'Pad Luyện Tập Trống', 'vicfirth', 'accessory', '600000.00', 0, 'Bề mặt cao su, giúp luyện tập trống yên lặng và tăng cường độ nảy.'),
('SP30', 'Trống Đồng Latin', 'meilan', 'drum', '4800000.00', 0, 'Bộ Trống Conga/Bongo kiểu Latin, âm thanh vang, phù hợp cho nhạc Latin Jazz.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vai_tro`
--

CREATE TABLE `vai_tro` (
  `ma_vt` char(10) NOT NULL,
  `tenvt` varchar(50) NOT NULL,
  `mota` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vai_tro`
--

INSERT INTO `vai_tro` (`ma_vt`, `tenvt`, `mota`) VALUES
('Admin', 'Quản lý', 'Quyền cao nhất, quản trị toàn hệ thống'),
('Staff', 'Nhân viên', 'Quản lý sản phẩm và đơn hàng');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_don_dat_hang`
--
ALTER TABLE `chi_tiet_don_dat_hang`
  ADD PRIMARY KEY (`ma_ddh`,`ma_sp`),
  ADD KEY `ma_sp` (`ma_sp`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`ma_nd`,`ma_sp`),
  ADD KEY `ma_sp` (`ma_sp`);

--
-- Chỉ mục cho bảng `don_dat_hang`
--
ALTER TABLE `don_dat_hang`
  ADD PRIMARY KEY (`ma_ddh`),
  ADD KEY `ma_nd` (`ma_nd`),
  ADD KEY `ma_nv` (`ma_nv`);

--
-- Chỉ mục cho bảng `hinh`
--
ALTER TABLE `hinh`
  ADD PRIMARY KEY (`ma_hinh`),
  ADD KEY `ma_sp` (`ma_sp`);

--
-- Chỉ mục cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  ADD PRIMARY KEY (`ma_loai`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ma_nd`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`ma_nv`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ma_vt` (`ma_vt`);

--
-- Chỉ mục cho bảng `nha_san_xuat`
--
ALTER TABLE `nha_san_xuat`
  ADD PRIMARY KEY (`ma_nsx`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`ma_sp`),
  ADD KEY `ma_nsx` (`ma_nsx`),
  ADD KEY `ma_loai` (`ma_loai`);

--
-- Chỉ mục cho bảng `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`ma_vt`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `don_dat_hang`
--
ALTER TABLE `don_dat_hang`
  MODIFY `ma_ddh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `hinh`
--
ALTER TABLE `hinh`
  MODIFY `ma_hinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `ma_nd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_don_dat_hang`
--
ALTER TABLE `chi_tiet_don_dat_hang`
  ADD CONSTRAINT `chi_tiet_don_dat_hang_ibfk_1` FOREIGN KEY (`ma_ddh`) REFERENCES `don_dat_hang` (`ma_ddh`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_dat_hang_ibfk_2` FOREIGN KEY (`ma_sp`) REFERENCES `san_pham` (`ma_sp`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`ma_nd`) REFERENCES `nguoi_dung` (`ma_nd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`ma_sp`) REFERENCES `san_pham` (`ma_sp`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `don_dat_hang`
--
ALTER TABLE `don_dat_hang`
  ADD CONSTRAINT `don_dat_hang_ibfk_1` FOREIGN KEY (`ma_nd`) REFERENCES `nguoi_dung` (`ma_nd`) ON UPDATE CASCADE,
  ADD CONSTRAINT `don_dat_hang_ibfk_2` FOREIGN KEY (`ma_nv`) REFERENCES `nhan_vien` (`ma_nv`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hinh`
--
ALTER TABLE `hinh`
  ADD CONSTRAINT `hinh_ibfk_1` FOREIGN KEY (`ma_sp`) REFERENCES `san_pham` (`ma_sp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD CONSTRAINT `nhan_vien_ibfk_1` FOREIGN KEY (`ma_vt`) REFERENCES `vai_tro` (`ma_vt`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`ma_nsx`) REFERENCES `nha_san_xuat` (`ma_nsx`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `san_pham_ibfk_2` FOREIGN KEY (`ma_loai`) REFERENCES `loai_san_pham` (`ma_loai`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
