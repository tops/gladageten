-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(10) unsigned NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phonenumber` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bookings` (`id`, `room_id`, `fromdate`, `todate`, `fullname`, `phonenumber`, `email`) VALUES
(1,	1,	'2017-01-24',	'2017-01-26',	'Tobias',	'1209312309',	'tobias@qlok.se'),
(2,	1,	'2017-02-01',	'2017-02-02',	'Erik',	'12093i123',	'lkasndlkasnd'),
(3,	6,	'2017-01-24',	'2017-01-25',	'Anna',	'1209312+0389',	'lkasmdlasmd'),
(4,	4,	'2017-01-24',	'2017-01-27',	'dsasd',	'klmlkm',	'lkmlkm');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pages` (`id`, `name`, `content`) VALUES
(1,	'start',	'<h1>Välkommen!</h1>\r\n		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eros arcu, dignissim ac iaculis sit amet, scelerisque id ipsum. Sed ornare vulputate purus sed molestie. Nam interdum elit sed diam dignissim, sit amet lacinia leo finibus. Nam vulputate efficitur tortor, vel vehicula massa tristique ac. Sed ut elit semper, ultrices mauris vitae, gravida metus. Donec nec vulputate sem, ut condimentum ante. Nullam auctor odio dui, eu molestie augue convallis vel.</p>\r\n\r\n		<h2>Bo lantligt men modernt</h2>\r\n		<p>Nam volutpat lobortis tellus, non luctus lorem commodo eu. Aliquam non fermentum metus. Pellentesque dictum risus in semper accumsan. Curabitur facilisis, mi vel malesuada volutpat, nunc sapien ultricies erat, ut hendrerit arcu sem eget nisi. Sed eu dictum enim, id malesuada nisl. Morbi eu quam diam. Aliquam ut consectetur ligula. Aliquam accumsan ipsum ligula, ut porttitor nulla dictum a. Curabitur vitae dignissim tellus. Nunc in posuere odio, ut sodales augue. Quisque vel feugiat sapien. Etiam mauris sem, mollis nec accumsan et, laoreet ut nibh.</p>\r\n\r\n		<p>Duis augue est, tristique vel odio nec, suscipit tempor nisl. Duis mollis gravida nisl et rhoncus. Integer eleifend dapibus quam ac porttitor. Aliquam risus sem, venenatis quis commodo ut, euismod id ex. Aenean eu leo vel nisi vulputate convallis a at velit. Sed in commodo diam. Proin sit amet dolor lorem. Ut sed odio justo. Etiam faucibus, odio ac aliquet faucibus, sapien velit consequat mauris, eget hendrerit neque leo ullamcorper nisi. Fusce sit amet eros dui. Nulla vestibulum libero ut turpis vulputate varius. Quisque eleifend sem neque, vitae dictum enim iaculis in. Donec lacus quam, ullamcorper sit amet scelerisque in, ornare ac nunc.</p>\r\n\r\n		<p>Morbi varius eu dolor sed condimentum. Vivamus eget lectus sed turpis iaculis bibendum. Aliquam pellentesque risus arcu, at cursus nisi semper quis. Quisque placerat maximus quam, quis vestibulum arcu pretium quis. Nam quis nunc nibh. Duis id lacus id quam tincidunt molestie. Nunc laoreet ultrices erat, eu cursus eros. Aliquam risus arcu, fermentum non ultrices non, imperdiet et ligula. Cras sit amet ipsum sit amet est luctus fermentum. Praesent elit quam, porta sed egestas eget, fermentum nec tellus. Proin vitae rutrum metus. Etiam aliquet nibh placerat, pellentesque felis et, venenatis enim.</p>'),
(2,	'contact',	'<h1>Kontakta oss</h1>\r\n\r\nHej hej'),
(3,	'activities',	'<h1>Aktiviteter</h1>');

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rooms` (`id`, `name`, `description`, `type`) VALUES
(1,	'Lilla rummet',	'Det här är vårt minsta rum.',	'Enkelrum'),
(2,	'Gula rummet',	'Ett rum helt i gult för dig som bor själv.',	'Enkelrum'),
(3,	'Blå rummet',	'Ett rum helt i blått!',	'Enkelrum'),
(4,	'Dubberummet',	'Ett rum för två',	'Dubbelrum'),
(5,	'Dubbeldelux',	'Ett lyxigare dubbelrum',	'Dubbelrum'),
(6,	'Presidentsviten',	'Lyx, lyx och mer lyx för två!',	'Dubbelrum'),
(7,	'Familjerummet',	'Ett rum för hela familjen',	'Familjerum'),
(8,	'Sagorummet',	'Ett rum fyllt av sagor...',	'Familjerum');

-- 2017-01-24 16:00:05