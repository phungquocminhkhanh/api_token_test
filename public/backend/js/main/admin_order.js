    var arrorder = {}; //dung de tìm kiếm
    var arr_tam = {}; // dùng để show all,
    var arr_phantrang = {}; //dung de phan tranvg
    var trangtam = 1;
    var trangmax = 5;

    function numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }

    function show_order() {
        output = '';
        $.ajax({
            url: "../admin/get-order-order",
            method: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-show-order"]').attr('content')
            },
            success: function(data) {
                arrorder = data;
                arr_tam = data;
                arr_phantrang = data;
                $.each(data, function(k, v) {
                    if (k == 10)
                        return false;
                    output += `
                    <tr onclick="detai_order(${v.id})">
                    <td>${k+1}</td>
                    <td>${v.order_code}</td>
                    <td> ${numberWithCommas(Number(v.order_total_cost)-Number(v.order_direct_discount))} đ</td>`;

                    if (v.order_status == 1)
                        output += ` <td>Đặt món</td>`
                    if (v.order_status == 2)
                        output += ` <td>Chế biến</td>`
                    if (v.order_status == 3)
                        output += ` <td>Lên món</td>`
                    if (v.order_status == 4)
                        output += ` <td>Thanh toán</td>`
                    if (v.order_status == 5)
                        output += ` <td>Hoàn tất</td>`
                    if (v.order_status == 6)
                        output += ` <td>Hủy</td>`

                    output += `<td> ${v.order_created}</td>
                    <td>`;
                    if (v.order_status == 1)
                        output += `<button onclick="cancel_order(${v.id})" class="label label-primary" data-toggle="modal" data-target="#cancle_order_modal">Hủy</button>`
                    else
                        output += `<button style="background-color:#ADD8E6;" class="label label-primary">Hủy</button>`

                    output += `
                    </td>
                    </tr>
                    `;

                });
                $("#content-order").html(output)
            }

        });

    }

    function cancel_order(id) {
        $('#id_order').val(id);
    }

    function next_phantrang() {
        trang = trangtam + 1;
        if (trang > trangmax) {
            document.getElementById('next_trang').remove();
            $("#content_phantrang").append(`
            <li class="page-item"><a class="page-link" onclick="phantrang(${trang})" href="#">${trang}</a></li>
            <li class="page-item"><a class="page-link" onclick="next_phantrang()" id="next_trang" >>></a></li>`)
            trangmax = trang;
        }
        phantrang(trang);


    }

    function back_phantrang() {
        trang = trangtam - 1;
        if (trang == 0) {

        } else {
            phantrang(trang);
        }




    }

    function phantrang(trang) {

        trangtam = trang;
        var n = Object.keys(arr_phantrang).length;
        t = trang * 10 - 10;
        max = t + 10;
        output = '';
        for (let i = t; i < n; i++) {
            if (i == max) {
                break;
            }
            output += `
                <tr onclick="detai_order(${arr_phantrang[i].id})">
                <td>${i+1}</td>
                <td>${arr_phantrang[i].order_code}</td>
                <td> ${numberWithCommas(Number(arr_tam[i].order_total_cost)-Number(arr_phantrang[i].order_direct_discount))} đ</td>`;

            if (arr_phantrang[i].order_status == 1)
                output += ` <td>Đặt món</td>`
            if (arr_phantrang[i].order_status == 2)
                output += ` <td>Chế biến</td>`
            if (arr_phantrang[i].order_status == 3)
                output += ` <td>Lên món</td>`
            if (arr_phantrang[i].order_status == 4)
                output += ` <td>Thanh toán</td>`
            if (arr_phantrang[i].order_status == 5)
                output += ` <td>Hoàn tất</td>`
            if (arr_phantrang[i].order_status == 6)
                output += ` <td>Hủy</td>`

            output += `<td> ${arr_phantrang[i].order_created}</td>
                <td>`;
            if (arr_phantrang[i].order_status == 1)
                output += `<button onclick="cancel_order(${arr_phantrang[i].id})" class="label label-primary" data-toggle="modal" data-target="#cancle_order_modal" >Hủy</button>`
            else
                output += `<button style="background-color:#ADD8E6;" class="label label-primary">Hủy</button>`

            output += `
                </td>
                </tr>
                `;





        }
        $("#content-order").html(output)
    }


    function detai_order(id) {
        output = "";
        $.ajax({
            url: "../admin/order-order-detail",
            method: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-detail-order"]').attr('content')
            },
            data: {
                id_order: id
            },
            success: function(data) {

                $.each(data.data, function(k, v) {

                    output += `
                    <table style="width:95%;" class="table table-striped table-hover">
                    <tr>
                    <td><h4>${v.floor_title} - ${v.table_title}</h4></td>
                    </tr>
                    <tr>
                        <td>Mã khách hàng</td>
                        <td>${v.id_customer}</td>
                    </tr>

                    <tr>
                    <td>Nhân viên</td>
                    <td>${v.account_username}</td>
                    </tr>
                    <tr>
                    <td>Mã đơn hàng</td>
                    <td>${v.order_code}</td>
                    </tr>
                    <tr>
                    <td>Trạng thái</td>
                    `;

                    if (v.order_status == 1)
                        output += ` <td>Đặt món</td>`
                    if (v.order_status == 2)
                        output += ` <td>Chế biến</td>`
                    if (v.order_status == 3)
                        output += ` <td>Lên món</td>`
                    if (v.order_status == 4)
                        output += ` <td>Thanh toán</td>`
                    if (v.order_status == 5)
                        output += ` <td>Hoàn tất</td>`
                    if (v.order_status == 6)
                        output += ` <td>Hủy</td>`




                    output += `
                    </tr>
                    <tr>
                    <td>Ngày tạo</td>
                    <td>${v.order_created}</td>
                    </tr>`;


                    if (v.order_status == 6 && v.order_comment != null)
                        output += `<tr>
                    <td colspan ="2" style="color:red">Lý do hủy : <br />- ${v.order_comment}</td>

                    </tr>`;




                    output += `<tr>
                    <td colspan ="2" ><img style="height:180px; weight: 500px" src="../images/bd_food.png" alt="" style="width: 100%;"></td>
                    </tr>
                    <tr>
                    <td colspan ="2"><h4>Thực đơn món đã gọi</h4></td>

                    </tr>
                    `;

                    $.each(v.detail, function(j, d) {

                        if (d.detail_status == 'Y' || d.detail_status == 'N') {
                            tongtien_detail = Number(d.product_sales_price);
                            output += `<tr>
                                        <td colspan ="2"><h5>${d.product_title}</h5>
                                            <div style="color:DarkGray">Món đi kèm:</div>
                                        `;
                            $.each(d.detail_extra, function(kk, extra) { //chú ý chổ này nhé, for thêm cái nữa nhé,console ra để xem cho rõ
                                $.each(extra, function(z, e) {
                                    tongtien_detail += Number(e.product_sales_price);
                                    output += `<div style="color:DarkGray">- ${e.product_title} - ${numberWithCommas(e.product_sales_price)} đ</div>
                                    `
                                });

                            });
                            output += `     <div>${tongtien_detail} x  ${d.detail_quantity} = ${numberWithCommas(d.detail_cost)} đ</div>
                                        </td>
                                        </tr>
                                    `;
                        }



                    });
                    $.each(v.detail, function(j, d) {

                        if (d.detail_status == 'C') {

                            tongtien_detail = Number(d.product_sales_price);
                            output += `<tr>
                                        <td colspan ="2">
                                        <h5 style="color:red">Món hủy</h5>
                                        <h5 style="color:DarkGray">${d.product_title}</h5>
                                            <div style="color:DarkGray">Món đi kèm:</div>
                                        `;

                            $.each(d.detail_extra, function(kk, extra) { //chú ý chổ này nhé, for thêm cái nữa nhé,console ra để xem cho rõ
                                $.each(extra, function(z, e) {
                                    tongtien_detail += Number(e.product_sales_price);
                                    output += `<div style="color:DarkGray">- ${e.product_title} - ${numberWithCommas(e.product_sales_price)} đ</div>
                                    `
                                });

                            });

                            output += `     <div style="color:DarkGray">${numberWithCommas(tongtien_detail)} x  ${d.detail_quantity} = ${numberWithCommas(d.detail_cost)} đ</div>
                                        </td>
                                        </tr>
                                    `;

                        }



                    });




                    output += `
                        <tr>
                            <td colspan ="2" ><h3>Ghi chú</h3>`;


                    if (v.order_comment != null && v.order_status != 6)
                        output += v.order_comment;


                    output += `</td>
                        </tr>`;
                    output += `


                        <tr>
                            <td style="color:Blue"><h3>Tổng tạm tính</h3></td>
                            <td style="color:#000000"><h3>${numberWithCommas(v.order_total_cost)} đ</h3></td>
                        </tr>

                        <tr>
                            <td style="color:Blue"><h3>Giảm trực tiếp</h3></td>
                            <td style="color:#000000"><h3>${numberWithCommas(v.order_direct_discount)} đ</h3></td>
                        </tr>
                        <tr style="color:Green">
                            <td><h2>Thành tiền</h2></td>
                            <td><h2>${numberWithCommas(Number(v.order_total_cost)-Number(v.order_direct_discount))} đ</h2></td>
                        </tr>
                    </table>`;
                });
                $('#content_order_detail').html(output);

            }
        });

    }



    function seach_order() {
        let status = $('#inputStatee').val();
        var tam = arrorder;
        ngaybatdau = Date.parse($('#ngaybatdau').val());
        ngayketthuc = Date.parse($('#ngayketthuc').val());
        if (ngaybatdau && ngayketthuc) {
            let tam2 = {};
            let i = 0;
            $.each(tam, function(k, v) {
                date = Date.parse(v.order_created)
                if (ngaybatdau <= date && date <= ngayketthuc) {
                    tam2[i] = v;
                    i++;
                }
            });
            tam = tam2;
        }
        if (status != 0) {
            let tam2 = {};
            let j = 0;
            $.each(tam, function(k, v) {
                if (v.order_status == status) {
                    tam2[j] = v;
                    j++;
                }
            });
            tam = tam2;

        }
        arr_phantrang = tam;
        phantrang(1);
    }

    function show_order_type(type) {
        if (type == 'all') {
            arrorder = arr_tam;
            arr_phantrang = arr_tam;
            phantrang(1);
        } else {
            var tam = {};
            output = '';
            i = 0;
            $.each(arr_tam, function(k, v) {
                if (v.floor_type == type) {
                    tam[i] = v;
                    i++;
                }
            });

            arr_phantrang = tam;
            arrorder = tam;
            phantrang(1);
            $("#content-order").html(output)
        }

        output_status = `
        <option selected value="0">Tất cả</option>
        <option value="1">Đặt món</option>
        <option value="2">Chế biến</option>
        <option value="3">Lên món</option>
        <option value="4">Thanh toán</option>
        <option value="5">Hoàn tất</option>
        <option value="6">Hủy</option>`;
        $('#inputStatee').html(output_status);

        $('#start_date').html(`<label for="inputState">ngày bắt đầu</label>
                                <input type="date" id="ngaybatdau" value="" onchange="seach_order()">`);

        $('#end_date').html(`<label for="inputState"> ngày kết thúc</label>
                                <input type="date" id="ngayketthuc" value="" onchange="seach_order()">`)

    }

    function check_cacel() {
        flag = 0;
        var comment = $('#order_comment').val();
        if (comment == "") {
            $('#erorder_comment').html('Điền lý do hủy đơn hàng');
            flag = 1;
        } else {
            $('#erorder_comment').html('')
        }
        if (flag == 0)
            return true;
        return false;
    }
    $(document).ready(function() {
        show_order();
        $('#cancel_order_form').on('submit', function(event) {
            event.preventDefault();
            r = confirm('Bạn có chắc muốn hủy đơn này không');
            if (r == true) {
                if (check_cacel() == false) {

                } else {
                    $.ajax({
                        url: "../admin/order-order/" + $('#id_order').val(),
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token-cacel"]').attr('content')
                        },
                        data: $('#cancel_order_form').serialize(),
                        dataType: 'JSON',
                        success: function(data) {
                            if (data.status == 200) {
                                alert(data.message);
                                show_order();
                                $('#close_modol_cancle').click();
                            }
                        }
                    })
                }

            } else {

            }

        });
    });
    $(document).on("click", "a", function() {
        $(".clients-list a").css("color", "black");
        $(this).css("color", "red");
    });
