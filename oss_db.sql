-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2016. Nov 12. 18:24
-- Kiszolgáló verziója: 10.1.16-MariaDB
-- PHP verzió: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `oss_db`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `background_users`
--

CREATE TABLE `background_users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `background_users`
--

INSERT INTO `background_users` (`id`, `username`, `password`) VALUES
(1, 'testuser', '6c2a82d055638e244672dc3b226bde02');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `description`) VALUES
(1, 'index_Create', 'Index létrehozása'),
(2, 'index_Delete', 'Index törlése'),
(3, 'field_Create', 'Mező létrehozása'),
(4, 'field_Modify', 'Mező módosítása'),
(5, 'field_Delete', 'Mező törlése'),
(6, 'template_Create', 'Sablon létrehozása'),
(7, 'template_Modify', 'Sablon módosítása'),
(8, 'template_Delete', 'Sablon törlése'),
(9, 'synonym_Modify', 'Szinonima szótár módosítása'),
(10, 'index_View', 'Indexek megtekintése'),
(11, 'field_View', 'Mezők megtekintése'),
(12, 'template_View', 'Sablonok megtekintése'),
(13, 'search_Run', 'Keresés futtatása'),
(14, 'admin_view', 'Admin nézet megtekintése');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `searches`
--

CREATE TABLE `searches` (
  `id` int(12) NOT NULL,
  `query` varchar(64) NOT NULL,
  `index_name` varchar(64) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `settings`
--

CREATE TABLE `settings` (
  `id` int(32) NOT NULL,
  `oss_host` varchar(64) DEFAULT NULL,
  `oss_port` smallint(8) DEFAULT NULL,
  `last_index` varchar(64) DEFAULT NULL,
  `last_template` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `settings`
--

INSERT INTO `settings` (`id`, `oss_host`, `oss_port`, `last_index`, `last_template`) VALUES
(1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `userlevels`
--

CREATE TABLE `userlevels` (
  `id` int(11) NOT NULL,
  `level_name` varchar(64) NOT NULL,
  `background_user_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `userlevels`
--

INSERT INTO `userlevels` (`id`, `level_name`, `background_user_id`) VALUES
(1, 'Admin', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `userlevels_permissions`
--

CREATE TABLE `userlevels_permissions` (
  `id` int(11) NOT NULL,
  `userlevel_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `userlevels_permissions`
--

INSERT INTO `userlevels_permissions` (`id`, `userlevel_id`, `permission_id`) VALUES
(5, 1, 2),
(6, 1, 3),
(7, 1, 4),
(8, 1, 5),
(9, 1, 6),
(10, 1, 7),
(11, 1, 8),
(12, 1, 9),
(13, 1, 10),
(14, 1, 11),
(15, 1, 12),
(17, 1, 13),
(21, 1, 14),
(47, 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(64) CHARACTER SET utf8 NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL,
  `userlevel_id` int(11) NOT NULL,
  `settings_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `userlevel_id`, `settings_id`) VALUES
(1, 'Admin', 'admin@admin.com', '/DaG5uwAuoOfl97/dJmN7L90RCDobcqAp8UOeI26LQWCgJVPAAGdlSDDxPGHAPUh6bEBbcn/jUsQ8bl3WaEpSg==', 1, 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `background_users`
--
ALTER TABLE `background_users`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `searches_ibfk_1` (`user_id`);

--
-- A tábla indexei `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `background_user_id` (`background_user_id`);

--
-- A tábla indexei `userlevels_permissions`
--
ALTER TABLE `userlevels_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `57d2f62e8579e` (`permission_id`),
  ADD KEY `57d2f62e8dd26` (`userlevel_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD UNIQUE KEY `email_4` (`email`),
  ADD KEY `57d2f62e7cd22` (`userlevel_id`),
  ADD KEY `users_ibfk_1` (`settings_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `background_users`
--
ALTER TABLE `background_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT a táblához `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT a táblához `searches`
--
ALTER TABLE `searches`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT a táblához `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT a táblához `userlevels`
--
ALTER TABLE `userlevels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT a táblához `userlevels_permissions`
--
ALTER TABLE `userlevels_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `searches`
--
ALTER TABLE `searches`
  ADD CONSTRAINT `searches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `userlevels`
--
ALTER TABLE `userlevels`
  ADD CONSTRAINT `userlevels_ibfk_1` FOREIGN KEY (`background_user_id`) REFERENCES `background_users` (`id`);

--
-- Megkötések a táblához `userlevels_permissions`
--
ALTER TABLE `userlevels_permissions`
  ADD CONSTRAINT `57d2f62e8923c` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `57d2f62e91727` FOREIGN KEY (`userlevel_id`) REFERENCES `userlevels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `57d2f62e8039f` FOREIGN KEY (`userlevel_id`) REFERENCES `userlevels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`settings_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
