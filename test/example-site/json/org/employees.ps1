<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: Test org\employees
 #>
 
using module ..\Modules\TestResults.psm1;
using module ..\Modules\Test-Assert.psm1;

$test = @();

## Get employee list
$list = [TestResults]::Execute('org/employees');
$test += Test-Assert -Label $list.Url -TestResults ( [string]::IsNullOrEmpty($list.ErrorMessage) ) -Fail "Request returned error = $($list.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $list.Url -TestResults ( $null -ne $list.Data -and $list.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass ( 'Request returned results ({0}).' -f $list.Data.Count);

## get test case
$testCase = $list.Data[0];

## fetch employee by id
$result = [TestResults]::Execute( "org/employees/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## fetch employee by id - invalid
$result = [TestResults]::Execute( 'org/employees/-1' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search employee by id
$result = [TestResults]::Execute( "org/employees/id/$($testCase.id)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail $("Request returned error = $($result.ErrorMessage)") -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0 ) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## search employee by id - invalid
$result = [TestResults]::Execute( 'org/employees/id/-1' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0 ) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search employee by employee_number 
$result = [TestResults]::Execute( "org/employees/employee-number/$($testCase.employee_number)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## search employee by employee_number - invalid
$result = [TestResults]::Execute( 'org/employees/employee-number/42' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## search employee by email 
$result = [TestResults]::Execute( "org/employees/email/$($testCase.email_address)" );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) ) -Fail "Request returned error = $($result.ErrorMessage)" -Pass 'Request returned no error.' ;
$test += Test-Assert -Label $result.Url -TestResults ( $null -ne $result.Data -and $result.Data.Count -gt 0) -Fail 'Request returned no data.' -Pass "Request returned result=$($result.Data).";

## search employee by email - invalid
$result = [TestResults]::Execute( 'org/employees/email/42' );
$test += Test-Assert -Label $result.Url -TestResults ( [string]::IsNullOrEmpty($result.ErrorMessage) -eq $false ) -Pass "Request returned error = $($result.ErrorMessage)" -Fail 'Request returned no error.';
$test += Test-Assert -Label $result.Url -TestResults ( $null -eq $result.Data -or $result.Data.Count -eq 0) -Pass 'Request returned no data.' -Fail "Request returned result=$($result.Data).";

## display test results
$test | Select Status, Label, Message | Out-GridView
