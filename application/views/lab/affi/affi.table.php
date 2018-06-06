<!-- Affiliation search results should be put here -->
<!--
    recommanded format for affiliation results
        if not first item in this list:
            <hr>
        <div class="panel-item-title-0">[index].[&nbsp][<a>affiliation name</a>]</div>
        <div class="panel-item-content-0">
                [&nbsp*5]Affiliation ID:[&nbsp][affiliation id][&nbsp*2]-[&nbsp*2]Total Paper: [total paper]
        </div>
-->
<?php foreach($query_result as $index => $affi_item): ?>
    <?php if ($index != 0) { ?>
        <hr>
    <?php } ?>
    <div class="panel-item-title-0 panel-dark-body" >
        <?php echo $offset + $index + 1; ?>.&nbsp&nbsp
        <a href="#" >
            <?php echo ucwords($affi_item['AffiliationName']); ?>
        </a>
    </div>
    <div class="panel-item-content-0 panel-dark-body" >
        &nbsp&nbsp&nbsp&nbsp&nbsp
        Affiliation ID:&nbsp<?php echo $affi_item['AffiliationID']; ?>
        &nbsp&nbsp-&nbsp&nbsp
        Total Publication:&nbsp<?php echo $affi_item['PaperNum']; ?>
    </div>

<?php endforeach; ?>