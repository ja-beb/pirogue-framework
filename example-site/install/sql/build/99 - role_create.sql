USE [example-site]
GO

/****** Object:  StoredProcedure [site].[role_create]    Script Date: 2019-02-12 21:02:06 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		Sean Bourg <sean.bourg@gmail.com>
-- Create date: 2019-02-12
-- Description:	Create site rule and application.
-- =============================================
CREATE PROCEDURE [site].[role_create]
	-- Add the parameters for the stored procedure here
	@application NVARCHAR(50),
	@role NVARCHAR(50)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from interfering with SELECT statements.
	SET NOCOUNT ON;

	DECLARE @_application_id INT;
	DECLARE @_role_id INT;

	-- Create application if not found
	SELECT @_application_id=Id FROM site.applications WHERE [name] = @application;
	IF ( @_application_id IS NULL)
	BEGIN
		INSERT INTO site.applications([name]) VALUES(@application);
		SET @_application_id=@@IDENTITY;
		PRINT 'create application'
	END

	-- Create role if not found
	SELECT @_role_id=Id FROM site.roles WHERE [name] = @role;
	IF ( @_role_id IS NULL )
	BEGIN
		INSERT INTO site.roles([application_id], [name]) VALUES(@_application_id,@role);
		SET @_role_id=@@IDENTITY;
	END

	SELECT application_id, application_name, role_id, role_name 
		FROM site.application_roles
		WHERE application_id=@_application_id
			AND role_id=@_role_id;

END
GO


