<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test site/roles
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get roles list
$list = [TestResults]::Execute('site/roles');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data -and $list.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass ( 'Request returned results ({0}).' -f $list.Data.Count);

## Get test case
$testCase = $list.Data[0];

$result = [TestResults]::Execute( "site/roles/$($testCase.role_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## fetch - invalid
$result = [TestResults]::Execute( 'site/roles/1000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get id lookup 
$result = [TestResults]::Execute( "site/roles/id/$($testCase.role_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get id lookup - invalid
$result = [TestResults]::Execute( 'site/roles/id/-1' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get name lookup
$result = [TestResults]::Execute( "site/roles/name/$($testCase.role_name)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get name lookup with invalid data
$result = [TestResults]::Execute( 'site/roles/name/this-is-an-invalid-location-label' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get application lookup
$result = [TestResults]::Execute( "site/roles/application/$($testCase.application_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get application lookup with invalid data
$result = [TestResults]::Execute( 'site/roles/application/500000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Get application name lookup
$result = [TestResults]::Execute( "site/roles/application/$($testCase.application_name)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Get application name lookup with invalid data
$result = [TestResults]::Execute( 'site/roles/application/no-such-app' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";



$test | Select Status, Label, Message | Out-GridView
