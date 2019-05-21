$pass = Read-Host 'What is your password?' -AsSecureString;


$BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pass)
$password = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)

$db = Open-SqlConnection 'INVLABSSERVER' -Database 'example-site' -Username 'website_user' -Password $password ;
Get-SqlData -Connection $db -Query "SELECT TABLE_NAME, TABLE_SCHEMA FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' and TABLE_NAME<>'sysdiagrams'" | ForEach-Object {
    Get-SqlData $db -query ( 'select * from {0}.{1}' -f $_.TABLE_SCHEMA, $_.TABLE_NAME) | Export-CSV -NoTypeInformation ( "{0}\data\{1}.{2}.csv" -f $PSScriptRoot, $_.TABLE_SCHEMA, $_.TABLE_NAME );
}
$db.close();