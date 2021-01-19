//window.io = io('http://192.168.100.39:3000');

function passwordChanged3() {
    // var strength = document.getElementById('dasherpassword');
    // var strongRegex = new RegExp("^(?=.{10,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    // var mediumRegex = new RegExp("^(?=.{6,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    // var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    // var pwd = document.getElementById('dashpassword_change');
    // if (pwd.value.length == 0) {
    //     strength.innerHTML = 'Nhập mật khẩu';
    // } else if (false == enoughRegex.test(pwd.value)) {
    //     strength.innerHTML = 'Mật khẩu ít nhất 6 ký tự';
    // } else if (strongRegex.test(pwd.value)) {
    //     strength.innerHTML = '<span style="color:green">Mạnh!</span>';
    // } else if (mediumRegex.test(pwd.value)) {
    //     strength.innerHTML = '<span style="color:orange">Trung bình!</span>';
    // } else {
    //     strength.innerHTML = '<span style="color:red">Yếu!</span>';
    // }
}

function clear_data_pass() {

    $('#old_password').val("");
    $('#dashpassword_change').val("");
    $('#dashpassword_change2').val("");
    $('#erold_password').html("");
    $('#dasherpassword_change').html("");
    $('#dasherpassword_change2').html("");
}

function check_pass_dashboard() {

    var flag = 0;
    var cpass = $('#dashpassword_change').val();
    var cpass2 = $('#dashpassword_change2').val();
    var strongRegex = new RegExp("^(?=.{10,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{6,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    if (cpass == '' || cpass.length < 6) {
        flag = 1;
        $('#dasherpassword').html('Mật khẩu phải ít nhất 6 ký tự')
    } else {
        // if (mediumRegex.test(cpass) || strongRegex.test(cpass)) {
        //     $('#dasherpassword').html('')
        // } else {
        //     flag = 1;
        //     $('#dasherpassword').html('Mật khẩu phải bao hồm chữ hoa, chữ thường và số')
        // }
        if (cpass != cpass2 && cpass != "") {
            flag = 1;
            $('#dasherpassword2').html('Mật khẩu nhập lại không đúng')
        } else {
            $('#dasherpassword2').html('');
            if (cpass.search(" ") == -1)
                $('#dasherpassword').html('');
            else {
                flag = 1;
                $('#dasherpassword').html('Mật khẩu không được có ký tự dấu cách');
            }

        }

    }

    if (flag == 0)
        return true;
    return false;

}
var arrayper = {};

// function force_sign(type) {
//     idbu = String($('#id_bu').val())
//     io.emit('force_sign_out', { id_business: idbu, type: type })
//     $("#close_force_manage").click();
// }

// io.on('forced_sign_out', data => {
//     if (data.type == "account") {
//         xxx = $('#xxxxx').val()
//         if (xxx) {
//             alert('Cưỡng chế đăng xuất thành công');
//         } else {
//             window.location.replace("../page/logout");


//         }
//     }

// })

$(document).ready(function() {
    idbu = String($('#id_bu').val())
    const a = { id_business: idbu };
    // io.emit('join-store', a);
    $.ajax({
        type: "post",
        url: "../admin/account-account-detail",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token-force-sign"]').attr('content')
        },
        data: { id_account: $('#id_ac').val() },
        dataType: "json",
        success: function(response) {
            arrayper = response.data.detail;

        }
    });




    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    });

    $('#change_password_dashboard_account_form').on("submit", function(event) {
        event.preventDefault();
        if (check_pass_dashboard() == false) {} else {
            $.ajax({
                url: "../admin/account-account-change-password-dashboard",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token-change-password-dashboard"]').attr('content')
                },
                data: { account_password: $('#dashpassword_change').val(), old_password: $("#old_password").val() },
                success: function(data) {
                    if (data.success == 200) {
                        $('#content_alert_das').html('<h3>' + data.message + '</h3>');
                        $('#alert_change_pass_dashboard').modal('show');
                        $('#close_modol_changge_password_dashboard').click();
                    } else {
                        $('#erold_password').html('Mật khẩu cũ không đúng');
                    }
                }
            });
        }


    });
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
    $("#show_hide_password2 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password2 input').attr("type") == "text") {
            $('#show_hide_password2 input').attr('type', 'password');
            $('#show_hide_password2 i').addClass("fa-eye-slash");
            $('#show_hide_password2 i').removeClass("fa-eye");
        } else if ($('#show_hide_password2 input').attr("type") == "password") {
            $('#show_hide_password2 input').attr('type', 'text');
            $('#show_hide_password2 i').removeClass("fa-eye-slash");
            $('#show_hide_password2 i').addClass("fa-eye");
        }
    });
    $("#show_hide_password3 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password3 input').attr("type") == "text") {
            $('#show_hide_password3 input').attr('type', 'password');
            $('#show_hide_password3 i').addClass("fa-eye-slash");
            $('#show_hide_password3 i').removeClass("fa-eye");
        } else if ($('#show_hide_password3 input').attr("type") == "password") {
            $('#show_hide_password3 input').attr('type', 'text');
            $('#show_hide_password3 i').removeClass("fa-eye-slash");
            $('#show_hide_password3 i').addClass("fa-eye");
        }
    });


});