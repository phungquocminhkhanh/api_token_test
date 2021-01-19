 function numberWithCommas(x) {
     x = x.toString();
     var pattern = /(-?\d+)(\d{3})/;
     while (pattern.test(x))
         x = x.replace(pattern, "$1,$2");
     return x;
 }

 function show_customer() {
     output = '';
     $.ajax({
         url: "../admin/get-customer-customer",
         method: "post",
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token-customer-list"]').attr('content')
         },
         success: function(data) {
             $.each(data, function(k, v) {
                 output += `
                <tr>
                <td onclick="show_list_order_in_customer(${v.id})"><a data-toggle="tab" href="#contact-1" class="client-link">${v.customer_name}</a></td>
                <td onclick="show_list_order_in_customer(${v.id})">${v.customer_phone}</td>
                <td onclick="show_list_order_in_customer(${v.id})"> ${v.customer_point} điểm</td>
                <td class="client-status"><button onclick="edit_customer(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_customer_Modal" >Sửa</button>
                                        <button onclick="delete_customer(${v.id})" class="label label-primary" >Xóa</button>
                </td>
                </tr>
                `;
             });
             $("#content-customer").html(output)
         }
     });
 }

 function delete_customer(id) {
     var r = confirm('Bạn có chắc muốn xóa khách hàng này không')
     if (r == true) {
         $.ajax({
             url: "../admin/customer-customer/" + id,
             method: "delete",
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token-customer-delete"]').attr('content')
             },
             dataType: 'JSON',
             success: function(data) {
                 if (data.status == 200) {
                     alert(data.message);
                     show_customer();
                 }


             }
         });
     }
 }

 function show_list_order_in_customer(id) {
     output = '';
     $.ajax({
         url: "../admin/customer-customer-order",
         method: "post",
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token-customer-order"]').attr('content')
         },
         data: { id_customer: id },
         success: function(data) {
             console.log(data);
             outputdetail = ` <h4 style="color: darkred">${data.detail.customer_name}</h4>
            <h5>Mã: ${data.detail.customer_code}</h5>
            <h5>Email: ${data.detail.customer_email}</h5>
            <h5>Giới tính: `
             if (data.detail.customer_sex == 'male')
                 outputdetail += 'nam'
             else
                 outputdetail += 'nữ'

             outputdetail += `</h5>
            <h5>Cấp độ: ${data.detail.customer_level}</h5>
            <h5>Taxcode:`;
             if (data.detail.customer_taxcode != null)
                 outputdetail += ` ${data.detail.customer_taxcode}`;


             outputdetail += `</h5>`
             $("#content_detail_customer").html(outputdetail);
             output += `Đơn đặt hàng`;
             $.each(data.order, function(k, v) {
                 output += `
                <div class="panel-body pb5">
                <h4>Mã đơn hàng : ${v.order_code}</h4>
                <h4>Phone: ${v.customer_phone}</h4>
                <h4>Ngày: ${v.order_created}</h4>
                <h4>Tổng tiền: ${numberWithCommas(v.total_cost)} đ
                <a onclick="show_detail_order(${v.id})" class="label label-primary" data-toggle="modal" data-target="#detail_order_Modal" >chi tiết</a>

                </h4>
                <h4>-------------------------</h4>
             </div>
                `;

             });
             $("#content-order").html(output)


         }
     });
 }

 function show_detail_order(id) {
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
                  <td>Món</td>
                  <td>${v.order_created}</td>
                </tr>
                <tr>
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
                        <td style="color:Blue"><h3>Tổng tạm tính</h3></td>
                        <td style="color:#000000"><h3>${numberWithCommas(v.order_total_cost)} đ</h3></td>
                    </tr>

                    <tr>
                        <td style="color:Blue"><h3>Giảm trực tiếp</h3></td>
                        <td style="color:#000000"><h3>${numberWithCommas(v.order_direct_discount)} đ</h3></td>
                    </tr>
                    <tr style="color:Green">
                        <td><h2>Thành tiền</h2></td>
                        <td><h2>${numberWithCommas((v.order_total_cost)-Number(v.order_direct_discount))} đ</h2></td>
                    </tr>
                </table>`;
             });
             $('#content_order_detail').html(output);
             console.log(data.data);
         }
     });

 }

 function clear_data() {
     $('#customer_name').val("");
     $('#customer_phone').val("");
     $('#customer_address').val("");
     $('#customer_email').val("");
     $('#customer_birthday').val("");
     $('#customer_taxcode').val("");

 }

 function edit_customer(id) {
     $.ajax({
         url: "../admin/get-customer-customer",
         method: "post",
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token-customer-list"]').attr('content')
         },
         data: {
             id_customer: id
         },
         success: function(data) {
             $('#ecustomer_name').val(data[0].customer_name);
             $('#ecustomer_phone').val(data[0].customer_phone);
             $('#ecustomer_address').val(data[0].customer_address);
             $('#ecustomer_email').val(data[0].customer_email);

             $('#ecustomer_birthday').val(data[0].customer_birthday);

             if (data[0].customer_sex == 'male')
                 $("#ecustomer_sex_male").prop("checked", true);
             else
                 $("#ecustomer_sex_female").prop("checked", true);

             $('#ecustomer_taxcode').val(data[0].customer_taxcode);
             $('#id_customer').val(id);
         }
     });
 }

 function validateEmail(email) {
     const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     return re.test(email);
 }

 function KT_sodienthoai(sdt) {
     if (sdt.length < 10 || sdt.length > 10) {
         $('#ercustomer_phone').html('Số điện thoại gồm 10 số');
         return false;
     } else {
         $('#ercustomer_phone').html('');
         return true;
     }
 }

 function KT_sodienthoai2(sdt) {
     if (sdt.length < 10 || sdt.length > 10) {
         $('#eercustomer_phone').html('Số điện thoại gồm 10 số');
         return false;
     } else {
         $('#eercustomer_phone').html('');
         return true;
     }
 }

 function check_input() {
     var flag = 0;
     var name = $('#customer_name').val();
     var sdt = $('#customer_phone').val();
     var email = $('#customer_email').val();
     var address = $('#customer_address').val();
     if (name == '') {
         flag = 1;
         $('#ercustomer_name').html('Điền tên khách hàng')
     } else {
         $('#ercustomer_name').html('')
     }
     if (address == '') {
         flag = 1;
         $('#ercustomer_address').html('Điền địa chỉ khách hàng')
     } else {
         $('#ercustomer_address').html('')
     }

     if (validateEmail(email) || email == "") {
         $('#ercustomer_email').html('')

     } else {
         flag = 1;
         $('#ercustomer_email').html('Email không hợp lệ');
     }

     if (KT_sodienthoai(sdt) || sdt == "") {
         $('#ercustomer_phone').html('')
     } else {
         flag = 1;
         $('#ercustomer_phone').html('Số điện thoại phải là 10 số');
     }
     if (flag == 0)
         return true;
     return false;

 }

 function check_edit() {
     const start = Date.now();
     var flag = 0;
     var name = $('#ecustomer_name').val();
     var sdt = $('#ecustomer_phone').val();
     var address = $('#ecustomer_address').val();
     var birthday = Date.parse($('#ecustomer_birthday').val());
     var email = $('#ecustomer_email').val();
     var tax = $('#ecustomer_taxcode').val();

     if (name == '') {
         flag = 1;
         $('#eercustomer_name').html('Điền tên khách hàng')
     } else {
         $('#eercustomer_name').html('')
     }
     if (address == '') {
         flag = 1;
         $('#eercustomer_address').html('Điền địa chỉ khách hàng')
     } else {
         $('#eercustomer_address').html('')
     }

     if (validateEmail(email) || email == "") {
         $('#eercustomer_email').html('')

     } else {
         flag = 1;
         $('#eercustomer_email').html('Email không hợp lệ');
     }

     if (birthday >= start) {
         flag = 1;
         $('#eercustomer_birthday').html('Ngày tháng năm sinh không hợp lệ');
     } else {
         $('#eercustomer_birthday').html('')
     }

     if (KT_sodienthoai2(sdt) || sdt == "") {
         $('#eercustomer_phone').html('')
     } else {
         flag = 1;
         $('#eercustomer_phone').html('Số điện thoại phải là 10 số');
     }
     if (flag == 0)
         return true;
     return false;
 }

 function seach_customer(k) {
     $.ajax({
         url: "../admin/customer-seach",
         method: "POST",
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token-seach"]').attr('content')
         },
         data: { key_seach: k }, // chuyen vao bien name vs du lieu cua input do
         dataType: "json",
         success: function(response) {
             let output = "";
             $.each(response.data, function(k, v) {
                 output += `
                <tr>
                <td onclick="show_list_order_in_customer(${v.id})"<a data-toggle="tab" href="#contact-1" class="client-link">${v.customer_name}</a></td>
                <td onclick="show_list_order_in_customer(${v.id})">${v.customer_phone}</td>
                <td onclick="show_list_order_in_customer(${v.id})">${v.customer_point}</td>
                <td class="client-status"><button onclick="edit_customer(${v.id})" class="label label-primary" data-toggle="modal" data-target="#edit_customer_Modal" >Sửa</button>
                <button onclick="delete_customer(${v.id})" class="label label-primary">Xóa</button>
                </td>

                </tr>
                `;
             });
             $("#content-customer").html(output)

         }
     });
 }
 $(document).ready(function() {
     show_customer();
     $('#insert_customer_form').on("submit", function(event) {
         event.preventDefault();
         if (check_input() == false) {

         } else {
             $.ajax({
                 url: "../admin/customer-customer",
                 method: "post",
                 data: $('#insert_customer_form').serialize(),
                 success: function(data) {
                     if (data.status == 200) {
                         show_customer();
                         alert(data.message);
                         $('#close_modol_insert').click();
                     } else {
                         alert(data.message);
                     }
                 }
             });
         }


     });

     $('#edit_customer_form').on("submit", function(event) {
         event.preventDefault();
         if (check_edit() == false) {

         } else {
             $.ajax({
                 url: "../admin/customer-customer/" + $('#id_customer').val(),
                 method: "put",
                 data: $('#edit_customer_form').serialize(),
                 success: function(data) {
                     if (data.status == 200) {
                         show_customer();
                         alert(data.message);
                         $('#close_modol_edit').click();
                     } else {
                         alert(data.message);
                     }
                 }
             });
         }


     });



 });
