-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 01 Mar 2020, 22:50:46
-- Sunucu sürümü: 10.0.38-MariaDB
-- PHP Sürümü: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ersamobi_test`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aday`
--

CREATE TABLE `aday` (
  `aday_id` int(11) NOT NULL,
  `aday_adsoyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `aday_resimyol` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `aday_sira` int(2) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `aday`
--

INSERT INTO `aday` (`aday_id`, `aday_adsoyad`, `aday_resimyol`, `aday_sira`) VALUES
(1, 'Salih Bozdemir', 'img/adayresim/5b1a71aeaae11.jpg', 0),
(3, 'Thomas Shelby', 'img/adayresim/5b132d090706c.jpg', 1),
(4, 'Gökhan Soğancı', 'img/adayresim/5b1a7152e7d16.jpg', 2),
(6, 'Burak Devecioğlu', 'img/adayresim/5b1a70f33267e.jpg', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayar`
--

CREATE TABLE `ayar` (
  `ayar_id` int(11) NOT NULL,
  `ayar_ad` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `ayar_tur` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `ayar_aciklama` varchar(250) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayar`
--

INSERT INTO `ayar` (`ayar_id`, `ayar_ad`, `ayar_tur`, `ayar_aciklama`) VALUES
(1, 'title', 'Seçim Anket Scriptii', ''),
(2, 'description', 'Seçim Anket Scripti Açıklaması', ''),
(3, 'keywords', 'secim,anket,baskan,aday', ''),
(5, 'oyturu', '1', '0 - Sms ile 1 - Mail ile oy verme');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_zaman` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kullanici_mail` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_password` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `kullanici_zaman`, `kullanici_mail`, `kullanici_password`) VALUES
(1, '2018-05-31 17:06:04', 'info@secimanket.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oy`
--

CREATE TABLE `oy` (
  `oy_id` int(11) NOT NULL,
  `oy_zaman` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aday_id` int(11) NOT NULL,
  `oy_araci` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `oy`
--

INSERT INTO `oy` (`oy_id`, `oy_zaman`, `aday_id`, `oy_araci`) VALUES
(51, '2018-06-08 14:44:24', 6, 'test@test.com');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `aday`
--
ALTER TABLE `aday`
  ADD PRIMARY KEY (`aday_id`);

--
-- Tablo için indeksler `ayar`
--
ALTER TABLE `ayar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `oy`
--
ALTER TABLE `oy`
  ADD PRIMARY KEY (`oy_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `aday`
--
ALTER TABLE `aday`
  MODIFY `aday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `ayar`
--
ALTER TABLE `ayar`
  MODIFY `ayar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `oy`
--
ALTER TABLE `oy`
  MODIFY `oy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
