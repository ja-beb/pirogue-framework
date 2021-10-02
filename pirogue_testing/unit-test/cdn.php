<?php 
    /**
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     * @category
     * @package
     * @license
     * @version
     * @link
     */

    function cdn_test(array $list, int $count) : void
    {
        __cdn($list);
        var_dump($GLOBALS['._pirogue.cdn.address_list']);        
        
        for ( $i = 0; $i < $count; $i++ ){            
            var_dump($GLOBALS['._pirogue.cdn.current_index']);
            printf( '%d) %s', $i+1, cdn_create_url('test', ['key' => 'one', 'value' => 1]));
            var_dump($GLOBALS['._pirogue.cdn.current_index']);
        }
    }
    
    cdn_test([],3);
    cdn_test(['cdn.localhost'],4);
    cdn_test([
        'cdn1.localhost',
        'cdn2.localhost',
        'cdn3.localhost',
        'cdn4.localhost',        
    ],12);
    
    pirogue\cdn