function showdonhangchuannhan() {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/donhang-Agent/" + idKH,
        method: "GET",
        success: function(data) {
            output = "";
            $.each(data, function(k, v) {
                output += `
                            <tr>
                                <th>......</th>
                                <th>${v.id}</th>
                                <th>${v.created_at}</th>
                                <th> <button onclick="showdetailDH(${v.id})">Chi tiết</button> </th>
                                <th> <button onclick="chotDH(${v.id})">Chốt đơn</button> </th>
                                 <th> <button onclick="huyDH(${v.id})">Hủy đơn</button> </th>
                            </tr>
                            `;
            });
            $('#dondathang').html(output);
        }
    });
}

function showdetailDH(id) {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/detail-DH/" + id,
        method: "GET",
        data: { idAgent: idKH },
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>......</th>
                    <th>${v.idDH}</th>
                    <th>${v.ten}</th>
                    <th>${v.soluong}</th>
                    <th style="width:30px;">
                    </th>
                </tr>`;

            });
            $('#body-detail').html(output);
        }
    });
}

function huyDH(id) {
    idKH = $('#idKH').val();
    var r = confirm("Bạn có chắc muốn hủy đơn không !");
    if (r == true) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/huydonhang-Agent/" + id,
            method: "PUT",
            data: { idAgent: idKH },
            success: function(data) {
                if (data.status) {
                    alert("Hủy thành công");
                }

            }
        });
    }


}

function chotDH(id) {
    idKH = $('#idKH').val();
    var r = confirm("Bạn có chắc chốt đơn không !");
    if (r == true) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/chotdonhang-Agent/" + id,
            method: "GET",
            data: { idAgent: idKH },
            success: function(data) {
                if (data.status) {
                    alert("Chốt thành công");
                }

            }
        });
    }


}
$(function() {
    showdonhangchuannhan();
});
