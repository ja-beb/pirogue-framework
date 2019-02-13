USE [example-site]
GO

/****** Object:  Table [site].[roles]    Script Date: 2019-01-24 19:36:51 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [site].[roles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[application_id] [int] NOT NULL,
	[name] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_roles] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

ALTER TABLE [site].[roles]  WITH CHECK ADD  CONSTRAINT [FK_roles_roles] FOREIGN KEY([id])
REFERENCES [site].[roles] ([id])
GO

ALTER TABLE [site].[roles] CHECK CONSTRAINT [FK_roles_roles]
GO


