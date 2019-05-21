<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test site/applications
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get department list
$list = [TestResults]::Execute('site/applications');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data ) -Fail 'Request returned no data.' -Pass ( 'Request returned results ({0}).' -f $list.Data.Count);

## Get test case
$testCase = $list.Data[0];

$result = [TestResults]::Execute( "site/applications/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## fetch - invalid
$result = [TestResults]::Execute( 'site/applications/10000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get id lookup 
$result = [TestResults]::Execute( "site/applications/id/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get id lookup - invalid
$result = [TestResults]::Execute( 'site/applications/id/100000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get name lookup
$result = [TestResults]::Execute( "site/applications/$($testCase.name)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get name lookup with invalid data
$result = [TestResults]::Execute( 'site/applications/invalid-app' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get name lookup
$result = [TestResults]::Execute( "site/applications/name/$($testCase.name)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get name lookup with invalid data
$result = [TestResults]::Execute( 'site/applications/name/invalid-app' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

$test | Select Status, Label, Message | Out-GridView
