USE [example-site]
GO

/****** Object:  UserDefinedFunction [site].[password_encrypt]    Script Date: 2019-02-12 21:02:23 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		Sean Bourg
-- Create date: 2019-02-12
-- Description:	Encrypt user password.
-- =============================================
CREATE FUNCTION [site].[password_encrypt]
(
	-- Add the parameters for the function here
	@password NVARCHAR(MAX)
)
RETURNS VARBINARY(54)
AS
BEGIN

	RETURN HASHBYTES('SHA2_512', @password);
END
GO


