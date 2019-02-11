$(document).ready(function () {
    $('.summernote').summernote({
        height: 350
    });

    if (!Modernizr.inputtypes.date) {
        $('.date-picker').datepicker({language: "pt-BR", orientation: "top auto", autoclose: true});
    } else {
        $('.date-picker').prop('type', 'date');
    }

    $('#cp1').colorpicker({
        format: 'hex'
    });
    $('#cp2').colorpicker();

    $('#timepicker1').timepicker();
});