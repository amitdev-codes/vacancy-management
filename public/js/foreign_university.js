$(document).ready(function() {

    var is_foreign_university = $("input[type='radio'][name='is_foreign_university']:checked").val();

    //debugger;
    if (is_foreign_university == '1') {
        $('#form-group-university_name').show();
        $('#form-group-country_name').show();
        $('#form-group-equivalent_certificate').show();

        $('#equivalent_certificate').prop('required', true);
        $('#university_name').prop('required', true);
        $('#country_name').prop('required', true);

        $('#form-group-university').hide();
        $('#university').prop('required', false);
        $('#university').val('');

    } else {
        $('#form-group-university_name').hide();
        $('#university_name').val('');
        $('#university_name').prop('required', false);
        $('#form-group-country_name').hide();
        $('#country_name').val('');
        $('#country_name').prop('required', false);
        $('#form-group-equivalent_certificate').hide();
        $('#equivalent_certificate').prop('required', false);
        $('#equivalent_certificate').val('');
        $('#form-group-university').show();
        $('#university').prop('required', true);


    }
    $('#form-group-is_foreign_university input:radio').click(function() {

        if ($(this).val() == '1') {
            $('#form-group-university_name').show();
            $('#form-group-country_name').show();
            $('#form-group-equivalent_certificate').show();

            $('#equivalent_certificate').prop('required', true);
            $('#university_name').prop('required', true);
            $('#country_name').prop('required', true);

            $('#form-group-university').hide();
            $('#university').prop('required', false);
            $('#university').val('');

        } else {
            $('#form-group-university_name').hide();
            $('#university_name').val('');
            $('#university_name').prop('required', false);
            $('#form-group-country_name').hide();
            $('#country_name').val('');
            $('#country_name').prop('required', false);
            $('#form-group-equivalent_certificate').hide();
            $('#equivalent_certificate').prop('required', false);
            $('#equivalent_certificate').val('');
            $('#form-group-university').show();
            $('#university').prop('required', true);


        }
    });
});