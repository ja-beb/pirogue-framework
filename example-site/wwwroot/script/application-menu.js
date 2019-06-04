/**
 * application menu
 */
window.addEventListener('DOMContentLoaded', event => {
	const application_menu_show = () => document.getElementsByTagName('body')[0].classList.add('__application-menu-show');
	const application_menu_hide = () => document.getElementsByTagName('body')[0].classList.remove('__application-menu-show');
	
    document.getElementById('application-button').addEventListener('click', e => {
    	e.preventDefault();
    	application_menu_show();
    });
    document.getElementById('page-cover').addEventListener('click', e => {
    	e.preventDefault();
    	application_menu_hide();
    });
    
    document.getElementById('application-menu-close').addEventListener('click', e => {
    	console.log('click');
    	e.preventDefault();
    	application_menu_hide();
    });
    
});