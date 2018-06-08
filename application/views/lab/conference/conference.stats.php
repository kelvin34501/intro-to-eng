<!-- info display -->
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-2"></div>
		<div class="col-md-8 column py-5">
		<div class="stats-info">
		
		</div>
	</div>
</div>
</div>

<!-- section 1 -->
<div class="stats-section-0 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-6 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-0">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 column py-5">

			</div>
		</div>
	</div>
</div>

<!-- section 2 -->
<div class="stats-section-1 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-4 column py-5">
			<h1>Publication Increament</h1>
			<h2>This displays the number of publications of the affiliation each year.<br>You can click the graph to change view.</h2>
			</div>
			<div class="col-md-8 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-1 text-center">
					<div id="pi1-div">
					<svg onclick="$('#pi1-div').hide('slow');$('#pi2-div').show('slow');" width="900" height="450" id="pi1" class="center-block" />
					<h2 style="color:black">Annual Publication Changes</h2>
					</div>
					<div id="pi2-div">
					<svg onclick="$('#pi2-div').hide('slow');$('#pi1-div').show('slow');" width="900" height="450" id="pi2" class="center-block" />
					<h2 style="color:black">Total Publication Increament</h2>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- section 3 -->
<div class="stats-section-0 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-7 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-1">
					<div id="tau-div">
					<svg onclick="$('#tau-div').hide('slow');$('#taf-div').show('slow');" width="700" height="400" id="tau" class="center-block" />
					<h2 style="color:black">Top Authors</h2>
					</div>
					<div id="taf-div">
					<svg onclick="$('#taf-div').hide('slow');$('#tau-div').show('slow');" width="700" height="400" id="taf" class="center-block" />
					<h2 style="color:black">Top Affiliation</h2>
					</div>
					</div>
				</div>
			</div>
			<div class="col-md-5 column py-5">
				<h1>Publication Leaderboard</h1>
				<h2>This graph shows the leaderboard of the current conference.</h2>
				<h2>It displays the top 10 authors (affiliations) that publishes the most papers and the number of their publications in this conference</h2>
				<h2>You can click the graph to change view.</h2>
			</div>
		</div>
	</div>
</div>

<br><br><br>

<!-- plot operations -->
<script type='text/javascript'>

get_publication_increament should recieve one more parameter 'key', details please refer to my IE lab (updated)

plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$conference_id&mode=1&key=conference"); ?>", 1);
plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$conference_id&mode=2&key=conference"); ?>", 2);
$("#pi2-div").hide();

plot_vertical_bar("<?php echo site_url("visual/conference_top_pub?id=$conference_id&key=author"); ?>", "#tau", "top");
plot_vertical_bar("<?php echo site_url("visual/conference_top_pub?id=$conference_id&key=affiliation"); ?>", "#taf", "top");
$("#taf-div").hide();
</script>