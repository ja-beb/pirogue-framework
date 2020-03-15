<?php

#    $db = mysqli_connect('pirogue-database', 'website', 'app-test-website-password', 'website');
#    $sql_results = mysqli_query($db, 'select * from users');


ob_start();

$GLOBALS['._pirogue.dispatcher.start_time'] = microtime(true);
$GLOBALS['.pirogue.request.data'] = $_GET;
$GLOBALS['.pirogue.request.path'] = $GLOBALS['.pirogue.request.data']['__pirogue::dispatcher::path'] ?? '';
$GLOBALS['.pirogue.request.view'] = strtolower($GLOBALS['.pirogue.request.data']["__pirogue::dispatcher::view"] ?? '');

switch($GLOBALS['.pirogue.request.view'])
{
    case 'csv':
    case 'json':
        $GLOBALS['.pirogue.request.view'] = $GLOBALS['.pirogue.request.view'];
        break;

    case 'html':
    default:
        $GLOBALS['.pirogue.request.view'] = 'html';
}


unset($GLOBALS['.pirogue.request.data']['__pirogue::dispatcher::path'], $GLOBALS['.pirogue.request.data']["__pirogue::dispatcher::view"]);

// send resuts to user.
header('Content-Type: text/html');
header('X-Powered-By: pirogue php');

// route parse: (application, page, path)
$_path = array_map(fn($x) => preg_replace('/^(_+)/', '', $x), array_filter(explode('/', $GLOBALS['.pirogue.request.path']), fn($x) => !empty($x)));

$GLOBALS['.pirogue.request.application'] = $_path[0] ?? 'default';
$GLOBALS['.pirogue.request.path'] = $_path[1] ?? 'index';
    
header(sprintf('X-Execute-Milliseconds: %0.00f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));

?>
<html>
<head>
<title></title>
<style>
</style>
</head>
<body>
<pre>
    <a href="./">reload</a>
    <?php print_r($GLOBALS['.pirogue.request.data']); ?>
    <?php var_dump($_path); ?>
    </pre>
    <ul>
        <li><?=$GLOBALS['.pirogue.request.path']; ?></li>
        <li><?=$GLOBALS['.pirogue.request.view']; ?></li>
        <li>template = <?php printf('%s/%s.phtml', $GLOBALS['.pirogue.request.application'], $GLOBALS['.pirogue.request.path']); ?></li>
    </ul>
</body>
</html>
