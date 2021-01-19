function showAgent() {
    $.ajax({
        url: "http://127.0.0.1:8000/api/agent",
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>`;
                if (v.trangthai == 1)
                    output += `<a href="http://127.0.0.1:8000/show-detail-agent/${v.id}"><img height="100px" width="100px" src="frontend/images/blue-coffe.png"  ></a>`;
                else
                    output += `<a href="http://127.0.0.1:8000/show-detail-agent/${v.id}"><img height="100px" width="100px" src="frontend/images/red-coffe.png"  ></a>`;

                output += `</th>
                    <th>${v.ten}</th>
                    <th style="width:30px;">
                        <button type="button" name="edit-agent" data-toggle="modal" data-target="#edit_data_Modal" onclick="editAgent(${v.id})" class="btn btn-info">sữa</button>
                        <button type="button" name="delete-agent" onclick="deleteAgent(${v.id})" class="btn btn-info">Xóa</button>
                    </th>
                </tr>`;

            });
            $('#body-agent').html(output);
        }
    });
}

function deleteAgent(id) {

    var r = confirm("Bạn có chắc muốn xóa không !");
    if (r == true) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/agent/" + id,
            method: "DELETE",
            success: function(data) {
                if (data.status) {
                    alert("Xóa thành công");
                    showAgent();
                }
            }
        });
    }
}

function editAgent(id) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/agent/" + id + "/edit",
        method: "GET",
        success: function(data) {
            $.each(data, function(k, v) {
                $('#eemail').val(v.email);
                $('#epassword').val(v.password);
                $('#eten').val(v.ten);
                $('#ediachi').val(v.diachi);
                $('#esdt').val(v.sdt);
                $('#etrangthai').val(v.trangthai);
            });

        }
    });
    $('#edit_form').on("submit", function(event) {
        event.preventDefault();
        if ($('#eten').val() == "") {
            alert("ten is required");
        } else if ($('#eemail').val() == '') {
            alert("email is required");
        } else if ($('#epassword').val() == '') {
            alert("password is required");
        } else if ($('#ediachi').val() == '') {
            alert("dia chi is required");
        } else if ($('#esdt').val() == '') {
            alert("so dien thoai is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/agent/" + id,
                method: "PUT",
                data: $('#edit_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        alert("Update thành công");
                        showAgent();
                    }
                }
            });
        }
    });
}
$(function() {
    showAgent();
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
            alert("dso dien thoai is required");
        } else {
            $.ajax({
                url: "http://127.0.0.1:8000/api/agent",
                method: "POST",
                data: $('#insert_form').serialize(),
                success: function(data) {
                    if (data.status) {
                        alert("Thêm thành công");
                        showAgent();
                    }
                }
            });
        }
    });

});