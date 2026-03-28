
@push('bottom')

@if (App::getLocale() != 'en')
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/locales/bootstrap-datepicker.'.App::getLocale().'.js') }}" charset="UTF-8"></script>
@endif
<script type="text/javascript">
    var lang = '{{App::getLocale()}}';
    $(function() {
        $('.nepaliDatePicker').nepaliDatePicker({
			npdMonth: true,
			npdYear: true,
			npdYearCount: 100 // Options | Number of years to show
			});	
        
        $('.open-datetimepicker').click(function() {
			  $(this).next('.nepaliDatePicker').nepaliDatePicker({
			npdMonth: true,
			npdYear: true,
			npdYearCount: 10 // Options | Number of years to show
			});
		});
        
    });

</script>
@endpush