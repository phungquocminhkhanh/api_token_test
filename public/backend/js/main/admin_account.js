function change_password(id) {
    $("#eold_password").val("");
    $("#epassword_change").val("");
    $("#epassword_change2").val("");
    $('#id_change_password_account').val(id);
}

function clear_data() {
    $('#username').val("");
    $('#password').val("");
    $('#fullname').val("");
    $('#email').val("");
    $('#phone').val("");
}

function show_detail_account(id) {
    $.ajax({
        url: "../admin/account-account-detail",
        method: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token-detail"]').attr('content')
        },
        data: { id_account: id },
        success: function(data) {
            if (data.success == 200) {
                output = `<div id="contact-1" class="tab-pane active">
                                 <div class="row m-b-lg">
                                    <div class="col-lg-8">
                                       <strong>
                                      ${data.data.detail[0].account_fullname}
                                       </strong>

                                    </div>
                                 </div>
                                 <div class="client-detail">
                                    <div class="full-height-scroll">
                                       <strong>Thông tin</strong>
                                       <ul class="list-group clear-list">
                                          <li class="list-group-item">Username:
                                             <span class="pull-right">${data.data.detail[0].account_username}</span>

                                          </li>
                                          <li class="list-group-item">Email:
                                             <span class="pull-right">${data.data.detail[0].account_email}</span>
                                          </li>
                                          <li class="list-group-item">Số điện thoại:
                                             <span class="pull-right">${data.data.detail[0].account_phone}</span>

                                          </li>
                                       </ul>
                                       <strong>Quyền</strong>
                                       <ul class="list-group clear-list">`;
                $.each(data.data.permission, function(k, v) {
                    output += `<li class="list-group-item">${v.description}</li>`;
                });
                output += ` </ul>
                                            <hr/>
                                            <strong id="btn-disable-account">`;

                if (data.data.detail[0].account_status == 'Y')
                    output += `<button type="button" onclick="disable_account(${data.data.detail[0].id},'N')" class="btn btn-danger">Vô hiệu hóa</button></strong>`;
                else
                    output += `<button type="button" onclick="disable_account(${data.data.detail[0].id},'Y')" class="btn btn-secondary">Mở lại tài khoản</button></strong>`;


                output += `<button type="button" onclick="change_password(${data.data.detail[0].id})" class="btn btn-light" data-toggle="modal" data-target="#change_password_account_Modal">Đặt lại mật khẩu</button></strong>`
                output += `    </div>

                                        </div>
                                </div>`

                $('#detail-account').html(output)
            }


        }
    });

}

function disable_account(id, status) {
    if (status == 'N')
        var r = confirm("Bạn có chắc muốn vô hiệu hóa tài khoản này không !");
    else
        var r = confirm("Bạn có chăc muốn mở lại tài khoản này không !");
    if (r == true) {
        $.ajax({
            url: "../admin/account-account-disable",
            method: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-disable-account"]').attr('content')
            },
            data: { id_account: id, account_status: status },
            success: function(data) {
                if (data.success == 200) {
                    console.log(data.data);
                    if (data.data[0].account_status == 'Y') {
                        $('#btn-disable-account').html(`<button type="button" onclick="disable_account(${data.data[0].id},'N')" class="btn btn-danger">Vô hiệu hóa</button></strong>`)
                    } else {
                        $('#btn-disable-account').html(`<button type="button" onclick="disable_account(${data.data[0].id},'Y')" class="btn btn-secondary">Mở lại tài khoản</button></strong>`)
                    }
                    alert("Cập nhật thành công");
                    show_account();

                }
            }
        });
    }
}

