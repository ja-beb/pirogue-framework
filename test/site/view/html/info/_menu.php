<?php 

    pirogue_import_load('site/menu');

    return [
        site_menu_create( title:'View php info output.', label:'PHP Info', path:'php.html'),
        site_menu_create( title:'View session data.', label:'Session Data', path:'session.html'),
        site_menu_create( title:'View framework data.', label:'Pirogue Framework Data', path:'pirogue-vars.html'),
        site_menu_create( title:'View dispatcher data.', label:'Dispatcher Data', path:'dispatcher-vars/page/options.html', request:[ 'test1' => 'true', 'test2' => 'false' ] ),
        site_menu_create( title:'User Session', label:'User Sesion', path:'user-session.html'),
    ];