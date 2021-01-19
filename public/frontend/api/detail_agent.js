function chonSP() {
    var tam = [];
    var tong = 0;
    $(':checkbox:checked').each(function(i) {
        var val = [];
        val[0] = $(this).val();
        val[1] = $('#sl' + $(this).val()).val();
        val[2] = $('#gia' + $(this).val()).val();
        val[3] = Number($('#sl' + $(this).val()).val()) * Number($('#gia' + $(this).val()).val());
        tam[i] = val;
        tong += Number($('#sl' + $(this).val()).val()) * Number($('#gia' + $(this).val()).val());
    });
    arrSP = tam;
    $('#tongtien').val(tong);
}

function showKhoAgent() {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/khoAgent/" + idKH,
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>......</th>
                    <th>${v.ten}</th>
                    <th>${v.soluong}</th>
                    <th>${v.soluongantoan}</th>
                    <th>${v.donvi}</th>
                    <th style="width:30px;">
                    </th>
                </tr>
                </tr>`;

            });
            $('#body-kho').html(output);
        }
    });
}

function showDH() {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/Agent-DH/" + idKH,
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <th>......</th>
                    <th>${v.id}</th>
                    <th>${v.created_at}</th>
                    <th>${v.tonggia}</th>
                    <th>`;
                if (v.trangthai == 0)
                    output += "Chờ xác nhận";
                else if (v.trangthai == 1)
                    output += "Đã nhận";
                else
                    output += "Đã hủy";

                output += `</th>
                    <th style="width:30px;">
                    <button type="button" id="showdetail"onclick="showdetailDH(${v.id})" class="btn btn-info">Chi tiết</button>
                    </th>
                </tr>`;

            });
            $('#body-dh').html(output);
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
$(function() {
    showDH();
    showKhoAgent();
    $.ajax({
        url: "http://127.0.0.1:8000/api/kho",
        method: "GET",

        success: function(data) {
            outputdonhang = "";
            outputhopdongsanpham = "";
            $.each(data, function(k, v) {
                outputdonhang += `
                <tr>
                    <td><input type="checkbox" value="${v.id}">${v.ten}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="gia${v.id}" type="hidden" value="${v.dongia}"></td>
                    <td>Tồn : ${v.soluong}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    <td>-Số Lượng:<input id="sl${v.id}" type="number">${v.dongia}/${v.donvi}</td>
                </tr>
                 `;
                outputhopdongsanpham += `
                <tr>
                    <td><input type="checkbox" value="${v.id}">&nbsp;&nbsp;${v.ten}</td>
                </tr>`;
            });
            $('#dssphopdongsanpham').html(outputhopdongsanpham);
            $('#dsSPDH').html(outputdonhang);
        }
    });
    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        tongtien = $('#tongtien').val();
        idKH = $('#idKH').val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/donhang",
            method: "POST",
            data: { dssp: arrSP, tien: tongtien, idAgent: idKH },
            success: function(data) {
                if (data.status) {
                    alert("Thêm thành công");
                }
            }
        });
    });
    $('#hopdongsanpham').click(function(e) {
        idKH = $('#idKH').val();
        var arr = {};
        $(':checkbox:checked').each(function(i) {
            arr[i] = $(this).val();
        });
        $.ajax({
            url: "http://127.0.0.1:8000/api/taohopdongsanpham",
            method: "POST",
            data: { dssp: arr, idAgent: idKH },
            success: function(data) {
                if (data.status) {
                    alert("Thêm thành công");
                }
            }
        });

        $(':checkbox').attr('checked', false);


    });
});
