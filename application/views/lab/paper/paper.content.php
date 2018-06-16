<!-- papers whose first author is from this affiliation -->
<!--
    recommanded format for each item
        <div class="list-group-item">
            <a>[paper name]</a>
        </div>
-->
<?php foreach($query_result as $index => $paper_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'/lab/view_paper?paper_id='.$paper_item['PaperID']; ?>" 
        title="<?php echo ucwords($paper_item['Title']); ?>" >
            <?php 
                $tmp = ucwords($paper_item['Title']);
                if (strlen($tmp) > 25) {
                    $tmp=substr($tmp,0,25).'...';
                }
                echo $tmp;
            ?>
            &nbsp(<?php echo $paper_item['ReferenceNum']; ?>)
        </a>
    </div>
<?php endforeach ?>