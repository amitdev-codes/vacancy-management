$('#dob_bs').on('change', function () {
    var dobbs = $(this).val();
    if (dobbs) {
        $.ajax({
            url: '/check_validage/',
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}',
                'dob_bs': dobbs,
            },
            dataType: 'json',
            success: function (data) {
                if (data.success == true) {
                    return;
                } else {
                    swal("Done!", "Age must be greater than 16");
                    location.reload(true);
                }
            }
        });
    } else {
        $('#dob_bs').empty();
    }
});