@extends('admin.dashboard')
@section('admin_content')
   <body>

    <div style="clear: both; height: 61px;"></div>
    <div class="wrapper wrapper-content animated fadeInRight">

         <div class="row">
            <div class="col-sm-12">
               <div class="inqbox">
                  <div class="inqbox-content">
                           <span class="text-muted small pull-right"><i class="fa fa-clock-o"></i></span>
                           <h2>Đơn vị sản phẩm</h2>
                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger">
                                 <li class="active"><a data-toggle="tab" href="#tab-category">Đơn vị</a></li>
                                 <li class="active"> <button type="button" name="x" id="x" data-toggle="modal" data-target="#add_unit_Modal" class="btn btn-warning">+</button></li>
                              </ul>
                              <div class="tab-content" >

                                 <div id="tab-category" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">
                                              <tr>
                                                <td>Tên đơn vị</td>
                                                <td>Ký hiệu đơn vị</td>
                                                <td></td>
                                              </tr>
                                             <tbody id="content-unit">

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
               <div class="inqbox ">
                  <div class="inqbox-content">
                     <div class="tab-content" id="detail-account">

                     </div>
                  </div>
               </div>
            </div>
         </div>

    </div>
    <meta name="csrf-token-delete-category" content="{{ csrf_token() }}" />
    <div id="add_unit_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Thêm đơn vị sản phẩm</h4>
          </div>
          <div class="modal-body">

           <form id="insert_unit_form">
            {{ csrf_field() }}

            <label>Tên đơn vị (<font style="color: red">*</font>)</label>
            <input type="text" name="unit_title" id="unit_title" class="form-control" />
            <small id="erunit_title" class="text-danger"></small>
            <br/>
            <br/>
            <label>Ký hiệu đơn vị (<font style="color: red">*</font>)</label>
            <input type="text" name="unit" id="unit" class="form-control" />
            <small id="erunit" class="text-danger"></small>
            <br/>
            <br/>
            <input type="submit" name="insert" id="insert_category" value="Thêm" class="btn btn-success" />

           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_insert" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>

       <meta name="csrf-token-delete-unit" content="{{ csrf_token() }}" />
       <div id="edit_unit_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Cập nhật đơn vị</h4>
          </div>
          <div class="modal-body">
            <meta name="csrf-token-disable-product" content="{{ csrf_token() }}" />

           <form id="edit_unit_form">
            {{ csrf_field() }}
            <input type="hidden" value="" id="id_unit" name="id_unit">
            <label>Tên đơn vị (<font style="color: red">*</font>)</label>
            <input type="text" name="unit_title" id="eunit_title" class="form-control" />
            <small id="eerunit_title" class="text-danger"></small>
            <br/>
            <br/>
            <label>Ký hiệu đơn vị (<font style="color: red">*</font>)</label>
            <input type="text" name="unit" id="eunit" class="form-control" />
            <small id="eerunit" class="text-danger"></small>
            <br/>
            <br/>
            <input type="submit" name="edit" id="edit_unit" value="Cập nhật" class="btn btn-success" />
           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_edit_unit" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>
    </body>
    <script src="{{ asset('backend/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_product_unit.js') }}"></script>
@endsection
