-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2016. Nov 26. 19:32
-- Kiszolgáló verziója: 10.1.16-MariaDB
-- PHP verzió: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `wouldyou_db`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `answers`
--

CREATE TABLE `answers` (
  `id` int(12) NOT NULL,
  `text` varchar(128) NOT NULL,
  `counter` int(12) NOT NULL DEFAULT '0',
  `question_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `answers`
--

INSERT INTO `answers` (`id`, `text`, `counter`, `question_id`) VALUES
(1, 'Kecske', 11, 1),
(2, 'Ló', 5, 1),
(30, 'Veigar', 8, 2),
(31, 'Kassandra', 4, 2),
(83, 'Teszt válasz 2', 11, 3),
(84, 'Teszt válasz 1', 1, 3),
(94, 'Teszt válasz 1', 11, 4),
(95, 'Teszt válasz 2', 1, 4),
(96, 'Teszt válasz 1', 12, 5),
(97, 'Teszt válasz 2', 0, 5),
(98, 'Teszt válasz 1', 12, 6),
(99, 'Teszt válasz 2', 0, 6),
(100, 'Teszt válasz 1', 2, 7),
(101, 'Teszt válasz 2', 0, 7),
(102, 'Teszt válasz 1', 2, 8),
(103, 'Teszt válasz 2', 0, 8),
(104, 'Teszt válasz 1', 2, 9),
(105, 'Teszt válasz 2', 0, 9),
(106, 'Teszt válasz 1', 2, 10),
(107, 'Teszt válasz 2', 0, 10);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `questions`
--

CREATE TABLE `questions` (
  `id` int(12) NOT NULL,
  `text` varchar(256) NOT NULL,
  `answer_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `questions`
--

INSERT INTO `questions` (`id`, `text`, `answer_id`) VALUES
(1, 'Mi lennél inkább, kecske vagy ló?', 0),
(2, 'Mi lennél inkább, Veigar vagy Kassandra?', 0),
(3, 'Teszt kérdés 3', 0),
(4, 'Teszt kérdés', 0),
(5, 'Teszt kérdés 4', 0),
(6, 'Teszt kérdés 5', 0),
(7, 'Teszt kérdés 6', 0),
(8, 'Teszt kérdés 7', 0),
(9, 'Teszt kérdés 8', 0),
(10, 'Teszt kérdés 9', 0),
(11, 'Teszt kérdés 10', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `testquestions`
--

CREATE TABLE `testquestions` (
  `id` int(12) NOT NULL,
  `test_id` int(12) NOT NULL,
  `question_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `testquestions`
--

INSERT INTO `testquestions` (`id`, `test_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 1, 3),
(6, 1, 4),
(8, 1, 5),
(9, 1, 6),
(12, 1, 7),
(14, 1, 8),
(16, 1, 9),
(18, 1, 10);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tests`
--

CREATE TABLE `tests` (
  `id` int(12) NOT NULL,
  `completing_counter` int(12) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `tests`
--

INSERT INTO `tests` (`id`, `completing_counter`) VALUES
(1, 2);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_answer_id` (`question_id`);

--
-- A tábla indexei `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `testquestions`
--
ALTER TABLE `testquestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_id` (`question_id`),
  ADD KEY `fk_test_id` (`test_id`);

--
-- A tábla indexei `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT a táblához `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT a táblához `testquestions`
--
ALTER TABLE `testquestions`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT a táblához `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answer_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `testquestions`
--
ALTER TABLE `testquestions`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_test_id` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
