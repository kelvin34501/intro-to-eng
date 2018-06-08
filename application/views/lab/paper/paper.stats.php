<!-- info display -->
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-2"></div>
		<div class="col-md-8 column py-5">
		<div class="stats-info">
		<br><br>
			<?php
				echo "<h1>".ucwords($paper_info['PaperName'])."</h1><br>";
				
				$id_sents = array("<h2>The paper is using ID {$paper_info['PaperID']}.</h2>",
				"<h2>The paper uses {$paper_info['PaperID']} as ID.</h2>",
				"<h2>The ID of this paper is {$paper_info['PaperID']}.</h2>");
				echo $id_sents[rand(0, 2)];
				
				if($paper_info['Affiliation']!="None"){
					$aff_sents = array("<h2>This paper was published under the name of {$paper_info['Affiliation']}</h2>",
					"<h2>{$paper_info['Affiliation']} is where the paper was published.</h2>",
					"<h2>The paper was born in {$paper_info['Affiliation']}.</h2>");
					echo $aff_sents[rand(0, 2)];
				}
				else echo "<h2>The paper belongs to no affiliation.</h2>";
				
				if($paper_info['Conference']!="None"){
					$conf_sents = array("<h2>You can find this paper in {$paper_info['Conference']}.</h2>", 
					"<h2>{$paper_info['Conference']} is the conference where the paper was published.</h2>", 
					"<h2>The paper was published in {$paper_info['Conference']}.</h2>");
					echo $conf_sents[rand(0, 2)];
				}
				else echo "<h2>The paper does not publish in any conference.</h2>";
				
				$year_sents = array("<h2>According to Acemap, the paper was published at {$paper_info['PaperPublishYear']}.</h2>",
				"<h2>The birth year of this paper is {$paper_info['PaperPublishYear']}.</h2>",
				"<h2>In the year of {$paper_info['PaperPublishYear']}, this paper was published.</h2>");
				echo $year_sents[rand(0, 2)];
				
			?>
		<br><br><br><br><br><br><br><br>
		</div>
	</div>
</div>
</div>

<!-- section 1 -->
<div class="stats-section-1 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-6 column py-5">
				<div class="panel">
					<div class="panel-body stats-panel-1">
					<div id="rtd1-div">
					<svg onclick="$('#rtd1-div').hide('slow');$('#rtd2-div').show('slow');" width="700" height="400" id="rtd1" class="center-block" />
					<h2 style="color:black">Times being refered in each year</h2>
					</div>
					<div id="rtd2-div">
					<svg onclick="$('#rtd2-div').hide('slow');$('#rtd1-div').show('slow');" width="700" height="400" id="rtd2" class="center-block" />
					<h2 style="color:black">Reference year distribution</h2>
					</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 column py-5">
			<h1>Reference Time Distribution</h1>
			<h2>This graph shows how much papers the current paper was cited in each year, and the publish years of its references.</h2>
			<h2>To switch between views, please click the graph.</h2>
			</div>
		</div>
	</div>
</div>

<!-- section 2 -->
<div class="stats-section-0 text-center py-5">
	<div class="container-fluid">
		<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="carousel slide" id="carousel-767845">
				<ol class="carousel-indicators">
					<li data-slide-to="0" data-target="#carousel-767845">
					</li>
					<li data-slide-to="1" data-target="#carousel-767845" class="active">
					</li>
					<li data-slide-to="2" data-target="#carousel-767845">
					</li>
				</ol>
				<div class="carousel-inner">
					<div class="item">
						<div class="row clearfix">
							<div class="col-md-12 column">
							<br><br><br><br><br><br><br><br>
							</div>
						</div>
					</div>
					<div class="item active">
						<div class="row clearfix">
							<div class="col-md-12 column">
							<br><br><br><br><br><br><br><br>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row clearfix">
							<div class="col-md-12 column">
							<br><br><br><br><br><br><br><br>
							</div>
						</div>
					</div>
				</div> <a class="left carousel-control" href="#carousel-767845" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-767845" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
		</div>
	</div>
	</div>
</div>

<br><br><br>

<!-- plot operations -->
<script type='text/javascript'>
plot_vertical_bar("<?php echo site_url("visual/paper_referred?paper_id=$paper_id"); ?>", "#rtd1", "ref");
plot_vertical_bar("<?php echo site_url("search/paper_referring?paper_id=$paper_id"); ?>", "#rtd2", "ref");
$("#rtd2-div").hide();
</script>