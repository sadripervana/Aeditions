
define([
        "jquery", "jquery/ui", "mage/calendar"
    ],
    function($)
    {
        return function(datepicker){
            $(document).ready(function () {
                var field = datepicker.id;
                $(field).calendar(
                    {
                        dateFormat:"yy-mm-dd",
                        showButtonPanel: true,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-90:+00"
                    });
                $(".ui-datepicker-trigger").removeAttr("style");
                $(".control-value").hide();
                $(".ui-datepicker-trigger").click(function(){
                    $(this).prev().focus();
                });
            });
        }
    }
);
