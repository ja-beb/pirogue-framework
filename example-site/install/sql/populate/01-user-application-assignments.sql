INSERT INTO site.user_application_assignments(role_id, [user_id])
	SELECT role_id, 1 FROM site.application_roles

INSERT INTO site.user_application_assignments(role_id, [user_id]) VALUES(2,2)

	