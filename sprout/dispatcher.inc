<?php


namespace sprout;


/**
 * dispatcher address.
 * @var string 
 */
$GLOBALS['.dispatcher_address'] = '';



/**
 * 
 * @param string $address
 */
function dispatcher_init(string $address){
    $GLOBALS['.dispatcher_address'] = $address;
}


/**
 * Send content to user then exit.
 * @param string $content
 * @param array $headers
 * @param bool $cachable
 */
function dispatcher_send(string $content, array $headers = [], bool $cachable = true)
{
    foreach ($headers as $current) {
        header($current);
    }
    echo $content;
    exit();
}

/**
 * Redirect user to new address.
 */
function dispatcher_redirect(string $address, int $code = 301){
    header("Location: {$address}", true, $code );
    exit();
}