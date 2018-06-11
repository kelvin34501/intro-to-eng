<div class="container-fluid">
<br><br>
	<div class="row clearfix">
		<div class="col-md-8 column">
		<div class="panel">
			<div class="panel-heading panel-dark-title">
				<h3 class="panel-title centering">
					Papers
				</h3>
			</div>
			<div class="panel-body panel-dark-body" id="lab-author-main-panel">
				<!-- Author's papers should be listed here -->
				<!--
					recommanded format for each item
						if not first item in this list:
							<hr>
						<div class="panel-item-title-0">[index].[&nbsp][<a>paper title</a>]</div>
						<div class="panel-item-content-0">
								[&nbsp*5]Paper ID:[&nbsp][paper id][&nbsp*2]-[&nbsp*2]Venue: [conference]<br>
								[&nbsp*5]Published Year: [published year][&nbsp*2]-[&nbsp*2]Times Cited: [referenced times]<br>
								[&nbsp*5]Coauthors: [<a>author_name</a>, ]
						</div>
				-->
			</div>
		</div>
		<div class="text-center">
			<ul class="pagination pagination-dark" id="lab-author-main-pagination">
				<!-- pagination should be put here -->
			</ul>
		</div>
		</div>
		<div class="col-md-4 column">
		<div class="panel panel-primary borderless">
		<div class="panel-body text-center bg-primary">
				Author name: <?php echo ucwords($author_name);?><br>
				Author ID: <?php echo $author_id; ?>
		</div>
		</div>
		<div class="panel panel-primary borderless">
			<div class="panel-heading">
				<h3 class="panel-title centering">
					Cooperation Network
				</h3>
			</div>
			<div class="panel-body">
				<svg width="450" height="450" id="cn" class="center-block">
			</div>
		</div>
		<div class="list-group">
			<a href="###" class="list-group-item text-center active" id="lab-author-sidebar-af-control">Affiliations</a>
			<div id="lab-author-sidebar-af-box">
				<div id="lab-author-sidebar-af-items" >
					<!-- top affiliations should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[affiliation name]</a>
							</div>
					-->
				</div>
				<div class="list-group-item-text text-center">
					<ul class="pagination pagination-sm" id="lab-author-sidebar-af-pagination">
						<!-- pagination should be put here -->
					</ul>
				</div>
			</div>
			
			<a href="###" class="list-group-item text-center active" id="lab-author-sidebar-cf-control">Conferences</a>
			<div id="lab-author-sidebar-cf-box">
				<div id="lab-author-sidebar-cf-items" >
					<!-- top conferences should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[conference name]</a>
							</div>
					-->
				</div>
				<div class="list-group-item-text text-center">
						<ul class="pagination pagination-sm" id="lab-author-sidebar-cf-pagination">
							<!-- pagination should be put here -->
						</ul>
				</div>
			</div>
			
			<a href="###" class="list-group-item text-center active" id="lab-author-sidebar-ca-control">Coauthors</a>
			<div id="lab-author-sidebar-ca-box">
				<div id="lab-author-sidebar-ca-items" >
					<!-- most cooperative coauthors should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[coauthor name]</a>
							</div>
					-->
				</div>
				<div class="list-group-item-text text-center">
						<ul class="pagination pagination-sm" id="lab-author-sidebar-ca-pagination">
							<!-- pagination should be put here -->
						</ul>
				</div>
			</div>
		
			<!-- Whether this part will be implemented remains to be seen -->
			<a href="###" class="list-group-item text-center active" id="lab-author-sidebar-lb-control">Labels</a>
			<div id="lab-author-sidebar-lb-box">
				<div id="lab-author-sidebar-lb-items">
				</div>
				<div class="list-group-item-text text-center">
						<ul class="pagination pagination-sm" id="lab-author-sidebar-lb-pagination">
						</ul>
				</div>
			</div>
			</div>
		
		</div>
		
	</div>
</div>

<script>
	plot_force_direct_graph("<?php echo site_url("visual/get_cn_neighbor?author_id=$author_id"); ?>");
</script>