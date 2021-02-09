/*
 * 
 * activityhub front end Javascript
 * 
 * @since 1.0.0
 * 
 */
var Smedia;
(function ($) {
    Smedia = {
        initilaize: function () {
            $this = Smedia;
            $(document).ready(function () {
                $this.onInitMethods();
            });
        },
        onInitMethods: function () {
            $this.initDatePicker();
            $this.joineeInput();
        },
        initDatePicker: function() {
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                minDate : 0
            });
        },
        joineeInput: function() {
            $('.joinee_input').tagsinput({
                maxTags: $('#max_participant').val()
            });
            
            $(document).on('change', "#max_participant", function() {
                $('.joinee_input').val('');
                $('.joinee_input').tagsinput('destroy');
                $this.joineeInput();
            });
        },
        makeCall: function (url, data, callback, hideloader) {
            $.ajax({
                url: url, // server url
                type: 'POST', //POST or GET 
                data: data, // data to send in ajax format or querystring format
                datatype: 'json',
                async: true,
                crossDomain: true,
                beforeSend: function (xhr) {
                    
                },
                success: function (data) {
                    callback(data); // return data in callback
                },
                complete: function () {
                   
                },

                error: function (xhr, status, error) {
                    
                }

            });
        }
    }
    
    Smedia.initilaize();
})(jQuery);