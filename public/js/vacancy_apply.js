$(document).ready(function() {
    isAppliedBefore();
    iAgree();
    enablePrivilegeCheckbox();
    var opening_type_id = $('#opening_type').val();
    if (opening_type_id == 3 || opening_type_id == 2) {

    } else {
        calculateTotal();
    }

    convertAdtoBs('#applied_date_ad', '#applied_date_bs');
    $('#is_open,#is_female,#is_janajati,#is_madhesi,#is_dalit,#is_handicapped,#is_remote_village').on('change', function() {
        isCheckedOne();
        calculateTotal();
    });
});

function calculateTotal() {

    var i = 0;

    if ($('#is_open').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_female').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_janajati').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_madhesi').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_dalit').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_handicapped').prop('checked') == true) {
        i = i + 1;
    }
    if ($('#is_remote_village').prop('checked') == true) {
        i = i + 1;
    }
    if (i == 1) {
        var exam_fee = parseInt($('#exam_fee').val());
        $('#amount_for_job').val(exam_fee);
        $('#total_amount').val(exam_fee);
        $('#amount_for_priv_grp').val('0');
    } else if (i > 1) {
        var priv_fee       = parseInt($('#privilege_fee').val());
        var exam_fee       = parseInt($('#amount_for_job').val());
        var additional_fee = (i - 1) * priv_fee;
        var total_fee      = exam_fee + additional_fee;

        $('#amount_for_priv_grp').val(additional_fee);
        $('#total_amount').val(total_fee);
    } else {
        $('#amount_for_job').val('0');
        $('#total_amount').val('0');
    }

}

function tokenNumber() {
    return;
    //var random_number = Math.floor(Math.random() * 10);

    var max_token = parseInt($('#max_token').val());
    var token_no  = max_token + 1;

    $('#token_number').val(token_no);
}

function isCheckedOne() {
    var opening_type_id = $('#opening_type').val();
    if (opening_type_id == 3 || opening_type_id == 2) {
        submit.disabled = false;
    } else {
        if ($('#is_open').prop('checked') == true || $('#is_female').prop('checked') == true || $('#is_janajati').prop('checked') == true || $('#is_madhesi').prop('checked') == true || $('#is_dalit').prop('checked') == true || $('#is_handicapped').prop('checked') == true || $('#is_remote_village').prop('checked') == true) {
            if ($('#i_agree').prop('checked')) {
                submit.disabled = false;
            }
        } else {
            submit.disabled = true;
        }
    }

}

function iAgree() {
    var i_agree = $('#i_agree').prop('checked');
    if (i_agree == true) {
        isCheckedOne();
    } else {
        submit.disabled = true;
    }
}

function isAppliedBefore() {
    var cancelled_count = parseInt( $('#cancelled_count').val());
  
    var is_applied_before = parseInt($('#is_applied_before').val());
    var cancelled_count   = parseInt($('#cancelled_count').val());
    if (is_applied_before > 0 && cancelled_count <= 0) {
        alertify.alert('Warning!', 'You have already applied for this post.', function() { history.go(-1); });
    }
}

function enablePrivilegeCheckbox() {
    var i           = 0;
    var gender_id   = parseInt($('#gender_id').val());
    var mahila      = parseInt($('#mahila_seats').val());
    var open        = parseInt($('#open_seats').val());
    var tribal      = parseInt($('#janajati_seats').val());
    var madhesi     = parseInt($('#madheshi_seats').val());
    var dalit       = parseInt($('#dalit_seats').val());
    var handicapped = parseInt($('#apanga_seats').val());
    var remote      = parseInt($('#remote_seats').val());

    if (open > 0) {
        i = 1;
        $('#is_open').attr('enabled', true);
    } else {
        $('#is_open').next('label').hide();
        $('#is_open').hide();
    }
    if (mahila > 0 && gender_id == 2) {
        i = 1;
        $('#is_female').attr('enabled', true);
    } else {
        $('#is_female').next('label').hide();
        $('#is_female').hide();
    }
    if (tribal > 0) {
        i = 1;
        $('#is_janajati').attr('enabled', true);
    } else {
        $('#is_janajati').next('label').hide();
        $('#is_janajati').hide();
    }
    if (madhesi > 0) {
        i = 1;
        $('#is_madhesi').attr('enabled', true);
    } else {
        $('#is_madhesi').next('label').hide();
        $('#is_madhesi').hide();
    }
    if (dalit > 0) {
        i = 1;
        $('#is_dalit').attr('enabled', true);
    } else {
        $('#is_dalit').next('label').hide();
        $('#is_dalit').hide();
    }
    if (handicapped > 0) {
        i = 1;
        $('#is_handicapped').attr('enabled', true);
    } else {
        $('#is_handicapped').next('label').hide();
        $('#is_handicapped').hide();
    }
    if (remote > 0) {
        i = 1;
        $('#is_remote_village').attr('enabled', true);
    } else {
        $('#is_remote_village').next('label').hide();
        $('#is_remote_village').hide();
    }
    if (i == 0) {
        $('#previlageLbl').hide();
    }
}

