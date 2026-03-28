
@push('bottom')
<script type="text/javascript">
    var lang = '{{App::getLocale()}}';
    $(function() {
        $('.input_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            @if (App::getLocale() == 'ar')
            rtl: true,
            @endif
            language: lang
        });
        
        $('.open-datetimepicker').click(function() {
			  $(this).next('.input_date').datepicker('show');
		});
        $('.input_date').on('show', function(e){
            if ( e.date ) {
                $(this).data('stickyDate', e.date);
            }
            else {
                $(this).data('stickyDate', null);
            }
        });
        $('.input_date').on('hide', function(e){
            var stickyDate = $(this).data('stickyDate');

            if ( !e.date && stickyDate ) {
                $(this).datepicker('setDate', stickyDate);
                $(this).data('stickyDate', null);
            }
        });
        
    });

</script>
@endpush
