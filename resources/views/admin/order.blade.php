@extends('admin.dashboard')
@section('admin_content')
   <body>
    {{-- <?php $idbussin = Auth::user()->id_business;
    ?> --}}
    <div style="clear: both; height: 61px;"></div>
    <div class="wrapper wrapper-content animated fadeInRight">

         <meta name="csrf-token-detail-order" content="{{ csrf_token() }}" />
         <meta name="csrf-token-show-order" content="{{ csrf_token() }}" />
        <meta name="csrf-token-show-order-type" content="{{ csrf_token() }}" />
        <meta name="csrf-token-product-detail" content="{{ csrf_token() }}" />
         <div class="row">
            <div class="col-sm-8">
               <div class="inqbox">
                  <div class="inqbox-content">
                           <span class="text-muted small pull-right"><i class="fa fa-clock-o"></i></span>
                           <h2>Đơn hàng</h2>

                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger">
                                <li class="active"><a onclick="show_order_type('all')">All</a></li>
                                <li class="active"><a onclick="show_order_type('eat-in')">Tại bàn</a></li>
                                <li class="active"><a onclick="show_order_type('carry-out')">Mang đi</a></li>

                                <div class="form-group col-md-4">
                                    <label for="inputState">Trạng thái</label>
                                    <select id="inputStatee" class="form-control" onchange="seach_order()">
                                        <option selected value="0">Tất cả</option>
                                        <option value="1">Đặt món</option>
                                        <option value="2">Chế biến</option>
                                        <option value="3">Lên món</option>
                                        <option value="4">Thanh toán</option>
                                        <option value="5">Hoàn tất</option>
                                        <option value="6">Hủy</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-4" id="start_date">
                                    <label for="inputState">ngày bắt đầu</label>
                                    <input type="date" id="ngaybatdau" onchange="seach_order()">

                                  </div>

                                  <div class="form-group col-md-4" id="end_date">
                                    <label for="inputState"> ngày kết thúc</label>
                                    <input type="date" id="ngayketthuc" onchange="seach_order()">
                                  </div>
                              </ul>





                              <div class="tab-content" >

                                 <div id="tab-account" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">
                                            <td>STT</td>
                                            <td>Mã đơn</td>
                                            <td>Tổng tiền</td>
                                            <td>Trạng thái</td>
                                            <td>Ngày lập</td>
                                            <td></td>
                                             <tbody id="content-order">

                                             </tbody>
                                          </table>
                                          <nav aria-label="Page navigation example">
                                            <ul class="pagination" id="content_phantrang">
                                              <li class="page-item"><a class="page-link" onclick="back_phantrang()" ><<</a></li>
                                              <li class="page-item"><a class="page-link" onclick="phantrang(1)" href="#">1</a></li>
                                              <li class="page-item"><a class="page-link" onclick="phantrang(2)" href="#">2</a></li>
                                              <li class="page-item"><a class="page-link" onclick="phantrang(3)" href="#">3</a></li>
                                              <li class="page-item"><a class="page-link" onclick="phantrang(4)" href="#">4</a></li>
                                              <li class="page-item"><a class="page-link" onclick="phantrang(5)" href="#">5</a></li>
                                              <li class="page-item"><a class="page-link" onclick="next_phantrang()" id="next_trang" >>></a></li>
                                            </ul>
                                          </nav>

                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                  </div>
               </div>

            </div>
            <meta name="csrf-token-cancel-order" content="{{ csrf_token() }}" />
            <div class="col-sm-4">
               <div class="inqbox ">
                  <div class="inqbox-content">
                     <div class="tab-content" id="content_order_detail">

                     </div>
                  </div>
               </div>
            </div>
         </div>
    </div>
    <meta name="csrf-token-cacel" content="{{ csrf_token() }}" />
    <div id="cancle_order_modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
           <form id="cancel_order_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>Lý do hủy đơn hàng</label>
            <input type="hidden" value="" name="id_order" id="id_order">
            <textarea type="text" name="order_comment" id="order_comment" class="form-control" ></textarea>
            <small id="erorder_comment" class="text-danger"></small>
            <br />
            <br/>
            <input type="submit" name="insert" id="insert_floor" value="Hủy" class="btn btn-success" />
           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_cancle" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>
    </body>
    <script src="{{ asset('backend/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_order.js') }}"></script>
@endsection
