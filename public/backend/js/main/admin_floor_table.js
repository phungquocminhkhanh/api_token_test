function show_floor() {
    var output = "";
    $.ajax({
        url: "../admin/floor",
        method: "get",
        dataType: 'JSON',
        success: function(data) {
            $.each(data, function(k, v) {
                output += `
                    <tr onclick="show_table_floor(${v.id},'${v.floor_title}')">
                    <td> ${v.floor_title}</td>
                    <td>`;
                if (v.floor_type == "eat-in")
                    output += 'Ăn tại bàn';
                else
                    output += 'Mang đi';
                output += ` </td>
                <td> ${v.floor_priority}</td>
                    <td class="client-status"><button onclick="edit_floor(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_floor_Modal" >Sửa</button></td>
                   <td class="client-status"><button onclick="delete_floor(${v.id})" class="label label-primary">Xóa</button></td>
                    </tr>
                    `;

            });
            $("#content-floor").html(output)
        }
    })
}

function show_table_floor(id, title) {
    output = "";
    output1 = `
                <li class="active"><a data-toggle="tab" onclick="show_table_floor(${id},'${title}')"><i class="fa fa-user"></i>${title}</a></li>
                <li class="active"> <button type="button" name="x" id="x" data-toggle="modal" data-target="#add_table_Modal" class="btn btn-warning">Thêm bàn</button></li>`;
    $("#select-floor").html(output1); // add may cái lựa chọn
    $("#id_floor_table").val(id);
    $.ajax({
        url: "../admin/get-table",
        method: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token-show-floor-table"]').attr('content')
        },
        data: { id_floor: id },
        dataType: 'JSON',
        success: function(data) {
            $.each(data, function(k, v) {
                output += `
                <tr>
                <td> ${v.table_title} - ${v.floor_title} </td>
                <td class="client-status"><button onclick="edit_table(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_table_Modal" >Sửa</button></td>
                <td class="client-status"><button onclick="delete_table(${v.id})" class="label label-primary">Xóa</button></td>
                </tr>
                `;
            });
            $("#content-table").html(output)
        }
    })

}

function delete_floor(id) {
    // console.log($('meta[name="csrf-token-delete-floor"]').attr('content'));
    var r = confirm("Bạn có chắc muốn xóa không !");
    if (r == true) {
        $.ajax({
            url: "../admin/floor/" + id,
            method: "delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-delete-floor"]').attr('content'),
            },
            data: { id_floor: id },
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 200) {
                    alert(data.message);
                    show_floor();
                    show_table();
                }
            }
        })
    }
}

function show_table() {
    var output11 = `
                <li class="active"><a data-toggle="tab" onclick="show_table()" ><i class="fa fa-user"></i>Tất cả-`;
    var output20 = "";
    $.ajax({
        url: "../admin/table",
        method: "get",
        dataType: 'JSON',
        success: function(data) {
            $.each(data, function(k, v) {
                output20 += `
                <tr>
                <td> ${v.table_title} - ${v.floor_title} </td>
                <td class="client-status"><button onclick="edit_table(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_table_Modal" >Sửa</button></td>
                <td class="client-status"><button onclick="delete_table(${v.id})" class="label label-primary" >Xóa</button></td>
                </tr>
                `;
            });
            output11 += `${data.length} Bàn</a></li>`;
            $("#content-table").html(output20);
            $("#select-all").html(output11);
        }
    })

}

function delete_table(id) {
    var r = confirm("Bạn có chắc muốn xóa không !");
    if (r == true) {
        $.ajax({
            url: "../admin/table/" + id,
            method: "delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-delete-table"]').attr('content')
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 200) {
                    alert(data.message);
                    show_table();
                }
            }
        })
    }

}

function edit_table(id) {
    $.ajax({
        url: "../admin/table/" + id,
        method: "get",
        dataType: 'JSON',
        success: function(data) {
            $.each(data, function(k, v) {
                $('#etable_title').val(v.table_title);
                $('#id_table').val(v.id);
            });
        }
    })
}

