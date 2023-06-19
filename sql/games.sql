
CREATE DATABASE GamesReleases;
GRANT USAGE ON *.* TO 'majeed'@'localhost' IDENTIFIED BY 'mypass123';
GRANT ALL PRIVILEGES ON GamesReleases.* TO 'majeed'@'localhost';
FLUSH PRIVILEGES;

USE GamesReleases;
--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `release_date` date NOT NULL,
    `platforms` varchar(255) NOT NULL,
    `cover` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `release_date`, `platforms`, `cover`) VALUES
(1, 'Dying Light 2 Stay Human', '2022-02-04', 'PC, PS4, PS5, Stadia, Xbox One, and Xbox Series X/S', 'imgs/Dying_Light_2.jpg'),
(2, 'Horizon Forbidden West', '2022-02-18', 'PS4 and PS5', 'imgs/Horizon_Forbidden_West.jpg'),
(3, 'Elden Ring', '2022-02-25', 'PC, PS4, PS5, Xbox One, and Xbox Series X/S', 'imgs/Elden_Ring.jpg'),
(4, 'Saints Row', '2022-08-23', 'PC, PS4, PS5, Xbox One, and Xbox Series X/S', 'imgs/Saints_Row.jpg');

