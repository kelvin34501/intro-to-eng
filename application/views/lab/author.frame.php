<div class="container-fluid author-theme-0">
<br><br>
	<div class="row clearfix">
		<div class="col-md-8 column">
		<div class="panel">
			<div class="panel-heading panel-dark-title">
				<h3 class="panel-title centering">
					Papers
				</h3>
			</div>
			<div class="panel-body panel-dark-body" id="lab-author-panel-main">
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
			<ul class="pagination pagination-dark" id="lab-author-pagination">
				<!-- pagination should be put here -->
			</ul>
		</div>
		</div>
		<div class="col-md-4 column">
		<div class="panel panel-primary">
		<div class="panel-body text-center bg-primary">
				Author name: <?php echo ucwords($author_info[0]['author_name']);?><br>
				Author ID: <?php echo $author_info[0]['author_id']; ?>
		</div>
		</div>
		<div class="panel panel-primary">
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
				<a href="###" class="list-group-item text-center active" id="af-control">Affiliations</a>
				<div id="af-items">
					<!-- top affiliations should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[affiliation name]</a>
							</div>
					-->
					<div class="list-group-item-text text-center">
							<ul class="pagination pagination-sm" id="lab-sidebar-pagination-af">
								<!-- pagination should be put here -->
							</ul>
					</div>
				</div>
				
				<a href="###" class="list-group-item text-center active" id="cf-control">Conferences</a>
				<div id="cf-items">
					<!-- top conferences should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[conference name]</a>
							</div>
					-->
					<div class="list-group-item-text text-center">
							<ul class="pagination pagination-sm" id="lab-sidebar-pagination-cf">
								<!-- pagination should be put here -->
							</ul>
					</div>
				</div>
				
				<a href="###" class="list-group-item text-center active" id="ca-control">Coauthors</a>
				<div id="ca-items">
					<!-- most cooperative coauthors should be listed here -->
					<!--
						recommanded format for each item:
							<div class="list-group-item">
								<a>[coauthor name]</a>
							</div>
					-->
					<div class="list-group-item-text text-center">
							<ul class="pagination pagination-sm" id="lab-sidebar-pagination-ca">
								<!-- pagination should be put here -->
							</ul>
					</div>
				</div>
			
			<!-- Whether this part will be implemented remains to be seen -->
			<a href="###" class="list-group-item text-center active" id="lb-control">Labels</a>
			<div id="lb-items">
					<div class="list-group-item">
						<a href="#">lb1</a>
					</div>
					<div class="list-group-item">
						<a href="#">lb2</a>
					</div>
					<div class="list-group-item">
						<a href="#">lb3</a>
					</div>
					<div class="list-group-item-text text-center">
							<ul class="pagination pagination-sm">
								<li>
									 <a href="#">Prev</a>
								</li>
								<li>
									 <a href="#">1</a>
								</li>
								<li>
									 <a href="#">2</a>
								</li>
								<li>
									 <a href="#">3</a>
								</li>
								<li>
									 <a href="#">4</a>
								</li>
								<li>
									 <a href="#">5</a>
								</li>
								<li>
									 <a href="#">Next</a>
								</li>
							</ul>
					</div>
			</div>
			</div>
		
		</div>
		
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column centering">
			<!-- This should be deleted when the pressed event is added to breadcrumb -->
			<!-- Or the URLs should be changed -->
			<h3>
			<?php
				echo "<a href='".site_url("search/view_home?")."'>Home</a>";
				if($rpage > 0)
					echo "&nbsp&nbsp<a href='".site_url("search/view_result/$rpage?name=$name&vague=$vague")."'>Result</a>";
				echo "<br>";
				?>
				<br>
			</h3>
		</div>
	</div>
</div>

<script src="<?php echo base_url().'assets/js/Lab/shared/sidebar.js' ?>" ></script>
