// date conversion
$('#date_from_ad').change(function(){
    convertAdtoBs('#date_from_ad','#date_from_bs');
    });
$('#date_from_bs').change(function(){
    convertBstoAd('#date_from_bs','#date_from_ad');
    });
$('#date_to_ad').change(function(){
    convertAdtoBs('#date_to_ad','#date_to_bs');
    });
$('#date_to_bs').change(function(){
    convertBstoAd('#date_to_bs','#date_to_ad');
    });
$('#contract_end_date_ad').change(function(){
    convertAdtoBs('#contract_end_date_ad','#contract_end_date_bs');
    });
$('#contract_end_date_bs').change(function(){
    convertBstoAd('#contract_end_date_bs','#contract_end_date_ad');
    });

$('#incharge_date_from_bs').change(function(){
    convertBstoAd('#incharge_date_from_bs','#incharge_date_from_ad');
    });
$('#incharge_date_to_bs').change(function(){
    convertBstoAd('#incharge_date_to_bs','#incharge_date_to_ad');
    });
$('#incharge_date_from_ad').change(function(){
    convertAdtoBs('#incharge_date_from_ad','#incharge_date_from_bs');
    });
$('#incharge_date_to_ad').change(function(){
    convertAdtoBs('#incharge_date_to_ad','#incharge_date_to_bs');
    });
$('#seniority_date_bs').change(function(){
    convertBstoAd('#seniority_date_bs','#seniority_date_ad');
    });
$('#seniority_date_ad').change(function(){
    convertAdtoBs('#seniority_date_ad','#seniority_date_bs');
    });
    
var url=window.location.href;
    
    $("<div class='form-group col-sm-12 header-group-0 group-separater'></div>").insertBefore($("#form-group-appointment_letter"));
    $("<div class='form-group col-sm-12 header-group-0 group-separater'></div>").insertBefore($("#form-group-is_current"));
    $("<div class='form-group col-sm-12 header-group-0 group-separater'></div>").insertBefore($("#form-group-incharge_date_from_bs"));
    $("<div class='form-group col-sm-12 header-group-0 group-separater'><h5></div>").insertBefore($("#form-group-minimum_qualification_upload"));
    $("<div class='form-group col-sm-12 header-group-0 group-separater'><h5></div>").insertBefore($("#form-group-additional_qualification_upload"));
    if (url.indexOf('/merged_data') < -1){
    $("<div class='form-group col-sm-12 header-group-0 group-separater' style='margin-left:15px'><h3 style='color:blue'><b>Note:</b></h3><p> हालको पदमा एक भन्दा बढी कार्यालयमा कार्यरत कर्मचारी हरुले एक कार्यालयको लागि तोकिए बमोजिमका सुचनाहरु entry गरी थप कार्यालयहरुको लागि सुचना entry गर्न save and add more गर्नुहोला ।</p></div>").insertBefore($(".box-footer"));
    }
    // contract date showing only if contract is selected

// jab category change event


if (url.indexOf('/add') > -1){
    $('input[name="is_office_incharge"]').attr('checked','');
    $('input[name="is_current"]').attr('checked','');
    $('#form-group-incharge_date_from_bs').hide();
    $('#form-group-incharge_date_to_bs').hide();
    $('#form-group-incharge_date_from_ad').hide();
    $('#form-group-incharge_date_to_ad').hide();
    $('#form-group-seniority_date_bs').hide();
    $('#form-group-seniority_date_ad').hide();
    $('#seniority_date_bs').prop('required', false);
    $('#form-group-appointment_letter').hide();
        $('#appointment_letter').prop('required', false);

}
else{
    const radio_values=$('input[name="is_office_incharge"]:checked').val();
    if(radio_values==1){
        $('#form-group-incharge_date_from_bs').show();
        $('#form-group-incharge_date_to_bs').show();
        $('#form-group-incharge_date_from_ad').show();
        $('#form-group-incharge_date_to_ad').show();  
    }
    else{
        $('#form-group-incharge_date_from_bs').hide();
        $('#form-group-incharge_date_to_bs').hide();
        $('#form-group-incharge_date_from_ad').hide();
        $('#form-group-incharge_date_to_ad').hide();
    }

    const is_current=$('input[name="is_current"]:checked').val();
    if(is_current==1){
        $('#form-group-seniority_date_bs').show();
        $('#form-group-seniority_date_ad').show();
        $('#form-group-leave_letter').hide();
        $('#form-group-appointment_letter').show();
        
        $('#seniority_date_bs').prop('required', true);
        $('#leave_letter').prop('required', false);
        $('#appointment_letter').prop('required', true);
        
    }
    else{
        $('#form-group-seniority_date_bs').hide();
        $('#form-group-seniority_date_ad').hide();
        $('#form-group-leave_letter').show();
        $('#seniority_date_bs').prop('required', false);
        $('#leave_letter').prop('required', true);

        $('#form-group-appointment_letter').hide();
        $('#appointment_letter').prop('required', false);
        
        
    }
}
$('input[type=radio][name=is_office_incharge]').on('change', function() {
    const radio_value=$('input[name="is_office_incharge"]:checked').val();
    if(radio_value==1){
        $('#form-group-incharge_date_from_bs').show();
        $('#form-group-incharge_date_to_bs').show();
        $('#form-group-incharge_date_from_ad').show();
        $('#form-group-incharge_date_to_ad').show();
        $('#incharge_date_from_bs').prop('required', true);
        $('#incharge_date_to_bs').prop('required', true);
    }
    else{
        $('#form-group-incharge_date_from_bs').hide();
        $('#form-group-incharge_date_to_bs').hide();
        $('#form-group-incharge_date_from_ad').hide();
        $('#form-group-incharge_date_to_ad').hide();
        $('#incharge_date_from_bs').prop('required', false);
        $('#incharge_date_to_bs').prop('required', false);
   
    }
});

$('input[type=radio][name=is_current]').on('change', function() {
    const radio_value=$('input[name="is_current"]:checked').val();
    if(radio_value==1){
        $('#form-group-seniority_date_bs').show();
        $('#form-group-seniority_date_ad').show();
        $('#form-group-leave_letter').hide();
        $('#seniority_date_bs').prop('required', true);
        $('#leave_letter').prop('required', false);
        $('#form-group-appointment_letter').show();
        $('#appointment_letter').prop('required', true);

    }
    else{
        $('#form-group-seniority_date_bs').hide();
        $('#form-group-seniority_date_ad').hide();
        $('#form-group-leave_letter').show();
        $('#seniority_date_bs').prop('required', false);
        $('#leave_letter').prop('required', true);
        $('#form-group-appointment_letter').hide();
        $('#appointment_letter').prop('required', false);
   
    }
});