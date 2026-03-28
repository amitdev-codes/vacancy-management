// for the design

$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Temporary Address</span><hr/></div>"
).insertBefore($("#form-group-temp_district_id"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Name (In English)</span><hr width='68%'/></div>"
).insertBefore($("#form-group-first_name_en"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>नाम (नेपालीमा)</span><hr width='68%'/></div>"
).insertBefore($("#form-group-first_name_np"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>जन्म विवरण</span><hr width='68%'/></div>"
).insertBefore($("#form-group-dob_bs"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Permanent Address</span><hr/></div>"
).insertBefore($("#form-group-district_id"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>नागरिकता / Citizenship</span><hr/></div>"
).insertBefore($("#form-group-citizenship_no"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Uploads (File type: JPG, JPEG, PNG, GIF, BMP)</span><hr/></div>"
).insertBefore($("#form-group-photo"));

$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>अपाङ्गता  हो?</span><hr/></div>"
).insertBefore($("#form-group-is_handicapped"));

$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>NT कर्मचारी हो?</span><hr/></div>"
).insertBefore($("#form-group-is_nt_staff"));



$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><p style='margin-left:40px'>देवनागरीमा टाईप गर्न सहायता चाहिएमा <a href='https://www.google.com/intl/ne/inputtools/try/' target='_blank'>यहाँ क्लिक गर्नुहोस्</a></p></div>"
).insertAfter($("#form-group-last_name_np"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span class='father-info'>Father Info:</span><hr/></div>"
).insertBefore($("#form-group-father_name_np"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Mother Info:</span><hr/></div>"
).insertBefore($("#form-group-mother_name_np"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Grand Father Info:</span><hr/></div>"
).insertBefore($("#form-group-grand_father_name_np"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Spouse Info:</span><hr/></div>"
).insertBefore($("#form-group-spouse_name_np"));

$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Education Info:</span><hr/></div>"
).insertBefore($("#form-group-edu_level_id"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Training Info:</span><hr/></div>"
).insertBefore($("#form-group-training_title"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Council Certificate:</span><hr/></div>"
).insertBefore($("#form-group-council_id"));
$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><span>Privilege Group Certificate:</span><hr/></div>"
).insertBefore($("#form-group-privilege_group_id"));

$(
    "<div class='form-group col-sm-12 header-group-0 group-separater' ><p style='margin-left:20px'>देवनागरीमा टाईप गर्न सहायता चाहिएमा <a href='https://www.google.com/intl/ne/inputtools/try/' target='_blank'>यहाँ क्लिक गर्नुहोस्</a></p></div>"
).insertBefore($(".father-info"));
// $(
//   "<p style='margin-top: -13px; margin-left: 184px;font-size:10px'><span style='color:red;font-size: 12px;'>Note:&nbsp&nbsp</span>इन्जिनियर समुहमा दरखास्त दिने उम्मेद्द्वारले division, percentage वा GPA खुलेको transcript को पाना upload गरि बाकी document तल upload 1-6 मा गर्नुहोला। </p>"
// ).insertBefore($("#form-group-upload_1"));

// date conversion
$("#dob_ad").change(function() {
    convertAdtoBs("#dob_ad", "#dob_bs");
});

$("#dob_bs").change(function() {
    convertBstoAd("#dob_bs", "#dob_ad");
});

$("#citizenship_issued_date_ad").change(function() {
    convertAdtoBs("#citizenship_issued_date_ad", "#citizenship_issued_date_bs");
});

$("#citizenship_issued_date_bs").change(function() {
    convertBstoAd("#citizenship_issued_date_bs", "#citizenship_issued_date_ad");
});

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
        




//checking payment date
$("#from_date_bs").change(function() {
    convertBstoAd("#from_date_bs", "#from_date_ad");
});

$("#to_date_bs").change(function() {
    convertBstoAd("#to_date_bs", "#to_date_ad");
});

// checking for is_nt_staff
if ($('input[name="is_nt_staff"]:checked').val() == "1") {
    $("#nt_staff_code").prop("required", true);
}
// change event on radio button is nt staff
$("input[name=is_nt_staff]").on("click", function() {
    var staffStat = $(this).val();
    if (staffStat == "1") {
        $("input[name=nt_staff_code]").show();
        $("#nt_staff_code").prop("required", true);
    } else {
        $("#nt_staff_code").val("");
        $("input[name=nt_staff_code]").hide();
        $("#nt_staff_code").prop("required", false);
    }
});

var staffStat = $("input[name=is_nt_staff]:radio:checked").val();

if (staffStat == "1") {
    $("input[name=nt_staff_code]").show();
} else {
    $("input[name=nt_staff_code]").hide();
}

//for disallow blank space in all inputs
$(function() {
    $('#first_name_en,#first_name_np,#mid_name_en,#mid_name_np,#last_name_en,#last_name_np,#mobile_no,#email,#phone_no').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});


// // Year AD - last 40 years
// var myselect = document.getElementById("year_ad"),
//     year = new Date().getFullYear();
// var gen = function(max) { do { myselect.add(new Option(year++, max--), null); } while (max > 0); }(5);

// // Year BS - last 40 years
// var myselect = document.getElementById("year_bs"),
//     year = new Date().getFullYear();
// year_bs = year + 56;
// var gen = function(max) { do { myselect.add(new Option(year_bs++, max--), null); } while (max > 0); }(5);}(5);