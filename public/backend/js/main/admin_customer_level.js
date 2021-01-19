function show_point() {
    output = '';
    $.ajax({
        url: "../admin/customer-point",
        method: "get",
        success: function(data) {

            $.each(data, function(k, v) {

                output += `
                <tr >
                <td onclick="show_customer_in_point(${v.id})"><a data-toggle="tab" href="#contact-1" class="client-link">${v.customer_level}</a></td>
                <td onclick="show_customer_in_point(${v.id})">${v.point} điểm</td>
                <td onclick="show_customer_in_point(${v.id})"> ${v.customer_discount}%</td>
                <td onclick="show_customer_in_point(${v.id})">Có ${v.total_customer} đạt được</td>
                <td onclick="show_customer_in_point(${v.id})"> ${v.customer_description}</td>
                <td class="client-status"><button onclick="edit_point(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_level_Modal" >Sửa</button></td>
                <td class="client-status"><button onclick="delete_point(${v.id})" class="label label-primary" >Xóa</button></td>
                </tr>

                `;

            });
            $("#content-level").html(output)
        }
    });
}

function delete_point(id) {
    var r = confirm('Bạn có chắc muốn xóa cấp độ này không')
    if (r == true) {
        $.ajax({
            url: "../admin/customer-point/" + id,
            method: "delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-point-delete"]').attr('content')
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 200) {
                    alert(data.message);
                    show_point()
                }


            }
        });
    }

}

function show_customer_in_point(id) {
    output = "";
    $.ajax({
        url: "../admin/customer-point-customer",
        method: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token-point-customer"]').attr('content')
        },
        data: { id_point: id },
        success: function(data) {

            if (data[0].list_customer) {
                $('#total_cus').html("Có " + data[0].list_customer.length + " người")
                $.each(data[0].list_customer, function(k, v) {
                    output += `
                    <div class="panel-body pb5">
                        <h3>${v.customer_name}</h3>
                        <h4>Địa chỉ : ${v.customer_address}</h4>
                        <h4>Phone: ${v.customer_phone}</h4>
                        <h4>Điểm tích lũy: ${v.customer_point}</h4>
                        <h4>-------------------------</h4>
                     </div>   `;

                });
            }

            $("#detail-level").html(output)
        }
    });
}

function edit_point(id) {
    output = '';
    $.ajax({
        url: "../admin/customer-point/" + id,
        method: "get",
        success: function(data) {
            $('#ecustomer_level').val(data[0].customer_level);
            $('#ecustomer_point').val(Number(data[0].customer_point));
            $('#ecustomer_discount').val(Number(data[0].customer_discount));
            $('#ecustomer_description').val(data[0].customer_description);
            $('#id_point').val(id);
        }
    });
}

function clear_data() //lam moi du lieu form insert
{
    $('#customer_level').val("");
    $('#customer_point').val("");
    $('#customer_discount').val("");
    $('#customer_description').val("");
}

function check_input() {
    var flag = 0;
    var level = $('#customer_level').val();
    var point = $('#customer_point').val();
    var discount = $('#customer_discount').val();
    var des = $('#customer_description').val();
    if (level == '') {
        flag = 1;
        $('#ercustomer_level').html('Điền tên cấp độ')
    } else {
        $('#ercustomer_level').html('')
    }
    if (point == '') {
        flag = 1;
        $('#ercustomer_point').html('Điền điểm tích lũy')
    } else {
        $('#ercustomer_point').html('')
    }
    if (discount == '') {
        flag = 1;
        $('#ercustomer_discount').html('Điền % giảm giá')
    } else {
        $('#ercustomer_discount').html('')
    }
    if (des == '') {
        flag = 1;
        $('#ercustomer_description').html('Điền ghi chú')
    } else {
        $('#ercustomer_description').html('')
    }
    if (flag == 0) {
        return true;
    }
    return false;

}

function check_edit() {
    var flag = 0;
    var level = $('#ecustomer_level').val();
    var point = $('#ecustomer_point').val();
    var discount = $('#ecustomer_discount').val();
    var des = $('#ecustomer_description').val();
    if (level == '') {
        flag = 1;
        $('#eercustomer_level').html('Điền tên cấp độ')
    } else {
        $('#eercustomer_level').html('')
    }
    if (point == '') {
        flag = 1;
        $('#eercustomer_point').html('Điền điểm tích lũy')
    } else {
        $('#eercustomer_point').html('')
    }
    if (discount == '') {
        flag = 1;
        $('#eercustomer_discount').html('Điền % giảm giá')
    } else {
        $('#eercustomer_discount').html('')
    }
    if (des == '') {
        flag = 1;
        $('#eercustomer_description').html('Điền ghi chú')
    } else {
        $('#eercustomer_description').html('')
    }
    if (flag == 0) {
        return true;
    }
    return false;

}
$(document).ready(function() {
    show_point();
    $('#insert_level_form').on("submit", function(event) {
        event.preventDefault();
        if (check_input() == false) {

        } else {
            $.ajax({
                url: "../admin/customer-point",
                method: "post",
                data: $('#insert_level_form').serialize(),
                success: function(data) {
                    if (data.status == 200) {
                        show_point();
                        alert(data.message);
                        $('#close_modol_insert').click();
                    } else
                        alert(data.message);
                }
            });
        }


    });

    $('#edit_level_form').on("submit", function(event) {
        event.preventDefault();
        if (check_edit() == false) {

        } else {
            $.ajax({
                url: "../admin/customer-point/" + $('#id_point').val(),
                method: "put",
                data: $('#edit_level_form').serialize(),
                success: function(data) {
                    if (data.status == 200) {
                        show_point();
                        alert(data.message);
                        $('#close_modol_edit').click();
                    } else
                        alert(data.message)
                }
            });
        }


    });

});
