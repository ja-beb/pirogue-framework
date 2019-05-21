<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test org\positions
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get position list
$list = [TestResults]::Execute('org/positions');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data -and $list.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass ( 'Request returned results ({0}).' -f $list.Data.Count);

## Get test case
$testCase = $list.Data[0];

## fetch by id
$result = [TestResults]::Execute( "org/positions/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## fetch by id - invalid
$result = [TestResults]::Execute( 'org/positions/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search by id
$result = [TestResults]::Execute( "org/positions/id/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## search by id - invalid
$result = [TestResults]::Execute( 'org/positions/id/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search by label
$result = [TestResults]::Execute( "org/positions/label/$($testCase.label)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## search by label - invalid
$result = [TestResults]::Execute( 'org/positions/label/this-is-an-invalid-position-label' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search by payrate 
$result = [TestResults]::Execute( "org/positions/payrate/$($testCase.payrate_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data) -Fail 'Request returned no data.' -Pass "Request returned result, size=$($result.Data.Count).";

## search by payrate - invalid
$result = [TestResults]::Execute( 'org/positions/payrate/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data) -Fail 'Request returned no data.' -Pass "Request returned result, size=$($result.Data.Count).";

## search by division 
$result = [TestResults]::Execute( "org/positions/division/$($testCase.division_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data) -Fail 'Request returned no data.' -Pass "Request returned result, size=$($result.Data.Count).";

## search by division - invalid
$result = [TestResults]::Execute( 'org/positions/division/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data) -Fail 'Request returned no data.' -Pass "Request returned result, size=$($result.Data.Count).";

## display test results.
$test | Select Status, Label, Message | Out-GridView
