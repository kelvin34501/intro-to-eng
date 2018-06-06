<!-- top affiliations should be listed here -->
<!--
    recommanded format for each item:
        <div class="list-group-item">
            <a>[affiliation name]</a>
        </div>
-->
<?php foreach($query_result as $index => $affi_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'lab/view_affi?affi_id='.$affi_item['AffiliationID']; ?>"
        ><?php echo ucwords($affi_item['AffiliationName']); ?>
        &nbsp
        (<?php echo $affi_item['AffiliationCount']; ?>)</a>
    </div>
<?php endforeach ?>
