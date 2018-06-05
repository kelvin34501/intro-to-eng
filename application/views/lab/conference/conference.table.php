<!-- Conference search results should be put here -->
<!--
    recommanded format for conference results
        if not first item in this list:
            <hr>
        <div class="panel-item-title-0">[index].[&nbsp][<a>conference name</a>]</div>
        <div class="panel-item-content-0">
                [&nbsp*5]Conference ID:[&nbsp][conference id][&nbsp*2]-[&nbsp*2]Total Publication: [total publication]
        </div>
-->
<?php foreach($query_result as $index => $conference_item): ?>
    <?php if ($index != 0) { ?>
        <hr>
    <?php } ?>
    <div class="panel-item-title-0 panel-dark-body" >
        <?php echo $offset + $index + 1; ?>.&nbsp&nbsp
        <a href="#" >
            <?php echo $conference_item['ConferenceName']; ?>
        </a>
    </div>
    <div class="panel-item-content-0 panel-dark-body" >
        &nbsp&nbsp&nbsp&nbsp&nbsp
        Conference ID:&nbsp<?php echo $conference_item['ConferenceID']; ?>
        &nbsp&nbsp-&nbsp&nbsp
        Total Publication:&nbsp<?php echo $conference_item['PaperNum']; ?>
    </div>

<?php endforeach; ?>