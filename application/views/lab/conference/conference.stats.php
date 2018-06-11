<!-- info display -->
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-1"></div>
		<div class="col-md-6 column py-5">
		<div class="stats-info">
		<br><br>
			<?php
				echo "<h1>".ucwords($conference_info['ConferenceName'])."</h1><br>";
				
				$id_sents = array("<h2>The conference is using ID {$conference_info['ConferenceID']}.</h2>",
				"<h2>The conference uses {$conference_info['ConferenceID']} as ID.</h2>",
				"<h2>The ID of the conference is {$conference_info['ConferenceID']}.</h2>");
				echo $id_sents[rand(0, 2)];
				
				$pap_sents = array("<h2>{$conference_info['PaperNum']} papers have been published in this conference.</h2>",
					"<h2>In this conference, {$conference_info['PaperNum']} papers have been published.</h2>",
					"<h2>This conference has produced {$conference_info['PaperNum']} papers.</h2>");
					echo $pap_sents[rand(0, 2)];
				
				$aut_sents = array("<h2>{$conference_info['AuthorNum']} authors have made publication in this conference.</h2>",
					"<h2>The number of authors who have made publication in the conference add up to {$conference_info['AuthorNum']}.</h2>",
					"<h2>This conference attracted {$conference_info['AuthorNum']} authors to have made publication here.</h2>");
					echo $aut_sents[rand(0, 2)];
				
			?>
		<br><br><br><br><br><br><br><br><br><br>
		</div>
		</div>
		<div class="col-md-5 column py-5">
			<svg width="600" height="400" id="label-cloud" class="center-block"/>
		</div>
	</div>
</div>

<!-- section 1 
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
</div>-->

<!-- section 2 -->
<div class="stats-section-1 text-center py-5" id="pi-g">
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
<div class="stats-section-0 text-center py-5" id="lb-g">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-7 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-1">
					<div id="tau-div">
					<svg onclick="$('#tau-div').hide('slow');$('#taf-div').show('slow');" width="800" height="550" id="tau" class="center-block" />
					<h2 style="color:black">Top Authors</h2>
					</div>
					<div id="taf-div">
					<svg onclick="$('#taf-div').hide('slow');$('#tau-div').show('slow');" width="800" height="550" id="taf" class="center-block" />
					<h2 style="color:black">Top Affiliation</h2>
					</div>
					</div>
				</div>
			</div>
			<div class="col-md-5 column py-5">
				<h1>Publication Leaderboard</h1>
				<h2>This graph shows the leaderboard of the current conference. It displays the top 10 authors (affiliations) with the most papers published in this conference.</h2>
				<h2>You can click the graph to change view.</h2>
				<div class="panel-group" id="panel-167619">
					<div class="panel">
						<div class="text-center">
						<div class="panel-heading panel-dark-toggle-title">
							 <a class="panel-title" data-toggle="collapse" data-parent="#panel-167619" href="#panel-element-150618">Author Leaderboard</a>
						</div>
						</div>
						<div id="panel-element-150618" class="panel-collapse collapse in">
							<div class="panel-body panel-dark-body pre-scrollable">
							<!-- Displays top 10 authors in following format, no pagination required -->
								<?php foreach($author_list as $index => $item): ?>
									<?php if ($index != 0) echo "<hr>"; ?>
									<?php echo $index + 1; ?>.&nbsp&nbsp<?php echo ucwords($item['name']); ?>
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="text-center">
						<div class="panel-heading panel-dark-toggle-title">
							 <a class="panel-title" data-toggle="collapse" data-parent="#panel-167619" href="#panel-element-211967">Affiliation Leaderboard</a>
						</div>
						</div>
						<div id="panel-element-211967" class="panel-collapse collapse">
							<div class="panel-body panel-dark-body pre-scrollable">
							<!-- Displays top 10 affiliations in following format, no pagination required -->
								<?php foreach($affi_list as $index => $item): ?>
									<?php if ($index != 0) echo "<hr>"; ?>
									<?php echo $index + 1; ?>.&nbsp&nbsp<?php echo ucwords($item['name']); ?>
								<?php endforeach ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br><br><br>

<!-- plot operations -->
<script type='text/javascript'>

// get_publication_increament should recieve one more parameter 'key', details please refer to my IE lab (updated)

plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$conference_id&mode=1&key=conference"); ?>", 1);
plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$conference_id&mode=2&key=conference"); ?>", 2);
$("#pi2-div").hide();

plot_vertical_bar("<?php echo site_url("visual/conference_top_pub?id=$conference_id&key=author"); ?>", "#tau", "top");
plot_vertical_bar("<?php echo site_url("visual/conference_top_pub?id=$conference_id&key=affiliation"); ?>", "#taf", "top");
$("#taf-div").hide();

plot_label_cloud("<?php echo site_url("visual/get_conf_label?conf_id=$conference_id"); ?>", "#label-cloud");
</script>