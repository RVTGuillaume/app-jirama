CREATE TABLE `users` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(100) NOT NULL UNIQUE,
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users`(`username`,`email`,`password`) VALUES
('guillaume','rvonytianaguillaume@gmail.com',MD5('guillaume06')),
('guyzaho','guyzaho@gmail.com',MD5('guyzaho05'));