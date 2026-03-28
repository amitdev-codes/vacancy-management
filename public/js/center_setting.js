
// applicant statistics according to center and paper id
$('#paper_id').change(function(){
    var paper_id=$('#paper_id').val(); 
    var vacancy_post_id=$('#vacancy_post_id').val();
    if(paper_id!=""){
    $.ajax({
        type:'get',
        url:'/totalapplicant',
        data:{paper_id:paper_id,vacancy_post_id:vacancy_post_id},
        success:function(data){
            //assigning respose data value to text boxes
            if(document.getElementById("applicant-statistics") !== null){
                $("div").remove( "#applicant-statistics" );
            }
            $("<div class='form-group col-sm-12 header-group-0' id='applicant-statistics'><label class='col-sm-2' style='color:blue'>Total applicant: "+data.data.va_count+"</label> <label class='col-sm-2' style='color:darkgreen'>Already assigned: "+data.data.diff+"</label><label class='col-sm-2' style='color:darkred' id='left_value' value="+data.data.vpe_count+">Left : "+data.data.vpe_count+"</label></div>").insertBefore($("#form-group-examcenters"));

        }
    });
   }
        
 });


 // center capacity statistics
 $('#modal-datamodal-examcenterscenter_id').on('hidden.bs.modal', function () {
     var center_id=$('.input-id','#examcenterscenter_id').val();
    var paper_id=$('#paper_id').val(); 
    
    if(center_id!=""){
    $.ajax({
        type:'get',
        url:'/getcentercapacity',
        data:{center_id:center_id,paper_id:paper_id},
        success:function(data){
            //assigning respose data value to text boxes
            if(document.getElementById("center-statistics") !== null){
                $("div").remove( "#center-statistics" );
            }
            if(document.getElementById("note") !== null){
                $("div").remove( "#note" );
            }
            if(data.data.valid_date==false){
                $("<div class='form-group col-sm-12 header-group-0' id='center-statistics'><label class='col-sm-12' style='color:red'>Please add the exam date in vacancy post exam menu for minimum conflicts.</label></div>").insertBefore($(".child-form-area"));
            }
            else{
                $("<div class='form-group col-sm-12 header-group-0' id='center-statistics'><label class='col-sm-3' style='color:blue'>Center Capacity: "+data.data.center_capacity+"</label> <label class='col-sm-4' style='color:darkgreen'>Already assigned to this center: "+data.data.center_assigned_count+"</label><label class='col-sm-2' style='color:darkred'>Sit Left : "+data.data.diff+"</label></div>").insertBefore($(".child-form-area"));
                $('#examcentersmax_candidates').attr('max',data.data.diff);
            }
            if(data.data.is_on_same_date_time==true){
                $("<div class='form-group col-sm-12 header-group-0' id='note'><label class='col-sm-12' style='color:red'>Other exam are also on the same date and same time.</label></div>").insertBefore($(".child-form-area"));
            }
            else{
                $("div").remove( "#note" );
            }  
        }
    });
   }
    // do something…
})
// child table exam center on update
$('#table-examcenters').on('update', function(){
    $("div").remove( "#center-statistics" );
    var total=0;
    var values=0;
    $('#table-examcenters > tbody  > tr').each(function() {
        var $row = jQuery(this).closest('tr');
        var $columns = $row.find('input');
        values=parseInt($columns[1].value);
        total+=values;
    });
    var left=$('#left_value').attr('value')-total;
    if(document.getElementById("now_applicant-statistics") !== null){
        $("div").remove( "#now_applicant-statistics" );
    }
    $("<div class='form-group col-sm-12 header-group-0' id='now_applicant-statistics'><label class='col-sm-4' style='color:#3c8dbc'>According to center and no.of candidate selected: </label> <label class='col-sm-2' style='color:darkgreen'>Assigned: "+total+"</label><label class='col-sm-2' style='color:darkred'>Left :"+left+" </label></div>").insertBefore($("#form-group-examcenters"));
});

// function checkChildTableData(center_id){
//     centers={};
//     i=0;
//     $('#table-examcenters > tbody  > tr').each(function() {
//         centers[i]=$("input[name='examcenters-center_id[]']").val();
//         values[i]=$('#table-examcenters .max_candidates').text();
//         i++;
//     }); 
//     return {centers:centers,values:values}; 
// }