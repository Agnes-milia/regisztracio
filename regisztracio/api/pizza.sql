-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Máj 24. 17:32
-- Kiszolgáló verziója: 10.4.24-MariaDB
-- PHP verzió: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Adatbázis: `pizzahot`
--
CREATE DATABASE IF NOT EXISTS `pizzahot` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `pizzahot`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

DROP TABLE IF EXISTS `felhasznalo`;
CREATE TABLE IF NOT EXISTS `felhasznalo` (
  `felhAzon` int(11) NOT NULL AUTO_INCREMENT,
  `jogAzon` int(11) NOT NULL,
  `nev` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
  `bejelentkezett` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`felhAzon`),
  UNIQUE KEY `felhAzon` (`felhAzon`),
  KEY `jogAzon` (`jogAzon`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`felhAzon`, `jogAzon`, `nev`, `email`, `jelszo`, `bejelentkezett`) VALUES
(1, 1, 'teszt11', 'teszt11@szamalk.hu', '26549e22263d93682083f53dfeaaab4e', 0),
(4, 2, 'teszt22', 'teszt22@szamalk.hu', '89f6b41d27a4b8ae07ca7eae8eaf3ff0', 1),
(5, 2, 'teszt33', 'teszt33@szamalk.hu', '621d0fb23f2597fd462c9250e9cfee07', 1),
(10, 2, 'Haha', 'haha@gmail.com', '4e4d6c332b6fe62a63afe56171fd3725', 0),
(11, 1, 'Maa', 'maa@gmail.com', '71a81e2afb8ac1659c61c04c9d638f68', 0),
(12, 2, 'jjj', 'ratipotti@gmail.com', '5e36941b3d856737e81516acd45edc50', 0),
(13, 1, 'Zoli', 'zoli@gmail.com', 'dd71d14c9212c3108b642d0e9f3d1883', 1),
(14, 2, 'Peti', 'peti@gmail.com', 'ee465671cf0cf54ee42b2bbefce03f54', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jogosultsag`
--

DROP TABLE IF EXISTS `jogosultsag`;
CREATE TABLE IF NOT EXISTS `jogosultsag` (
  `jogAzon` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`jogAzon`),
  UNIQUE KEY `jogAzon` (`jogAzon`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `jogosultsag`
--

INSERT INTO `jogosultsag` (`jogAzon`, `nev`) VALUES
(1, 'admin'),
(2, 'editor');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

DROP TABLE IF EXISTS `kategoria`;
CREATE TABLE IF NOT EXISTS `kategoria` (
  `kategoriaAzon` int(11) NOT NULL AUTO_INCREMENT,
  `ar` int(11) NOT NULL DEFAULT 1000,
  `nev` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`kategoriaAzon`),
  UNIQUE KEY `nev` (`nev`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kategoria`
--

INSERT INTO `kategoria` (`kategoriaAzon`, `ar`, `nev`) VALUES
(1, 500, 'ital'),
(2, 1500, 'kicsi'),
(3, 2500, 'közepes'),
(4, 4500, 'óriás'),
(77, 1000, 'alkohol'),
(86, 2000, 'feles');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendeles`
--

DROP TABLE IF EXISTS `rendeles`;
CREATE TABLE IF NOT EXISTS `rendeles` (
  `rendelesAzon` int(11) NOT NULL AUTO_INCREMENT,
  `pizzaAzon` int(11) NOT NULL,
  `felhAzon` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL,
  PRIMARY KEY (`rendelesAzon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

DROP TABLE IF EXISTS `termek`;
CREATE TABLE IF NOT EXISTS `termek` (
  `termekAzon` int(11) NOT NULL AUTO_INCREMENT,
  `kategoria` int(11) NOT NULL,
  `keszito` int(11) NOT NULL,
  `leiras` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`termekAzon`),
  KEY `kategoria` (`kategoria`),
  KEY `keszito` (`keszito`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `termek`
--

INSERT INTO `termek` (`termekAzon`, `kategoria`, `keszito`, `leiras`) VALUES
(1, 1, 4, 'Coca-Cola'),
(2, 2, 5, 'Margaréta'),
(3, 1, 4, 'Cappy'),
(4, 3, 5, 'Margaréta');

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD CONSTRAINT `felhasznalo_ibfk_1` FOREIGN KEY (`jogAzon`) REFERENCES `jogosultsag` (`jogAzon`);

--
-- Megkötések a táblához `termek`
--
ALTER TABLE `termek`
  ADD CONSTRAINT `termek_ibfk_1` FOREIGN KEY (`kategoria`) REFERENCES `kategoria` (`kategoriaAzon`),
  ADD CONSTRAINT `termek_ibfk_2` FOREIGN KEY (`keszito`) REFERENCES `felhasznalo` (`felhAzon`);
COMMIT;
