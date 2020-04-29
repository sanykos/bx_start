$(function() {
    // избранные товары
    function addFavorite(id, action, elem) {
        var param = 'id='+id+'&action='+action;
        $wrapper_fav = elem.closest('.favorites__section');
        $.ajax({
            url: '/local/templates/agrolavka/ajax/favorites.php',
            type: 'GET',
            dataType: 'json',
            data: param,
            success: function(data) {
                //console.log(data);
                if(data.status == 'success') {
                    if(data.fav_status == 'deleted') {
                        $('.header-icons_fav .count').text(data.fav_count);
                        $('a.favor[data-id="'+id+'"]').removeClass('active');
                         
                        if($wrapper_fav.length > 0) {
                            $wrapper_fav.find('.catalog-item[data-item="'+id+'"]').fadeOut(300);
                        }
                        if($('a.favor[data-id="'+id+'"]').find('.favor__text').length > 0) {
                            $('a.favor[data-id="'+id+'"]').find('.favor__text').text('В избранное');
                        }
                    }else if(data.fav_status == 'added') {
                        $('a.favor[data-id="'+id+'"]').addClass('active');
                        $('.header-icons_fav .count').text(data.fav_count);
                        if($('a.favor[data-id="'+id+'"]').find('.favor__text').length > 0) {
                            $('a.favor[data-id="'+id+'"]').find('.favor__text').text('В избранном');
                        }
                        
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error: '+ errorThrown);
            }
        });
    }


    $('body').on('click','a.favor', function() {
        let favId = $(this).data('id');
        
        if($(this).hasClass('active'))
            var doAction = 'delete'
        else 
            var doAction = 'add';

        addFavorite(favId, doAction, $(this));

        return false;
    });

    // Избранные бренды
    $('body').on('click','a.favor-brand', function(){
        let id = $(this).data('id');

       // console.log(id);
        if($(this).hasClass('active'))
            var action = 'delete'
        else 
            var action = 'add';

        let param = 'id='+id+'&action='+action;
        $wrapper_fav = $(this).closest('.favbrands__section');


        $.ajax({
            url: '/local/templates/agrolavka/ajax/favorites_brands.php',
            type: 'GET',
            dataType: 'json',
            data: param,
            success: function(data){
                //console.log(data);
                if(data.status == 'success') {
                    if(data.fav_status == 'deleted') {
                        $('.favbrands__section .count-fv-brand').text(data.fav_count+' ');
                        $('a.favor-brand[data-id="'+id+'"]').removeClass('active');
                         
                        if($wrapper_fav.length > 0) {
                            $wrapper_fav.find('.fav-brend-item[data-id="'+id+'"]').fadeOut(300);
                        }
                    }else if(data.fav_status == 'added') {
                        $('a.favor-brand[data-id="'+id+'"]').addClass('active');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error: '+ errorThrown);
            }

        })


        return false;

    })

    
});