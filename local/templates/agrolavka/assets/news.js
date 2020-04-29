$(document).on('click', '[data-show-more]', function() {
    var btn = $(this);
    var page = btn.attr('data-next-page');
    var id = btn.attr('data-show-more');
    var bx_ajax_id = btn.attr('data-ajax-id');
    //var block_id = "#comp_"+bx_ajax_id;
    var newsBox = $('.news-list');
    
    var data = {
        bxajaxid:bx_ajax_id
    };
    data['PAGEN_'+id] = page;
    //console.log(data);
    $.ajax({
            type: "GET",
            url: window.location.href,
            data: data,
            timeout: 3000,
            success: function(data) {
                $("#btn_"+bx_ajax_id).closest('.pagination-item').remove();
                var elements = $(data).find('.news-item'),
                        pagination = $(data).find('.load_more');     
                newsBox.append(elements);
                newsBox.append(pagination);
                
                //$('.news-list').append(data);
            }
    });
});