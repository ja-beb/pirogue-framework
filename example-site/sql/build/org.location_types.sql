USE [example-site]
GO

/****** Object:  Table [org].[location_types]    Script Date: 2019-03-19 11:23:42 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [org].[location_types](
	[id] [tinyint] NOT NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_location_types] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

