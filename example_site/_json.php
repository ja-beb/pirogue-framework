<?php

/**
 * Main dispatcher for JSON content.
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

/* Bootsrap */

/* Declare page varaiables */


try{

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);


    // Check for file:


    // 404
}catch(Exception $_exception){
   // 500  
}catch(Error $_exception){
    // 500  
}

echo $_request_path;



