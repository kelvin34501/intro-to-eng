<script>
    function <?php echo $prefix; ?>_pagin_goto() {
        var table_target = <?php echo $prefix; ?>_content_fetch_url + 
            "page=" + <?php echo $prefix; ?>_page +
            "&mode=" + <?php echo $prefix; ?>_field[0] + 
            "&field=" + <?php echo $prefix; ?>_field[1];
        $.get(table_target, function(result){
            $("#" + <?php echo $prefix; ?>_content_handle).html(result);
        });

        var pagin_target = <?php echo $prefix; ?>_pagin_fetch_url + 
            "handle=" + <?php echo $prefix; ?>_pagin_handle +
            "&page=" + <?php echo $prefix; ?>_page +
            "&startpage=" + <?php echo $prefix; ?>_startpage +
            "&endpage=" + <?php echo $prefix; ?>_endpage +
            "&width=" + <?php echo $prefix; ?>_width;
        $.get(pagin_target, function(result) {
            $("#" + <?php echo $prefix; ?>_pagin_handle).html(result);
        });
    }
    
    $(<?php echo $prefix; ?>_pagin_goto);

    $("#" + <?php echo $prefix; ?>_pagin_handle).on(
        'click',
        'a#' + <?php echo $prefix; ?>_pagin_handle + '-begin',
        function() {
            <?php echo $prefix; ?>_page = <?php echo $prefix; ?>_startpage;
            <?php echo $prefix; ?>_pagin_goto();
        });

    $("#" + <?php echo $prefix; ?>_pagin_handle).on(
        'click',
        'a#' + <?php echo $prefix; ?>_pagin_handle + '-end',
        function() {
            <?php echo $prefix; ?>_page = <?php echo $prefix; ?>_endpage;
            <?php echo $prefix; ?>_pagin_goto();    
        });

    $("#" + <?php echo $prefix; ?>_pagin_handle).on(
        'click',
        'a#' + <?php echo $prefix; ?>_pagin_handle + '-backward', 
        function() {
            <?php echo $prefix; ?>_page = $(this).attr('pagenum');
            <?php echo $prefix; ?>_pagin_goto();
        });

    $("#" + <?php echo $prefix; ?>_pagin_handle).on(
        'click',
        'a#' + <?php echo $prefix; ?>_pagin_handle + '-forward', 
        function() {
            <?php echo $prefix; ?>_page = $(this).attr('pagenum');
            <?php echo $prefix; ?>_pagin_goto();
        });

    $("#" + <?php echo $prefix; ?>_pagin_handle).on(
        'click',
        'a#' + <?php echo $prefix; ?>_pagin_handle + '-item', 
        function() {
            <?php echo $prefix; ?>_page = $(this).attr('pagenum');
            <?php echo $prefix; ?>_pagin_goto();
        });
</script>