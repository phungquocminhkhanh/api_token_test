@extends('admin.dashboard')
@section('admin_content')
   <body>
    <div style="clear: both; height: 61px;"></div>
    <div class="wrapper wrapper-content animated fadeInRight">

         <div class="row">
            <div class="col-sm-8">
               <div class="inqbox">
                  <div class="inqbox-content">
                           <span class="text-muted small pull-right"><i class="fa fa-clock-o"></i> </span>
                           <h2>Cấp độ khách hàng</h2>

                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger">
                                 <li class="active"><a data-toggle="tab"><i class="fa fa-user"></i> Khách hàng</a></li>
                                 <li class="active"> <button type="button" onclick="clear_data()" name="x" id="x" data-toggle="modal" data-target="#add_level_Modal" class="btn btn-warning">+</button></li>
                              </ul>
                              <div class="tab-content" >

                                 <div id="tab-account" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">
                                            <tr>
                                                <td>Cấp độ</td>
                                                <td>Điểm tích lũy</td>
                                                <td>% giảm giá</td>
                                                <td></td>
                                                <td>Ghi chú</td>
                                                <td class="client-status"></td>
                                            </tr>
                                             <tbody id="content-level">

                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="inqbox">
                  <div class="inqbox-content">Danh sách khách hàng
                      <h5 id="total_cus"></h5>

                     <div class="tab-content" id="detail-level">

                     </div>

                  </div>
               </div>
            </div>
         </div>

    </div>
    <meta name="csrf-token-point-delete" content="{{ csrf_token() }}" />
    <meta name="csrf-token-point-customer" content="{{ csrf_token() }}" />
        <div id="add_level_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Thêm cấp độ khách hàng</h4>
              </div>
              <div class="modal-body">

               <form id="insert_level_form">
                {{ csrf_field() }}

                <label>Tên cấp độ (<font style="color: red">*</font>)</label>
                <input type="text" name="customer_level" id="customer_level" class="form-control" />
                <small id="ercustomer_level" class="text-danger"></small>
                <br />
                <br />
                <label>Điểm tích lũy (<font style="color: red">*</font>)</label>
                <input type="number" name="customer_point" id="customer_point" class="form-control" />
                <small id="ercustomer_point" class="text-danger"></small>
                <br />
                <br />
                <label>% giảm giá (<font style="color: red">*</font>)</label>
                <input type="number" name="customer_discount" id="customer_discount" class="form-control" />
                <small id="ercustomer_discount" class="text-danger"></small>
                <br />
                <br />
                <label>Ghi chú (<font style="color: red">*</font>)</label>
                <textarea  name="customer_description" id="customer_description" class="form-control"></textarea>
                <small id="ercustomer_description" class="text-danger"></small>
                <br />
                <br />
                <input type="submit" name="insert" id="insert_level" value="Thêm" class="btn btn-success" />
               </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_insert" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>

           <div id="edit_level_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Cập nhật</h4>
              </div>
              <div class="modal-body">

               <form id="edit_level_form">
                {{ csrf_field() }}
                <input type="hidden" id="id_point" value=""/>
                <label>Tên cấp độ (<font style="color: red">*</font>)</label>
                <input type="text" name="customer_level" id="ecustomer_level" class="form-control" />
                <small id="eercustomer_level" class="text-danger"></small>
                <br />
                <br />
                <label>Điểm tích lũy (<font style="color: red">*</font>)</label>
                <input type="number" name="customer_point" id="ecustomer_point" class="form-control" />
                <small id="eercustomer_point" class="text-danger"></small>
                <br />
                <br />
                <label>% giảm giá (<font style="color: red">*</font>)</label>
                <input type="number" name="customer_discount" id="ecustomer_discount" class="form-control" />
                <small id="eercustomer_discount" class="text-danger"></small>
                <br />
                <br />
                <label>Ghi chú (<font style="color: red">*</font>)</label>
                <textarea  name="customer_description" id="ecustomer_description" class="form-control"></textarea>
                <small id="eercustomer_description" class="text-danger"></small>
                <br />
                <br />
                <input type="submit" name="insert" id="edit_level" value="Cập nhật" class="btn btn-success" />
               </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_edit" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>





    </body>
    <script src="{{ asset('backend/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_local.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_customer_level.js') }}"></script>
@endsection
