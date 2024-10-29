<?PHP
// get plugin funcs
require_once(dirname(__FILE__).'/../plugin_info.php');

// check dependecies
require_once(dirname(__FILE__).'/requirements.php');
if($error) {
	return ;
}

//see if form has been submitted
if (isset($_POST['pform_data'])){
	if(isset($_POST['Reset'])) {
		update_option('afc_imgloop_options', afc_imgloop_get_options(1) );
		$MSG = '<div class="updated"><p><strong>Default values have been restored.</strong></p></div>';
	}else {
		update_option('afc_imgloop_options', $_POST['pform_data']);
		$MSG = '<div class="updated"><p><strong>Options saved.</strong></p></div>';
	}
}else {
	$MSG = '';
}

//get options
$o = afc_imgloop_get_options();
?>
<br clear="all" />
<div class="wrap">
	<h2>AFC Image Loop Options</h2>
	<?php echo $MSG?>
	<form name="plugin_html_form" method="post" action="admin.php?page=/afc-image-loop/menu_pages/index.php">
	<fieldset class="options">
		<legend>Required settings</legend>
		<table class="optiontable"> 
			<tbody>
			<tr valign="top"> 
				<th scope="row">AFC IMG Loop Component Location (URL):</th> 
				<td>
					<input name="pform_data[component_uri]" value="<?php echo $o['component_uri']?>" size="70" class="code" type="text"><br>
					Setup path to <a href="http://www.afcomponents.com/components/img_loop/">AFC IMG Loop</a> component. <br>This path must be provided and be valid (by default it's available as /wp-content/plugins/afc-image-loop/component.swf).
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">File Base Location (URL):</th> 
				<td>
					<input name="pform_data[base_uri]" value="<?php echo $o['base_uri']?>" size="70" class="code" type="text"><br>
					Saves you couple of clicks by opening Remote Browser in that directory.
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">Background Color:</th> 
				<td>
					<input type="text" value="<?php echo $o['bgcolor']?>" name="pform_data[bgcolor]" size="8" maxlength="8" /><br>
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">Component's Tag:</th> 
				<td>
					<input type="text" value="<?php echo $o['comp_tag']?>" name="pform_data[comp_tag]" size="70" class="code" maxlength="15" /><br>
					In most cases, default value would be good enough. Sometimes, however, default tag might be used by other previously installed plugin - this option allows you to resolve such conflicts.
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
				<th scope="row">Default Title:</th> 
				<td>
					<input name="pform_data[alt_title]" value="<?php echo $o['alt_title']?>" size="70" class="code" type="text">
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">Enable Quick-Tag:</th> 
				<td>
					<input type="radio" value="1" name="pform_data[quicktag]" <?php echo ($o['quicktag'] ? 'checked="checked"' : '') ?> /> yes<br />
					<input type="radio" value="0" name="pform_data[quicktag]" <?php echo (!$o['quicktag'] ? 'checked="checked"': '') ?> /> no
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">Default Dimensions:</th> 
				<td>
					<input type="text" value="<?php echo $o['width']?>" name="pform_data[width]" size="3" maxlength="4" /> x
					<input type="text" value="<?php echo $o['height']?>" name="pform_data[height]" size="3" maxlength="4" />
				</td>
			</tr> 
			<tr valign="top"> 
				<th scope="row">Auto-Start:</th> 
				<td>
					<input type="radio" value="1" name="pform_data[autostart]" <?php echo ($o['autostart'] ? 'checked="checked"' : '') ?>  /> yes<br />
					<input type="radio" value="0" name="pform_data[autostart]" <?php echo (!$o['autostart'] ? 'checked="checked"' : '') ?>  /> no
				</td>
			</tr> 
			<tbody>
		</table>
	</fieldset>

	<p class="submit">
		<input type="submit" name="Submit" value="Update Options &raquo;" />
		<input type="submit" name="Reset" value="Reset Options &raquo;" />
	</p>
	</form>
</div>
