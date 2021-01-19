function show_unit() {
    let output = "";
    $.ajax({
        type: "get",
        url: "../admin/product-unit",
        dataType: "json",
        success: function(response) {
            $.each(response, function(k, v) {
                output += `
                <tr>
                <td> ${v.unit_title}</td>
                <td> ${v.unit}</td>
                <td class="client-status"><button onclick="edit_unit(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_unit_Modal" >Sửa</button>
                <button onclick="delete_unit(${v.id})" class="label label-primary">Xóa</button>
                </td>

                </tr>
                `;

            });
            $("#content-unit").html(output)

        }
    });
}

function delete_unit(id) {
    var r = confirm("Bạn có chắc muốn xóa đơn vị này không !");
    if (r == true) {
        $.ajax({
            type: "delete",
            url: "../admin/product-unit/" + id,
            data: { id_unit: id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-delete-unit"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 200) {
                    alert(response.message)
                    show_unit();
                }

            }
        });
    }
}

function edit_unit(id) {
    $('#id_unit').val(id);
    $.ajax({
        url: "../admin/product-unit/" + id,
        method: "GET",
        success: function(data) {
            if (data.status == 200) {
                $.each(data.data, function(k, v) {
                    $('#eunit_title').val(v.unit_title);
                    $('#eunit').val(v.unit);
                });
            }


        }
    });

}

function check_input() {
    var flag = 0;
    var name = $('#unit_title').val();
    var kyhieu = $('#unit').val();

    if (name == '') {
        flag = 1;
        $('#erunit_title').html('Điền tên đơn vị')
    } else {
        $('#erunit_title').html('')
    }

    if (kyhieu == '') {
        flag = 1;
        $('#erunit').html('Điền ký hiệu đơn vị')
    } else {
        $('#erunit').html('')
    }

    return flag = 0 ? true : false;

}

function check_edit() {
    var flag = 0;
    var name = $('#eunit_title').val();
    var kyhieu = $('#eunit').val();

    if (name == '') {
        flag = 1;
        $('#eerunit_title').html('Điền tên đơn vị')
    } else {
        $('#eerunit_title').html('')
    }

    if (kyhieu == '') {
        flag = 1;
        $('#eerunit').html('Điền ký hiệu đơn vị')
    } else {
        $('#eerunit').html('')
    }

    return flag = 0 ? true : false;

}
$(document).ready(function() {
    show_unit();
    $('#insert_unit_form').on('submit', function(event) {
        event.preventDefault();
        if (check_input()) {

        } else {
            $.ajax({
                url: "../admin/product-unit",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message)
                        show_unit();
                        $('#close_modol_insert').click();
                    } else {
                        alert(data.message)
                    }
                }
            })
        }

    });
    $('#edit_unit_form').on('submit', function(event) {
        console.log($("#id_unit").val());
        event.preventDefault();
        if (check_edit()) {

        } else {
            $.ajax({
                url: "../admin/product-unit/" + $("#id_unit").val(),
                method: "put",
                data: $('#edit_unit_form').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message);
                        // show_floor();
                        $('#close_modol_edit_unit').click();
                        show_unit();
                    } else
                        alert(data.message);
                }
            })
        }

    });
});
