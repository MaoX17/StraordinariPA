/*
Navicat MySQL Data Transfer

Source Server         : DB-192.168.0.20
Source Server Version : 50173
Source Host           : 192.168.0.20:3306
Source Database       : PersStraordinari

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2015-11-27 12:36:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for aree
-- ----------------------------
DROP TABLE IF EXISTS `aree`;
CREATE TABLE `aree` (
  `id_area` int(4) NOT NULL AUTO_INCREMENT,
  `area` varchar(300) NOT NULL,
  `id_dirigente` int(4) NOT NULL,
  `note` varchar(254) DEFAULT NULL,
  `abilitato` varchar(1) NOT NULL,
  `titolare_area` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'S o N',
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id_log` int(4) NOT NULL AUTO_INCREMENT,
  `id_utente` int(4) NOT NULL,
  `id_straord` int(6) NOT NULL,
  `data_ora` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operazione` varchar(100) NOT NULL,
  `ip_sorgente` varchar(15) NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=9948 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ruoli
-- ----------------------------
DROP TABLE IF EXISTS `ruoli`;
CREATE TABLE `ruoli` (
  `id_ruolo` int(4) NOT NULL AUTO_INCREMENT,
  `ruolo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_ruolo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for straordinari
-- ----------------------------
DROP TABLE IF EXISTS `straordinari`;
CREATE TABLE `straordinari` (
  `id_straordinario` int(6) NOT NULL AUTO_INCREMENT,
  `id_utente` int(4) NOT NULL,
  `id_area` int(4) NOT NULL,
  `data_richiesta` date NOT NULL,
  `orainizio` time NOT NULL,
  `orafine` time NOT NULL,
  `motivazione` varchar(254) NOT NULL,
  `pagamento_recupero` varchar(1) NOT NULL,
  `data_approvazione` date DEFAULT NULL,
  `approvato` varchar(1) DEFAULT NULL,
  `note_dirigente` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id_straordinario`),
  UNIQUE KEY `index_uniq_01` (`id_utente`,`data_richiesta`,`approvato`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3139 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for utenti
-- ----------------------------
DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `id_utente` int(4) NOT NULL AUTO_INCREMENT,
  `id_ruolo` int(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `cognome_nome` varchar(60) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_utente`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;
