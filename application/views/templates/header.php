<!DOCTYPE html>
<html>
	  <head>
		    <title>Acemap Search Engine</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="<?php echo base_url('vendor/components/jqueryui/themes/smoothness/jquery-ui.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap3/dist/css/bootstrap.css'); ?>" />

        <script type="text/javascript" src="<?php echo base_url('vendor/components/jquery/jquery.js'); ?>" ></script>
        <script type="text/javascript" src="<?php echo base_url('vendor/components/jqueryui/jquery-ui.js'); ?>" ></script>
        <script type="text/javascript" src="<?php echo base_url('node_modules/bootstrap3/dist/js/bootstrap.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'node_modules/d3v4/build/d3.js'; ?>" ></script>


		<!-- import default theme -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/Lab/themes/theme.css'); ?>" />
		
		<!-- import sidebar utils -->
		<script src="<?php echo base_url().'assets/js/Lab/shared/sidebar.js' ?>" ></script>
		
		<!-- import loader -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'vendor/components/loader/loader.css' ?>" />
		
		<!-- import velocity -->
		<link rel="stylesheet" href="<?php echo base_url().'vendor/components/velocity/velocity-style.css' ?>" />
		<script type="text/javascript" href="<?php echo base_url().'vendor/components/velocity/velocity.min.js' ?>"></script>
		<script type="text/javascript" href="<?php echo base_url().'vendor/components/velocity/velocity.ui.min.js' ?>"></script>
		
		<!-- import myplots -->
		<script src=<?php echo base_url().'assets/js/Lab/shared/myplots.js'; ?>></script>
		<script src=<?php echo base_url().'assets/js/Lab/shared/d3.layout.cloud.js' ?>></script>
	  </head>

	<script type="text/javascript">
		$(window).on('load', function() {
			$('body').addClass('loaded');
			setTimeout("$('.load_title #loader-wrapper').remove();", 2000);
			// $('.load_title #loader-wrapper').remove();
		});
	</script>
	<div id="loader-wrapper" class="load_title" >
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	  
	  
    <body class='home-bg' <?php if(stristr($title, 'stats')){ ?>data-spy="scroll" data-target="#scroll-listener" <?php } ?>>

