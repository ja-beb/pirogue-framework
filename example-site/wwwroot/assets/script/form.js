/**
 * Base page Javascript include
 */
window.addEventListener('DOMContentLoaded', (event) => {
    const list = document.getElementsByClassName('onload-focus');
    if ( 0 < list.length ){
    	list[0].focus();
    	list[0].select();
    }
});