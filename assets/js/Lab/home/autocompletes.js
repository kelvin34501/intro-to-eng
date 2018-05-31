/* Other autocompletes should be added. I am not sure whether we can call php functions in javascript... */
$( "#author" ).autocomplete({
	source: "<?php echo $auto_completer; ?>",
	autoFocus: true
});