$(function () {
    // fill the page when it's loaded;
    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });

    // page navi bar part
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });
});

$("#lab-result-navi").on('click','li#lab-result-navi-begin',function() {
    page = startpage;
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });
});

$("#lab-result-navi").on('click','li#lab-result-navi-end',function() {
    page = endpage;
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });
});

$("#lab-result-navi").on('click','li#lab-result-navi-backward',function() {
    var active = $(this).attr('active');
    if (active == 'disabled')
        return;

    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });
});

$("#lab-result-navi").on('click','li#lab-result-navi-forward',function() {
    var active = $(this).attr('active');
    if (active == 'disabled')
        return;

    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });
});

$("#lab-result-navi").on('click','li#lab-result-navi-item',function() {
    var active = $(this).attr('active');
    if (active == 'disabled')
        return;

    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/result_bar?page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-result-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/result_table?page=" + page +
        "&author_name=" + field;
    $.get(table_target, function(result){
        $("#lab-result-table").html(result);
    });
});
