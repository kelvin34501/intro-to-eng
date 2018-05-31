var controllers = new Array("#author-search", "#id-search", "#affiliation-search", "#conference-search", "#paper-search");

var value_ids = new Array("#author", "#id", "#affiliation", "#conference", "#paper");

var colors = new Array("#66ccff", "#e5eecc", "#ff4f4f", "#ee9a00", "#8f31e7");

var opened = new Array(false, false, false, false, false);

function close_open(target=null){
	for(var i=0;i<controllers.length;i++){
		prefix = controllers[i];
		if(target==prefix){
			if(!opened[i]){
				$(prefix + '-title').animate({
					color:colors[i]
				});
				opened[i] = true;
			}
			else{
				$(prefix + '-title').animate({
					color:"#ffffff"
				});
				$(value_ids[i]).val('');
				opened[i] = false;
			}
		}
		else{
			if(opened[i]){
				$(prefix + '-title').animate({
					color:"#ffffff"
				});
				$(prefix).hide('slow');
				$(value_ids[i]).val('');
				opened[i] = false;
			}
		}
	}
}

$(document).ready(function(){
	for(var i=0;i<controllers.length;i++)
		$(controllers[i]).hide();
	
	$('#author-search-title').hover(
		function(){
		$('#author-search-title').animate({
			fontSize:'26'
		}, 'fast')},
		function(){
		$('#author-search-title').animate({
			fontSize:'23'
		}, 'fast')}
	);
	$('#id-search-title').hover(
		function(){
		$('#id-search-title').animate({
			fontSize:'26'
		}, 'fast')},
		function(){
		$('#id-search-title').animate({
			fontSize:'23'
		}, 'fast')}
	);
	$('#affiliation-search-title').hover(
		function(){
		$('#affiliation-search-title').animate({
			fontSize:'26'
		}, 'fast')},
		function(){
		$('#affiliation-search-title').animate({
			fontSize:'23'
		}, 'fast')}
	);
	$('#conference-search-title').hover(
		function(){
		$('#conference-search-title').animate({
			fontSize:'26'
		}, 'fast')},
		function(){
		$('#conference-search-title').animate({
			fontSize:'23'
		}, 'fast')}
	);
	$('#paper-search-title').hover(
		function(){
		$('#paper-search-title').animate({
			fontSize:'26'
		}, 'fast')},
		function(){
		$('#paper-search-title').animate({
			fontSize:'23'
		}, 'fast')}
	);
	
	$('#author-search-title').click(function(){
		$('#author-search').toggle('slow');
		close_open("#author-search");
	});
	$('#id-search-title').click(function(){
		$('#id-search').toggle('slow');
		close_open("#id-search");
	});
	$('#affiliation-search-title').click(function(){
		$('#affiliation-search').toggle('slow');
		close_open("#affiliation-search");
	});
	$('#conference-search-title').click(function(){
		$('#conference-search').toggle('slow');
		close_open("#conference-search");
	});
	$('#paper-search-title').click(function(){
		$('#paper-search').toggle('slow');
		close_open("#paper-search");
	});
});
