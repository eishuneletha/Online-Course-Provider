-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 08:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educally`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `Email`, `Password`) VALUES
(1, 'Regina George', 'regina@gmail.com', '221182760f5b980c97c7a74a94d57364');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Web Development'),
(10, 'Vocal'),
(12, 'cooking'),
(14, 'Software Development'),
(15, 'Fashion Design'),
(16, 'Dance');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL,
  `CourseTitle` varchar(255) NOT NULL,
  `SkillLevel` varchar(255) NOT NULL,
  `ThumbnailPicture` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Outcomes` text NOT NULL,
  `LanguageUsed` varchar(255) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `PublishedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `CategoryID`, `InstructorID`, `CourseTitle`, `SkillLevel`, `ThumbnailPicture`, `Price`, `Description`, `Outcomes`, `LanguageUsed`, `Status`, `PublishedDate`) VALUES
(2, 12, 2, 'Basic cooking skills', 'Beginner', 'coursethumbnail/_bcooking.jpeg', 78, 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer sit amet urna vitae orci fringilla blandit. Nunc a felis enim. Vestibulum a malesuada eros. Donec quis velit tellus. Quisque purus nisi, vulputate ut pulvinar id, posuere ut urna. Vivamus vitae pellentesque libero. Sed gravida fermentum erat eget accumsan. In diam nisl, auctor volutpat rutrum et, ornare ut massa. Fusce finibus faucibus ligula eget efficitur. Morbi tristique nisl mauris, at efficitur libero pharetra id. Sed eu orci sed sapien iaculis egestas. Donec in gravida neque. Proin euismod, leo sit amet scelerisque varius, lorem est blandit elit, eu accumsan tortor dui sed diam. Proin elementum justo eget mi efficitur tempus.\r\n\r\n', 'Nunc finibus augue et velit porta dictum. Quisque dolor est, bibendum aliquam lacus vitae, luctus ultrices leo. Integer feugiat vulputate nunc, nec faucibus arcu dignissim sit amet. Vestibulum aliquam ex malesuada urna ultricies laoreet. Vivamus massa est, tempor at enim non, sollicitudin scelerisque eros. Aliquam sed pretium elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus nisi, aliquet sit amet enim sed, dignissim iaculis sem. Nam consectetur tincidunt quam, vel rhoncus metus bibendum vitae. Nam rhoncus justo ut elit consectetur tincidunt. Vivamus felis urna, scelerisque non purus eget, congue placerat nunc. Vestibulum non tincidunt turpis, eu placerat erat. Aliquam sit amet nunc at orci fringilla pulvinar ut euismod velit. Aliquam consectetur velit erat, id tincidunt odio molestie sed.', 'English', 1, '2022-11-15'),
(3, 14, 2, 'Java Zero to Hero', 'Beginner', 'coursethumbnail/_javacourse.png', 90, 'Nunc finibus augue et velit porta dictum. Quisque dolor est, bibendum aliquam lacus vitae, luctus ultrices leo. Integer feugiat vulputate nunc, nec faucibus arcu dignissim sit amet. Vestibulum aliquam ex malesuada urna ultricies laoreet. Vivamus massa est, tempor at enim non, sollicitudin scelerisque eros. Aliquam sed pretium elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus nisi, aliquet sit amet enim sed, dignissim iaculis sem. Nam consectetur tincidunt quam, vel rhoncus metus bibendum vitae. Nam rhoncus justo ut elit consectetur tincidunt. Vivamus felis urna, scelerisque non purus eget, congue placerat nunc. Vestibulum non tincidunt turpis, eu placerat erat. Aliquam sit amet nunc at orci fringilla pulvinar ut euismod velit. Aliquam consectetur velit erat, id tincidunt odio molestie sed.', 'Nam ornare leo enim, sed condimentum turpis bibendum vel. Nullam id ullamcorper est. Vivamus a tincidunt orci, in consequat neque. Curabitur auctor justo nibh, at dictum metus fermentum sit amet. Cras ultricies, lectus eu aliquet venenatis, nisi turpis vehicula nisl, scelerisque auctor arcu tortor et enim. Integer porttitor consectetur odio, vel dapibus magna aliquet eu. Morbi mauris massa, accumsan nec rhoncus sit amet, vehicula eget lacus. Vivamus congue imperdiet felis, a fermentum lorem pretium vitae. Praesent aliquam bibendum lacus eu laoreet. Nullam id turpis pulvinar, consequat mi sit amet, rhoncus leo. Cras vitae magna suscipit felis imperdiet vulputate.', 'English', 1, '2022-11-16'),
(4, 12, 2, 'Baking is for all', 'AllLevel', 'coursethumbnail/_baking.jpg', 23, 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget s', 'a massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magna nisi, interdum nec auctor sit amet, ornare quis tellus. Donec pulvinar tincidunt enim, quis dapibus dui imperdiet quis. Phasellus id elementum nulla, nec tempus risus. Pellentesque fermentum enim sit amet eros viverra, quis dictum massa sodales.', 'English', 1, '2022-11-16'),
(5, 10, 2, 'Mariah Carey\'s vocal training course', 'Advanced', 'coursethumbnail/_mcsinging.jpg', 23, 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.\r\n\r\nClass aptent taciti sociosqu ad litora to', 'c, nec faucibus arcu dignissim sit amet. Vestibulum aliquam ex malesuada urna ultricies laoreet. Vivamus massa est, tempor at enim non, sollicitudin scelerisque eros. Aliquam sed pretium elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus nisi, aliquet sit amet enim sed, dignissim iaculis sem. Nam consectetur tincidunt quam, vel rhoncus metus bibendum vitae. Nam rhoncus justo ut elit consectetur tincidunt. Vivamus felis urna, scelerisque non purus eget, congue placerat nunc. Vestibulum non tincidunt turpis, eu placerat erat. Aliquam sit amet nunc at orci fringilla pulvina', 'English', 1, '2022-11-17'),
(6, 15, 1, 'Wanna impress Anna Wintour?', 'Advanced', 'coursethumbnail/_anawintour.jpg', 23, 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.', 'Nunc finibus augue et velit porta dictum. Quisque dolor est, bibendum aliquam lacus vitae, luctus ultrices leo. Integer feugiat vulputate nunc, nec faucibus arcu dignissim sit amet. Vestibulum aliquam ex malesuada urna ultricies laoreet. Vivamus massa est, tempor at enim non, sollicitudin scelerisque eros. Aliquam sed pretium elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus nisi, aliquet sit amet enim sed, dignissim iaculis sem. Nam consectetur tincidunt quam, vel rhoncus metus bibendum vitae. Nam rhoncus justo ut elit consectetur tincidunt. Vivamus felis urna, scelerisque non purus eget, congue placerat nunc. Vestibulum non tincidunt turpis, eu placerat erat. Aliquam sit amet nunc at orci fringilla pulvinar ut euismod velit. Aliquam consectetur velit erat, id tincidunt odio molestie sed.', 'English', 1, '2022-11-17'),
(7, 14, 4, 'Programming Essentials', 'Advanced', 'coursethumbnail/_1126718-the-x-files.jpg', 28, 'aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magn', 'aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magn', 'English', 1, '2022-11-18'),
(8, 16, 3, 'Yule ball dance training', 'Advanced', 'coursethumbnail/_17108878.jpg', 12, 'klsfowiriwe', 'ererwwe', 'English', 0, '0000-00-00'),
(9, 16, 6, 'Salsa dancing course', 'Beginner', 'coursethumbnail/_17108878.jpg', 80, 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer sit amet urna vitae orci fringilla blandit. Nunc a felis enim. Vestibulum a malesuada eros. Donec quis velit tellus. Quisque purus nisi, vulputate ut pulvinar id, posuere ut urna. Vivamus vitae pellentesque libero. Sed gravida fermentum erat eget accumsan. In diam nisl, auctor volutpat rutrum et, ornare ut massa. Fusce finibus faucibus ligula eget efficitur. Morbi tristi', 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer sit amet urna vitae orci fringilla blandit. Nunc a felis enim. Vestibulum a malesuada eros. Donec quis velit tellus. Quisque purus nisi, vulputate ut pulvinar id, posuere ut urna. Vivamus vitae pellentesque libero. Sed gravida fermentum erat eget accumsan. In diam nisl, auctor volutpat rutrum et, ornare ut massa. Fusce finibus faucibus ligula eget efficitur. Morbi tristi', 'English', 1, '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `InstructorID` int(11) NOT NULL,
  `InstructorName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ProfilePicture` varchar(255) NOT NULL,
  `About` text NOT NULL,
  `Interestedcategories` text NOT NULL,
  `InstructorSince` date DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`InstructorID`, `InstructorName`, `Email`, `Password`, `ProfilePicture`, `About`, `Interestedcategories`, `InstructorSince`, `status`) VALUES
(1, 'Lizzie Mcguire', 'lizzie@gmail.com', 'ab1dcbe37922da370c5843f01434c8eb', 'userprofile/_FdjOTI1aMAIOEJc.jfif', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer sit amet urna vitae orci fringilla blandit. Nunc a felis enim. Vestibulum a malesuada eros. Donec quis velit tellus. Quisque purus nisi, vulputate ut pulvinar id, posuere ut urna. Vivamus vitae pellentesque libero. Sed gravida fermentum erat eget accumsan. In diam nisl, auctor volutpat rutrum et, ornare ut massa. Fusce finibus faucibus ligula eget efficitur. Morbi tristique nisl mauris, at efficitur libero pharetra id. Sed eu orci sed sapien iaculis egestas. Donec in gravida neque. Proin euismod, leo sit amet scelerisque varius, lorem est blandit elit, eu accumsan tortor dui sed diam. Proin elementum justo eget mi efficitur tempus.\r\n\r\nNunc finibus augue et velit porta dictum. Quisque dolor est, bibendum aliquam lacus vitae, luctus ultrices leo. Integer feugiat vulputate nunc, nec faucibus arcu dignissim sit amet. Vestibulum aliquam ex malesuada urna ultricies laoreet. Vivamus massa est, tempor at enim non, sollicitudin scelerisque eros. Aliquam sed pretium elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tellus nisi, aliquet sit amet enim sed, dignissim iaculis sem. Nam consectetur tincidunt quam, vel rhoncus metus bibendum vitae. Nam rhoncus justo ut elit consectetur tincidunt. Vivamus felis urna, scelerisque non purus eget, congue placerat nunc. Vestibulum non tincidunt turpis, eu placerat erat. Aliquam sit amet nunc at orci fringilla pulvinar ut euismod velit. Aliquam consectetur velit erat, id tincidunt odio molestie sed.', 'Vocal,cooking,', '2022-11-03', 1),
(2, 'Elizabeth Bennet', 'elizabeth@gmail.com', '4af09080574089cbece43db636e2025f', 'userprofile/_shrek.jpg', 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.', 'Vocal,cooking,Fashion Design,', '2022-11-05', 1),
(3, 'Minerva Mcgonagall', 'minerva@gmail.com', 'dfa410a0fbac3a2e5983192b73b03f3f', 'userprofile/_FdruQnZXkCAfYHP.jfif', 'Headmistress at hogwarts', 'Vocal,cooking,Software Development,Fashion Design,', '2022-11-06', 1),
(4, 'Maddy Perez', 'maddy@gmail.com', '2b10435032f537ce08893c0962878796', 'userprofile/_FhFbKdWUYAAZi0s.jfif', 'Nam ornare leo enim, sed condimentum turpis bibendum vel. Nullam id ullamcorper est. Vivamus a tincidunt orci, in consequat neque. Curabitur auctor justo nibh, at dictum metus fermentum sit amet. Cras ultricies, lectus eu aliquet venenatis, nisi turpis vehicula nisl, scelerisque auctor arcu tortor et enim. Integer porttitor consectetur odio, vel dapibus magna aliquet eu. Morbi mauris massa, accumsan nec rhoncus sit amet, vehicula eget lacus. Vivamus congue imperdiet felis, a fermentum lorem pretium vitae. Praesent aliquam bibendum lacus eu laoreet. Nullam id turpis pulvinar, consequat mi sit amet, rhoncus leo. Cras vitae magna suscipit felis imperdiet vulputate.', 'Vocal,Software Development,Fashion Design,', '2022-11-06', 1),
(5, 'Stiles Stilinski', 'stiles@gmail.com', '960fd0320d5b12b2da0481b6f8823ff6', 'userprofile/_FhR0cvAaMAAcYbr.jfif', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis nunc vel aliquet vehicula. Suspendisse sollicitudin ac velit et aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magna nisi, interdum nec auctor sit amet, ornare quis tellus. Donec pulvinar tincidunt enim, quis dapibus dui imperdiet quis. Phasellus id elementum nulla, nec tempus risus. Pellentesque fermentum enim sit amet eros viverra, quis dictum massa sodales.', 'Web Development,Vocal,cooking,Software Development,', '2022-11-28', 1),
(6, 'lydia martin', 'lydia@gmail.com', '40996e3e179435cfb64c2cedb2c099dc', 'userprofile/_FiVynQGXwAIfBoe.jfif', 'sum dolor sit amet, consectetur adipiscing elit. Nunc venenatis nunc vel aliquet vehicula. Suspendisse sollicitudin ac velit et aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magna nisi, interdum nec auctor sit amet, ornare quis tellu', 'Web Development,Vocal,', '2022-11-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

CREATE TABLE `learners` (
  `LearnerID` int(11) NOT NULL,
  `LearnerName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `ProfilePicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `learners`
--

INSERT INTO `learners` (`LearnerID`, `LearnerName`, `Email`, `Password`, `DateOfBirth`, `ProfilePicture`) VALUES
(1, 'Blair', 'blair@gmail.com', '695d3555929f09cca1f9cc2295df8ca2', '2001-07-08', 'userprofile/_FiOzsQhakAAh-fX.jfif'),
(2, 'Santana Lopez', 'santana@gmail.com', '0ef4355061c51f7f8411e0bdb8ed2468', '2003-08-17', 'userprofile/_FdzHFEXXwAA1OY2.jfif'),
(3, 'Fallon Carrington', 'fallon@gmail.com', 'bab23844ba91d035fe5ccc0c0bebdb98', '2004-02-02', 'userprofile/_spongebobcrying.jpg'),
(4, 'Allison Argent', 'alliison@gmail.com', '4651d80cfa79f4933bc5408665394e9c', '2005-06-15', 'userprofile/_Ffn9436X0BwVTmx.jfif'),
(5, 'Max Mayfield', 'max@gmail.com', '2ffe4e77325d9a7152f7086ea7aa5114', '2007-02-21', 'userprofile/_Fe5iFCbWAAAbyKb.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `LessonID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `LessonTitle` varchar(255) NOT NULL,
  `VideoFile` varchar(255) NOT NULL,
  `LessonDescription` text NOT NULL,
  `UploadDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`LessonID`, `SectionID`, `LessonTitle`, `VideoFile`, `LessonDescription`, `UploadDate`) VALUES
(1, 1, 'Another one thank you', 'another one thank you.mp4', 'Why should Caesar just get to stomp around like a giant while the rest of us try not to get smushed under his big feet? Brutus is just as cute as Caesar, right? \r\nBrutus is just as smart as Caesar, people totally like Brutus just as much as they like Caesar,\r\n and when did it become okay for one person to be the boss of everybody because that\'s not what Rome is about! We should totally just STAB CAESAR!\r\n', '2022-11-12'),
(2, 8, 'Intro', 'Jennifer Hudson - insufficient funds, you aint GOT no money.mp4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis nunc vel aliquet vehicula. Suspendisse sollicitudin ac velit et aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interd', '2022-11-12'),
(3, 8, 'Gretchen Weiners is cracked', 'Anakin on Twitter- -Avengers 1 but Hawkeye misses every shot https-__t.co_05Qfn2jrWI- _ Twitter.mp4', 'Why should Caesar just get to stomp around like a giant while the rest of us try not to get smushed under his big feet? Brutus is just as cute as Caesar, right? Brutus is just as smart as Caesar, people totally like Brutus just as much as they like Caesar, and when did it become okay for one person to be the boss of everybody because that\'s not what Rome is about! We should totally just STAB CAESAR!', '2022-11-12'),
(4, 8, 'erewrew', 'Fallon Carrington being ICONIC for 7 minutes straight.mp4', 'wrewer', '2022-11-12'),
(6, 4, 'Never gonna give you up', 'Nicki Minaj once said.mp4', 'Fuck it yes i\'m in love with nate jacobs and he\'s in love with me \r\ndon\'t you fucking give me that look maddy because i didn\'t fuck your boyfriend\r\nyou two have broken up for 3 weeks and 3 days before we even had sex so i didn\'t betray you besides you guys are terrible for each other and you know i\'m right \r\nyou can all judge me if you want but i do not care cuz i\'ve never ever been happier\r\n', '2022-11-13'),
(7, 1, 'Lesson 2', 'Control -- Evil Queens.mp4', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '2022-11-14'),
(8, 1, 'Lesson 3', 'elizaᥫ᭡ on Twitter- -disappointed at the level of Cillian Murphy\'s disappointed face in an interview https-__t.co_jNhNGpv9yr- _ Twitter.mp4', 'oerjowjrewijworjeworewiojrwejirjeworij', '2022-11-14'),
(9, 10, 'Lesson 1/Section 1', 'Djungelskog 🇸🇪 ➐ on Twitter- -why is this a debate like Regina didn’t literally cause an entire school to riot just because she gained 10 pounds https-__t.co_cquwKOcqkI- _ Twitter.mp4', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur adipisci[ng] velit, sed quia non numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum[d] exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? [D]Quis autem vel eum i[r]ure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, ', '2022-11-14'),
(10, 10, 'Lesson 2: Ghost hunting with the kardashians', 'Nicki Minaj As A Ghost Hunter With The Kardashians.mp4', 'iwjrwjeroiwejroewijroweijrewiojrewoirewrew', '2022-11-15'),
(11, 3, 'idk', 'Michael Warburton on Twitter- -Teachers. You cannot pay them enough.👏🏻https-__t.co_4WquoDGtK0- _ Twitter.mp4', 'jieojoiewjriwjeorewr', '2022-11-15'),
(12, 12, 'when the choir teacher\'s gone', 'When the choir teacher\'s gone....mp4', 'rewrwerewr', '2022-11-15'),
(13, 5, 'Lesson 1', 'Bri🌸⁷ on Twitter- -WAit cause this is exactly how it is 😭😭😭😭😭 https-__t.co_DuAGLxBta5- _ Twitter.mp4', 'Cypher', '2022-11-17'),
(14, 13, 'Lesson 1: Introduction', 'Kylie Gets Schooled by Her Sisters (Kardashians Spoof).mp4', 'aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magn', '2022-11-17'),
(15, 14, 'How to make delicious pasta at home', 'Jade West yelling for a minute and 52 seconds straight.mp4', 'jrejiorjeiowrjw', '2022-11-17'),
(16, 15, 'Lesson 1', 'Chicken version filter.mp4', 'sum dolor sit amet, consectetur adipiscing elit. Nunc venenatis nunc vel aliquet vehicula. Suspendisse sollicitudin ac velit et aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magna nisi, interdum nec auctor sit amet, ornare quis tellu', '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `PurchaseID` int(11) NOT NULL,
  `LearnerID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `PurchaseDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PurchaseID`, `LearnerID`, `CourseID`, `PurchaseDate`) VALUES
