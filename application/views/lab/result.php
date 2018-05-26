<script>
 <!-- store the page information -->
 var page = <?php echo $page; ?>;
 var startpage = <?php echo $startpage; ?>;
 var endpage = <?php echo $endpage; ?>;
 var baseurl = "<?php echo base_url(); ?>";
 var field = "<?php echo $field; ?>";
</script>

<div class="row" >
    <div class="col" >
        <center>
            <h1><?php echo $title; ?></h1>
        </center>
    </div>
</div>

<div class="row" id="lab-result-table">
    <!-- empty here -->
</div>

<div class="row" >
    <div class="col-xs-8 mx-auto" >
        <ul class="pagination" id="lab-result-navi" >
           <!-- empty here, fill with json -->
        </ul>
    </div>
</div>
<div class="row" >
    <div class="col" >
        <center>
            <p><a href="<?php echo base_url(); ?>">Return</a></p>
        </center>
    </div>
</div>

<script src="<?php echo base_url().'assets/js/Lab/result/navi.js' ?>" ></script>
