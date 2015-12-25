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
  `transaction_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_amount` double NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `sender_id`, `recipient_id`, `transaction_datetime`, `transaction_amount`) VALUES
(5, 2, 1, '2015-12-25 21:02:48', 400),
(6, 1, 2, '2015-12-25 21:02:55', 123.23);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` bigint(16) NOT NULL,
  `card_cv2` int(3) NOT NULL,
  `card_expiration_date` date NOT NULL,
  `card_hold_name` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `card_amount` double NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `card_number`, `card_cv2`, `card_expiration_date`, `card_hold_name`, `user_email`, `user_first_name`, `user_last_name`, `card_amount`) VALUES
(1, 4539714184190039, 123, '2017-12-21', 'OLEKSANDR SHAPOVAL', 'test@gmail.com', 'alexander', 'shapoval', 1476.77),
(2, 5136350937756596, 123, '2017-12-21', 'VASYA PUPKIN', 'tes4@gmail.com', 'vasya', 'pupkin', 123.23);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
