function showNV() {
    $.ajax({
        url: "http://127.0.0.1:8000/api/nhanvien",
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>......</th>
                    <th>${v.ten}</th>
                    <th>${v.email}</th>
                    <th>`;
                if (v.gioitinh == 1) output += `Nam`;
                else output += `Nữ`;

                output += `</th>
                    <th>${v.sdt}</th>
                    <th>${v.quyen}</th>
                    <th style="width:30px;">
                        <button type="button" name="edit-sp" data-toggle="modal" data-target="#edit_data_Modal" onclick="editNV(${v.id})" class="btn btn-info">sữa</button>
                        <button type="button" name="delete-sp" onclick="deleteNV(${v.id})" class="btn btn-info">Xóa</button>
                    </th>
                </tr>
                </tr>`;

            });
            $('#body-sanpham').html(output);
        }
    });
}

function deleteNV(id) {
    var r = confirm("Bạn có chắc muốn xóa không !");
    if (r == true) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/nhanvien/" + id,
            method: "DELETE",
            success: function(data) {
                if (data.status) {
                    alert("Xóa thành công");
                    showNV();
                }
            }
        });
    }

}

function editNV(id) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/nhanvien/" + id + "/edit",
        method: "GET",
        success: function(data) {
            console.log(data);
            $.each(data, function(k, v) {
                $('#eemail').val(v.email);
                $('#epassword').val(v.password);
                $('#eten').val(v.ten);
                if (v.gioitinh == 1)
                    $('#enam').attr('checked', true);
                else
                    $('#enu').attr('checked', true);

                $('#engaysinh').val(v.ngaysinh);
                $('#khanh').val(v.diachi);
                $('#esdt').val(v.sdt);
                $('#equyen').val(v.quyen);

            });

        }
    });
    $('#edit_form').on("submit", function(event) {
        event.preventDefault();
        if ($('#ten').val() == "") {
            alert("ten is required");
        } else if ($('#email').val() == '') {
            alert("email is required");
        } else if ($('#password').val() == '') {
            alert("password is required");
        } else if ($('#diachi').val() == '') {
            alert("diachi is required");
        } else if ($('#sdt').val() == '') {
            alert("so dien thoai is required");
        } else if ($('#ngaysinh').val() == '') {
            alert("ngay sinh is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/nhanvien/" + id,
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
    showNV();
    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        if ($('#ten').val() == "") {
            alert("ten is required");
        } else if ($('#email').val() == '') {
            alert("email is required");
        } else if ($('#password').val() == '') {
            alert("password is required");
        } else if ($('#diachi').val() == '') {
            alert("diachi is required");
        } else if ($('#sdt').val() == '') {
            alert("so dien thoai is required");
        } else if ($('#ngaysinh').val() == '') {
            alert("ngay sinh is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/nhanvien",
                method: "POST",
                data: $('#insert_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        alert("Thêm thành công");
                        showNV();
                    }
                }
            });
        }
    });

});