<link rel="stylesheet"
      type="text/css"
      href="<?php echo base_url().'assets/css/Lab/author/visual.css' ?>" />
<!-- comment this; d3 version in composer repoistory is too low -->
<!-- <script src="<?php echo base_url().'vendor/mbostock/d3/d3.js'; ?>" ></script> -->
<script src="https://d3js.org/d3.v4.min.js"></script>

<script>
 <!-- store the page information -->
 var page = <?php echo $page; ?>;
 var startpage = <?php echo $startpage; ?>;
 var endpage = <?php echo $endpage; ?>;
 var baseurl = "<?php echo base_url(); ?>";
 var field = "<?php echo $author_item['AuthorID']; ?>";
 var tgt = "<?php echo base_url() ?>" + "lab/" +
  "<?php echo $visual_handler; ?>" + "?author_id=" + field;
</script>

<div class="row" >
    <div class="col-sm-6" >
        <center>
            <h1><?php echo $author_item['AuthorID']; ?></h1>
        </center>
    </div>
    <div class="col-sm-6" >
        <center>
            <h1><?php echo $author_item['AuthorName']; ?></h1>
        </center>
    </div>
</div>

<?php if($author_affi) { ?>
    <div class="row" >
        <h2><?php echo 'Affiliation: '; ?></h2>
    </div>

    <div class="row" >
        <div class="col" >
            <h5><?php echo $author_affi; ?></h5>
        </div>
    </div>
<?php } ?>

<div class="row" >
    <h2><?php echo 'Relationship Network: ' ?></h2>
</div>

<div class="row" >
    <div class="col-xs-12 mx-auto" >
        <svg width="960" height="400"></svg>
    </div>
</div>

<div class="row" >
    <h2><?php echo 'Paper List: ' ?></h2>
</div>

<div class="row" >
    <div class="col-xs-8 mx-auto" >
        <ul class="pagination" id="lab-author-navi" >
            <!-- empty here, fill with json -->
        </ul>
    </div>
</div>

<div class="row" >
    <div class="col" >
        <table class="table table-hover" >
            <thead>
                <tr>
                    <th>Paper ID</th>
                    <th>Title</th>
                    <th>Reference Count</th>
                    <th>Conference Name</th>
                    <th>Published Year</th>
                    <th>Author List</th>
                </tr>
            </thead>
            <tbody id="lab-author-table">
                <!-- empty here -->
            </tbody>
        </table>
    </div>
</div>

<div class="row" >
    <div class="col" >
        <center>
            <p><a href="<?php echo base_url(); ?>">Return</a></p>
        </center>
    </div>
</div>

<script src="<?php echo base_url().'assets/js/Lab/author/view.js' ?>" ></script>
<script src="<?php echo base_url().'assets/js/Lab/author/visual.js' ?>" ></script>
