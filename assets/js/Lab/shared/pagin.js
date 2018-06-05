$(function () {
    // fill the page when it's loaded;
    var table_target = content_fetch_url + "page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#" + content_handle).html(result);
    });

    // page navi bar part
    var pagin_target = pagin_fetch_url + "handle=" + pagin_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(pagin_target, function(result) {
        $("#" + pagin_handle).html(result);
    });
});

$("#" + pagin_handle).on('click','a#' + pagin_handle + '-begin',function() {
    page = startpage;
    var pagin_target = pagin_fetch_url + "handle=" + pagin_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(pagin_target, function(result) {
        $("#" + pagin_handle).html(result);
    });

    var table_target = content_fetch_url + "page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#" + content_handle).html(result);
    });

});

$("#" + pagin_handle).on('click','a#' + pagin_handle + '-end',function() {
    page = endpage;
    var pagin_target = pagin_fetch_url + "handle=" + pagin_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(pagin_target, function(result) {
        $("#" + pagin_handle).html(result);
    });

    var table_target = content_fetch_url + "page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#" + content_handle).html(result);
    });

});

function pagin_goto() {
    page = $(this).attr('pagenum');
    var pagin_target = pagin_fetch_url + "handle=" + pagin_handle +
        "&page=" + page +
        "&startpage=" + startpage +
        "&endpage=" + endpage;
    $.get(pagin_target, function(result) {
        $("#" + pagin_handle).html(result);
    });

    var table_target = content_fetch_url + "page=" + page +
        "&" + field[0] + "=" + field[1];
    $.get(table_target, function(result){
        $("#" + content_handle).html(result);
    });
}
$("#" + pagin_handle).on('click','a#' + pagin_handle + '-backward', pagin_goto);
$("#" + pagin_handle).on('click','a#' + pagin_handle + '-forward', pagin_goto);
$("#" + pagin_handle).on('click','a#' + pagin_handle + '-item', pagin_goto);
