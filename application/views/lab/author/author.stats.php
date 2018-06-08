<!-- info display -->
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-2"></div>
		<div class="col-md-8 column py-5">
		<div class="stats-info">
		<br><br>
			<?php
				echo "<h1>".ucwords($author_info['AuthorName'])."</h1><br>";
				
				$id_sents = array("<h2>The author is using ID {$author_info['AuthorID']}.</h2>",
				"<h2>The author uses {$author_info['AuthorID']} as ID.</h2>",
				"<h2>The author's ID is {$author_info['AuthorID']}.</h2>");
				echo $id_sents[rand(0, 2)];
				
				if($author_info['Affiliation']!="None"){
					$aff_sents = array("<h2>The author usually publishes papers in {$author_info['Affiliation']}</h2>",
					"<h2>{$author_info['Affiliation']} is where the author publishes most of its papers.</h2>",
					"<h2>The author's major affiliation is {$author_info['Affiliation']}.</h2>");
					echo $aff_sents[rand(0, 2)];
				}
				else echo "<h2>The author belongs to no affiliation.</h2>";
				
				if($author_info['Conference']!="None"){
					$conf_sents = array("<h2>As a \"fan\" of {$author_info['Conference']}, the author published most of its paper on it.</h2>", 
					"<h2>{$author_info['Conference']} is the conference where most of the author's papers were published.</h2>", 
					"<h2>The author's major conference is {$author_info['Conference']}.</h2>");
					echo $conf_sents[rand(0, 2)];
				}
				else echo "<h2>The author does not publish in any conference.</h2>";
				
				$total_sents = array("<h2>According to Acemap, the author has published {$author_info['total_paper']} papers.</h2>",
				"<h2>The productive author has published {$author_info['total_paper']} papers in total.</h2>",
				"<h2>According to Acemap, {$author_info['total_paper']} papers have been penned by the author.</h2>");
				echo $total_sents[rand(0, 2)];
				
				if(count($author_info['coauthors'])>0){
					$coa_sents = array("<h2>The author often coauthors papers with ",
					"<h2>The author has close partnership with ",
					"<h2>The author's freqent cooperators are ");
					echo $coa_sents[rand(0, 2)];
					for($i=0;$i<count($author_info['coauthors']);$i++){
						echo ucwords($author_info['coauthors'][$i]);
						if($i<count($author_info['coauthors'])-1) echo ", ";
					}
					echo ".</h2>";
				}
				else echo "<h2>The author seems to enjoy working alone, since it hasn's coauthored any paper with others.</h2>";
			?>
			<br><br><br>
		</div>
	</div>
</div>
</div>

<!-- section 1 -->
<div class="stats-section-0 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-7 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-0">
					<svg width="800" height="500" id="cn" class="center-block" />
					</div>
				</div>
			</div>
			<div class="col-md-6 column py-5">
			<h1>Cooperation Network</h1>
			<h2>This displays the cooperation network centering the author.</h2>
			<div class="row clearfix">
				<br>
				<div class="col-md-3"></div>
				<div class="col-md-3">
					<svg width="20" height="20" class="center-block">
						<circle cx="10" cy="10" r="8" stroke="white" stroke-width="2" fill="#912CEE" />
					</svg>
					<p>Current Author</p>
				</div>
				<div class="col-md-3">
					<svg width="20" height="20" class="center-block">
						<circle cx="10" cy="10" r="8" stroke="white" stroke-width="2" fill="#66ccff" />
					</svg>
					<p>Coauthor</p>
				</div>
			</div>
			<div class="row clearfix">
				<br>
				<div class="col-md-3"></div>
				<div class="col-md-3">
					<svg width="20" height="20" class="center-block">
						<circle cx="10" cy="10" r="8" stroke="white" stroke-width="2" fill="#8B008B" />
					</svg>
					<p>Advisor Coauthor</p>
				</div>
				<div class="col-md-3">
					<svg width="20" height="20" class="center-block">
						<circle cx="10" cy="10" r="8" stroke="white" stroke-width="2" fill="#CD853F" />
					</svg>
					<p>Advisee Coauthor</p>
				</div>
				<br>
			</div>
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
			<h2>This displays the number of publications of the author each year.<br>You can click the graph to change view.</h2>
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
			<div class="col-md-8 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-0">
					<svg width="750" height="500" id="rbp" class="center-block" />
					</div>
				</div>
			</div>
			<div class="col-md-4 column py-5">
			<h1>Reference Box Plot</h1>
			</div>
		</div>
</div>
</div>

<div class="stats-section-0 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-5 column py-5">
				<h1>Conference Distribution</h1>
				<h2>This graph shows the distribution of the publication of current author in different conferences.</h2>
			</div>
			<div class="col-md-7 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-0">
					<svg width="750" height="500" id="cfpc" class="center-block" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br><br><br>

<!-- plot operations -->
<script type='text/javascript'>

get_publication_increament should recieve one more parameter 'key', details please refer to my IE lab (updated)

plot_force_direct_graph("<?php echo site_url("visual/get_cn_neighbor?author_id=$author_id"); ?>");
plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$author_id&mode=1&key=author"); ?>", 1);
plot_publication_increament("<?php echo site_url("visual/get_publication_increament?id=$author_id&mode=2&key=author"); ?>", 2);
$("#pi2-div").hide();
plot_box_chart("<?php echo site_url("visual/publication_reference_count?author_id=$author_id"); ?>");
plot_conference_dist_pi_chart("<?php echo site_url("visual/author_con?id=$author_id&key=author"); ?>", "#cfpc");
</script>