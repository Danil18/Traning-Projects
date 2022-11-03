-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 10 2022 г., 01:23
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sweater`
--

-- --------------------------------------------------------

--
-- Структура таблицы `flyway_schema_history`
--

DROP TABLE IF EXISTS `flyway_schema_history`;
CREATE TABLE IF NOT EXISTS `flyway_schema_history` (
  `installed_rank` int(11) NOT NULL,
  `version` varchar(50) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `script` varchar(1000) NOT NULL,
  `checksum` int(11) DEFAULT NULL,
  `installed_by` varchar(100) NOT NULL,
  `installed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `execution_time` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`installed_rank`),
  KEY `flyway_schema_history_s_idx` (`success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flyway_schema_history`
--

INSERT INTO `flyway_schema_history` (`installed_rank`, `version`, `description`, `type`, `script`, `checksum`, `installed_by`, `installed_on`, `execution_time`, `success`) VALUES
(1, '1', 'Init DB', 'SQL', 'V1__Init_DB.sql', 1318075049, 'root', '2022-09-17 03:04:56', 1144, 1),
(2, '2', 'Add admin', 'SQL', 'V2__Add_admin.sql', 1774556276, 'root', '2022-09-17 03:07:34', 4, 1),
(3, '3', 'Add subscriptions table', 'SQL', 'V3__Add_subscriptions_table.sql', 98971434, 'root', '2022-09-23 07:33:08', 223, 1),
(4, '4', 'Add message likes', 'SQL', 'V4__Add_message_likes.sql', 1044778455, 'root', '2022-09-24 13:30:56', 153, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hibernate_sequence`
--

DROP TABLE IF EXISTS `hibernate_sequence`;
CREATE TABLE IF NOT EXISTS `hibernate_sequence` (
  `next_val` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hibernate_sequence`
--

INSERT INTO `hibernate_sequence` (`next_val`) VALUES
(16);

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `text` varchar(2048) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_user_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `filename`, `tag`, `text`, `user_id`) VALUES
(1, NULL, 'some tag1', 'Some new message1', 1),
(6, NULL, 'none', 'Русский текст', 2),
(7, NULL, 'img', 'Image', 2),
(8, NULL, 'some', 'new one', 2),
(9, NULL, 'noimg', 'Что-нибудь про что-то', 2),
(10, NULL, 'Мэил', 'Сообщение', 2),
(11, NULL, 'img', 'Some new message image', 2),
(12, NULL, 'new', 'Что-то новенькое', 2),
(13, NULL, 'russian text', 'Русский текст', 2),
(14, NULL, 'none', 'Очередное сообщение', 2),
(15, NULL, 'img', 'Another', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `message_likes`
--

DROP TABLE IF EXISTS `message_likes`;
CREATE TABLE IF NOT EXISTS `message_likes` (
  `user_id` bigint(20) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message_likes`
--

INSERT INTO `message_likes` (`user_id`, `message_id`) VALUES
(1, 6),
(1, 8),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(2, 7),
(2, 15),
(3, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `spring_session`
--

DROP TABLE IF EXISTS `spring_session`;
CREATE TABLE IF NOT EXISTS `spring_session` (
  `PRIMARY_ID` char(36) NOT NULL,
  `SESSION_ID` char(36) NOT NULL,
  `CREATION_TIME` bigint(20) NOT NULL,
  `LAST_ACCESS_TIME` bigint(20) NOT NULL,
  `MAX_INACTIVE_INTERVAL` int(11) NOT NULL,
  `EXPIRY_TIME` bigint(20) NOT NULL,
  `PRINCIPAL_NAME` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PRIMARY_ID`),
  UNIQUE KEY `SPRING_SESSION_IX1` (`SESSION_ID`),
  KEY `SPRING_SESSION_IX2` (`EXPIRY_TIME`),
  KEY `SPRING_SESSION_IX3` (`PRINCIPAL_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `spring_session`
--

INSERT INTO `spring_session` (`PRIMARY_ID`, `SESSION_ID`, `CREATION_TIME`, `LAST_ACCESS_TIME`, `MAX_INACTIVE_INTERVAL`, `EXPIRY_TIME`, `PRINCIPAL_NAME`) VALUES
('7e0e94bd-4aab-4646-b0a0-45a1146334c0', '7671aaee-7916-4d79-a4cb-e2d2c1a09ce0', 1664028950783, 1664031610908, 1800, 1664033410908, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `spring_session_attributes`
--

DROP TABLE IF EXISTS `spring_session_attributes`;
CREATE TABLE IF NOT EXISTS `spring_session_attributes` (
  `SESSION_PRIMARY_ID` char(36) NOT NULL,
  `ATTRIBUTE_NAME` varchar(200) NOT NULL,
  `ATTRIBUTE_BYTES` blob NOT NULL,
  PRIMARY KEY (`SESSION_PRIMARY_ID`,`ATTRIBUTE_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `spring_session_attributes`
--

INSERT INTO `spring_session_attributes` (`SESSION_PRIMARY_ID`, `ATTRIBUTE_NAME`, `ATTRIBUTE_BYTES`) VALUES
('7e0e94bd-4aab-4646-b0a0-45a1146334c0', 'org.springframework.security.web.csrf.HttpSessionCsrfTokenRepository.CSRF_TOKEN', 0xaced0005737200366f72672e737072696e676672616d65776f726b2e73656375726974792e7765622e637372662e44656661756c7443737266546f6b656e5aefb7c82fa2fbd50200034c000a6865616465724e616d657400124c6a6176612f6c616e672f537472696e673b4c000d706172616d657465724e616d6571007e00014c0005746f6b656e71007e0001787074000c582d435352462d544f4b454e7400055f6373726674002464333563613232312d613833352d346238322d393063342d643064336633643031663431),
('7e0e94bd-4aab-4646-b0a0-45a1146334c0', 'SPRING_SECURITY_CONTEXT', 0xaced00057372003d6f72672e737072696e676672616d65776f726b2e73656375726974792e636f72652e636f6e746578742e5365637572697479436f6e74657874496d706c000000000000023a0200014c000e61757468656e7469636174696f6e7400324c6f72672f737072696e676672616d65776f726b2f73656375726974792f636f72652f41757468656e7469636174696f6e3b78707372004f6f72672e737072696e676672616d65776f726b2e73656375726974792e61757468656e7469636174696f6e2e557365726e616d6550617373776f726441757468656e7469636174696f6e546f6b656e000000000000023a0200024c000b63726564656e7469616c737400124c6a6176612f6c616e672f4f626a6563743b4c00097072696e636970616c71007e0004787200476f72672e737072696e676672616d65776f726b2e73656375726974792e61757468656e7469636174696f6e2e416273747261637441757468656e7469636174696f6e546f6b656ed3aa287e6e47640e0200035a000d61757468656e746963617465644c000b617574686f7269746965737400164c6a6176612f7574696c2f436f6c6c656374696f6e3b4c000764657461696c7371007e0004787001737200266a6176612e7574696c2e436f6c6c656374696f6e7324556e6d6f6469666961626c654c697374fc0f2531b5ec8e100200014c00046c6973747400104c6a6176612f7574696c2f4c6973743b7872002c6a6176612e7574696c2e436f6c6c656374696f6e7324556e6d6f6469666961626c65436f6c6c656374696f6e19420080cb5ef71e0200014c00016371007e00067870737200136a6176612e7574696c2e41727261794c6973747881d21d99c7619d03000149000473697a657870000000027704000000027e72001f636f6d2e6578616d706c652e737765617465722e6d6f64656c732e526f6c6500000000000000001200007872000e6a6176612e6c616e672e456e756d00000000000000001200007870740004555345527e71007e000e74000541444d494e7871007e000d737200486f72672e737072696e676672616d65776f726b2e73656375726974792e7765622e61757468656e7469636174696f6e2e57656241757468656e7469636174696f6e44657461696c73000000000000023a0200024c000d72656d6f7465416464726573737400124c6a6176612f6c616e672f537472696e673b4c000973657373696f6e496471007e0015787074000f303a303a303a303a303a303a303a3174002430356461663265312d326261332d343739622d393961362d353536323731326235663430707372001f636f6d2e6578616d706c652e737765617465722e6d6f64656c732e55736572174a3a505176e12902000a5a00066163746976654c000e61637469766174696f6e436f646571007e00154c0005656d61696c71007e00154c000269647400104c6a6176612f6c616e672f4c6f6e673b4c00086d6573736167657374000f4c6a6176612f7574696c2f5365743b4c000870617373776f726471007e00154c0005726f6c657371007e001b4c000b737562736372696265727371007e001b4c000d737562736372697074696f6e7371007e001b4c0008757365726e616d6571007e00157870017074001b64616e696c2e66656f6b746973746f762e3937406d61696c2e72757372000e6a6176612e6c616e672e4c6f6e673b8be490cc8f23df0200014a000576616c7565787200106a6176612e6c616e672e4e756d62657286ac951d0b94e08b020000787000000000000000017372002f6f72672e68696265726e6174652e636f6c6c656374696f6e2e696e7465726e616c2e50657273697374656e745365748b47ef79d4c9917d0200014c000373657471007e001b7872003e6f72672e68696265726e6174652e636f6c6c656374696f6e2e696e7465726e616c2e416273747261637450657273697374656e74436f6c6c656374696f6e5718b75d8aba735402000b5a001b616c6c6f774c6f61644f7574736964655472616e73616374696f6e49000a63616368656453697a655a000564697274795a000e656c656d656e7452656d6f7665645a000b696e697469616c697a65645a000d697354656d7053657373696f6e4c00036b65797400164c6a6176612f696f2f53657269616c697a61626c653b4c00056f776e657271007e00044c0004726f6c6571007e00154c001273657373696f6e466163746f72795575696471007e00154c000e73746f726564536e617073686f7471007e0023787000ffffffff0000000071007e002071007e001c740028636f6d2e6578616d706c652e737765617465722e6d6f64656c732e557365722e6d6573736167657370707074003c243261243038246f56364b576f5a3356427541463379686561374f7975666832525050643530335a5872634a5774773176577756656b4c64756830577371007e002100ffffffff0000010071007e002071007e001c740025636f6d2e6578616d706c652e737765617465722e6d6f64656c732e557365722e726f6c657370737200116a6176612e7574696c2e486173684d61700507dac1c31660d103000246000a6c6f6164466163746f724900097468726573686f6c6478703f400000000000037708000000040000000271007e001071007e001071007e001271007e001278737200116a6176612e7574696c2e48617368536574ba44859596b8b7340300007870770c000000103f4000000000000271007e001071007e0012787371007e002100ffffffff0000000071007e002071007e001c74002b636f6d2e6578616d706c652e737765617465722e6d6f64656c732e557365722e73756273637269626572737070707371007e002100ffffffff0000000071007e002071007e001c74002d636f6d2e6578616d706c652e737765617465722e6d6f64656c732e557365722e737562736372697074696f6e7370707074000561646d696e);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `active` bit(1) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `activation_code`, `active`, `email`, `password`, `username`) VALUES
(1, NULL, b'1', 'danil.feoktistov.97@mail.ru', '$2a$08$oV6KWoZ3VBuAF3yhea7Oyufh2RPPd503ZXrcJWtw1vWwVekLduh0W', 'admin'),
(2, NULL, b'1', 'danil.feoktistov.97@mail.ru', '$2a$08$8oq3HZ1dNCSIGhcQ5qfCsurGyNs/IQyAXDAT4rtV6viJfQsjTKm9i', 'u'),
(3, NULL, b'1', 'danil.feoktistov.97@mail.ru', '$2a$08$OPKZ.fXCeJy1YL7Y9Tj55eqc3KwcqdKaQUd3EOWUL3FbKo6mcLCsy', 'u1'),
(4, NULL, b'1', 'danil.feoktistov.97@mail.ru', '$2a$08$d/poFAGPYp5Dsz2l.bbfO.vOMcQ31cYdzvKv6SWTQrFWzJo0g981a', 'u2'),
(5, NULL, b'1', 'danil.feoktistov.97@mail.ru', '$2a$08$0njhUg3xTJB4GqMlrfsYBeBVOq5HGyxP/F6fdOy7kllFc1K1g6nJu', 'u3');

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` bigint(20) NOT NULL,
  `roles` varchar(255) DEFAULT NULL,
  KEY `message_role_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`user_id`, `roles`) VALUES
(1, 'USER'),
(1, 'ADMIN'),
(2, 'USER'),
(3, 'USER'),
(4, 'USER'),
(5, 'USER');

-- --------------------------------------------------------

--
-- Структура таблицы `user_subscriptions`
--

DROP TABLE IF EXISTS `user_subscriptions`;
CREATE TABLE IF NOT EXISTS `user_subscriptions` (
  `channel_id` bigint(20) NOT NULL,
  `subscriber_id` bigint(20) NOT NULL,
  PRIMARY KEY (`channel_id`,`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`channel_id`, `subscriber_id`) VALUES
(1, 2),
(2, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `spring_session_attributes`
--
ALTER TABLE `spring_session_attributes`
  ADD CONSTRAINT `SPRING_SESSION_ATTRIBUTES_FK` FOREIGN KEY (`SESSION_PRIMARY_ID`) REFERENCES `spring_session` (`PRIMARY_ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `message_role_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;