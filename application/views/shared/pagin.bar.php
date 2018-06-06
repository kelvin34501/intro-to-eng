<?php if ($page>$startpage) { ?>
    <li>
        <a href="###" id="<?php echo $pagin_handle; ?>-begin" >&laquo;</a>
    </li>

    <li class="<?php echo $pagebackward['status']; ?>
            <?php echo $pagebackward['active']; ?>"
    >
        <a  href="###" 
            id="<?php echo $pagin_handle; ?>-backward"
            pagenum="<?php echo $pagebackward['number']; ?>"
            pagestatus="<?php echo $pagebackward['status']; ?>"
            pageactive="<?php echo $pagebackward['active']; ?>"
        >
            &lsaquo;
        </a>
    </li>
<?php } ?>

<?php foreach($pageindex as $index_item): ?>
    <li class="<?php echo $index_item['status']; ?>
               <?php echo $index_item['active']; ?>"
    >
        <a  href="###"
            id="<?php echo $pagin_handle; ?>-item"
            pagenum="<?php echo $index_item['number']; ?>"
            pagestatus="<?php echo $index_item['status']; ?>"
            pageactive="<?php echo $index_item['active']; ?>"
        >
            <?php echo $index_item['number']; ?>
        </a>
    </li>
<?php endforeach; ?>

<?php if ($page<$endpage) { ?>
    <li class="<?php echo $pageforward['status']; ?>
            <?php echo $pageforward['active']; ?>"
    >
        <a  href="###"
            id="<?php echo $pagin_handle; ?>-forward"
            pagenum="<?php echo $pageforward['number']; ?>"
            pagestatus="<?php echo $pageforward['status']; ?>"
            pageactive="<?php echo $pageforward['active']; ?>"
        >
            &rsaquo;
        </a>
    </li>

    <li>
        <a href="###" id="<?php echo $pagin_handle; ?>-end" >&raquo;</a>
    </li>
<?php } ?>