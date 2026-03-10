-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 10, 2026 at 06:09 PM
-- Wersja serwera: 8.0.45
-- Wersja PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `karate`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `camp`
--

CREATE TABLE `camp` (
  `city` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `city_start` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `accommodation` text COLLATE utf8mb4_polish_ci NOT NULL,
  `meals` text COLLATE utf8mb4_polish_ci NOT NULL,
  `trips` text COLLATE utf8mb4_polish_ci NOT NULL,
  `staff` text COLLATE utf8mb4_polish_ci NOT NULL,
  `transport` text COLLATE utf8mb4_polish_ci NOT NULL,
  `training` text COLLATE utf8mb4_polish_ci NOT NULL,
  `insurance` text COLLATE utf8mb4_polish_ci NOT NULL,
  `cost` int NOT NULL,
  `advancePayment` int NOT NULL,
  `advanceDate` date NOT NULL,
  `guesthouse` varchar(70) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `camp`
--

INSERT INTO `camp` (`city`, `city_start`, `date_start`, `date_end`, `time_start`, `time_end`, `place`, `accommodation`, `meals`, `trips`, `staff`, `transport`, `training`, `insurance`, `cost`, `advancePayment`, `advanceDate`, `guesthouse`) VALUES
('CHEMIK  w Szczawnicy', 'Gdynia Główna.Os                                ', '2024-06-28', '2024-07-07', '13:00:00', '18:00:00', 'Domem Wypoczynkowym  CHEMIK , ul. Park Dolny 11, 34-460 Szczawnica.\r\n\r\n', 'ZAKWATEROWANIE: w pokojach 2- 6 lub osobowych z węzłem sanitarnym.', 'WYŻYWIENIE: trzy posiłki dziennie (wyżywienie pełno-kaloryczne. dostosowane do treningu wyczynowego, bez ograniczeń).', 'AUTOKAROWĄ wycieczkę do zamków Niedzica i Czorsztyn ( lub inny ), Jaskini Bielskiej na Słowacji ( Prosimy o zabranie Dowodów Osobistych  lub paszportów).\r\n\r\nWYCIECZKI: piesze trasami turystycznymi ( 2-3 trasy), spływ pontonami po Dunajcu lub inne.\r\n\r\nZWIEDZANIE Szczawna i okolicy... i inne nespodzianki', 'KADRĘ opiekunów ( jeden opiekun na 10 -15 dzieci i młodzieży) , kadrę trenerską.', 'TRANSPORT PKP (proszę o zabranie aktualnej legitymacji szkolnej !!! ) , autokar.', 'TRENINGI karate kyokushin jeden, dwa ( uzależnione od programu dnia ) razy dziennie dla członków Klubu i osób zainteresowanych , gry zespołowe dla pozostałych uczestników wypoczynku.', 'UBEZPIECZENIE i opiekę medyczną ( pielęgniarka 24 godz , lekarz 8 godz dziennie na terenie ośrodka)).																																', 2350, 500, '2024-02-15', 'Domu  Wypoczynkowego CHEMIK  w Szczawnicy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `contact`
--

CREATE TABLE `contact` (
  `email` text COLLATE utf8mb4_polish_ci NOT NULL,
  `phone` int NOT NULL,
  `address` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `contact`
--

INSERT INTO `contact` (`email`, `phone`, `address`) VALUES
('kyokushin.wejherowo@gmail.com', 123456789, 'Ul. Nanicka 22, Wejherowo');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fees`
--

CREATE TABLE `fees` (
  `reduced_contribution_1_month` int NOT NULL,
  `reduced_contribution_2_month` int NOT NULL,
  `family_contribution_month` int NOT NULL,
  `reduced_contribution_1_year` int NOT NULL,
  `reduced_contribution_2_year` int NOT NULL,
  `family_contribution_year` int NOT NULL,
  `extra_information` text COLLATE utf8mb4_polish_ci NOT NULL,
  `fees_information` text COLLATE utf8mb4_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `fees`
--

INSERT INTO `fees` (`reduced_contribution_1_month`, `reduced_contribution_2_month`, `family_contribution_month`, `reduced_contribution_1_year`, `reduced_contribution_2_year`, `family_contribution_year`, `extra_information`, `fees_information`) VALUES
(150, 220, 280, 1500, 2200, 2800, 'Składka członkowska i miesięczna ( łącznie składka ) obowiązuje wszystkich Członków Klubu przez 12 miesięcy w roku. Zajęcia prowadzimy przez cały rok, w wakacje i ferie też. W okresie wakacji składka jest obniżona. W przypadku, gdy członek Klubu nie uczestniczył w zajęciach np: z powodu choroby, oraz w innych szczególnych wypadkach nieobecności dłuższej niż 3 tygodnie w miesiącu, może być zmniejszona na pisemny wniosek Członka ( lub rodziców/opiekunów prawnych) do wysokości 100 zł za miesiąc. Wpisowe obecnie jest zawieszone. Obowiązuje tylko przy ponownym wstąpieniu do Klubu.', 'Składka za dwie osoby i rodzinna dotyczy osób pozostających w bliskim pokrewieństwie: rodzeństwo, rodzice i dzieci, małżeństwo.\r\n\r\nTreningi , dla Członków Klubu są bezpłatne. Ich ilość nie jest limitowana. Każdy Członek po uiszczeniu składki może brać udział we wszystkich treningach, we wszystkich lokalizacjach, gdzie je prowadzimy. Jedynym kryterium wstępu jest stopień zaawansowania i wiek ( jeśli zajęcia są skierowane do konkretnej grupy wiekowej ) Składki opłacamy przez cały rok, tj. 12 miesięcy Nieobecność na treningach nie zwalnia z opłacania składek. Obowiązuje trzymiesięczny okres wypowiedzenia członkostwa.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `gallery`
--

CREATE TABLE `gallery` (
  `id` int NOT NULL,
  `image_name` text COLLATE utf8mb4_polish_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `position` int NOT NULL DEFAULT '1',
  `category` enum('training','camp') COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `gallery`
--

INSERT INTO `gallery` (`id`, `image_name`, `description`, `created_at`, `updated_at`, `position`, `category`, `status`) VALUES
(2, '1.jpg', 'Obóz karate!!!!', '2025-09-06', '2025-10-08', 3, 'training', 1),
(3, '2.jpg', 'Obóz karate!', '2025-09-07', '2026-02-22', 2, 'camp', 1),
(12, 'karate_699b422c6adc13.40604600.jpg', 'Obóz karate 2', '2026-02-22', '2026-02-22', 1, 'training', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `important_posts`
--

CREATE TABLE `important_posts` (
  `id` int NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `description` text COLLATE utf8mb4_polish_ci NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `status` tinyint NOT NULL,
  `important` int DEFAULT NULL,
  `position` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `important_posts`
--

INSERT INTO `important_posts` (`id`, `title`, `description`, `created`, `updated`, `status`, `important`, `position`) VALUES
(1, 'Remont Sal 01.07 - 31.07 ', '                   W związku z remontem salki na basenie w Wejherowie i salki w SP 4 w Redzie, zajęcia odbywają się tylko w\r\nRedzie w Szkole Podstawowej nr 6 na ul. Gniewowskiej 33. Remont będzie trwał od 01.07 - 31.        ', '2025-08-02', '2025-10-16', 0, 0, 1),
(2, 'ZAPISY 2025/26  ', '     ZAPISY Rozpoczynamy zapisy dzieci od lat 5 , młodzież i dorośli na rok 2025/2026 do sekcji karate Kyokushin w Wejherowie i Redzie    ', '2025-08-02', '2025-09-04', 1, 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `main_page_posts`
--

CREATE TABLE `main_page_posts` (
  `id` int NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `description` text COLLATE utf8mb4_polish_ci NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `status` tinyint NOT NULL,
  `position` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `main_page_posts`
--

INSERT INTO `main_page_posts` (`id`, `title`, `description`, `created`, `updated`, `status`, `position`) VALUES
(1, 'Pierwsze zajęcia są bezpłatne', 'Chcesz spróbować, zanim się zdecydujesz? Zapraszamy na pierwsze zajęcia całkowicie bezpłatnie!\r\nPrzekonaj się sam, jak ciekawa i wartościowa może być nauka z nami.\r\nNie przegap okazji – zapisz się już dziś!\r\n\r\n', '2025-08-02', '2025-08-02', 1, 4),
(2, 'DLACZEGO KARATE ?', '        Karate daje dzieciom i młodzieży poczucie przynależności do grupy, gdzie łączy ich wspólne zainteresowanie sportami walki, pokonywanie trudności i własnych słabości. Daje możliwość indywidualnego rozwoju, bez potrzeby rywalizacji o miejsce w drużynie, jak dzieje się to w innych dyscyplinach sportowych . Każdy z trenujących bierze udział w treningu bez ryzyka, że zostanie zepchnięty na ławkę rezerwowych.\r\n\r\n\r\n        ', '2025-08-02', '2026-01-29', 1, 1),
(3, 'DOTACJAAAA', '   Zajęcia dla dzieci i młodzieży\r\n\r\nw WEJHEROWIE\r\n\r\nsą prowadzone w ramach  zadania publicznego\r\n\r\n\" Szkolenie karate Kyokushin \"\r\n\r\nrealizowanego przez nasz Klub, dofinansowanego przez\r\n\r\nGminę Miasta Wejherowa. ', '2025-08-02', '2025-09-25', 1, 3),
(4, 'TRENING RODZINNY', '           Zapraszamy na wspólne treningi rodzinne, w których obok dzieci i młodzieży uczestniczą rodzice. Możecie wspólnie spędzać czas na realizowaniu wspólnych pasji, odświeżając wcześniej nabyte umiejętności lub zacząć  przygodę z karate od samego początku ze swoimi dziećmi. Zajęcia są realizowane w w trzech formach: trening wspólny, trening dla dzieci, trening  rodziców                                     ', '2025-08-02', '2025-10-16', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `description` text COLLATE utf8mb4_polish_ci NOT NULL,
  `created` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `created`, `updated`, `status`, `position`) VALUES
(35, 'MISTRZOSTWA POLSKI 2011', '14 maja 2011 w Mielnie odbyły się XXXVIII Mistrzostwa Polski Seniorów Karate Kyokushin. W zawodach wzięło udział 99 karateka z 41 ośrodków. Organizatorem był Mieleński Klub Sztuk i Sportów Walki. Sędzią głównym był shihan Andrzej Drewniak. Patryk Borowski zajął 2 miejsce w kategorii kumite -80 kg', '2025-07-28', '2025-07-28', 1, 32),
(36, 'KRAKÓW 2011 OBÓZ LETNI', 'W dniach 21-24 lipca na obiektach Akademii Wychowania Fizycznego w Krakowie odbył się 38 Wschodnioeuropejski Letni Obóz Kyokushin .  Uczestniczyło w nim 190 karateka z Austrii, Czech, Mołdawi, Niemiec, Polski, Rosji i Ukrainy. Zajęcia prowadził  shihan Antonio Pinero 7 dan i  mistrz Świata w kata,  mistrz Europy w kumite shihan Jose Lezkano 5 dan. Celem obozu było doszkalenie kierowników ośrodków i instruktorów. Treningi odbywały się 4 razy dziennie zgodnie z programem przygotowanym przez shihan', '2025-07-28', '2025-07-28', 1, 31),
(37, 'MISTRZOSTWA EUROPY WARNA 2011', 'W dniach 15-16 października 2011 w Warnie odbyły się Otwarte Mistrzostwa Europy Kyokushin Karate Warna 2011. Wzięło w nich udział 280 uczestników z 16 krajów : Armenia, Bulgaria, Czechy, Francja, Grecja, Hiszpania, Holandia, Kazachstan, Niemcy, Norwegia, Polska, Portugalia, Rosja, Rumunia, Turcja i Ukraina.', '2025-07-28', '2025-07-28', 1, 30),
(38, 'PUCHAR POLSKI SUWAŁKI 2011', 'W dniu 29 10.2011 w Suwałkach odbył się Puchar Polski w kumite w Karate Kyokushin.Uczestniczyło w nim 93 zawodników z 36 ośrodków. Organizatorem zawodów był Suwalski Klub Karate Kyokushin.  Nasz Klub reprezentowało trzech zawodników:  Patryk Borowski 2 kyu, Piotr Puchalski 2 kyu oraz Piotr Tomaszewski 2 kyu.\r\n\r\nPatryk Borowski zajął I miejsce w kumite Kat – 80 kg,\r\n\r\nPiotr Tomaszewski V miejsce w kat – 80 kg\r\n\r\nDrużynowo VI- IX ( 5 pkt. ) miejsce\r\n\r\n', '2025-07-28', '2025-07-28', 1, 29),
(39, 'ORKIESTRA ŚWIĄTECZNEJ POMOCY 2012', 'W dniu 08.01.2012 dzieci naszego klubu wsparły pokazem Orkiestrę Świątecznej Pomocy .', '2025-07-28', '2025-07-28', 1, 28),
(40, 'SAMORZĄD WOJEWÓDZTWA POMORSKIEGO', 'Samorząd Województwa Pomorskiego wsparł kwotą 3000,00 ( trzy tysiące ) organizację MISTRZOSTW MAKROREGIONU ZACHODNIEGO- WEJHEROWO 2012, które odbędą się w sali judo AKADEMII WYCHOWANIA FIZYCZNEGO I SPORTU w GDAŃSKU dnia 24 marca 2012 roku. DZIĘKUJEMY - ZARZĄD KLUBU KARATE KYOKUSHIN I SPORTÓW WALKI w Wejherowie - organizator', '2025-07-28', '2025-07-28', 1, 27),
(41, 'MISTRZOSTWA MAKROREGIONU ZACHODNIEGO 2012', 'Klub nasz 24.03.2012 roku był organizatorem Mistrzostw Makroregionu Zachodniego. Zawody odbyły się w hali judo Akademii Wychowania Fizycznego i Sportu w Gdańsku. Współorganizatorem był Samorząd Województwa Pomorskiego.', '2025-07-28', '2025-07-28', 1, 26),
(42, 'WSPARCIE SAMORZĄDU GMINY WEJHEROWO', 'Samorząd Gminy Wejherowo wsparł nasz Klub w realizacji zadania \" Organizacja szkolenia sportowego karate Kyokushin \" kwotą 2000 ( dwa tysiące ) złotych. Dotacja, zgodnie z projektem,  będzie przeznaczona na opłaty za wynajem sali sportowej.', '2025-07-28', '2025-07-28', 1, 25),
(43, 'WSPARCIE SAMORZĄDU POWIATU WEJHEROWSKIEGO', 'Samorząd Powiatu Wejherowskiego wsparł realizację zadania \" Organizacja Szkolenia Sportowego Karate Kyokushin \" kwotą 1000 ( jeden tysiąc ) zł. i  zadania \" Obóz sportowo-wypoczynkowy Lato 2012 \"  kwotą 1000 ( tysiąca ) zł.', '2025-07-28', '2025-07-28', 1, 24),
(44, 'KURATORIUM - DOFINANSOWANIE', 'Kuratorium Oświaty w Gdańsku dofinansowało obóz sportowo-wypoczynkowy Lato 2012 kwotą 3300 zł.', '2025-07-28', '2025-07-28', 1, 23),
(45, 'ZGRUPOWANIE KADRY NARODOWEJ', 'W CENTRUM JAPOŃSKICH SPORTÓW I SZTUK WALKI DOJO w Starej Wsi w dniach 02-08 odbyło się zgrupowanie kadry narodowej. W zgrupowaniu uczestniczyli : Jarosław Preis, Patryk Borowski, Piotr Puchalski, Piotr Tomaszewski i Konrad Kryspin.', '2025-07-28', '2025-07-28', 1, 22),
(47, 'POPRZEZ SPORT KU LEPSZEJ PRZYSZŁOŚCI', 'W dniach od 08-10. do 31.10.2014  w Zespole Szkół nr 3 w Wejherowie realizowany jest projekt \" Poprzez sport ku lepszej przyszłości\", dofinansowany ze środków Gminy Miasta Wejherowa. Celem projektu jest zapobieganie negatywnym zjawiskom na które narażona jest młodzież , takich jak uzależnienia i przemoc. Adresatem projektu jest młodzież pierwszych klas gimnazjalnych  Z.S.  nr 3 w Wejherowie. Projekt składa się z trzech modułów: wykładów , warsztatów i zajęć sportowych. Projekt realizowany jest przez wykwalifikowanego trenera i coacha.', '2025-07-28', '2025-07-28', 1, 21),
(48, 'POWIAT PUCKI 2015', 'Zadanie publiczne \" Organizacja szkolenia sportowego karate kyokushin \" zostało wsparte kwotą 500 zł  przez Powiat Pucki\r\n\r\n ', '2025-07-28', '2025-07-28', 1, 20),
(49, 'GMINA MIASTA WEJHEROWO 2015', 'Gmina Miasta Wejherowo dofinansowała kwotą 2000 zł realizację projektu \" Organizacja szkolenia sportowego karate Kyokushin \" realizowanego przez nasz Klub w ramach wspierania i upowszechniania kultury fizycznej.', '2025-07-28', '2025-07-28', 1, 19),
(50, 'ZARZĄD POWIATU WEJHEROWSKIEGO 2015', 'Zarząd Powiatu Wejherowskiego wsparł kwotą 1000 zł realizację zadania  \" Organizacja szkolenia sportowego karate Kyokushin \" oraz kwotą 1500 zł realizację projektu \" Obóz sportowo - wypoczynkowy Lato 2015 \"', '2025-07-28', '2025-07-28', 1, 18),
(51, 'ZARZĄD POWIATU PUCKIEGO 2016', 'Starostwo Puckie dofinansowało zadanie \" Szkolenie sportowe karate kyokushin\" kwotą 1000 zł organizację  zajęć karate kyokushin w Powiecie Puckim w roku 2016.', '2025-07-28', '2025-07-28', 1, 17),
(52, 'ZARZĄD POWIATU WEJHEROWSKIEGO 2016', 'Zarząd Powiatu Wejherowskiego dofinansował kwotą 2000 zł zadanie publiczne,  \" Obóz sportowo-wypoczynkowy Lato 2016 \" skierowane do dzieci i młodzieży niezrzeszonej i  członków naszego Klubu', '2025-07-28', '2025-07-28', 1, 16),
(53, 'GMINA MIASTA WEJHEROWO 2016', 'Zarząd Gminy Miasta Wejherowa dofinansował kwotą 2000 zł zadanie publiczne \" Organizacja Szkolenia Sportowego Karate Kyokushin \" realizowanego przez nasz Klub.', '2025-07-28', '2025-07-28', 1, 15),
(54, 'SEMINARIUM STYCZEŃ 2017', 'W dniach 21-22 stycznia w Gdyni odbyło się seminarium karate kyokushin poświęcone doskonaleniu technik i taktyki walki. Zajęcia prowadził Shihan Andrzej Drewniak 8 dan, asystowali Shihan Zdzisław Niedźwiedź 5 dan, sensei: Andrzej Kłujszo 4 dan, Eljasz Madej 4 dan, Paweł Olszewski 4 dan, Stanisław Samsel 4 dan.W seminarium uczestniczyło 90 karateka z ośrodków: Białogard, Brusy, Bydgoszcz, Chojnice, Gdańsk, Gdynia, Kołobrzeg, Koszalin, Lipno, Miastko, Nowogard, Postumino, Reda, Słupsk, Szczecinek, Wejherowo i Zielona  Góra. Z naszego Klubu uczestniczyły 4 osoby.', '2025-07-28', '2025-07-28', 1, 14),
(55, 'PATRYK BOROWSKI', 'W dniu 12.02.2017 minęła pierwsza  rocznica tragicznej śmierci Patryka medalisty Mistrzostw Polski, Pucharu Polski i Mistrzostw Europy\r\nPAMIĘTAMY', '2025-07-28', '2025-07-28', 1, 13),
(56, 'MAGDA II MIEJSCE !', 'W dniu 04.03.2017 roku w Gdańsku, odbyły się Mistrzostwa Makroregionu Zachodniego seniorów i juniorów  i Międzywojewódzkie Mistrzostwa Młodzików.\r\n\r\nOrganizatorem był klub Pomorska Akademia Sportu - Karate Kyokushin. Po raz pierwszy, oprócz kumite w formule kyokushin , rozegrano kumite w olimpijskiej formule WKF. Uczestniczyło w nich 170 zawodników z 22 ośrodków z 7 województw centralnej i zachodniej Polski. W zawodach uczestniczyło dwóch naszych reprezentantów: Magdalena Kuklińska i Szymon Skiba.  Magda zajęła 2 miejsce w kategorii kumite kobiet + 65 kg. Pierwsze miejsce w tej kategorii  zdobyła Katarzyna Regent z Koszalińskiego Klubu Karate kyokushin.  Sędzią Głównym zawodów był Andrzej Drewniak 8 dan.\r\n\r\n', '2025-07-28', '2025-07-28', 1, 11),
(57, 'GMINA MIASTA WEJHEROWA 2020', 'Gmina Miasta Wejherowo wsparła kwotą 3500 zł  realizację zadania \" Szkolenie karate kyokushin\" którą przeznaczymy na najem sali i zakup sprzętu sportowego.', '2025-07-28', '2025-07-28', 1, 12),
(58, 'GMINA MIASTA WEJHEROWA 2021', 'Gmina Miasta Wejherowa wsparła nasz projekt \" Szkolenie Karate Kyokushin \" kwotą 1500 zł. Umowę podpisano 24.02.2021 roku. Niniejsza dotacja zostanie wykorzystana na najem sali gimnastycznej i zakup sprzętu.', '2025-07-28', '2025-07-28', 1, 10),
(59, 'POWIAT WEJHEROWSKI 2021', 'Zarząd Powiatu Wejherowskiego wsparł kwotą 1500 zł nasz projekty: \" Szkolenie Karate Kyokushin w Powiecie Wejherowskim kwotą 1500 zł i : Obóz sportowo-wypoczynkowy Lato 2021 \" kwotą 3000 zł', '2025-07-28', '2025-07-28', 1, 9),
(60, 'GMINA MIASTA REDA 2021', 'Gmina Miasta Reda dofinansowała nasz projekt \" Szkolenie Karate Kyokushin \" kwotą 3000 zł które zamierzamy przeznaczyć na najem sal gimnastycznych i zakup sprzętu\r\n\r\n ', '2025-07-28', '2025-07-28', 1, 8),
(61, 'PROGRAM KLUB 2021', 'Klub uzyskał dotację w wysokości 10.000 zł w ramach Programu Klub 2021', '2025-07-28', '2025-07-28', 1, 6),
(62, 'GMINA MIASTA WEJHEROWA 2022', 'Gmina Miasta Wejherowa wsparła kwotą 1500 zł nasz projekt \" Szkolenie Karate Kyokushin \" którą przeznaczymy na najem sal gimnastycznych', '2025-07-28', '2025-07-28', 1, 7),
(63, 'PROGRAM KLUB 2022', 'Otrzymaliśmy dofinansowanie w wysokości 10.000 zł w ramach Programu Klub 2022 na wynagrodzenie Instruktorów i trenerów.', '2025-07-28', '2025-07-28', 1, 5),
(64, 'GMINA MIASTA WEJHEROWA 2023', '    Gmina Miasta Wejherowa wsparła nasze zadanie \" Szkolenie karate Kyokushin\" kwotą 1000 zł', '2025-07-28', '2025-10-06', 1, 3),
(65, 'GMINA MIASTA WEJHEROWA 2024!', '    Gmina Miasta Wejherowa wsparła nasz projekt \" Szkolenie Karate Kyokushin \" kwotą  1000 ( jeden tysiąc ) złotych. Dotacja będzie przeznaczona na opłatę najmu sal gimnastycznych.  ', '2025-07-28', '2026-02-22', 1, 1),
(66, 'POWIAT WEJHEROWSKI 2024', '    Zarząd Powiatu Wejherowskiego wsparł nasz projekt \" Szkolenie Karate Kyokushin \" kwotą 2350 zł , którą zamierzamy przeznaczyć na opłacenie najmu sali, oraz kwotą 3000 zł zadanie \"Obóz sportowo-wypoczynkowy Lato 2024 którą przeznaczymy na opłatę pobytu w OW \" Edyta \" w Muszynie.\r\n\r\n     ', '2025-07-28', '2025-08-27', 1, 4),
(67, 'XIV Mistrzostwa Województwa Pomorskiego w Karate KYOKUSHIN', '    W dniu 26.04.2025 roku odbyły się XIV Mistrzostwa Województwa Pomorskiego w Karate KYOKUSHIN juniorów i seniorów\r\n\r\nNasz Klub reprezentowało 5 zawodników i zawodniczek,  seniorzy  troje i juniorzy dwoje osób\r\n\r\nAndrzej Klahs zajął drugie miejsce w kategorii  kumite senior + 80 kg\r\n\r\nKacper Walczyk i Kacper Nosal zajęli trzecie miejsce w kumite senior -75 kg\r\n\r\nDorota Klahs zajęła 3 miejsce w kategorii kumite junior 15-17 lat + 62 kg\r\n\r\nSofiia Cherenok 3 miejsce w kategorii kumite junior 11-12 lat -37 kg\r\n\r\nStartowało 217 zawodników i zawodniczek z 17 Klubów', '2025-07-28', '2025-10-07', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `token` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `is_active`, `token`) VALUES
(1, 'example@gmail.com', 0, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `timetable`
--

CREATE TABLE `timetable` (
  `id` int NOT NULL,
  `day` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `city` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `advancement_group` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `place` text COLLATE utf8mb4_polish_ci NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `timetable`
--

INSERT INTO `timetable` (`id`, `day`, `city`, `advancement_group`, `place`, `start`, `end`, `status`, `position`) VALUES
(2, 'ŚR', 'rekowo', 'Wszyscy', 'sala gimnastyczna', '17:00:00', '18:00:00', 1, 2),
(3, 'CZW', 'Reda SP6', 'Kadra', 'Treningi odbywają się na sali gimnastycznej', '17:30:00', '19:00:00', 1, 2),
(4, 'PT', 'REDA SP4', 'Początkująca dzieci', 'Treningi odbywają się na łączniku', '18:00:00', '18:45:00', 1, 2),
(5, 'SOB', 'Wejherowo ', 'Początkująca dzieci', 'Salka pod basenem', '11:00:00', '11:45:00', 1, 2),
(6, 'WT    ', 'Wejherowo', 'Początkująca', 'Treningi odbywają się na salce pod basenem ', '18:00:00', '19:00:00', 1, 2),
(7, 'SOB', 'Wejherowo', 'Zaawansowana', 'Treningi odbywają się na salce pod basenem', '11:45:00', '13:00:00', 1, 2),
(13, 'PON', 'Wejherowo', 'Zaawansowana', 'asdasd', '19:41:00', '22:44:00', 1, 2),
(16, 'PON', 'Rekowo', 'Zaawansowana', 'po basenem', '20:45:00', '23:48:00', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password`) VALUES
(1, 'Musashi', '$2y$10$ErJp/xcJgY4QRrYipGtsjO2tJk7LVhArlCfYPxj6ii5AiA5cAdnvm'),
(2, 'test', '$2y$10$rx/38yd5XRg5fzMHGfi3i.SjEQhIIqiiTM.eF2C/NvYIo8c/HEXUq');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `important_posts`
--
ALTER TABLE `important_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `main_page_posts`
--
ALTER TABLE `main_page_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indeksy dla tabeli `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `important_posts`
--
ALTER TABLE `important_posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `main_page_posts`
--
ALTER TABLE `main_page_posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT dla tabeli `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
