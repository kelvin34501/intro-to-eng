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
					<!-- Searching results should be put here -->
					<!--
						recommanded format for each item
							if not first item in this list:
								<hr>
							<div class='panel-item-title-0'>
								[index].[&nbsp][<a>author name</a>]
							</div>
							<div class='panel-item-content-0'>
								[&nbsp*5]Author ID:[&nbsp][author id][&nbsp*2]-[&nbsp*2]Paper Publish:[&nbsp][total paper]<br>
								[&nbsp*5]Major Affiliation:[&nbsp][<a>major affiliation</a>]<br>
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