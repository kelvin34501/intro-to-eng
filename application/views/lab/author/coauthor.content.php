<!-- most cooperative coauthors should be listed here -->
<!--
    recommanded format for each item:
        <div class="list-group-item">
            <a>[coauthor name]</a>
        </div>
-->
<?php foreach($query_result as $index => $coau_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'lab/view_author?author_id='.$coau_item['CoAuthorID']; ?>"
        ><?php echo ucwords($coau_item['CoAuthorName']); ?></a>
    </div>
<?php endforeach ?>