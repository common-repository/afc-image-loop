<?PHP
/*
Plugin Name: AFC Image Loop
Plugin URI: http://www.afcomponents.com/ext/wp/afc-image-loop/
Description: AFC Image Loop allows you to display list of images using embeddable version of <a href="http://www.afcomponents.com/components/img_loop/">IMG Loop Component</a> from <a href="http://www.afcomponents.com">Advanced Flash Components</a>.
Version: 0.9.5
Author: Vic Farazdagi
Author URI: http://www.afcomponents.com/team/torio/
*/

/*
AFC Image Loop for Wordpress
(c) 2007 Advanced Flash Components / CrabDish LLC (email : support@afcomponents.com)

This plugin uses free embeddable version of	Advanced Flash Component's IMG Loop.
For more details on component itself see	http://www.afcomponents.com/components/img_loop/
	
This Wordpress plugin is released "as is". Without any warranty. The author cannot
be held responsible for any damage that this script might cause.
*/

require_once(dirname(__FILE__).'/plugin_funcs.php');

function afc_image_loop() {return '0.9.5';}	// dummy function to let the others know that plugin has been loaded

/*
* Registered Hooks
*/
add_filter('the_content', 'afc_imgloop_the_content', '10');	// <afc_image_loop> tag -> HTML tags
add_filter('the_editor_content','afc_imgloop_quicktag_button',1);

add_action('admin_menu', 'afc_image_loop_reqs_failed'); // on failed reqs, user would see requirements.php in menu


?>