<?php foreach($author_pub as $row): ?>
    <tr>
        <td><?php echo $row['PaperID']; ?></td>
        <td><?php echo $row['Title']; ?></td>
        <td><?php echo $row['ReferenceNum']; ?></td>
        <td><?php echo $row['ConferenceName']; ?></td>
        <td><?php echo $row['PaperPublishYear']; ?></td>
        <td>
            <table frame="void">
                <tbody>
                    <?php foreach($row['Links'] as $link): ?>
                        <tr>
                            <td width="100px"><?php echo $link['AuthorID']; ?></td>
                            <td width="200px">
                                <a href="<?php echo base_url('lab/author?author_id='.$link['AuthorID']); ?>" >
                                    <?php echo $link['AuthorName'] ?>
                                </a>
                            </td>
                            <td width="50px"><?php echo $link['AuthorSequence']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>
<?php endforeach; ?>
