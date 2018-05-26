$(function () {
    // fill the page when it's loaded;
    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });

    // page navi bar part
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });
});

$("#lab-author-navi").on('click','li#lab-author-navi-begin',function() {
    page = startpage;
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });
});

$("#lab-author-navi").on('click','li#lab-author-navi-end',function() {
    page = endpage;
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });
});

$("#lab-author-navi").on('click','li#lab-author-navi-backward',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });
});

$("#lab-author-navi").on('click','li#lab-author-navi-forward',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });
});

$("#lab-author-navi").on('click','li#lab-author-navi-item',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/view_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-author-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/view_table?page=" + page +
        "&author_id=" + field;
    $.get(table_target, function(result){
        $("#lab-author-table").html(result);
    });
});
