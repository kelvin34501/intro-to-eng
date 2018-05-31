<div class="row" >
    <div class="col" >
        <center>
            <h1><?php echo $title; ?></h1>
        </center>
    </div>
</div>
<div class="row" >
    <div class="col" >
        <center>
            <form method="get" accept-charset="utf-8" action=<?php echo $result_handler;?> >
                <label for="author_name">AuthorName</label>
                <input type="input" id="author_name" name="author_name" />
                <input type="submit" value="Query" />
            </form>

            <script type="text/javascript" >
             $( "#author_name" ).autocomplete({
                 source: "<?php echo $auto_completer; ?>",
                 autoFocus: true
             });
            </script>
        </center>
    </div>
</div>

