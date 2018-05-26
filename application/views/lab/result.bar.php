<li class="page-item" id="lab-result-navi-begin" >
        <a class="page-link" >&laquo;</a>
</li>

<li class="page-item
           <?php echo $pagebackward['status']; ?>
           <?php echo $pagebackward['active']; ?>"
    id="lab-result-navi-backward"
    pagenum="<?php echo $pagebackward['number']; ?>"
    pagestatus="<?php echo $pagebackward['status']; ?>"
    pageactive="<?php echo $pagebackward['active']; ?>"
>
    <a class="page-link" >&lsaquo;</a>
</li>

<?php foreach($pageindex as $index_item): ?>
    <li class="page-item
               <?php echo $index_item['status']; ?>
               <?php echo $index_item['active']; ?>"
        id="lab-result-navi-item"
        pagenum="<?php echo $index_item['number']; ?>"
        pagestatus="<?php echo $index_item['status']; ?>"
        pageactive="<?php echo $index_item['active']; ?>"
    >
        <a class="page-link">
            <?php echo $index_item['number']; ?>
        </a>
    </li>
<?php endforeach; ?>

<li class="page-item
           <?php echo $pageforward['status']; ?>
           <?php echo $pageforward['active']; ?>"
    id="lab-result-navi-forward"
    pagenum="<?php echo $pageforward['number']; ?>"
    pagestatus="<?php echo $pageforward['status']; ?>"
    pageactive="<?php echo $pageforward['active']; ?>"
>
    <a class="page-link" >
        &rsaquo;
    </a>
</li>

<li class="page-item"
    id="lab-result-navi-end">
    <a class="page-link" ?>&raquo;</a>
</li>