function author_account(id) {
    $(':checkbox').attr('checked', false);
    $('#id_author_account').val(id);
    $.ajax({
        url: "../admin/account-account-get-permission",
        method: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token-get-permission"]').attr('content')
        },
        data: { id_account: id },
        success: function(data) {
            console.log(data);
            output3 = "";
            $.each(data.list_per, function(k, v) {
                var tam = `<tr>
                <th>${v.description}</th>
                <th><div class="checkbox checkbox-danger">
                    <input value="${v.id}" name="list_permission[]" type="checkbox">
                     </div>
                </th>
            </tr>`;
                $.each(data.account_per, function(j, acc) {
                    if (v.id == acc.id) {
                        tam = `
                        <tr>
                            <th>${v.description}</th>
                            <th><div class="checkbox checkbox-danger">
                                <input value="${v.id}" name="list_permission[]" checked type="checkbox">
                                 </div>
                            </th>
                        </tr>
                        `;
                    }
                });
                output3 += tam;

            });
            $("#account_permission").html(output3);
        }
    });
}

function edit_account(id) {
    $.ajax({
        url: "../admin/account-account/" + id,
        method: "GET",
        success: function(data) {
            if (data.success == 200) {
                $.each(data.data, function(k, v) {
                    $('#eusername').val(v.account_username);
                    $('#efullname').val(v.account_fullname);
                    $('#eemail').val(v.account_email);
                    $('#ephone').val(v.account_phone);
                    $("#id_edit_account").val(v.id);

                });
                output = "";
                $.each(data.type, function(k, v) {
                    if (v.id == data.data[0].id_type)
                        output += ` <option selected value="${v.id}">${v.type_account}</option>`;
                    else
                        output += ` <option value="${v.id}">${v.type_account}</option>`;
                });
                $('#etype_account').html(output)
            }


        }
    });

}

function show_account() {
    let output = "";
    $.ajax({
        type: "get",
        url: "../admin/account-account",
        data: "data",
        dataType: "json",
        success: function(response) {
            $.each(response, function(k, v) {
                output += `
                <tr onclick="show_detail_account(${v.id})">
                <td><a data-toggle="tab" href="#contact-1" class="client-link">${v.account_fullname}</a></td>
                <td>${v.type_account}</td>
                <td>`
                if (v.account_phone != null)
                    output += v.account_phone

                output += `</td>
                <td>`;
                if (v.account_status == 'Y')
                    output += 'Đang hoạt động'
                else
                    output += 'Không hoạt động';

                output += `</td>
                <td class="client-status"><button onclick="edit_account(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_account_Modal" >Sửa</button></td>`;
                if (v.type_account == "admin")
                    output += `<td class="client-status"><button onclick="author_account(${v.id})" class="label label-primary" data-toggle="modal" data-target="#author_account_Modal" >Phân quyền</button></td>`
                else
                    output += `<td class="client-status"><button class="label label-primary">Phân quyền</button></td>`
                output += `</tr>
                `;

            });
            $("#content-account").html(output)

        }
    });



}



function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function passwordChanged() {
    var strength = document.getElementById('erpassword');
    var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    var pwd = document.getElementById('password');
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
    if (false == enoughRegex.test(pwd.value)) {
        strength.innerHTML = 'Mật khẩu ít nhất 6 ký tự';
    } else {
        strength.innerHTML = '';
    }
}

function passwordChanged2() {
    var strength = document.getElementById('cerpassword');
    var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    var pwd = document.getElementById('epassword_change');
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

    //phần màu xanh khi nào cần thì khôi phục lại và xóa cái ở dưới đi
    if (false == enoughRegex.test(pwd.value)) {
        strength.innerHTML = 'Mật khẩu ít nhất 6 ký tự';
    } else {
        strength.innerHTML = '';
    }
}

