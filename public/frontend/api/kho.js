var arrSP = {};

function showKho() {
    $.ajax({
        url: "http://127.0.0.1:8000/api/kho",
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
                    <th>${v.soluong}</th>
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

    $.ajax({
        url: "http://127.0.0.1:8000/api/kho",
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
                    <th>${v.soluong}</th>
                    <th>${v.donvi}</th>
                    <th style="width:30px;">
                        <button type="button" name="delete-sp" onclick="chitiet(${v.id})" class="btn btn-info">Chi tiết</button>
                    </th>
                </tr>
                </tr>`;

            });
            $('#body-kho').html(output);
        }
    });
}

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

$(function() {
    showKho();
    $.ajax({
        url: "http://127.0.0.1:8000/api/sanpham",
        method: "GET",

        success: function(data) {
            output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <td><input type="checkbox" value="${v.id}">${v.ten}
                    <input id="gia${v.id}" type="hidden" value="${v.dongia}"></td>
                    <td>Số Lượng:<input id="sl${v.id}" type="number">${v.dongia}/${v.donvi}</td>
                </tr>
                 `;
            });
            $('#dsSP').html(output);
        }
    });
    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        var gc = $('#ghichu').val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/kho",
            method: "POST",
            data: { dssp: arrSP, ghichu: gc },
            success: function(data) {
                if (data.status) {
                    alert("Thêm thành công");
                    showKho();
                }
            }
        });
    });

});
