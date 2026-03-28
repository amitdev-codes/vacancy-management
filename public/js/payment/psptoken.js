$('#psp_id').on('change', function () {
    var psp_id = $(this).val();
    if (psp_id) {
        $.ajax({
            url: './pward/key',
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}',
                'psp_id': psp_id,

            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data) {
                    $('#psp_code').val(data.pspcode);
                    $('#appkey').val(data.appkey);
                } else {
                    $('#psp_code').empty();
                    $('#appkey').empty();
                }
            }
        });
    } else {
        $('#psp_code').empty();
        $('#appkey').empty();
    }
});
