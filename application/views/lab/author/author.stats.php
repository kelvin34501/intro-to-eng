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
			<div class="col-md-6 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-0">
					<svg width="750" height="500" id="cn" class="center-block" />
					</div>
				</div>
			</div>
			<div class="col-md-6 column py-5">
			<h1>Cooperation Network</h1>
			<h2>This displays the cooperation network centering the author.</h2>
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
					<div class="panel-body stats-panel-1">
					<svg onclick="$('#pi1').hide('slow');$('#pi2').show('slow');" width="900" height="500" id="pi1" class="center-block" />
					<svg onclick="$('#pi2').hide('slow');$('#pi1').show('slow');" width="900" height="500" id="pi2" class="center-block" />
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
<br><br><br>

<!-- plot operations -->
<script type='text/javascript'>
var cur_pi = 0;

var force_direct_graph_source = "<?php echo site_url("visual/get_cn_neighbor?author_id=$author_id"); ?>";
var publication_increament_source_1 = "<?php echo site_url("visual/get_publication_increament?author_id=$author_id&mode=1"); ?>";
var publication_increament_source_2 = "<?php echo site_url("visual/get_publication_increament?author_id=$author_id&mode=2"); ?>";
var box_chart_source = "<?php echo site_url("visual/publication_reference_count?author_id=$author_id"); ?>";

plot_force_direct_graph();

plot_publication_increament(1);
plot_publication_increament(2);
$("#pi2").hide();

//plot_box_chart();
</script>