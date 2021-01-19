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
                           <h2>Danh mục sản phẩm</h2>
                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger">
                                 <li class="active"><a data-toggle="tab" href="#tab-category"><i class="fa fa-user"></i>Danh mục sản phẩm</a></li>
                                 <li class="active"> <button type="button" name="x" id="x" data-toggle="modal" data-target="#add_category_Modal" class="btn btn-warning">+</button></li>
                              </ul>
                              <div class="tab-content" >

                                 <div id="tab-category" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">
                                             <tbody id="content-category">

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
    <div id="add_category_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Thêm danh mục sản phẩm</h4>
          </div>
          <div class="modal-body">
           <form id="insert_category_form" enctype="multipart/form-data">
            {{ csrf_field() }}

            <label>Tên danh mục (<font style="color: red">*</font>)</label>
            <input type="text" name="category_title" id="category_title" class="form-control" />
            <small id="ercategory_title" class="text-danger"></small>
            <br/>
            <br/>
            <label><label>Icon danh mục (<font style="color: red">*</font>)</label>
                <input type="file" id="category_icon" onChange="return fileValidation()" name="select_file" class="form-control" multiple="multiple"  placeholder="Hình ảnh">

            </label>
            <small id="ercategory_icon" class="text-danger"></small>
            <br/>

                <span id="upload_ed_image"></span>
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


       <div id="edit_category_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Sửa danh mục</h4>
          </div>
          <div class="modal-body">
            <meta name="csrf-token-disable-product" content="{{ csrf_token() }}" />

           <form id="edit_category_form">
            {{ csrf_field() }}
            <input type="hidden" value="0" name="check_upload_image" id="check_upload_image">
            <input type="hidden" value="" id="id_category" name="id_category">
            <label>Tên danh mục (<font style="color: red">*</font>)</label>
            <input type="text" name="category_title" id="ecategory_title" class="form-control" />
            <small id="eercategory_title" class="text-danger"></small>
            <br/>
            <br/>
            <label><label>Icon danh mục (<font style="color: red">*</font>)</label>
                <input type="file" id="ecategory_icon" onChange="return fileValidation2()" name="select_file" class="form-control"  placeholder="Hình ảnh">
                <small id="eercategory_icon" class="text-danger"></small>
                </label>
            <br/>
                <span id="eupload_ed_image"></span>
            <br/>
            <br/>
            <input type="submit" name="edit" id="edit_category" value="Chỉnh sửa" class="btn btn-success" />
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
    <script src="{{ asset('backend/js/main/admin_product_category.js') }}"></script>
@endsection
