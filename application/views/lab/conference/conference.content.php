<!-- top conferences should be listed here -->
<!--
    recommanded format for each item:
        <div class="list-group-item">
            <a>[conference name]</a>
        </div>
-->
<?php foreach($query_result as $index => $conf_item): ?>
    <div class="list-group-item" >
        <a href="<?php echo base_url().'lab/view_conf?conf_id='.$conf_item['ConferenceID']; ?>"
        ><?php echo $conf_item['ConferenceName']; ?></a>
    </div>
<?php endforeach ?>
