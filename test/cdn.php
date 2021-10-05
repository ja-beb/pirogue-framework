<?php 
    /**
     * Test CDN server.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, , 'pirogue', 'cdn.php']));

    /**
     * Define testing function
     * @param array $server_list List of CDN servers.
     * @param int $count Number of times to preform test.
     * @return array list of testing errors.
     */
    function cdn_test(array $server_list, int $count): array
    {
        pirogue_cdn_init($server_list);
        $_cdn_count = count($server_list);
        
        if (!empty(array_diff($server_list, $GLOBALS['._pirogue.cdn.address_list']))) {
            return ['pirogue_cdn_init(): failed to initialize CDN server list.'];
        }
        
        for ( $i = 0; $i < $count; $i++ ){            
            $_error_list = [];
            $_start_index = $GLOBALS['._pirogue.cdn.current_index'];
            $_uri = pirogue_cdn_create_url('test', ['key' => 'one', 'value' => 1]);

            if ($_start_index >= $_cdn_count && $_start_index !== 0) {
                array_push($_error_list, 'pirogue_cdn_create_url(): Start index state exceeds list length.');
            }

            if ($GLOBALS['._pirogue.cdn.current_index'] >= $_cdn_count) {
                array_push($_error_list, 'pirogue_cdn_create_url(): End index state exceeds list length.');
            }

            if (!str_starts_with($_uri, $GLOBALS['._pirogue.cdn.address_list'][$_start_index])) {
                array_push($_error_list, 'pirogue_cdn_create_url(): URI returned is not the expected address.');
            }
            
            if ( ($GLOBALS['._pirogue.cdn.current_index']-$_start_index) != 1 && 0 != $GLOBALS['._pirogue.cdn.current_index']) {
                array_push($_error_list, sprintf('pirogue_cdn_create_url(): Index not properly incremented. %d, %d', $_start_index, $GLOBALS['._pirogue.cdn.current_index']));
            }

            if (!empty($_error_list)) {
                return $_error_list;
            }
        }
        return [];
    }
    
    // Run test
    pirogue_test_execute('CDN-00x03', function(){
        try{
            cdn_test([],3);
            return ['Worked with no CDN servers registered.'];
        } catch (LogicException $e) {
            return [];
        }
    });
    pirogue_test_execute('CDN-01x04', fn() => cdn_test(['cdn.localhost'],4));
    pirogue_test_execute('CDN-04x12',fn() => cdn_test([
        'cdn.00.localhost',
        'cdn.01.localhost',
        'cdn.02.localhost',
        'cdn.03.localhost',        
    ],12));    
