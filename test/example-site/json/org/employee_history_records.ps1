<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test org\employment-history-records
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get list of records
$list = [TestResults]::Execute('org/employment-history-records');
$testCase = $list.Data[0];
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($list.Data.Count).";

## fetch by id
$result = [TestResults]::Execute( "org/employment-history-records/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result $($result.Data).";

## fetch by id - invalid id
$result = [TestResults]::Execute( 'org/employment-history-records/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false) -Pass $("Request returned error = $($result.ErrorMessage)") -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result size=$($result.Data.Count).";

## Lookup by id
$result = [TestResults]::Execute( "org/employment-history-records/id/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Lookup by id - invalid id
$result = [TestResults]::Execute( 'org/employment-history-records/id/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass $("Request returned error = $($result.ErrorMessage)") -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result size=$($result.Data.Count).";

## Lookup by employee
$result = [TestResults]::Execute( "org/employment-history-records/employee/$($testCase.employee_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Lookup by employee - invalid
$result = [TestResults]::Execute( 'org/employment-history-records/employee/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";


## display results
$test | Select Status, Label, Message | Out-GridView
