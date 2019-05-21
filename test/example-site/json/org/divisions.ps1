<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test org\divisions
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get division list
$list = [TestResults]::Execute('org/divisions');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data -and $list.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass ( 'Request returned results ({0}).' -f $list.Data.Count);

## Get test case
$testCase = $list.Data[0];

## Fetch by id
$result = [TestResults]::Execute( "org/divisions/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Fetch by id - invalid (returns 404)
$result = [TestResults]::Execute( 'org/divisions/-1' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Search by id 
$result = [TestResults]::Execute( "org/divisions/id/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Search by id - invalid (returns 404)
$result = [TestResults]::Execute( 'org/divisions/id/-1' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Search by label
$result = [TestResults]::Execute( "org/divisions/label/$($testCase.label)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## Search by label - invalid (returns 404)
$result = [TestResults]::Execute( 'org/divisions/label/this-is-an-invalid-location-label' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## Display results
$test | Select Status, Label, Message | Out-GridView
