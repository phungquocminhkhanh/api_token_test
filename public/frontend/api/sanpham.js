function showSP() {
    $.ajax({
        url: "http://127.0.0.1:8000/api/sanpham",
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>......</th>
                    <th>${v.ten}</th>
                    <th>${v.maSP}</th>
                    <th>${v.dongia}</th>
                    <th>${v.donvi}</th>
                    <th style="width:30px;">
                        <button type="button" name="edit-sp" data-toggle="modal" data-target="#edit_data_Modal" onclick="editSP(${v.id})" class="btn btn-info">sữa</button>
                        <button type="button" name="delete-sp" onclick="deleteSP(${v.id})" class="btn btn-info">Xóa</button>
                    </th>
                </tr>
                </tr>`;

            });
            $('#body-sanpham').html(output);
        }
    });
}

function deleteSP(id) {

    var r = confirm("Bạn có chắc muốn xóa không !");
    if (r == true) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/sanpham/" + id,
            method: "DELETE",
            success: function(data) {
                if (data.status) {
                    alert("Xóa thành công");
                    showSP();
                }
            }
        });
    }
}



function editSP(id) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/sanpham/" + id + "/edit",
        method: "GET",
        success: function(data) {
            $.each(data, function(k, v) {
                $('#eten').val(v.ten);
                $('#emaSP').val(v.maSP);
                $('#edongia').val(v.dongia);
                $('#edonvi').val(v.donvi);
            });

        }
    });
    $('#edit_form').on("submit", function(event) {
        event.preventDefault();
        if ($('#eten').val() == "") {
            alert("ten is required");
        } else if ($('#emaSP').val() == '') {
            alert("ma sp is required");
        } else if ($('#edongia').val() == '') {
            alert("don gia is required");
        } else if ($('#edonvi').val() == '') {
            alert("don vi is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/sanpham/" + id,
                method: "PUT",
                data: $('#edit_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        alert("Update thành công");
                        showSP();
                    }
                }
            });
        }
    });
}
$(function() {

    showSP();
    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        if ($('#ten').val() == "") {
            alert("ten is required");
        } else if ($('#maSP').val() == '') {
            alert("ma sp is required");
        } else if ($('#dongia').val() == '') {
            alert("don gia is required");
        } else if ($('#donvi').val() == '') {
            alert("don vi is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/sanpham",
                method: "POST",
                data: $('#insert_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        alert("Thêm thành công");
                        showSP();
                    }
                }
            });
        }
    });

});