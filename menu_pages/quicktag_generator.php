<?PHP
error_reporting(E_ERROR);
define('ABSPATH', realpath(dirname(__FILE__).'/../../../../').'/' );
require_once( dirname(__FILE__).'/../../../../wp-admin/admin.php'); 

require_once( dirname(__FILE__) . '/../../../../wp-config.php');
require_once( dirname(__FILE__) . '/../../../../wp-settings.php');

// require plugin functions
require_once(dirname(__FILE__).'/../plugin_info.php');

$error = '';
$missing_plugins = afc_image_loop_reqs();
if(!empty($missing_plugins) && count($missing_plugins)) {
	$error .= 'Required plugins are missing:<br><ul>
	';
	foreach($missing_plugins as $plugin) {
		$error .= '<li><a href="'.$plugin['uri'].'" target="_blank">'.$plugin['name'].'</a><br>';
	}
	$error .= '</ul>Please make sure that you have all required plugins (of a given version or above).';
}

$o = afc_imgloop_get_options();
if(!$o['quicktag']) {
	die('Quicktab disabled..');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>AFC Image Loop &rsaquo; Quicktag</title>
<link rel="stylesheet" href="<?php echo get_bloginfo('url')?>/wp-admin/wp-admin.css?version=2.1.3" type="text/css" />
<style type="text/css">* html { overflow-x: hidden; }</style>

<script type='text/javascript' src='<?php echo get_bloginfo('url')?>/wp-includes/js/quicktags.js?ver=3517'></script>
<script type='text/javascript' src='<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/quicktag.js'></script>
<script language="JavaScript">
	function doInsert(){
		var parentCanvas = window.opener.document.getElementById('content');
		var myField = window.opener.document.getElementById('content');

		var f_height = document.getElementById('f_height');
		var f_width = document.getElementById('f_width');
		var f_conf_uri = document.getElementById('f_conf_file_uri');
		var f_bgcolor = document.getElementById('f_bgcolor');
		var f_autostart = document.getElementById('f_autostart');
		
		var myValue = '<<?php echo $o['comp_tag'] ? strtolower($o['comp_tag']) : 'IMG_LOOP'?> path="' + f_conf_uri.value  
								+ '" width="' + f_width.value 
								+ '" height="' + f_height.value 
								+ '" bgcolor="' + f_bgcolor.value 
								+ '" autostart="';
		myValue += (f_autostart.checked) ? 'true" />' : 'false" />';

		//IE support
		if (window.opener.document.selection) {
			myField.focus();
			sel = window.opener.document.selection.createRange();
			sel.text = myValue;
			myField.focus();
		}
		//MOZILLA/NETSCAPE support
		else if (myField.selectionStart || myField.selectionStart == '0') {
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			myField.value = myField.value.substring(0, startPos)
										+ myValue 
												+ myField.value.substring(endPos, myField.value.length);
			myField.focus();
			myField.selectionStart = startPos + myValue.length;
			myField.selectionEnd = startPos + myValue.length;
		} else {
			myField.value += myValue;
			myField.focus();
		}
		window.close();
	}


	var quick_tag_screens = ['div_files', 'div_options', 'div_xml_conf'];
	var blog_uri = '<?php echo get_bloginfo('url')?>';

</script>

</head>
<body>
<?php
if($error) {
	?>
	<div class="wrap" style="margin:7px;">
	<h2>Error</h2>
	<?php echo $error;?>
	</div>
	</body>
	</html>
	<?
	exit;
}
?>
	<div class="wrap" style="margin:7px;">
		<h2>AFC Image Loop Options</h2>

		<form name="plugin_html_form" method="post">
		<input type="hidden" name="afc_file_pick_frame" id="afc_file_pick_frame">
		<input type="hidden" name="afc_file_pick_el" id="afc_file_pick_el">

		<div id="div_files" style="display:none;height:100%;">
			<iframe id="frmFiles" width="100%" height="450" scrolling="auto" src="<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/file_manager.php?sa=1&sp=<?php echo $o['base_uri']?>" frameborder="0" style="border:1px solid silver;"></iframe>
			<p class="submit">
				<input type="button" onClick="afc_tools_on_file_selected('div_options')" name="Select" value="Select &raquo;" />
				<input type="button" onClick="afc_tools_on_file_not_selected()" name="Cancel" value="Cancel &raquo;" />
			</p>
		
		</div>
		<div id="div_xml_conf" style="display:none;height:100%;">
			<iframe id="frmXmlConf" width="100%" height="450" scrolling="auto" src="<?php echo get_bloginfo('url')?>/wp-content/plugins/afc-plug-system/menu_pages/xml_parser.php?sa=1" frameborder="0" style="border:1px solid silver;"></iframe>
			<p class="submit">
				<input type="button" onClick="afc_tools_screen_select('div_options')" name="Back" value="Back &raquo;" />
			</p>
		
		</div>

		
		<div id="div_options" style="height:500px;">
		<fieldset class="options">
			<legend>Required settings</legend>
			<table class="optiontable"> 
				<tbody>
				<tr valign="top"> 
					<th scope="row">XML Configuration File:</th> 
					<td>
						<div>
							<input type="text" id="f_conf_file_uri" name="f_conf_file_uri"  size="40" class="code" type="text" readonly>
							<a href="javascript://" onClick="afc_tools_select_file('div_options', 'div_files','f_conf_file_uri');">Choose File</a>
							<a href="javascript://" onClick="afc_tools_edit_xml('div_xml_conf','f_conf_file_uri','AFC_XmlFormat_Image_Loop')">Configure</a>
						</div>
					</td>
				</tr> 
				<tbody>
			</table>
		</fieldset>
		<br />

		<fieldset class="options">
			<legend>Additional Settings</legend>
			<table class="optiontable"> 
				<tbody>
				<tr valign="top"> 
					<th scope="row">Dimensions:</th> 
					<td>
						<input type="text" value="<?php echo $o['width']?>" name="width" id="f_width" size="3" maxlength="4" /> x
						<input type="text" value="<?php echo $o['height']?>" name="height" id="f_height" size="3" maxlength="4" />
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Background Color:</th> 
					<td>
						<input type="text" value="<?php echo $o['bgcolor']?>" name="bgcolor" id="f_bgcolor" size="8" maxlength="8" /><br>
					</td>
				</tr> 
				<tr valign="top"> 
					<th scope="row">Auto-Start:</th> 
					<td>
						<input type="radio" value="1" id="f_autostart" name="autostart" <?php echo ($o['autostart'] ? 'checked="checked"' : '') ?> /> yes<br />
						<input type="radio" value="0" name="autostart" <?php echo (!$o['autostart'] ? 'checked="checked"' : '') ?> /> no
					</td>
				</tr> 
				<tbody>
			</table>
		</fieldset>

		<p class="submit" style="margin-top:100px;">
			<input type="button" onClick="doInsert()" name="Submit" value="Insert Tag &raquo;" />
		</p>
		</div>
		</form>
	</div>

</body>
</html>