(1, 2, 2, '2022-11-15'),
(2, 1, 2, '2022-11-15'),
(3, 1, 6, '2022-11-15'),
(5, 1, 3, '2022-11-15'),
(6, 1, 2, '2022-11-16'),
(9, 2, 3, '2022-11-16'),
(10, 2, 4, '2022-11-17'),
(11, 3, 3, '2022-11-17'),
(12, 2, 7, '2022-11-17'),
(13, 2, 6, '2022-11-28'),
(14, 5, 2, '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `LearnerID` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL,
  `AskedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `LessonID`, `LearnerID`, `Question`, `AskedDate`) VALUES
(1, 12, 2, 'are you gay?', '2022-11-17'),
(2, 7, 2, 'So..if you\'re from Africa, why are you white?', '2022-11-18'),
(3, 7, 2, 'blahh blahh', '2022-11-18'),
(4, 7, 2, 'ayo wassup', '2022-11-18'),
(5, 1, 2, 'I don\'t do cocainee...i don\'t know what it looks like ', '2022-11-18'),
(6, 3, 1, 'Boo', '2022-11-18'),
(7, 2, 2, 'Can i get a waffle?', '2022-11-18'),
(8, 1, 1, 'hellooo', '2022-11-18'),
(9, 4, 1, 'never gonna give you up', '2022-11-18'),
(10, 9, 2, 'But you\'re like really pretty', '2022-11-18'),
(11, 4, 3, 'Never gonna run around and...', '2022-11-18'),
(12, 6, 2, 'Wassup', '2022-11-18'),
(13, 14, 2, 'hi', '2022-11-18'),
(14, 4, 2, 'What are the variables?', '2022-11-18'),
(15, 1, 5, 'hello', '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `ratingsandreviews`
--

CREATE TABLE `ratingsandreviews` (
  `RRID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LearnerID` int(11) NOT NULL,
  `Scale` int(11) NOT NULL,
  `Review` text NOT NULL,
  `RRDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratingsandreviews`
--

INSERT INTO `ratingsandreviews` (`RRID`, `CourseID`, `LearnerID`, `Scale`, `Review`, `RRDate`) VALUES
(1, 2, 2, 4, 'good courses! keep going', '2022-11-01'),
(2, 3, 2, 5, 'This is amazing', '2022-11-01'),
(3, 3, 2, 4, 'dfwerewr', '2022-11-01'),
(4, 2, 1, 5, 'great course', '2022-11-02'),
(5, 6, 1, 5, 'nice course btw', '2022-11-02'),
(6, 3, 3, 4, 'Good course', '2022-11-02'),
(7, 3, 3, 1, 'hfiheir', '2022-11-02'),
(8, 2, 2, 4, 'love that', '2022-11-28'),
(9, 2, 5, 5, 'hellooo', '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `ReplyID` int(11) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `Reply` text NOT NULL,
  `ReplyDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`ReplyID`, `QuestionID`, `Reply`, `ReplyDate`) VALUES
