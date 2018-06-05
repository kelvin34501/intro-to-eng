<!-- Author search results should be put here -->
<!--
    recommanded format for author results
        if not first item in this list:
            <hr>
        <div class='panel-item-title-0'>
            [index].[&nbsp][<a>author name</a>]
        </div>
        <div class='panel-item-content-0'>
            [&nbsp*5]Author ID:[&nbsp][author id][&nbsp*2]-[&nbsp*2]Paper Published:[&nbsp][total paper]<br>
            [&nbsp*5]Major Affiliation:[&nbsp][<a>major affiliation</a>]
        </div>
-->
<?php foreach($query_result as $index => $author_item): ?>
    <?php if ($index != 0) { ?>
        <hr>
    <?php } ?>
    <div class="panel-item-title-0 panel-dark-body" >
        <?php echo $offset + $index + 1; ?>.&nbsp&nbsp
        <a href="#" >
            <?php echo ucwords($author_item['AuthorName']); ?>
        </a>
    </div>
    <div class="panel-item-content-0 panel-dark-body" >
        &nbsp&nbsp&nbsp&nbsp&nbsp
        Author ID:&nbsp<?php echo $author_item['AuthorID']; ?>
        &nbsp&nbsp-&nbsp&nbsp
        Paper Published:&nbsp<?php echo $author_item['PaperNum']; ?><br>
        &nbsp&nbsp&nbsp&nbsp&nbsp
        <?php if ($author_item['AffiliationName'] != null) { ?>
            Major Affiliation:&nbsp
            <a href="#" >
                <?php echo ucwords($author_item['AffiliationName']); ?>
            </a>
        <?php } ?>
    </div>

<?php endforeach; ?>