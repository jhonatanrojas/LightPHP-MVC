

    //Initialize Select2 Elements
    $('.select2').select2()
    $('#reservation').daterangepicker()


    $('#reservation').daterangepicker(
      {
        ranges   : {
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment(),
        locale: {
            format: 'DD/MM/YYYY',
            applyLabel: "Aceptar",
            customRangeLabel: "Fecha Inicio - Final",
            "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
            ],
            "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        }
      }
    )

$('.datepicker').bootstrapMaterialDatePicker({
    format: 'YYYY-MM-DD',
    time: false,
    maxDate: moment(),
    language: 'es',
    defaultDate:'2000-06-01'
});

$('#start').bootstrapMaterialDatePicker({
    changeYear: true,    
    changeMonth: true,
    changeDays: false,
    format: 'MM-YY',
    showButtonPanel: false,
    time: false,
    maxDate: moment(),
    onClose: function( selectedDate ) {
        $( "#end" ).bootstrapMaterialDatePicker( "option", "maxDate", selectedDate );
    }
});

$('#end').bootstrapMaterialDatePicker({
    format: 'MM-YY',
    dayViewHeaderFormat: 'MMMM YYYY',
    viewMode: 'month',
    time: false,
    maxDate: moment(),
    defaultDate: "+1w",
    changeMonth: false,
    numberOfMonths: 3,
    onClose: function( selectedDate ) {
    $( "#start" ).bootstrapMaterialDatePicker( "option", "minDate", selectedDate );
    }    
}); 

