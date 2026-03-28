
//initialize 
var url=window.location.href;
if (url.indexOf('/add?') > -1){
    $('#form-group-open_seats').hide();
    $('#form-group-mahila_seats').hide();
    $('#form-group-janajati_seats').hide();
    $('#form-group-madheshi_seats').hide();
    $('#form-group-apanga_seats').hide();
    $('#form-group-dalit_seats').hide();
    $('#form-group-remote_seats').hide();
    $('#form-group-file_pormotion').hide();
    $('#form-group-internal').hide();
    

}
else{
  const vacancy_ad_id=$('#vacancy_ad_id').val();
  $.ajax({
    type:'get',
    url:'/getopeningtype',
    data:{vacancy_ad_id:vacancy_ad_id},
    success:function(data){
        var opening_id=data.data.opening_type_id;
        switch(opening_id) {
            case 1:
            $('#form-group-open_seats').show();
            $('#form-group-mahila_seats').show();
            $('#form-group-janajati_seats').show();
            $('#form-group-madheshi_seats').show();
            $('#form-group-apanga_seats').show();
            $('#form-group-dalit_seats').show();
            $('#form-group-remote_seats').show();
            $('#form-group-internal').hide();
            $('#form-group-file_pormotion').hide();
            
                break;
            case 2:
            $('#form-group-internal').show();
            $('#form-group-open_seats').hide();
            $('#form-group-mahila_seats').hide();
            $('#form-group-janajati_seats').hide();
            $('#form-group-madheshi_seats').hide();
            $('#form-group-apanga_seats').hide();
            $('#form-group-dalit_seats').hide();
            $('#form-group-remote_seats').hide();
            $('#form-group-file_pormotion').hide();
                break;
            case 3:
            $('#form-group-file_pormotion').show();
            $('#form-group-open_seats').hide();
            $('#form-group-mahila_seats').hide();
            $('#form-group-janajati_seats').hide();
            $('#form-group-madheshi_seats').hide();
            $('#form-group-apanga_seats').hide();
            $('#form-group-dalit_seats').hide();
            $('#form-group-remote_seats').hide();
            $('#form-group-internal').hide();
                break;
            case 4:
            $('#form-group-open_seats').show();
            $('#form-group-mahila_seats').show();
            $('#form-group-janajati_seats').show();
            $('#form-group-madheshi_seats').show();
            $('#form-group-apanga_seats').show();
            $('#form-group-dalit_seats').show();
            $('#form-group-remote_seats').show();
            $('#form-group-internal').hide();
            $('#form-group-file_pormotion').hide();
                break;
            default:
                
        }
    }
 }); 
}



//ajax call to get opening type
$('#vacancy_ad_id').change(function(){
    var vacancy_ad_id=this.value;
        $.ajax({
            type:'get',
            url:'/getopeningtype',
            data:{vacancy_ad_id:vacancy_ad_id},
            success:function(data){
                var opening_id=data.data.opening_type_id;
                switch(opening_id) {
                    case 1:
            $('#form-group-open_seats').show();
            $('#form-group-mahila_seats').show();
            $('#form-group-janajati_seats').show();
            $('#form-group-madheshi_seats').show();
            $('#form-group-apanga_seats').show();
            $('#form-group-dalit_seats').show();
            $('#form-group-remote_seats').show();
            $('#form-group-internal').hide();
            $('#form-group-file_pormotion').hide();
            
                break;
            case 2:
            $('#form-group-internal').show();
            $('#form-group-open_seats').hide();
            $('#form-group-mahila_seats').hide();
            $('#form-group-janajati_seats').hide();
            $('#form-group-madheshi_seats').hide();
            $('#form-group-apanga_seats').hide();
            $('#form-group-dalit_seats').hide();
            $('#form-group-remote_seats').hide();
            $('#form-group-file_pormotion').hide();
                break;
            case 3:
            $('#form-group-file_pormotion').show();
            $('#form-group-open_seats').hide();
            $('#form-group-mahila_seats').hide();
            $('#form-group-janajati_seats').hide();
            $('#form-group-madheshi_seats').hide();
            $('#form-group-apanga_seats').hide();
            $('#form-group-dalit_seats').hide();
            $('#form-group-remote_seats').hide();
            $('#form-group-internal').hide();
                break;
            case 4:
            $('#form-group-open_seats').show();
            $('#form-group-mahila_seats').show();
            $('#form-group-janajati_seats').show();
            $('#form-group-madheshi_seats').show();
            $('#form-group-apanga_seats').show();
            $('#form-group-dalit_seats').show();
            $('#form-group-remote_seats').show();
            $('#form-group-internal').hide();
            $('#form-group-file_pormotion').hide();
                break;
                    default:
                        
                }
            }
         });
  })