function check_input() {
    var flag = 0;
    var name = $('#username').val();
    var pass = $('#password').val();
    var fullname = $('#fullname').val();
    var email = $('#email').val();
    var sdt = $('#phone').val();
    var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");

    if (name == '') {
        flag = 1;
        $('#erusername').html('Không được bỏ trống tên đăng nhập')
    } else {
        $('#erusername').html('')
    }
    if (pass == '' || pass.length < 6) {
        flag = 1;
        $('#erpassword').html('Mật khẩu phải ít nhất 6 ký tự')
    } else {
        // if (mediumRegex.test(pass) || strongRegex.test(pass)) {
        //     $('#erpassword').html('')
        // } else {
        //     flag = 1;
        //     $('#erpassword').html('mật khẩu phải bao hồm chữ hoa, chữ thường và số')
        // }
        $('#erpassword').html('')
        if (pass.search(" ") == -1)
            $('#erpassword').html('');
        else {
            flag = 1;
            $('#erpassword').html('Mật khẩu không được có ký tự dấu cách');
        }
    }
    if (fullname == '') {
        flag = 1;
        $('#erfullname').html('Không được bỏ trống họ và tên đầy đủ')
    } else {
        $('#erfullname').html('')
    }
    if (validateEmail(email) || email == "") {
        $('#eremail').html('')

    } else {
        flag = 1;
        $('#eremail').html('Email không hợp lệ');
    }
    if (KT_sodienthoai(sdt) || sdt == "") {
        $('#ersdt').html('')
    } else {
        flag = 1;
        $('#ersdt').html('Số điện thoại phải là 10 số');
    }
    if (flag == 0)
        return true;
    return false;

}

function check_change_password() {
    var flag = 0;
    var cpass = $('#epassword_change').val();
    var cpass2 = $('#epassword_change2').val();
    var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    if (cpass == '' || cpass.length < 6) {
        flag = 1;
        $('#cerpassword').html('Mật khẩu phải ít nhất 6 ký tự')
    } else {
        // if (mediumRegex.test(cpass) || strongRegex.test(cpass)) {
        //     $('#cerpassword').html('')
        // } else {
        //     flag = 1;
        //     $('#cerpassword').html('Mật khẩu phải bao hồm chữ hoa, chữ thường và số')
        // }
        if (cpass != cpass2) {
            flag = 1;
            $('#cerpassword2').html('Mật khẩu nhập lại không đúng');
        } else {
            $('#cerpassword2').html('');
            if (cpass.search(" ") == -1)
                $('#cerpassword').html('');
            else {
                flag = 1;
                $('#cerpassword').html('Mật khẩu không được có ký tự dấu cách');
            }
        }
    }

    if (flag == 0)
        return true;
    return false;

}

function check_einput() {
    var flag = 0;
    var name = $('#eusername').val();
    var fullname = $('#efullname').val();
    var email = $('#eemail').val();
    var sdt = $('#ephone').val();
    if (name == '') {
        flag = 1;
        $('#eerusername').html('Không được bỏ trống tên đăng nhập')
    } else {
        $('#eerusername').html('')
    }

    if (fullname == '') {
        flag = 1;
        $('#eerfullname').html('Không được bỏ trống họ và tên đầy đủ')
    } else {
        $('#eerfullname').html('')
    }
    if (validateEmail(email) || email == "") {
        $('#eeremail').html('')

    } else {
        flag = 1;
        $('#eeremail').html('Email không hợp lệ');
    }
    if (KT_sodienthoai(sdt) || sdt == "") {
        $('#eerphone').html('')
    } else {
        flag = 1;
        $('#eerphone').html('Số điện thoại phải là 10 số');
    }
    if (flag == 0)
        return true;
    return false;

}

function KT_sodienthoai(sdt) {
    if (sdt.length < 10 || sdt.length > 10) {
        $('#ersdt').html('Số điện thoại gồm 10 số');
        return false;
    } else {
        $('#ersdt').html('');
        return true;
    }
}

function KT_esodienthoai(sdt) {
    if (sdt.length < 10 || sdt.length > 10) {
        $('#eersdt').html('Số điện thoại gồm 10 số');
        return false;
    } else {
        $('#eersdt').html('');
        return true;
    }
}

