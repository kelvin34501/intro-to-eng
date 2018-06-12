<!-- <tr>
<td>1</td>
<td><a href="#">Tanmay</a></td>
<td><a href="#">Bangalore</a></td>
</tr>
<tr>
<td>2</td>
<td><a href="#">Sachin</a></td>
<td><a href="#">Mumbai</a></td>
</tr>
<tr>
<td>3</td>
<td><a href="#">Uma</a></td>
<td><a href="#">Pune</a></td>
</tr> -->
<?php foreach($query_result as $index => $author_item): ?>
    <tr>
        <td><?php echo $index + 1; ?></td>
        <td>
            <a href="<?php echo base_url().'lab/view_author?author_id='.$author_item['AuthorID']; ?>"
            ><?php echo ucwords($author_item['AuthorName']); ?></a>
        </td>
        <td>
            <a href="<?php echo base_url().'lab/view_affi?affi_id='.$author_item['Affiliation']['AffiliationID']; ?>"
            ><?php echo ucwords($author_item['Affiliation']['AffiliationName']); ?></a>
        </td>
    </tr>
<?php endforeach ?>