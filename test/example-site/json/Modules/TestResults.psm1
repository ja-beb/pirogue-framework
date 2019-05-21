<#
    Author_____: Sean Bourg <sean.bourg@gmail.com>
    Date_______: 2019-05-20
    Description: test object responsible for executing test on the org web services.
 #>


class TestResults {
    [string] $ErrorMessage;
    [System.Array] $Data;
    [string] $Url;
    [string] $Method;

    TestResults([string] $url, [string] $method) {
        $this.Url = $url;
        $this.Method = $method;
    }

    static [TestResults] Execute([string] $path) {
        return [TestResults]::Execute($path, 'Get');
    }

    static [TestResults] Execute([string] $path, [string] $method) {
        [TestResults] $TestResults = [TestResults]::new(
            ("http://invlabsserver/example-site/{0}.json" -f $path), 
            $method
        );  

        try {
            $TestResults.Data = Invoke-RestMethod -Method $Method $TestResults.Url;            
            $TestResults.ErrorMessage = $null;
            
        }
        catch [System.Net.WebException] { 
            $TestResults.ErrorMessage = $_.Exception.Message;
        }
        return $TestResults;
    }
}


