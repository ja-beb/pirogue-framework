/**
 * Populate base users.
 */
INSERT INTO site.users(email, [name], [status], [password]) VALUES ('username@domain.com', 'Username', 1, site.password_encrypt('apples 4 you'))
INSERT INTO site.users(email, [name], [status], [password]) VALUES ('username2@domain.com', 'Admin', 1, site.password_encrypt('apples 4 you'));
