<!-- Paper search results should be put here -->
<!--
    recommanded format for paper results
        if not first item in this list:
            <hr>
        <div class="panel-item-title-0">[index].[&nbsp][<a>paper title</a>]</div>
        <div class="panel-item-content-0">
                [&nbsp*5]Paper ID:[&nbsp][paper id][&nbsp*2]-[&nbsp*2]Venue: [<a>conference</a>]<br>
                [&nbsp*5]Published Year: [published year][&nbsp*2]-[&nbsp*2]Times Cited: [referenced times]<br>
                [&nbsp*5]Coauthors: [<a>author_name</a>, ]
        </div>
-->
<?php foreach($query_result as $index => $paper_item): ?>
    <?php if ($index != 0) { ?>
        <hr>
    <?php } ?>
    <div class="panel-item-title-0 panel-dark-body" >
        <?php echo $offset + $index + 1; ?>.&nbsp&nbsp
        <a href="#" >
            <?php echo ucwords($paper_item['Title']); ?>
        </a>
    </div>
    <div class="panel-item-content-0 panel-dark-body" >
        &nbsp&nbsp&nbsp&nbsp&nbsp
        Paper ID:&nbsp<?php echo $paper_item['PaperID']; ?>
        &nbsp&nbsp-&nbsp&nbsp
        Venue:&nbsp<?php echo $paper_item['ConferenceName']; ?><br>

        &nbsp&nbsp&nbsp&nbsp&nbsp
        Published Year:&nbsp<?php echo $paper_item['PaperPublishYear']; ?>
        &nbsp&nbsp-&nbsp&nbsp
        Times Cited:&nbsp<?php echo $paper_item['ReferenceCount']; ?><br>

        &nbsp&nbsp&nbsp&nbsp&nbsp
        Coauthors:&nbsp<?php echo $paper_item['AuthorList']; ?>
    </div>

<?php endforeach; ?>