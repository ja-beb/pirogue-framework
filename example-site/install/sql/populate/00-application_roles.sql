
-- Use the site.role_create procedure to create site roles:
EXECUTE site.role_create @application='Site', @role='User';
EXECUTE site.role_create @application='Site', @role='Admin';
