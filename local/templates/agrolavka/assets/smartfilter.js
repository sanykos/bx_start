

// CheckList
//setCookie();
// $(function() {
//     var checkedElems = [];
//     function creatCheckElem(elem) {
//         var checkInputBox = elem.parent(),
//                 facetValue = checkInputBox.data('value'),
//                 checkText = checkInputBox.data('name');
//         var filterCheckList = $('.filter-checked-list'),
//             filterCheckElement = '<div class="filter-checked-element" data-facet="'+facetValue+'">'+checkText+'<span class="delete-elem">x</span></div>';
    
//         if(elem.prop('checked') == true) {
//             filterCheckList.append(filterCheckElement);
//             checkedElems.push(facetValue);
//             //console.log(checkedElems);
//             setCookie('checkedlist', JSON.stringify(checkedElems));
//         }else if(elem.prop('checked') == false){
//             $('.filter-checked-list .filter-checked-element').filter('div[data-facet="'+facetValue+'"]').remove();
//             console.log('uncheck');
//             checkedElems.forEach(function(item,i){         
//                 if(item == facetValue) {
//                     checkedElems.splice(i,1);
//                 }
//             })
//             console.log(checkedElems);
//             setCookie('checkedlist', JSON.stringify(checkedElems));
//         }

        
//         //console.log(checkedElems);
//     }

//     $('.check__input').on('click', function() {
//         creatCheckElem($(this));
//     });

//     $('body').on('click', '.delete-elem', function() {
//         var elem = $(this).parent(),
//             facet = elem.data('facet');
//         elem.remove();
//         $('label .bx-filter-input-checkbox').filter('span[data-value="'+facet+'"]').find('.check__input').click();
//         //$('label .bx-filter-input-checkbox').filter('span[data-facet="'+facet+'"]').find('.check__input').prop('checked', false);
//     });

//     $('.smartfilter .check__input').each(function(i,item) {
//         creatCheckElem($(this));
//     });
// });









