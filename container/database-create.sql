
CREATE TABLE `website`.`users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx-users-email` (`email`),
  UNIQUE KEY `idx-users-username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into website.users(username,email) VALUES ('admin', 'admin@test-site.org'),
  ('user', 'user@test-site.org'),
  ('user.00', 'user.00@test-site.org'),
  ('user.01', 'user.01@test-site.org')
