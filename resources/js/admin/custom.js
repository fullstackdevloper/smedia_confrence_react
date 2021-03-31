$(document).ready(function()
{
    $('#change_stripe_mode').on('change', function(){
        let value = $(this).val();
        if(value == 'live') {
            $('.live_api_settings').removeClass('hidden');
            $('.test_api_settings').addClass('hidden');
        }else {
            $('.test_api_settings').removeClass('hidden');
            $('.live_api_settings').addClass('hidden');
        }
    }).on("click", ".form-control", function() {
        console.log("Hey");
    });
});