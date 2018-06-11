<?php foreach($query_result as $index => $label_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'lab/search_paper?paper='.$label_item; ?>"
        ><?php echo ucwords($label_item); ?>
        </a>
    </div>
<?php endforeach ?>