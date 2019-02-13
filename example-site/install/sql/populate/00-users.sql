
INSERT INTO site.users(email, [name], [status], [password]) VALUES 
		('sean.bourg@gmail.com', 'Sean Bourg', 1, site.password_encrypt('apples 4 you'))
		, ('seanbourg@gmail.com', 'Admin', 1, site.password_encrypt('apples 4 you'));