<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test org\employee_phone_numbers
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get listing of employee phone numbers
$list = [TestResults]::Execute('org/employee_phone_numbers');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Get test case 
$testCase = $list.Data[0];

## Get employee lookup 
$result = [TestResults]::Execute( "org/employee_phone_numbers/employee/$($testCase.employee_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Get id lookup - invalid
$result = [TestResults]::Execute( 'org/employee_phone_numbers/employee/100000000' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Get type lookup
$result = [TestResults]::Execute( "org/employee_phone_numbers/type/$($testCase.type_id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## Get type lookup with invalid data
$result = [TestResults]::Execute( 'org/employee_phone_numbers/type/500' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data ) -Fail 'Request returned no data.' -Pass "Request returned result size=$($result.Data.Count).";

## display test results
$test | Select Status, Label, Message | Out-GridView
