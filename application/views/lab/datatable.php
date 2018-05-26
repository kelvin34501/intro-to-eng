<h2><?php echo $title; ?></h2>

<?php foreach($author as $author_item): ?>

    <h3><?php echo $author_item['AuthorID']; ?></h3>
    <div class="main">
        <?php echo $author_item['AuthorName']; ?>
    </div>
    <p><a href="<?php echo site_url('lab/view/'.$author_item['AuthorID']); ?>">View Author</a></p>

<?php endforeach; ?>
