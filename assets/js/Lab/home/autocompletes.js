/* Other autocompletes should be added. I am not sure whether we can call php functions in javascript... */
$( "#author" ).autocomplete({
	source: author_completer,
	autoFocus: true
});

$( "#affiliation" ).autocomplete({
	source: affi_completer,
	autoFocus: true
});

$( "#conference" ).autocomplete({
	source: conference_completer,
	autoFocus: true
});

$( "#paper" ).autocomplete({
	source: paper_completer,
	autoFocus: true
});