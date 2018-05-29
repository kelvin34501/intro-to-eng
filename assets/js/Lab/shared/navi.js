$(function () {
    // fill the page when it's loaded;
    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });

    // page navi bar part
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });
});

$("#lab-" + navi_handle + "-navi").on('click','li#lab-' + navi_handle + '-navi-begin',function() {
    page = startpage;
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });
});

$("#lab-" + navi_handle + "-navi").on('click','li#lab-' + navi_handle + '-navi-end',function() {
    page = endpage;
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });
});

$("#lab-" + navi_handle + "-navi").on('click','li#lab-' + navi_handle + '-navi-backward',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });
});

$("#lab-" + navi_handle + "-navi").on('click','li#lab-' + navi_handle + '-navi-forward',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });
});

$("#lab-" + navi_handle + "-navi").on('click','li#lab-' + navi_handle + '-navi-item',function() {
    page = $(this).attr('pagenum');
    var navi_target = baseurl +
        "Lab/navi_bar?handle=" + navi_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(navi_target, function(result) {
        $("#lab-" + navi_handle + "-navi").html(result);
    });

    var table_target = baseurl +
        "Lab/" + content_handle +
        "?page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#lab-" + navi_handle + "-table").html(result);
    });
});
