<?php $vague="enabled";?>
<?php echo validation_errors(); ?>

<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-12 column centering">
		<h3>
			<!-- Action should be changed -->
			<form method='get' action='<?php echo "select_view"; ?>' >
			<h3 class="text-center" id='author-search-title' style="color:#ffffff">Author Search</h3>
			<div id='author-search'>
			Author name:
			<input type="text" id="author" name="author" value="">
			<br><br>
			<!-- Consider to discard the vague selection or move to global vague selection -->
			Vague Search:
			   <input type="radio" name="vague" <?php if (isset($vague) && $vague=="disabled") echo "checked";?>  value="disabled">Disabled
			   <input type="radio" name="vague" <?php if (isset($vague) && $vague=="enabled") echo "checked";?>  value="enabled">Enabled
			</div>
			
			<h3 class="text-center" id='affiliation-search-title' style="color:#ffffff">Affiliation Search</h3>
			<div id='affiliation-search'>
			Affiliation name:
			<input type="text" id="affiliation" name="affiliation" value="">
			</div>
			
			<h3 class="text-center" id='conference-search-title' style="color:#ffffff">Conference Search</h3>
			<div id='conference-search'>
			Conference name:
			<input type="text" id="conference" name="conference" value="">
			</div>
			
			<h3 class="text-center" id='paper-search-title' style="color:#ffffff">Paper Search</h3>
			<div id='paper-search'>
			Paper title:
			<input type="text" id="paper" name="paper" value="">
			</div>

			
			<h3 class="text-center" style="color:#ffffff" id='id-search-title'>ID Search</h3>
			<div id='id-search'>
			ID:
			<input type="text" id="id" name="author-id" value="">
			</div><br>

			
			<input type="submit" value="Launch" value="">
			</form>
		</h3>
	    </div>
	</div>
</div>

<script src="<?php echo base_url().'assets/js/Lab/home/animation.js' ?>" ></script>
<script src="<?php echo base_url().'assets/js/Lab/home/autocompletes.js' ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url()."assets/css/Lab/home/search_section_style.css"; ?>" />
