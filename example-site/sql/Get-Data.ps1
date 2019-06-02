<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-06-01
    Description: Export data from database to flat files.
 #>

## define export file
$exportFolder = "{0}\data" -f $PSScriptRoot;

## clear folder
Remove-Item –Path "$exportFolder\*" -Recurse;

## get & parse database password 
$pass = Read-Host 'What is your password?' -AsSecureString;
$password = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto( [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pass) );

## open database
$db = Open-SqlConnection 'INVLABSSERVER' -Database 'example-site' -Username 'website_user' -Password $password ;

## export data using information schema
Get-SqlData -Connection $db -Query "SELECT file_name=TABLE_SCHEMA + '.' + TABLE_NAME, TABLE_SCHEMA, TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' and TABLE_NAME<>'sysdiagrams'" | ForEach-Object {
    Get-SqlData $db -query ( 'select * from {0}.{1}' -f $_.TABLE_SCHEMA, $_.TABLE_NAME) | Export-CSV -NoTypeInformation ( "{0}\{1}.csv" -f $exportFolder, $_.file_name );
}

## close database
$db.close();
