-- populate table website.users
insert into website.users(username, email, password) VALUES ('admin', 'admin@test-site.org', SHA2('admin-password', 256) ),
  ('user', 'user@test-site.org', SHA2('user-password', 256)),
  ('user.00', 'user.00@test-site.org', SHA2('user-password', 256)),
  ('user.01', 'user.01@test-site.org', SHA2('user-password', 256))