(1, 1, 'yes', '2022-11-17'),
(2, 2, 'Oh my god karen, you can\'t just ask people why they\'re white', '2022-11-18'),
(3, 3, 'blah', '2022-11-18'),
(4, 2, 'sferewr', '2022-11-18'),
(5, 4, 'wassup', '2022-11-18'),
(7, 8, 'byeee', '2022-11-18'),
(8, 7, 'no :)', '2022-11-18'),
(9, 9, 'never gonna let you down', '2022-11-18'),
(11, 11, 'desert you', '2022-11-18'),
(12, 12, 'wassup', '2022-11-18'),
(13, 10, 'so you agree? you think you\'re really pretty?', '2022-11-18'),
(15, 13, 'hellooo', '2022-11-18'),
(16, 5, 'um chile', '2022-11-18'),
(17, 15, 'hi', '2022-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `SectionID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `SectionTitle` varchar(255) NOT NULL,
  `SectionDescription` text NOT NULL,
  `SectionMaterial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`SectionID`, `CourseID`, `SectionTitle`, `SectionDescription`, `SectionMaterial`) VALUES
(1, 2, 'Genie', 'wirjowejriewrjoewirjoewjrweior', 'Student HandBook (January 2022 Intake).pdf'),
(2, 2, 'Pilot', 'rwerwewrwererw', NULL),
(3, 2, 'Chapter 3', 'weerwewwrerweerwe', NULL),
(4, 6, 'Deathly Hallows', 'How do I even begin\r\n\r\nto explain Regina George?\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nRegina George is flawless.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nShe has two Fendi purses\r\n\r\nand a silver Lexus.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nI hear her hair\'s insured\r\n\r\nfor $.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nI hear she does car commercials.\r\n\r\nIn Japan.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nHer favorite movie is Varsity blues.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nOne time, she met John Stamos\r\n\r\non a plane.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nAnd he told her she was pretty.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nOne time,\r\n\r\nshe punched me in the face.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nIt was awesome.', 'HCI Comp (1650).pdf'),
(5, 6, 'I lost the count to sections', 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagittis ac posuere libero. Cras orci purus, varius ac magna in, maximus lacinia purus. Fusce ullamcorper elit vitae elit eleifend accumsan. Nullam vehicula lacus eget sodales efficitur.', 'Harry-potter-sorcerers-stone.pdf'),
(6, 6, 'Apple bottom Jean', 'Boots with the fur', NULL),
(7, 6, 'eewrwe', 'erewewr', NULL),
(8, 3, 'chapter 1', 'Fuck it yes i\'m in love with nate jacobs and he\'s in love with me \r\ndon\'t you fucking give me that look maddy because i didn\'t fuck your boyfriend\r\nyou two have broken up for 3 weeks and 3 days before we even had sex so i didn\'t betray you besides you guys are terrible for each other and you know i\'m right \r\nyou can all judge me if you want but i do not care cuz i\'ve never ever been happier', NULL),
(9, 6, 'ojerweirwoej', 'joeirjwiejroiwje', 'Academic Misconduct (English Version).pdf'),
(10, 4, 'Section 1', 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur adipisci[ng] velit, sed quia non numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum[d] exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? [D]Quis autem vel eum i[r]ure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? [33] At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'Second term project.docx'),
(11, 4, 'Goblet of Fire', 'ya a wizard harry', 'Prototoype (1).zip'),
(12, 2, 'Naur i\'m a star', 'werrewrewrewwer', NULL),
(13, 7, 'Section 1: Pilot', 'In gravida, mauris quis tincidunt egestas, felis diam ultricies ante, iaculis porta urna purus eu nunc. Nunc ornare id urna id rutrum. Mauris scelerisque ullamcorper nulla ac rhoncus. Vestibulum eget nunc auctor, interdum nunc vitae, vulputate nisi. Nunc neque libero, aliquam commodo magna sit amet, tempor consectetur eros. Aenean tempus venenatis arcu, non vulputate sapien semper quis. Ut dictum justo urna, vel efficitur nisl egestas a. Morbi sit amet nisi at eros cursus sagitti', 'Creating a custom page with SharePoint Designer 2013.pdf'),
(14, 2, 'Pasta making', 'fiofioewjriewjjewireor', NULL),
(15, 9, 'Section 1', 'sum dolor sit amet, consectetur adipiscing elit. Nunc venenatis nunc vel aliquet vehicula. Suspendisse sollicitudin ac velit et aliquam. Integer convallis iaculis ipsum, ut vehicula orci iaculis nec. Mauris feugiat scelerisque diam, nec pharetra felis auctor sit amet. Integer in erat ultricies massa volutpat tincidunt. Ut metus tortor, blandit ac scelerisque a, feugiat non dolor. Phasellus pulvinar nisl et eros dapibus, nec feugiat risus luctus. Pellentesque sodales mauris a leo mollis, vel imperdiet dolor egestas. Donec vitae suscipit nisi. Nullam euismod viverra massa, ut maximus sapien blandit in. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla condimentum in justo in suscipit. Praesent magna nisi, interdum nec auctor sit amet, ornare quis tellu', 'LearnJava.pdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `CategoryID` (`CategoryID`,`InstructorID`),
  ADD KEY `InstructorID` (`InstructorID`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`InstructorID`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
  ADD PRIMARY KEY (`LearnerID`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`LessonID`),
  ADD KEY `SectionID` (`SectionID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `LearnerID` (`LearnerID`,`CourseID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `LessonID` (`LessonID`,`LearnerID`),
  ADD KEY `LearnerID` (`LearnerID`);

--
-- Indexes for table `ratingsandreviews`
--
ALTER TABLE `ratingsandreviews`
  ADD PRIMARY KEY (`RRID`),
  ADD KEY `CourseID` (`CourseID`,`LearnerID`),
  ADD KEY `LearnerID` (`LearnerID`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`ReplyID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `QuestionID_2` (`QuestionID`),
  ADD KEY `QuestionID_3` (`QuestionID`),
  ADD KEY `QuestionID_4` (`QuestionID`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`SectionID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `InstructorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
  MODIFY `LearnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `LessonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `PurchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ratingsandreviews`
--
ALTER TABLE `ratingsandreviews`
  MODIFY `RRID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `ReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `SectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`InstructorID`) REFERENCES `instructors` (`InstructorID`);

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`SectionID`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`LearnerID`) REFERENCES `learners` (`LearnerID`),
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`LearnerID`) REFERENCES `learners` (`LearnerID`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`LessonID`) REFERENCES `lessons` (`LessonID`);

--
-- Constraints for table `ratingsandreviews`
--
ALTER TABLE `ratingsandreviews`
  ADD CONSTRAINT `ratingsandreviews_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `ratingsandreviews_ibfk_2` FOREIGN KEY (`LearnerID`) REFERENCES `learners` (`LearnerID`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
