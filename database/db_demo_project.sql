/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 80031 (8.0.31)
 Source Host           : localhost:3306
 Source Schema         : db_demo_project

 Target Server Type    : MySQL
 Target Server Version : 80031 (8.0.31)
 File Encoding         : 65001

 Date: 21/06/2024 15:56:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_url
-- ----------------------------
DROP TABLE IF EXISTS `tb_url`;
CREATE TABLE `tb_url`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `original_url` varchar(255) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `short_code` varchar(255) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `create_date` datetime NULL DEFAULT NULL,
  `isenabled` varchar(1) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = tis620 COLLATE = tis620_thai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_url
-- ----------------------------
INSERT INTO `tb_url` VALUES (1, 'https://www.google.com/', 'dA4Mhv', 2, '2024-06-21 15:54:28', 'Y');
INSERT INTO `tb_url` VALUES (2, 'https://www.microsoft.com/th-th/microsoft-365/outlook/web-email-login-for-outlook', 'SRGOOU', 2, '2024-06-21 15:55:12', 'Y');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `password_hash` varchar(100) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL,
  `user_type` varchar(1) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL COMMENT 'A=Admin/U=User',
  `isenabled` varchar(1) CHARACTER SET tis620 COLLATE tis620_thai_ci NULL DEFAULT NULL COMMENT 'Y=Active/N=Inactive',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = tis620 COLLATE = tis620_thai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES (1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$3suLgT3dUBpUEKtmCToe4e.xkKzPgskiL9S69zZx36dBgt65sV/dS', 'A', 'Y');
INSERT INTO `tb_user` VALUES (2, 'user test', 'usertest', 'usertest@gmail.com', '$2y$10$3suLgT3dUBpUEKtmCToe4e.xkKzPgskiL9S69zZx36dBgt65sV/dS', 'U', 'Y');

SET FOREIGN_KEY_CHECKS = 1;
