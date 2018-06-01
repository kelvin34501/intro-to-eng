<div class="container-fluid">
<br><br>
	<div class="row clearfix">
		<div class="col-md-8 column">
			<div class="panel">
				<div class="panel-heading panel-dark-title">
					<h3 class="panel-title centering">
						Authors
					</h3>
				</div>
				<div class="panel-body panel-dark-body" id="lab-affiliation-panel-main">
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
				<ul class="pagination pagination-dark" id="lab-affiliation-pagination">
					<!-- pagination should be put here -->
				</ul>
			</div>
		</div>
		<div class="col-md-4 column">
			<div class="panel panel-primary borderless">
				<div class="panel-body text-center bg-primary">
						Affiliation name: <?php echo ucwords($affiliation_name);?><br>
						Affiliation ID: <?php echo $affiliation_id; ?>
				</div>
			</div>
			<div class="list-group">
				<a href="###" class="list-group-item text-center active" id="fpp-control">Paper</a>
				<div id="fpp-items">
					<!-- papers whose first author is from this affiliation -->
					<!--
						recommanded format for each item
							<div class="list-group-item">
								<a>[paper name]</a>
							</div>
					-->
					<div class="list-group-item-text text-center">
							<ul class="pagination pagination-sm" id="lab-sidebar-pagination-fpp">
								<!-- pagination should be put here -->
							</ul>
					</div>
				</div>
			
				<!-- whether this will be implemented remains to be seen -->
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
</div>