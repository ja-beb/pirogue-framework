$connection = Open-SqlConnection -Server 'invlabsserver' -Database 'example-site' -Username 'website_user' -Password '1coldheart'
Get-SQLData -Connection $connection -Query "SELECT TABLE_SCHEMA, TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'" | %{
    $name = "{0}.{1}" -f $_.TABLE_SCHEMA, $_.TABLE_NAME
    Get-SQLData -Connection $connection -Query ( "SELECT * from {0}" -f $name ) | export-csv -NoTypeInformation ("C:\users\sean\git\pirogue-framework\example-site\sql\data\{0}.csv" -f $name);
}
