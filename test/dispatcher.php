<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, 'dispatcher.php']));

    
    pirogue_test_execute('pirogue_dispatcher_init', function() {
        $address = 'https://test-site.localhost';
        $request_path = 'users/list';
        $request_data = ['id' => '1'];

        pirogue_dispatcher_init($address, $request_path, $request_data);
        

        $errors = [];
        if ( $address !== $GLOBALS['.pirogue.dispatcher.address'] ) {
            array_push($errors, 'Unable to set address.');
        }

        if ( $request_path !== $GLOBALS['.pirogue.dispatcher.request_path'] ) {
            array_push($errors, 'Unable to set request path.');
        }
        
        if ( ($request_data['id'] ?? null) != ($GLOBALS['.pirogue.dispatcher.request_data']['id'] ?? null) ) {
            array_push($errors, 'Unable to set request data.');
        }

        return $errors;
    });

    pirogue_test_execute('pirogue_dispatcher_create_url - empty', fn() => pirogue_dispatcher_create_url('', []) == $GLOBALS['.pirogue.dispatcher.address'] 
        ? [] 
        : [ sprintf('Invalid url returned "%s".', pirogue_dispatcher_create_url('', []))]);
    
    pirogue_test_execute('pirogue_dispatcher_create_url - path only', function () {
        $path = 'index.html';
        $url = pirogue_dispatcher_create_url($path, []);
        return $url == "{$GLOBALS['.pirogue.dispatcher.address']}/{$path}" ? [] : [ "Invalid url '{$url}' returned."];
    });

    pirogue_test_execute('pirogue_dispatcher_create_url - path and data', function () {
        $path = 'index.html';
        $data_label = 'id';
        $data_value = 1;

        $url = pirogue_dispatcher_create_url($path, [$data_label => $data_value]);
        return $url == "{$GLOBALS['.pirogue.dispatcher.address']}/{$path}?{$data_label}={$data_value}" ? [] :  [ "Invalid url '{$url}' returned."];
    });
    