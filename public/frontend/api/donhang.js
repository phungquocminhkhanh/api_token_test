function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function trangthaiDonHang(trangthai) {
    if (trangthai) {
        $.ajax({
            url: "http://127.0.0.1:8000/api/trangthai-DH/" + trangthai,
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
                            <th>${v.tenAgent}</th>
                            <th>${v.tenNV}</th>
                            <th style="width:30px;">
                            <button type="button" id="showdetail"onclick="showdetailDH(${v.id})" class="btn btn-info">Chi tiết</button>
                            </th>
                        </tr>`;

                });
                $('#body-dh').html(output);
            }
        });
    } else showDonHang();
}

function showDonHang() {
    $.ajax({
        url: "http://127.0.0.1:8000/api/donhang",
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
                        <th>${v.tenAgent}</th>
                        <th>${v.tenNV}</th>
                        <th style="width:30px;">
                        <button type="button" id="showdetail"onclick="showdetailDH(${v.id})" class="btn btn-info">Chi tiết</button>
                        </th>
                    </tr>`;

            });
            $('#body-dh').html(output);
        }
    });
}

function checkdoanhthu() {
    thangdau = $("#thangdau").val();
    thangcuoi = $("#thangcuoi").val();
    showdoanhthu(Number(thangdau), Number(thangcuoi));
}

function showdoanhthu(thangdau, thangcuoi) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/tongdoanhthu-DH",
        method: "GET",
        data: { thangdau: thangdau, thangcuoi: thangcuoi },
        success: function(data) {
            if (data[0].tongdoanhthu != null) {
                var output = "";
                $.each(data, function(k, v) {
                    output += `
                    <tr>
                        <th>......</th>
                        <th>${v.tongdonhang}</th>
                        <th>`;
                    fm = numberWithCommas(v.tongdoanhthu);
                    output += fm + " VND";


                    output += `</th>
                        <th></th>
                    </tr>`;

                });
                $('#body-thongke').html(output);
            } else {
                console.log(1);
                output = `
                    <tr>
                        <th>......</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>`;
                $('#body-thongke').html(output);
            }

        }
    });
}
$(function() {
    showdoanhthu(1, 12);
    showDonHang();

});