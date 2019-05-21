
function Test-Assert($Label, [bool] $TestResults, $Pass, $Fail){
    $result = New-Object PSObject -Property @{
        'Label' = $Label;
        'Message' = $null;
        'Status' = 'Pass';
    };

    if ( $TestResults ){
        $result.Message = $Pass;
    }else{
        $result.Status = 'Fail';
        $result.Message = $Fail;
    }
    return $result;
}