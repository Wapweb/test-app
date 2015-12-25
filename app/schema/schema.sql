--
-- База данных: `test_app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `transaction_datetime` datetime NOT NULL,
  `transaction_amount` double NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `sender_id`, `recipient_id`, `transaction_datetime`, `transaction_amount`) VALUES
(1, 1, 4, '2015-12-25 17:42:15', 1000);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` bigint(16) NOT NULL,
  `card_cv2` int(3) NOT NULL,
  `card_expiration_date` date NOT NULL,
  `card_hold_number` int(10) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `card_amount` double NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `card_number`, `card_cv2`, `card_expiration_date`, `card_hold_number`, `user_email`, `user_first_name`, `user_last_name`, `card_amount`) VALUES
(1, 1234123412341200, 234, '2015-12-25', 2345, 'lol@lol.com', 'first name', 'last name', 0.62),
(2, 1234123412341234, 123, '2017-12-21', 1234556, 'test@gmail.com', 'first name', 'last name', 1244.23),
(3, 1234123412341234, 123, '2017-12-21', 1234556, 'test@gmail.com23', 'first name', 'last name', 1244.23),
(4, 1234123412341234, 123, '2017-12-21', 1234556, 'test@gmail.com2', 'alexander', 'shapoval', 1264.23);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;