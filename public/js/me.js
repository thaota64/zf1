
function popupAjax(id){
    jQuery.ajax({
            url: '/default/profile/detail/id/' + id,
            type: 'POST',
            data: {},
            success: function(result) {
                    if(result.length > 0){
                        alert(result);
                    } else {
                        if (confirm('Bạn có chắc chắn muốn xoá.')) {
                            jQuery.ajax({
                                url: '/default/profile/delete/id/'+ id,
                                type: 'POST',
                                data: {},
                                success: function(result) {
                                        window.location = '/profile/index';
                                }
                            });
                        } 
                        
                    }
                    
            }
    });  
    
}

function submitAjax(){
    
    jQuery.ajax({
            url: '/default/profile/create',
            type: 'POST',
            data: $('#form-save').serialize(),
            success: function(result) {
               result = jQuery.parseJSON(result);
               if(jQuery.isEmptyObject(result['Error'])){
                   $('#form-save input[type="text"').val('');
                   $('#form-save .text-danger').remove();
                   alert('Add success!');
               } else {
                   $('#form-save .text-danger').remove();
                   $.each(result['Error'], function( index, value ) {
                       if(value != null){
                           $('#form-save input[name="'+ index +'"').after('<div class="text-danger">'+ value +'</div>');
                       }
                   });
                   
               }
            }
    });  
    
}



