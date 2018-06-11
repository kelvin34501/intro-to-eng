<!-- info display -->
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-2"></div>
		<div class="col-md-8 column py-5">
		<div class="stats-info">
		<br><br>
			<?php
				echo "<h1>".ucwords($paper_info['Title'])."</h1><br>";
				
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
<div class="stats-section-1 text-center py-5" id="rtd-g">
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
<div class="stats-section-0 text-center py-5" id="rec-g">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-12 column py-5">
			<h1>Recommendation</h1>
			</div>
		</div>
		<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="carousel slide" id="carousel-767845">
				<ol class="carousel-indicators">
					<?php for($i=0;$i<count($recommends);$i++){ ?>
						<li data-slide-to="<?php echo $i; ?>" data-target="#carousel-767845" <?php if($i==0) echo "class='active'"; ?>>
						</li>
					<?php } ?>
				</ol>
				<div class="carousel-inner">
					<?php for($i=0;$i<count($recommends);$i++){ ?>
						<div class="item <?php if($i==0) echo "active"; ?>">
						<div class="row clearfix">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="panel">
								<div class="panel-body panel-dark-body">
									<div class="panel-item-title-0"><a href="<?php echo base_url()."lab/view_paper?paper_id={$recommends[$i]['PaperID']}"; ?>"><?php echo "&nbsp&nbsp".ucwords($recommends[$i]['Title']); ?></a></div>
									<div class="panel-item-content-0">&nbsp Paper ID: <?php echo $recommends[$i]['PaperID']; ?> - Venue: <?php echo ucwords($recommends[$i]['ConferenceName']); ?> - Published Year: <?php echo $recommends[$i]['PaperPublishYear']; ?> - Times Cited: <?php echo $recommends[$i]['ReferenceNum']; ?></div><hr>
									<div class="panel-item-title-0">&nbsp&nbspWe recommend this paper to you because:</div>
									<div class="panel-item-content-0">
									<?php
									$offset = 0;
									if(isset($recommends[$i]['coA'])){
										echo "&nbsp&nbspIt shares same coauthors: ";
										for($j=0;$j<count($recommends[$i]['coA']);$j++)
										{
											if($j > 0) echo ", ";
											echo "<a href=\"".base_url()."lab/view_author?author_id=".$recommends[$i]['coA'][$j]['AuthorID']."\">".ucwords($recommends[$i]['coA'][$j]['AuthorName'])."</a>";
										}
										echo ".<br>";
									}
									else $offset += 1;
									if(isset($recommends[$i]['coR'])){
										echo "&nbsp&nbspIt shares same references: ";
										for($j=0;$j<count($recommends[$i]['coR']);$j++)
										{
											if($j > 0) echo ", ";
											echo "<a href=\"".base_url()."lab/view_paper?paper_id=".$recommends[$i]['coR'][$j]['PaperID']."\">".ucwords($recommends[$i]['coR'][$j]['Title'])."</a>";
										}
										echo ".<br>";
									}
									else $offset += 1;
									if(isset($recommends[$i]['coL'])){
										echo "&nbsp&nbspIt shares same labels: ";
										for($j=0;$j<count($recommends[$i]['coL']);$j++)
										{
											if($j > 0) echo ", ";
											echo "<a href=\"".base_url()."lab/search_paper?paper=".$recommends[$i]['coL'][$j]."\">".ucwords($recommends[$i]['coL'][$j])."</a>";
										}
										echo ".<br>";
									}
									else $offset += 1;
									echo "&nbsp&nbspIt has a similarity score of ".$recommends[$i]['Score'].".";
									for($j=0;$j<$offset;$j++) echo "<br>";
									?>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						</div>
					<?php } ?>
				</div> 
				<br><br><br>
				<a class="left carousel-control" href="#carousel-767845" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-767845" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
		</div>
	</div>
	</div>
<br><br><br><br><br>
</div>

<!-- plot operations -->
<script type='text/javascript'>
plot_vertical_bar("<?php echo site_url("visual/paper_referred?paper_id=$paper_id"); ?>", "#rtd1", "ref");
plot_vertical_bar("<?php echo site_url("visual/paper_referring?paper_id=$paper_id"); ?>", "#rtd2", "ref");
$("#rtd2-div").hide();
</script>