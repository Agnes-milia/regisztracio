-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Ápr 27. 16:39
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
  PRIMARY KEY (`felhAzon`),
  UNIQUE KEY `felhAzon` (`felhAzon`),
  KEY `jogAzon` (`jogAzon`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`felhAzon`, `jogAzon`, `nev`, `email`, `jelszo`) VALUES
(1, 1, 'teszt11', 'teszt11@szamalk.hu', '26549e22263d93682083f53dfeaaab4e'),
(4, 2, 'teszt22', 'teszt22@szamalk.hu', '89f6b41d27a4b8ae07ca7eae8eaf3ff0'),
(5, 2, 'teszt33', 'teszt33@szamalk.hu', '621d0fb23f2597fd462c9250e9cfee07');

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

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD CONSTRAINT `felhasznalo_ibfk_1` FOREIGN KEY (`jogAzon`) REFERENCES `jogosultsag` (`jogAzon`);
COMMIT;