function edit_floor(id) {

    $.ajax({
        url: "../admin/floor/" + id,
        method: "get",
        dataType: 'JSON',
        success: function(data) {
            var output0 = "";
            $.each(data, function(k, v) {
                $('#efloor_title').val(v.floor_title);
                $('#efloor_priority').val(v.floor_priority);
                $('#id_floor').val(v.id);
                if (v.floor_type == 'carry-out') {
                    output0 += `<input type="radio"  name="floor_type" value="eat-in"/><label>Ăn tại bàn</label><br/>
                    <input type="radio" checked name="floor_type" value="carry-out"/><label>Mang đi</label>`

                } else {
                    output0 += `<input type="radio" checked name="floor_type" value="carry-out"/><label>Ăn tại bàn</label><br/>
                    <input type="radio" name="floor_type" value="carry-out"/><label>Mang đi</label>`
                }
            });
            $('#eerfloor_title').html('');
            $('#eerfloor_priority').html('');
            $('#efloor_type').html(output0);
        }
    })
}

function check_input_floor() {
    var flag = 0;
    var title = $('#floor_title').val();
    var pri = $('#floor_priority').val();

    if (title == '') {
        flag = 1;
        $('#erfloor_title').html('Điền tên tầng')
    } else {
        $('#erfloor_title').html('')
    }
    if (pri == '') {
        flag = 1;
        $('#erfloor_priority').html('Điền thứ tự ưu tiên')
    } else {
        $('#erfloor_priority').html('')
    }

    if (flag == 0) {
        return true;
    }
    return false;

}

function check_edit_floor() {
    var flag = 0;
    var title = $('#efloor_title').val();
    var pri = $('#efloor_priority').val();

    if (title == '') {
        flag = 1;
        $('#eerfloor_title').html('Điền tên tầng')
    } else {
        $('#eerfloor_title').html('')
    }
    if (pri == '') {
        flag = 1;
        $('#eerfloor_priority').html('Điền thứ tự ưu tiên')
    } else {
        $('#eerfloor_priority').html('')
    }

    if (flag == 0) {
        return true;
    }
    return false;

}

function check_input_table() {
    var flag = 0;
    var title = $('#table_title').val();


    if (title == '') {
        flag = 1;
        $('#ertable_title').html('Điền tên bàn')
    } else {
        $('#ertable_title').html('')
    }
    if (flag == 0) {
        return true;
    }
    return false;

}

function check_edit_table() {
    var flag = 0;
    var title = $('#efloor_title').val();


    if (title == '') {
        flag = 1;
        $('#eerfloor_title').html('Điền tên bàn')
    } else {
        $('#eerfloor_title').html('')
    }
    if (flag == 0) {
        return true;
    }
    return false;

}
$(document).ready(function() {
    show_floor();
    show_table();
    $('#insert_floor_form').on('submit', function(event) {
        event.preventDefault();
        if (check_input_floor() == false) {

        } else {
            $.ajax({
                url: "../admin/floor",
                method: "POST",
                data: $('#insert_floor_form').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message);
                        show_floor();
                        $('#close_modol_insert_floor').click();
                    } else
                        alert(data.message);
                }
            })
        }

    });
    $('#edit_floor_form').on('submit', function(event) {
        event.preventDefault();
        if (check_edit_floor() == false) {

        } else {
            $.ajax({
                url: "../admin/floor/" + $("#id_floor").val(),
                method: "PUT",
                data: $('#edit_floor_form').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message);
                        show_floor();
                        $('#close_modol_edit_floor').click();
                    } else
                        alert(data.message);
                }
            })
        }

    });
    $('#insert_table_form').on('submit', function(event) {
        event.preventDefault();
        if (check_input_table() == false) {

        } else {
            $.ajax({
                url: "../admin/table",
                method: "post",
                data: $('#insert_table_form').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message);
                        show_table();
                        $('#close_modol_insert_table').click();
                    } else
                        alert(data.message);
                }
            })
        }

    });
    $('#edit_table_form').on('submit', function(event) {
        event.preventDefault();
        if (check_edit_table() == false) {

        } else {
            $.ajax({
                url: "../admin/table/" + $("#id_table").val(),
                method: "put",
                data: $('#edit_table_form').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 200) {
                        alert(data.message);
                        // show_floor();
                        $('#close_modol_edit_table').click();
                        show_table();
                    } else
                        alert(data.message);
                }
            })
        }

    });
});