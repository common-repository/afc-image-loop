<?PHP
/*
* Plugin Management
*/

// returns list of required plugins
// thanks to Jonathan Leighton for an idea! see http://jonathanleighton.com/blog/wordpress-plugin-dependencies/
function afc_image_loop_reqs() {
	$required_plugins = array();
	$required_plugins[] = array(
		'name'=>'AFC Plug System ver 2.1.2 +', 'uri'=>'http://www.afcomponents.com/ext/wp/afc-plug-system/', 'func'=>'afc_plug_system', 'ver'=>'2.1.2'
	);
	$missing_plugins = array();
	foreach ($required_plugins as $plugin){
		if (!function_exists($plugin['func']) && !class_exists($plugin['func'])){
			$missing_plugins[] = $plugin;
		}elseif( $plugin['func']() < $plugin['ver'] ) { // check version
			$missing_plugins[] = $plugin; // plugin exists but version is missing
		}
		
	}
	return $missing_plugins;	
}

function afc_image_loop_reqs_failed() {
	$missing_plugins = afc_image_loop_reqs();
	if(!empty($missing_plugins) && count($missing_plugins)) {
		$this_plug_dir = '/afc-image-loop/';
		add_menu_page('AFC Image Loop', 'AFC Image Loop', 9, $this_plug_dir.'menu_pages/requirements.php');		
	}
}

/*
* Returns stored data associated with afc flv-player plugin
*/
function afc_imgloop_get_options($reset =  0) {
	//values used by default
	$def_opts = array(
		'component_uri'			=> get_bloginfo('url').'/wp-content/plugins/afc-image-loop/component.swf',
		'base_uri'				=> get_bloginfo('url').'/wp-content/uploads/',
		'comp_tag'			  => 'img_loop',
		'width'						=> 360,
		'height'					=> 270,
		'quicktag'				=> 1,
		'autostart'				=> 0,
		'bgcolor'				=> '0xFFFFFF',
		'alt_title' => 'Advanced Flash Components (www.afcomponents.com)',
	);
	

	$options = $reset ? 0 : get_option('afc_imgloop_options');
	if (!is_array($options)){
		$options = $def_opts;
		update_option('afc_imgloop_options', $options);
	}

	return $options;
}

/*
* Transform <flv> meta-tag into actual HTML tags
*/
function afc_imgloop_the_content($content) {
	$o = afc_imgloop_get_options();
	
	$req_opts = array('height','width','autostart','title');

	//open template
	$comp_html = file_get_contents(dirname(__FILE__).'/menu_pages/component_html.tpl');
	
	$comp_html = str_replace('{COMPONENT_URI}',$o['component_uri'],$comp_html);

	preg_match_all ('!<'.(trim($o['comp_tag']) ? strtolower($o['comp_tag']) : 'img_loop').'([^>]*)[ ]*[/]*>!i', $content, $_matches); //locate comp's tag
	if(isset($_matches[1])) {
		foreach($_matches[1] as $k1=>$comp_tag) {
			$comp_html_cur = $comp_html;
			preg_match_all('!(path|width|height|autostart|bgcolor)="([^"]*)"!i',$comp_tag,$attribs);	
			//now create an array containing all transmitted via tag vars
			$tpl_vars = array();
			foreach($attribs[1] as $k2=>$att_name) {
				$tpl_vars[$att_name] = $attribs[2][$k2];
			}

			//now make sure that parameters not present are obtained from defaults
			foreach($req_opts as $opt_name) {
				if(!isset($tpl_vars[$opt_name])) {
					$tpl_vars[$opt_name] = ($o[$opt_name]=='y')?'true':$o[$opt_name];
					$tpl_vars[$opt_name] = $tpl_vars[$opt_name]=='n'?'false':$tpl_vars[$opt_name];
				}
			}

			//do replace
			foreach($tpl_vars as $att_name=>$att_value) {
				$comp_html_cur = str_replace('{'.strtoupper($att_name).'}', $att_value.'', $comp_html_cur);
			}
			$content = str_replace($_matches[0][$k1],$comp_html_cur,$content);
		}
	}
	return $content;
}

// adds up quicktag button functionality
function afc_imgloop_quicktag_button($content) {
	$o = afc_imgloop_get_options();
	if($o['quicktag']) {
		require_once(dirname(__FILE__).'/menu_pages/quicktag_button.php');
	}
	return $content;
}


?>