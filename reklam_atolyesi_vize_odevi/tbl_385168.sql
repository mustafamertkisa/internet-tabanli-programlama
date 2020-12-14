-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Ara 2020, 21:30:10
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `itp_vt`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_385168`
--

CREATE TABLE `tbl_385168` (
  `siparisNo` int(11) NOT NULL,
  `musteriAdSoyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `reklamTuru` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `siparisTutar` int(20) NOT NULL,
  `siparisTarihi` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tbl_385168`
--

INSERT INTO `tbl_385168` (`siparisNo`, `musteriAdSoyad`, `reklamTuru`, `siparisTutar`, `siparisTarihi`) VALUES
(3, 'Mert Kısa', 'Kanvas Tablo', 228, '2020-12-02');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tbl_385168`
--
ALTER TABLE `tbl_385168`
  ADD PRIMARY KEY (`siparisNo`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tbl_385168`
--
ALTER TABLE `tbl_385168`
  MODIFY `siparisNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
