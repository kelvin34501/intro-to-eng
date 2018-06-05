<?php $vague="enabled";?>

<div class="container-fluid">
	  <div class="row clearfix">
		    <div class="col-md-12 column centering">
		        <h3>
			          <!-- Action should be changed -->
			          <form method='get' action='<?php echo $result_handler; ?>' >
			              <h3 class="text-center" id='author-search-title' style="color:#ffffff">Author Search</h3>
			              <div id='author-search'>
			                  Author name:
			                  <input type="text" id="author" name="author" value="">
			                  <br>
			              </div>

			              <h3 class="text-center" id='affiliation-search-title' style="color:#ffffff">Affiliation Search</h3>
			              <div id='affiliation-search'>
			                  Affiliation name:
							  <input type="text" id="affiliation" name="affiliation" value="">
							  <br>
			              </div>

			              <h3 class="text-center" id='conference-search-title' style="color:#ffffff">Conference Search</h3>
			              <div id='conference-search'>
			                  Conference name:
							  <input type="text" id="conference" name="conference" value="">
							  <br>
			              </div>

			              <h3 class="text-center" id='paper-search-title' style="color:#ffffff">Paper Search</h3>
			              <div id='paper-search'>
			                  Paper title:
							  <input type="text" id="paper" name="paper" value="">
							  <br>
			              </div>


			              <h3 class="text-center" style="color:#ffffff" id='id-search-title'>ID Search</h3>
			              <div id='id-search'>
			                  ID:
							  <input type="text" id="id" name="id" value="">
							  <br>
			              </div><br>

			              <input type="submit" value="Launch" value="">
			          </form>
		        </h3>
	      </div>
	  </div>
</div>

<script src="<?php echo base_url().'assets/js/Lab/home/animation.js'; ?>" ></script>
<script>
	var author_completer = "<?php echo base_url().'autocomplete/search_author'; ?>";
	var affi_completer = "<?php echo base_url().'autocomplete/search_affi'; ?>";
	var conference_completer = "<?php echo base_url().'autocomplete/search_conference'; ?>";
	var paper_completer = "<?php echo base_url().'autocomplete/search_paper'; ?>";
</script>
<script src="<?php echo base_url().'assets/js/Lab/home/autocompletes.js'; ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url()."assets/css/Lab/home/search_section_style.css"; ?>" />
