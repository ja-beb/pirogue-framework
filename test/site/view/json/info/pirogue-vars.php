<?php
    
    $_vars = [];
    foreach ( $GLOBALS as $_key => $_value ){
        if ( preg_match('/pirogue/', $_key) ){
            $_vars[$_key] = $_value;
        }
    }
    return $_vars;