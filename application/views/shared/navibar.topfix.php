<nav class="navbar navbar-inverse navbar-fixed-top" >
	<div class="navbar-inner">
    <div class="container-fluid">
		<div class="row clearfix">
		<br>
			<div class="col-md-12 column">
			<div class="navbar-header centering" role="navigation">
				<a style="font-size:40px" class="navbar-brand mb-0 h0" href="#"><?php echo $title; ?></a>
			</div>
			<div  class="text-right">
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php if(stristr($title, "page")){ ?>
					<li><a href="<?php
						if(stristr($title, "author")) echo site_url("lab/view_author_stats?title=$title&item_id=".$author_id);
						elseif(stristr($title, "paper")) echo site_url("lab/view_paper_stats?title=$title&item_id=".$paper_id);
						elseif(stristr($title, "affiliation")) echo site_url("lab/view_affiliation_stats?title=$title&item_id=".$affiliation_id);
					?>"><span class="glyphicon glyphicon-stats"></span> Stats</a></li>
					<?php 
					}
					elseif(stristr($title, "stats")) {
					?>
					<li><a href="<?php echo $_SERVER['HTTP_REFERER']?>"><span class="glyphicon glyphicon-th-list"></span> Lists</a></li>
					<?php } ?>
					<li><a href="#help"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
				</ul>
				<form class="form-inline m-2" action="hyper_search">
				  <input class="form-control mr-2" type="text" name="name" placeholder="Search">
				  <button class="btn btn-primary" type="submit">Search</button>
				</form>
			</div>
			</div>
			</div>
		</div>
		<?php if(stristr($title, "page")){ ?>
		<div class="row clearfix">
			<div class="col-md-12 column">
			<ul class="breadcrumb breadcrumb-setting-0 h1">
				<li class="breadcrumb-item">
					 <a href="###" id="home-link">Home</a>
				</li>
				<?php if($title=="Result Page"){ ?>
				<li class="breadcrumb-item active" style="color:#FFFFFF">
					Result
				</li>
				<?php }
				elseif($title=="Author Page"){ ?>
				<li class="breadcrumb-item">
					 <a href="###" id="result-link">Result</a>
				</li>
				<li class="breadcrumb-item active" style="color:#FFFFFF">
					Author
				</li>
				<?php }
				elseif($title=="Paper Page"){ ?>
				<li class="breadcrumb-item">
					 <a href="###" id="result-link">Result</a>
				</li>
				<li class="breadcrumb-item active" style="color:#FFFFFF">
					Paper
				</li>
				<?php }
				elseif($title=="Affiliation Page"){	?>
				<li class="breadcrumb-item">
					 <a href="###" id="result-link">Result</a>
				</li>
				<li class="breadcrumb-item active" style="color:#FFFFFF">
					Affiliation
				</li>
				<?php }
				elseif($title=="Conference Page"){	?>
				<li class="breadcrumb-item">
					 <a href="###" id="result-link">Result</a>
				</li>
				<li class="breadcrumb-item active" style="color:#FFFFFF">
					Conference
				</li>
				<?php } ?>
			</ul>
			</div>
		</div>
		<?php } ?>
	</div>
	</div>
	</nav><br><br><br><br>
