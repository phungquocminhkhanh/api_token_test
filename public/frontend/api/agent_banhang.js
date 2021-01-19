var arrSP = {};

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function showHoaDon() {

    $.ajax({
        url: "http://127.0.0.1:8000/api/banhang/" + idKH + "/edit",
        method: "GET",
        success: function(data) {
            var output = "";
            $.each(data, function(k, v) {
                output += `
                    <tr>
                    <th>......</th>
                    <th>${v.id}</th>
                    <th>${v.created_at}</th>
                    <th>`;
                x = numberWithCommas(v.tongtien);

                output += `${x}</th>
                    <th> <button onclick="showdetailHD(${v.id})">Chi tiết</button></th>
                    </tr>`;

            });
            $('#body-hoadon').html(output);
        }
    });
}

function showdetailHD(x) {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/detail-phieubanhang/" + x,
        method: "GET",
        data: { idAgent: idKH },
        success: function(data) {
            output = `<div class="table-agile-info"><div class="panel panel-default"><div class="panel-heading"> Chi tiết hóa đơn</div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Số lượng</th>
              <th>Đơn giá</th>
            </tr>

          </thead>
          <tbody>`;
            $.each(data, function(k, v) {
                output += `
                <tr>
                <th>${v.ten}</th>
                <th>${v.soluong}</th>
                <th>`;
                fm = numberWithCommas(v.dongiaAgent)
                output += `${fm}</th>
                </tr>`;

            });

            output += `</tbody>
                    </table>
                </div>
                </div>
            </div>`;
            console.log(output);
            $('#body-detailhoadon').html(output);
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
    showHoaDon();
    idKH = $('#idKH').val();
    $.ajax({

        url: "http://127.0.0.1:8000/api/khoAgent/" + idKH,
        method: "GET",

        success: function(data) {
            output = "";
            $.each(data, function(k, v) {
                output += `
                <tr>
                    <td><input type="checkbox" value="${v.id}">${v.ten} &nbsp;   &nbsp;   &nbsp;
                    <input id="gia${v.id}" type="hidden" value="${v.dongiaAgent}"></td>
                    <td>Số Lượng:${v.soluong} &nbsp;&nbsp;&nbsp;<input id="sl${v.id}" type="number">${v.dongiaAgent}/${v.donvi}</td>
                </tr>
                 `;
            });
            $('#dsSP').html(output);
        }
    });
    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        var idKH = $('#idKH').val();
        var gc = $('#ghichu').val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/banhang",
            method: "POST",
            data: { dssp: arrSP, ghichu: gc, idAgent: idKH },
            success: function(data) {
                if (data.status) {
                    alert("Tạo thành công");
                    showHoaDon();
                }
            }
        });
    });

});