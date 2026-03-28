var mismatched=$('#mismatched_key').val();
if(mismatched!=""){
    var mismatchedArray=mismatched.split('-');
    $.each(mismatchedArray, function(index, value) { 
        if(value!=""){
            var inputType=$('input[name="'+value+'"]').attr('type');
            // if(inputType=="radio"){
                $('#form-group-'+value + ' label').css('color','mediumblue');
                $('#form-group-'+value + ' div').css('background','red');
                $('#form-group-'+value + ' div').css('color','red');
                // $('#form-group-'+value).css('border','1px solid red');
                // $('#form-group-'+value).css('margin-left','0px');
                // $('#form-group-'+value).css('margin-right','0px');

            // }
            // else{
                // $('input[name="'+value+'"]').css('border','1px solid red');
            // }
        } 
      });

}