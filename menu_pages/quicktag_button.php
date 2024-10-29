<?PHP
	$quicktag_page_uri = get_bloginfo('url').'/wp-content/plugins/afc-image-loop/menu_pages/quicktag_generator.php';
?>
<script type="text/javascript">
	<!--
		var qtToolbar = document.getElementById("ed_toolbar");
		if(qtToolbar){
			var flvNr = edButtons.length;
			edButtons[edButtons.length] = new edButton('ed_image_loop','','','','');
			var compBut = qtToolbar.lastChild;
			while (compBut.nodeType != 1){
				compBut = compBut.previousSibling;
			}
			compBut = compBut.cloneNode(true);
			qtToolbar.appendChild(compBut);
			compBut.value = '<?php echo $o['comp_tag'] ? strtoupper($o['comp_tag']) : 'IMG_LOOP'?>';
			compBut.onclick = edInsertIMGLoop;
			compBut.title = "Insert an Image Loop";
			compBut.id = "ed_image_loop";
		}

		function edInsertIMGLoop() {
			new_window = window.open ('<?php echo $quicktag_page_uri?>', 'newwindow', config='height=600, width=650, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			new_window.focus();
		}

	//-->
</script>