$(document).ready(function() {
    show_account();
    $.ajax({
        type: "get",
        url: "../admin/list-account-type",
        data: "data",
        dataType: "json",
        success: function(response) {
            output2 = "";
            $.each(response, function(k, v) {
                output2 += `
                    <option value="${v.id}">${v.type_account}</option>
                `;
            });
            $("#type_account").html(output2);
            //$("#etype_account").html(output2);

        }
    });

    $('#insert_account_form').on("submit", function(event) {
        event.preventDefault();
        if (check_input() == false) {

        } else {
            $.ajax({
                url: "../admin/account-account",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token-insert"]').attr('content')
                },
                data: $('#insert_account_form').serialize(),
                success: function(data) {
                    if (data.success == 200) {
                        alert(data.message);
                        show_account();
                        $('#close_modol_insert').click();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }


    });
    $('#edit_account_form').on("submit", function(event) {
        event.preventDefault();
        id = $('#id_edit_account').val();
        if (check_einput() == false) {

        } else {
            $.ajax({
                url: "../admin/account-account/" + id,
                method: "put",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token-edit"]').attr('content')
                },
                data: $('#edit_account_form').serialize(),
                success: function(data) {
                    if (data.success == 200) {
                        alert(data.message);
                        show_account();
                        $('#close_modol_edit').click();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }


    });
    $('#author_account_form').on("submit", function(event) {
        event.preventDefault();
        let permission = [];

        $(':checkbox:checked').each(function(i) {
            permission.push($(this).val());
        });

        $.ajax({
            url: "../admin/account-account-permission",
            method: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-author"]').attr('content')
            },
            data: { id_account: $('#id_author_account').val(), list_permission: permission },
            success: function(data) {
                if (data.success == 200) {
                    alert("Phân quyền thành công");
                    $('#close_modol_author').click();
                }
            }
        });
    });
    $('#change_password_account_form').on("submit", function(event) {
        event.preventDefault();
        if (check_change_password() == false) {

        } else {
            $.ajax({
                url: "../admin/account-account-change-password",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token-change-password"]').attr('content')
                },
                data: {
                    id_account: $('#id_change_password_account').val(),
                    account_password: $('#epassword_change').val(),
                    old_password: $('#eold_password').val()
                },
                success: function(data) {
                    if (data.success == 200) {
                        $('#content_alert').html('<h3>' + data.message + '</h3>');
                        $('#alert_change_pass').modal('show');
                        $('#close_modol_changge_password').click();
                    } else {
                        $('#content_alert').html('<h3>' + data.message + '</h3>');
                        $('#alert_change_pass').modal('show');
                    }

                }
            });
        }

    });
    $("#show_hide_password4 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password4 input').attr("type") == "text") {
            $('#show_hide_password4 input').attr('type', 'password');
            $('#show_hide_password4 i').addClass("fa-eye-slash");
            $('#show_hide_password4 i').removeClass("fa-eye");
        } else if ($('#show_hide_password4 input').attr("type") == "password") {
            $('#show_hide_password4 input').attr('type', 'text');
            $('#show_hide_password4 i').removeClass("fa-eye-slash");
            $('#show_hide_password4 i').addClass("fa-eye");
        }
    });
    $("#show_hide_password5 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password5 input').attr("type") == "text") {
            $('#show_hide_password5 input').attr('type', 'password');
            $('#show_hide_password5 i').addClass("fa-eye-slash");
            $('#show_hide_password5 i').removeClass("fa-eye");
        } else if ($('#show_hide_password5 input').attr("type") == "password") {
            $('#show_hide_password5 input').attr('type', 'text');
            $('#show_hide_password5 i').removeClass("fa-eye-slash");
            $('#show_hide_password5 i').addClass("fa-eye");
        }
    });
    $("#show_hide_password_insert a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password_insert input').attr("type") == "text") {
            $('#show_hide_password_insert input').attr('type', 'password');
            $('#show_hide_password_insert i').addClass("fa-eye-slash");
            $('#show_hide_password_insert i').removeClass("fa-eye");
        } else if ($('#show_hide_password_insert input').attr("type") == "password") {
            $('#show_hide_password_insert input').attr('type', 'text');
            $('#show_hide_password_insert i').removeClass("fa-eye-slash");
            $('#show_hide_password_insert i').addClass("fa-eye");
        }
    });


});
