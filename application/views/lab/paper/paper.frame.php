<div class="contrainer-fluid">
<br><br>
	<div class="row clearfix">
		<div class="col-md-8">
			<div class="panel-group" id="panel-167619">
				<div class="panel">
					<div class="text-center">
					<div class="panel-heading panel-dark-toggle-title">
						 <a class="panel-title" data-toggle="collapse" data-parent="#panel-150618" href="#panel-element-150600">Authors</a>
					</div>
					</div>
					<div id="panel-element-150600" class="panel-collapse collapse in">
						<div class="panel-body panel-dark-body text-center">
						<table class="table table-bordered">
							<thead>
								<tr>
								<th class="text-center">Sequence</th>
								<th class="text-center">Author Name</th>
								<th class="text-center">Affiliation</th>
								</tr>
							</thead>
							<tbody id="lab-paper-panel-ca-items">
								<!-- fill by js -->
							</tbody>
						</table>
							<ul class="pagination pagination-dark" id="lab-paper-panel-ca-pagination">
								<!-- fill by js -->
							</ul>
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="text-center">
					<div class="panel-heading panel-dark-toggle-title">
						 <a class="panel-title" data-toggle="collapse" data-parent="#panel-167619" href="#panel-element-150618">References</a>
					</div>
					</div>
					<div id="panel-element-150618" class="panel-collapse collapse in">
						<div class="panel-body panel-dark-body" id="lab-paper-reference-panel">
							<div id="lab-paper-reference-items" >
								<!-- Paper's references should be pu here -->
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
							<div class="text-center">
							<hr>
							<ul class="pagination pagination-dark" id="lab-paper-reference-pagination">
								<!-- pagination should be put here -->
							</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="text-center">
					<div class="panel-heading panel-dark-toggle-title">
						 <a class="panel-title" data-toggle="collapse" data-parent="#panel-167619" href="#panel-element-211967">Cited by</a>
					</div>
					</div>
					<div id="panel-element-211967" class="panel-collapse collapse">
						<div class="panel-body panel-dark-body" id="lab-paper-citedby-panel">
							<div id="lab-paper-citedby-items" >
								<!-- Paper's cited-by should be pu here -->
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
							<div class="text-center">
							<hr>
							<ul class="pagination pagination-dark" id="lab-paper-citedby-pagination">
								<!-- pagination should be put here -->
							</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 column">
			<div class="panel panel-primary borderless">
				<div class="panel-body bg-primary text-center">
					Paper Title: <?php echo ucwords($paper_title); ?><br>
					Paper ID: <?php echo $paper_id; ?><br>
					Publish Year: <?php echo $published_year; ?>
					&nbsp&nbsp-&nbsp&nbsp
					Venue: 
						<a href="<?php echo base_url().'lab/view_conf?conf_id='.$venue_id; ?>" 
							style="color:#FFFFFF" >
						<?php echo $venue; ?></a>
					<br>
					Times Cited: <?php echo $times_cited; ?>
					&nbsp&nbsp-&nbsp&nbsp
					Total References: <?php echo $total_references; ?><br>
				</div>
			</div>
			<div class="list-group">

					<!-- Whether this part will be implemented remains to be seen -->
					<a href="###" class="list-group-item text-center active" id="lab-paper-sidebar-lb-control">Labels</a>
					<div id="lab-paper-sidebar-lb-items">
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
								<ul class="pagination pagination-sm" id="lab-paper-sidebar-lb-pagination">
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