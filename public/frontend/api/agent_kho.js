function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function showKho() {
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
                    <th>${v.maSP}</th>
                    <th><input type="number" value="${v.dongiaAgent}" id="gia${v.idSP}">
                         <button onclick="updatedongia(${v.idSP})">save</button></th>
                    <th>${v.soluong}</th>
                    <th> <input type="number" value="${v.soluongantoan}" id="sl${v.idSP}">
                        <button onclick="updatesoluongantoan(${v.idSP})">save</button>
                    </th>
                    <th>${v.donvi}</th>
                    <th style="width:30px;">
                    </th>
                </tr>
                </tr>`;

            });
            $('#body-agentkho').html(output);
        }
    });
}



function showDH() {
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/donhang-Agent-dachot/" + idKH,
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
                    <th style="width:30px;">
                    <button type="button" id="showdetail"onclick="showdetailDH(${v.id})" class="btn btn-info">Chi tiết</button>
                    </th>
                </tr>`;

            });
            $('#body-agentdonhang').html(output);
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
                fm = numberWithCommas(v.dongia)
                output += `${fm}</th>
                </tr>`;

            });
            output += `</tbody>
                    </table>
                </div>
                </div>
            </div>`;
            console.log(output);
            $('#detaildonhang').html(output);
        }
    });
}
//update lại số lượng an toàn
function updatesoluongantoan(idsp) {
    sl = $("#sl" + idsp).val();
    idKH = $('#idKH').val();
    console.log(sl);
    $.ajax({
        url: "http://127.0.0.1:8000/api/khoAgent/" + idKH,
        method: "PUT",
        data: { soluongantoan: sl, idSP: idsp },
        success: function(data) {
            if (data.status) {
                alert("Cập nhật thành công");
            }
        }
    });
}


//tùy chỉnh giá bán sản phẩm theo Agent
function updatedongia(idsp) {
    console.log(1);
    dongia = $("#gia" + idsp).val();
    idKH = $('#idKH').val();
    $.ajax({
        url: "http://127.0.0.1:8000/api/update-dongia-Agent" + idKH,
        method: "PUT",
        data: { dongia: dongia, idSP: idsp },
        success: function(data) {
            if (data.status) {
                alert("Cập nhật thành công");
            }
        }
    });
}

$(function() {
    showKho();
    showDH();
});
