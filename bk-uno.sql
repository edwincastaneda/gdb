/*
SQLyog Community v12.02 (64 bit)
MySQL - 5.6.20 : Database - gdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gdb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `gdb`;

/*Table structure for table `asigna_permisos` */

DROP TABLE IF EXISTS `asigna_permisos`;

CREATE TABLE `asigna_permisos` (
  `id_perfiles` int(10) DEFAULT NULL,
  `id_permisos` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `asigna_permisos` */

insert  into `asigna_permisos`(`id_perfiles`,`id_permisos`) values (1,23),(1,21),(1,20),(1,15),(1,14),(1,12),(1,11),(1,10),(1,9),(1,8),(1,7),(4,3),(4,2),(4,1),(6,3),(1,25),(1,22),(2,17),(2,13),(1,16),(1,6),(1,5),(1,4),(1,19),(1,18),(1,17),(1,13),(1,3),(1,2),(1,1),(1,24);

/*Table structure for table `grupos` */

DROP TABLE IF EXISTS `grupos`;

CREATE TABLE `grupos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_facilitador` int(10) DEFAULT NULL,
  `id_lider` int(10) DEFAULT NULL,
  `anfitrion` varchar(200) DEFAULT NULL,
  `direccion` text,
  `telefono` varchar(8) DEFAULT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `hora_inicia` varchar(20) DEFAULT NULL,
  `hora_finaliza` varchar(20) DEFAULT NULL,
  `directrices` text,
  `transporte` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `grupos` */

insert  into `grupos`(`id`,`id_facilitador`,`id_lider`,`anfitrion`,`direccion`,`telefono`,`dia`,`hora_inicia`,`hora_finaliza`,`directrices`,`transporte`) values (1,1,3,'Hector','zona 3','23433212','Miércoles','12 AM','12:20 PM','asd',' asAS'),(2,1,3,'Josue','zona 7','44553412','Miércoles','03:10 AM','12:05 AM','dddd','sss');

/*Table structure for table `opciones` */

DROP TABLE IF EXISTS `opciones`;

CREATE TABLE `opciones` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `ruta_php` varchar(100) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `descripcion` text,
  `imagen_icono` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `opciones` */

insert  into `opciones`(`id`,`nombre`,`titulo`,`ruta_php`,`tipo`,`descripcion`,`imagen_icono`) values (1,'usuarios','Usuarios','pages/usuarios.php',1,'Gestión de los usuarios del sistema.','usuarios.png'),(2,'opciones','Opciones','pages/opciones.php',1,'Catalogo de páginas, botones y acciones de tablade datos dentro del sistema para ser asignados a los perfiles.','opciones.png'),(3,'perfiles','Perfiles','pages/perfiles.php',1,'Gestiona los perfiles para los usuarios del sistema.','perfil.png'),(4,'ver','Ver','pages/usuarios.php',2,'Permite modificar la información de un usuario seleccionado.','eye-open'),(5,'ver','Ver','pages/perfiles.php',2,'Permite modificar la información y permisos de los perfiles.','eye-open'),(6,'ver','Ver','pages/opciones.php',2,'Permite agregar perfiles.','eye-open'),(7,'actualizar','Actualizar','pages/opciones.php',3,'Actualiza opcion\r\n','floppy-disk'),(8,'guardar','Guardar','pages/opciones.php',3,'Guarda nuevo opcion','floppy-disk'),(9,'actualizar','Actualizar','pages/usuarios.php',3,'Actualiza Usuario','floppy-disk'),(10,'guardar','Guardar','pages/usuarios.php',3,'Guarda usuario nuevo','floppy-disk'),(11,'actualizar','Actualizar','pages/perfiles.php',3,'Actualiza perfil','floppy-disk'),(12,'guardar','Guardar','pages/perfiles.php',3,'Guarda nuevo perfil','floppy-disk'),(13,'servidores','Servidores','pages/servidores.php',1,'Catálogo de servidores para utilizar en el sistema.','servidores.png'),(14,'guardar','Guardar','pages/servidores.php',3,' ','eye-open'),(15,'actualizar','Actualizar','pages/servidores.php',3,' ','floppy-disk'),(16,'ver','Ver','pages/servidores.php',2,' ','eye-open'),(17,'grupos','Grupos','pages/grupos.php',1,'Catálogo de grupos.','grupo.png'),(18,'registrar-actividad','Registrar Actividad','pages/registrar-actividad.php',1,'Registrar las actividades de los grupos.','registrar.png'),(19,'reportes','Reportes','pages/reportes.php',1,'Reporteador del sistema.','reportes.png'),(20,'guardar','Guardar','pages/grupos.php',3,' ','floppy-disk'),(21,'actualizar','Actualizar','pages/grupos.php',3,' ','floppy-disk'),(22,'ver','Ver','pages/grupos.php',2,'fddf','eye-open'),(23,'guardar','Guardar','pages/registrar-actividad.php',3,' ','floppy-disk'),(24,'actualizar','Actualizar','pages/registrar-actividad.php',3,' ','floppy-disk'),(25,'ver','Ver','pages/registrar-actividad.php',2,' ','eye-open');

/*Table structure for table `perfiles` */

DROP TABLE IF EXISTS `perfiles`;

CREATE TABLE `perfiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `perfiles` */

insert  into `perfiles`(`id`,`nombre`,`descripcion`) values (1,'Super Administrador','Funcionalidad Global del Sistema'),(2,'Usuario','Usuario del sistema'),(14,'Líder de Grupo','Registra actividad de grupo');

/*Table structure for table `registrar_actividad` */

DROP TABLE IF EXISTS `registrar_actividad`;

CREATE TABLE `registrar_actividad` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `asistentes` int(10) DEFAULT NULL,
  `invitados` int(10) DEFAULT NULL,
  `salvos` int(10) DEFAULT NULL,
  `ofrenda` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `registrar_actividad` */

insert  into `registrar_actividad`(`id`,`id_grupo`,`fecha`,`asistentes`,`invitados`,`salvos`,`ofrenda`) values (1,1,'0000-00-00',3,3,1,100),(2,1,'2014-11-28',1,1,1,30);

/*Table structure for table `servidores` */

DROP TABLE IF EXISTS `servidores`;

CREATE TABLE `servidores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(400) DEFAULT NULL,
  `apellidos` varchar(400) DEFAULT NULL,
  `telefono` varchar(8) DEFAULT NULL,
  `celular` varchar(8) DEFAULT NULL,
  `email` varchar(400) DEFAULT NULL,
  `direccion` text,
  `tipo` tinyint(1) DEFAULT NULL,
  `id_facilitador` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `servidores` */

insert  into `servidores`(`id`,`nombres`,`apellidos`,`telefono`,`celular`,`email`,`direccion`,`tipo`,`id_facilitador`) values (1,'Edwin','Castañeda','22868316','42204195','winedcasta@hotmail.com','28 calle B zona 6',3,0),(2,'Débora','Villagrán','22998833','44444444','dmvillagran@gmail.com','zona 16',1,0),(3,'Juan','Lucas','45788945','12455678','juan@gmail.com','zona 6',2,1);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `id_perfil` int(10) NOT NULL,
  PRIMARY KEY (`id`,`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`nombre`,`contrasena`,`id_perfil`) values (1,'admin','53a7d68451579f6b62ebc36c0401322f',1),(2,'otro','3760ee6b2c91c54411bf79df5adf6f48',4),(3,'Lider de Grupo','cee8d6b7ce52554fd70354e37bbf44a2',14);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
