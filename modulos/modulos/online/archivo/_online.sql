
CREATE TABLE IF NOT EXISTS `online` (
`idonline` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tiempo` int(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3525 DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `usuario` (
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `fotografia` varchar(200) NOT NULL DEFAULT 'default.jpg',
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `online`
 ADD PRIMARY KEY (`idonline`), ADD KEY `email` (`email`);

ALTER TABLE `usuario`
 ADD PRIMARY KEY (`email`);

ALTER TABLE `online`
MODIFY `idonline` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3525;

ALTER TABLE `online`
ADD CONSTRAINT `online_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
