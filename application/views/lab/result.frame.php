<div class="container-fluid">
<br><br>
	<div class="row clearfix">
		<div class="col-md-2 column">
		</div>
		<div class="col-md-8 column">
			<div class="alert alert-info alert-dismissable">
					 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4 class="text-center"><?php echo $total_result; ?> matches were found in database.</h4>
			</div>
			
			<!-- author display -->
			<?php if($display_author){ ?>
				<div class="panel">
					<div class="panel-heading panel-dark-title">
						<h3 class="panel-title centering">
							Author Results
						</h3>
					</div>
					<div class="panel-body panel-dark-body" id="lab-result-author-panel">
						<!-- Author search results should be put here -->
						<!--
							recommanded format for author results
								if not first item in this list:
									<hr>
								<div class='panel-item-title-0'>
									[index].[&nbsp][<a>author name</a>]
								</div>
								<div class='panel-item-content-0'>
									[&nbsp*5]Author ID:[&nbsp][author id][&nbsp*2]-[&nbsp*2]Paper Published:[&nbsp][total paper]<br>
									[&nbsp*5]Major Affiliation:[&nbsp][<a>major affiliation</a>]
								</div>
						-->
					</div>
				</div>
				<div class="centering">
					<ul class="pagination pagination-dark" id="lab-result-author-pagination">
						<!-- pagination should be put here -->
					</ul>
				</div>
			<?php } ?>
			
			<!-- affiliation display -->
			<?php if($display_affiliation){ ?>
				<div class="panel">
					<div class="panel-heading panel-dark-title">
						<h3 class="panel-title centering">
							Affiliation Results
						</h3>
					</div>
					<div class="panel-body panel-dark-body" id="lab-result-affiliation-panel">
						<!-- Affiliation search results should be put here -->
						<!--
							recommanded format for affiliation results
								if not first item in this list:
									<hr>
								<div class="panel-item-title-0">[index].[&nbsp][<a>affiliation name</a>]</div>
								<div class="panel-item-content-0">
										[&nbsp*5]Affiliation ID:[&nbsp][affiliation id][&nbsp*2]-[&nbsp*2]Total Paper: [total paper]
								</div>
						-->
					</div>
				</div>
				<div class="centering">
					<ul class="pagination pagination-dark" id="lab-result-affiliation-pagination">
						<!-- pagination should be put here -->
					</ul>
				</div>
			<?php } ?>
			
			<!-- conference display -->
			<?php if($display_conference){ ?>
				<div class="panel">
					<div class="panel-heading panel-dark-title">
						<h3 class="panel-title centering">
							Conference Results
						</h3>
					</div>
					<div class="panel-body panel-dark-body" id="lab-result-conference-panel">
						<!-- Conference search results should be put here -->
						<!--
							recommanded format for conference results
								if not first item in this list:
									<hr>
								<div class="panel-item-title-0">[index].[&nbsp][<a>conference name</a>]</div>
								<div class="panel-item-content-0">
										[&nbsp*5]Conference ID:[&nbsp][conference id][&nbsp*2]-[&nbsp*2]Total Publication: [total publication]
								</div>
						-->
					</div>
				</div>
				<div class="centering">
					<ul class="pagination pagination-dark" id="lab-result-conference-pagination">
						<!-- pagination should be put here -->
					</ul>
				</div>
			<?php } ?>
			
			<!-- paper display -->
			<?php if($display_paper){ ?>
				<div class="panel">
					<div class="panel-heading panel-dark-title">
						<h3 class="panel-title centering">
							Paper Results
						</h3>
					</div>
					<div class="panel-body panel-dark-body" id="lab-result-paper-panel">
						<!-- Paper search results should be put here -->
						<!--
							recommanded format for paper results
								if not first item in this list:
									<hr>
								<div class="panel-item-title-0">[index].[&nbsp][<a>paper title</a>]</div>
								<div class="panel-item-content-0">
										[&nbsp*5]Paper ID:[&nbsp][paper id][&nbsp*2]-[&nbsp*2]Venue: [<a>conference</a>]<br>
										[&nbsp*5]Published Year: [published year][&nbsp*2]-[&nbsp*2]Times Cited: [referenced times]<br>
										[&nbsp*5]Coauthors: [<a>author_name</a>, ]
								</div>
						-->
					</div>
				</div>
				<div class="centering">
					<ul class="pagination pagination-dark" id="lab-result-paper-pagination">
						<!-- pagination should be put here -->
					</ul>
				</div>
			<?php } ?>
			
		</div>
		<div class="col-md-2 column">
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 centering">
			<!-- This should be deleted when the pressed event is added to breadcrumb -->
			<!-- Or the URLs should be changed -->
			<h3>
			<?php
				echo "<a href='".site_url("search/view_home?")."'>Home</a><br>";
			?>
			<br>
			</h3>
		</div>
	</div>
</div>

<?php if (!isset($dyn_pagin)) { ?>
	<script src="<?php echo base_url().'assets/js/Lab/shared/pagin.js'; ?>" ></script>
<?php } ?>