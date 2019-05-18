USE [master]
GO
/****** Object:  Database [example-site]    Script Date: 2019-05-17 21:50:37 ******/
CREATE DATABASE [example-site]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'example-site', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\example-site.mdf' , SIZE = 28608KB , MAXSIZE = UNLIMITED, FILEGROWTH = 10%)
 LOG ON 
( NAME = N'example-site_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL14.SQLEXPRESS\MSSQL\DATA\example-site_log.ldf' , SIZE = 47616KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [example-site] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [example-site].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [example-site] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [example-site] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [example-site] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [example-site] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [example-site] SET ARITHABORT OFF 
GO
ALTER DATABASE [example-site] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [example-site] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [example-site] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [example-site] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [example-site] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [example-site] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [example-site] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [example-site] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [example-site] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [example-site] SET  DISABLE_BROKER 
GO
ALTER DATABASE [example-site] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [example-site] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [example-site] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [example-site] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [example-site] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [example-site] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [example-site] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [example-site] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [example-site] SET  MULTI_USER 
GO
ALTER DATABASE [example-site] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [example-site] SET DB_CHAINING OFF 
GO
ALTER DATABASE [example-site] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [example-site] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [example-site] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [example-site] SET QUERY_STORE = OFF
GO
USE [example-site]
GO

/****** Object:  Schema [org]    Script Date: 2019-05-17 21:50:37 ******/
CREATE SCHEMA [org]
GO
/****** Object:  Schema [site]    Script Date: 2019-05-17 21:50:37 ******/
CREATE SCHEMA [site]
GO
/****** Object:  UserDefinedFunction [site].[password_encrypt]    Script Date: 2019-05-17 21:50:37 ******/
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
/****** Object:  Table [org].[employees]    Script Date: 2019-05-17 21:50:37 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[employees](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[employee_number] [int] NOT NULL,
	[name_given] [nvarchar](50) NOT NULL,
	[name_surname] [nvarchar](50) NOT NULL,
	[name_middle] [nvarchar](50) NULL,
	[name_generation_qualifier] [nvarchar](10) NULL,
	[name_title] [nvarchar](10) NULL,
	[date_of_birth] [date] NOT NULL,
	[gender] [char](1) NOT NULL,
	[ssn] [char](11) NULL,
 CONSTRAINT [PK_staff] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[employee_accounts]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[employee_accounts](
	[employee_id] [int] NOT NULL,
	[email_address] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_employee_accounts] PRIMARY KEY CLUSTERED 
(
	[employee_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[employment_history_records]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[employment_history_records](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[employee_id] [int] NOT NULL,
	[status] [tinyint] NOT NULL,
	[date_start] [date] NOT NULL,
	[date_end] [date] NULL,
 CONSTRAINT [PK_employment_history_records] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [org].[employee_details]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [org].[employee_details]
AS

select employees.id, employees.employee_number
		, employees.name_given, employees.name_surname, employees.name_middle
		, employees.name_generation_qualifier, employees.name_title, employees.date_of_birth
		, employees.gender, employees.ssn
		, employee_accounts.email_address
		, employment_history_records.[status], date_start, date_end
	from org.employees
		left join org.employee_accounts on employees.id=employee_accounts.employee_id
		left join (
			SELECT employee_id, [status], date_start, date_end
				FROM (
						SELECT employee_id, [status], date_start, date_end, row_index=ROW_NUMBER() OVER(PARTITION BY employee_id ORDER BY date_end, date_start DESC)
							FROM org.employment_history_records
					) AS employment_history_records
				WHERE row_index=1
		) AS employment_history_records ON employees.id=employment_history_records.employee_id


GO
/****** Object:  Table [site].[applications]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [site].[applications](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_applications] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [site].[roles]    Script Date: 2019-05-17 21:50:38 ******/
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
/****** Object:  Table [site].[user_application_assignments]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [site].[user_application_assignments](
	[role_id] [int] NOT NULL,
	[user_id] [int] NOT NULL,
 CONSTRAINT [PK_user_application_assignments] PRIMARY KEY CLUSTERED 
(
	[role_id] ASC,
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [site].[user_roles]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [site].[user_roles]
AS
SELECT        site.user_application_assignments.user_id, site.roles.application_id, site.applications.name AS application_name, site.user_application_assignments.role_id, site.roles.name AS role_name
FROM            site.user_application_assignments INNER JOIN
                         site.roles ON site.user_application_assignments.role_id = site.roles.id INNER JOIN
                         site.applications ON site.roles.application_id = site.applications.id
GO
/****** Object:  View [site].[application_roles]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [site].[application_roles]
AS
SELECT        site.applications.id AS application_id, site.applications.name AS application_name, site.roles.id AS role_id, site.roles.name AS role_name
FROM            site.applications INNER JOIN
                         site.roles ON site.applications.id = site.roles.application_id
GO
/****** Object:  Table [org].[departments]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[departments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label] [nvarchar](50) NOT NULL,
	[parent_id] [int] NULL,
	[phone_number] [nvarchar](20) NULL,
	[phone_extension] [nvarchar](5) NULL,
 CONSTRAINT [PK_departments] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[divisions]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[divisions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_divisions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[employee_phone_numbers]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[employee_phone_numbers](
	[employee_id] [int] NOT NULL,
	[type_id] [tinyint] NOT NULL,
	[phone_number] [nvarchar](50) NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [org].[location_types]    Script Date: 2019-05-17 21:50:38 ******/
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
/****** Object:  Table [org].[locations]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[locations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label] [nvarchar](100) NOT NULL,
	[address_line_1] [nvarchar](50) NULL,
	[address_line_2] [nvarchar](50) NULL,
	[city] [nvarchar](50) NULL,
	[state] [char](2) NULL,
	[zipcode] [char](5) NULL,
	[phone] [nvarchar](20) NULL,
	[type_code] [tinyint] NOT NULL,
 CONSTRAINT [PK_locations] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[pay_rates]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[pay_rates](
	[id] [tinyint] NOT NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_pay_rates] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[phone_number_types]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[phone_number_types](
	[id] [tinyint] NOT NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_phone_number_types] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[position_assignments]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[position_assignments](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[employee_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[location_id] [int] NOT NULL,
	[department_id] [int] NOT NULL,
	[date_start] [date] NOT NULL,
	[date_end] [date] NULL,
	[pay_grade_id] [int] NULL,
 CONSTRAINT [PK_position_assignments] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[position_pay_grades]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[position_pay_grades](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[position_id] [int] NOT NULL,
	[label] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_position_pay_grades] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [org].[positions]    Script Date: 2019-05-17 21:50:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [org].[positions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[label] [nvarchar](50) NOT NULL,
	[payrate_id] [tinyint] NOT NULL,
	[division_id] [int] NOT NULL,
 CONSTRAINT [PK_positions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [site].[users]    Script Date: 2019-05-17 21:50:39 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [site].[users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[email] [nvarchar](max) NOT NULL,
	[status_code] [tinyint] NOT NULL,
	[password] [varbinary](64) NULL,
 CONSTRAINT [PK_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [org].[positions] ADD  CONSTRAINT [DF_positions_payrate_id]  DEFAULT ((0)) FOR [payrate_id]
GO
ALTER TABLE [org].[employee_accounts]  WITH CHECK ADD  CONSTRAINT [FK_employee_accounts_employment_history_records] FOREIGN KEY([employee_id])
REFERENCES [org].[employment_history_records] ([id])
GO
ALTER TABLE [org].[employee_accounts] CHECK CONSTRAINT [FK_employee_accounts_employment_history_records]
GO
ALTER TABLE [org].[employee_phone_numbers]  WITH CHECK ADD  CONSTRAINT [FK_employee_phone_numbers_employment_history_records] FOREIGN KEY([employee_id])
REFERENCES [org].[employment_history_records] ([id])
GO
ALTER TABLE [org].[employee_phone_numbers] CHECK CONSTRAINT [FK_employee_phone_numbers_employment_history_records]
GO
ALTER TABLE [org].[employee_phone_numbers]  WITH CHECK ADD  CONSTRAINT [FK_employee_phone_numbers_phone_number_types] FOREIGN KEY([type_id])
REFERENCES [org].[phone_number_types] ([id])
GO
ALTER TABLE [org].[employee_phone_numbers] CHECK CONSTRAINT [FK_employee_phone_numbers_phone_number_types]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_departments] FOREIGN KEY([department_id])
REFERENCES [org].[departments] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_departments]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_employees] FOREIGN KEY([employee_id])
REFERENCES [org].[employees] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_employees]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_employment_history_records] FOREIGN KEY([id])
REFERENCES [org].[employment_history_records] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_employment_history_records]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_locations] FOREIGN KEY([location_id])
REFERENCES [org].[locations] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_locations]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_position_pay_grades] FOREIGN KEY([pay_grade_id])
REFERENCES [org].[position_pay_grades] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_position_pay_grades]
GO
ALTER TABLE [org].[position_assignments]  WITH CHECK ADD  CONSTRAINT [FK_position_assignments_positions] FOREIGN KEY([position_id])
REFERENCES [org].[positions] ([id])
GO
ALTER TABLE [org].[position_assignments] CHECK CONSTRAINT [FK_position_assignments_positions]
GO
ALTER TABLE [org].[positions]  WITH CHECK ADD  CONSTRAINT [FK_positions_divisions] FOREIGN KEY([division_id])
REFERENCES [org].[divisions] ([id])
GO
ALTER TABLE [org].[positions] CHECK CONSTRAINT [FK_positions_divisions]
GO
ALTER TABLE [org].[positions]  WITH CHECK ADD  CONSTRAINT [FK_positions_pay_rates] FOREIGN KEY([payrate_id])
REFERENCES [org].[pay_rates] ([id])
GO
ALTER TABLE [org].[positions] CHECK CONSTRAINT [FK_positions_pay_rates]
GO
ALTER TABLE [site].[roles]  WITH CHECK ADD  CONSTRAINT [FK_roles_applications] FOREIGN KEY([application_id])
REFERENCES [site].[applications] ([id])
GO
ALTER TABLE [site].[roles] CHECK CONSTRAINT [FK_roles_applications]
GO
ALTER TABLE [site].[user_application_assignments]  WITH CHECK ADD  CONSTRAINT [FK_user_application_assignments_roles] FOREIGN KEY([role_id])
REFERENCES [site].[roles] ([id])
GO
ALTER TABLE [site].[user_application_assignments] CHECK CONSTRAINT [FK_user_application_assignments_roles]
GO
ALTER TABLE [site].[user_application_assignments]  WITH CHECK ADD  CONSTRAINT [FK_user_application_assignments_users] FOREIGN KEY([user_id])
REFERENCES [site].[users] ([id])
GO
ALTER TABLE [site].[user_application_assignments] CHECK CONSTRAINT [FK_user_application_assignments_users]
GO
/****** Object:  StoredProcedure [site].[role_create]    Script Date: 2019-05-17 21:50:39 ******/
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
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
      Begin ColumnWidths = 9
         Width = 284
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'org', @level1type=N'VIEW',@level1name=N'employee_details'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'org', @level1type=N'VIEW',@level1name=N'employee_details'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "applications (site)"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 102
               Right = 208
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "roles (site)"
            Begin Extent = 
               Top = 6
               Left = 246
               Bottom = 119
               Right = 416
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
      Begin ColumnWidths = 9
         Width = 284
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'site', @level1type=N'VIEW',@level1name=N'application_roles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'site', @level1type=N'VIEW',@level1name=N'application_roles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "user_application_assignments (site)"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 102
               Right = 208
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "roles (site)"
            Begin Extent = 
               Top = 6
               Left = 246
               Bottom = 119
               Right = 416
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "applications (site)"
            Begin Extent = 
               Top = 6
               Left = 454
               Bottom = 102
               Right = 624
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
      Begin ColumnWidths = 9
         Width = 284
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
         Width = 1500
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'site', @level1type=N'VIEW',@level1name=N'user_roles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'site', @level1type=N'VIEW',@level1name=N'user_roles'
GO
USE [master]
GO
ALTER DATABASE [example-site] SET  READ_WRITE 
GO
