$(document).ready(function() {
    $('#rehibilitate_password_form').on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "../page/send-otp",
            method: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-rehibilitate-password"]').attr('content')
            },
            data: { email: 'gdfger', otp_code: 2555 },
            success: function(data) {
                console.log(data);
            }
        });



    });
});