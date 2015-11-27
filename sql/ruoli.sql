/*
Navicat MySQL Data Transfer

Source Server         : DB-192.168.0.20
Source Server Version : 50173
Source Host           : 192.168.0.20:3306
Source Database       : PersStraordinari

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2015-11-27 13:06:51
*/

SET FOREIGN_KEY_CHECKS=0;

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
-- Records of ruoli
-- ----------------------------
INSERT INTO `ruoli` VALUES ('0', '');
INSERT INTO `ruoli` VALUES ('1', 'dipendente');
INSERT INTO `ruoli` VALUES ('2', 'dirigente');
INSERT INTO `ruoli` VALUES ('3', 'Ufficio del Personale');
