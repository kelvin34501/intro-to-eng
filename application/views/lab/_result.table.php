<?php foreach($query_result as $author_item): ?>

    <div class="col-md-3" >
        <center>
            <h3><?php echo $author_item['AuthorID']; ?></h3>
        </center>
        <div class="row" >
            <div class="col" >
                Author Name:
            </div>
            <div class="col" >
                <?php echo $author_item['AuthorName']; ?>
            </div>
        </div>
        <div class="row" >
            <div class="col" >
                Paper Count:
            </div>
            <div class="col" >
                <?php echo $author_item['PaperNum']; ?>
            </div>
        </div>
        <div class="row" >
            <div class="col" >
                <?php echo $author_item['AffiliationName']; ?>
            </div>
        </div>
        <p><a href="<?php echo base_url('lab/author?author_id='.$author_item['AuthorID']); ?>">View Author</a></p>
    </div>

<?php endforeach; ?>
