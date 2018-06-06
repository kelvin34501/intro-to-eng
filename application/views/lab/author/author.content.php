<!-- authors who have published in this conference -->
<!--
    recommanded format for each item
        <div class="list-group-item">
            <a>au1</a>
        </div>
-->
<?php foreach($query_result as $index => $author_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'lab/view_author?author_id='.$author_item['AuthorID']; ?>"
        ><?php echo ucwords($author_item['AuthorName']); ?></a>
    </div>
<?php endforeach ?>