@extends('admin.dashboard')
@section('admin_content')

   <body>

    <div style="clear: both; height: 61px;"></div>
    <div class="wrapper wrapper-content animated fadeInRight">


         <div class="row">
            <div class="col-sm-8">
               <div class="inqbox">
                  <div class="inqbox-content">
                           <span class="text-muted small pull-right"><i class="fa fa-clock-o"></i></span>
                           <h2>Sản phẩm</h2>
                           <div class="input-group">
                              <input type="text" id="seach_auto" placeholder="Nhập tên, mã sản phẩm hoặc giá sản phẩm" class="input form-control">
                              <span class="input-group-btn">
                              <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i>Tìm kiếm</button>
                              <input type="hidden" value="" id="category_seach_product">
                            </span>

                                <select id="inputStatee" class="form-control" onchange="show_product_disable(this.value)">
                                    <option value="N">Đang bán</option>
                                    <option value="Y">Ngừng bán</option>
                                </select>

                           </div>

                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger" id="content_category">


                              </ul>
                              <div class="tab-content" >

                                 <div id="tab-category" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">
                                             <tbody id="content-product">

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
                     <div class="tab-content" id="detail-product">

                     </div>
                  </div>
               </div>
            </div>
         </div>

    </div>
    <meta name="csrf-token-delete-product" content="{{ csrf_token() }}" />
    <meta name="csrf-token-disable-product" content="{{ csrf_token() }}" />
    <meta name="csrf-token-delete-extra" content="{{ csrf_token() }}" />
    <meta name="csrf-token-product-detail" content="{{ csrf_token() }}" />
    <meta name="csrf-token-product-seach" content="{{ csrf_token() }}" />
    <meta name="csrf-token-product-seach-disable" content="{{ csrf_token() }}" />
    <meta name="csrf-token-seach-auto" content="{{ csrf_token() }}" />
    <div id="add_product_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Thêm sản phẩm
          </div>
          <div class="modal-body">

            <meta name="csrf-token-category" content="{{ csrf_token() }}" />
           <form id="insert_product_form" enctype="multipart/form-data">
            {{ csrf_field() }}

            <label>Tên sản phẩm (<font style="color: red">*</font>)</label>
            <input type="text" name="product_title" id="product_title" class="form-control" />
            <small id="erproduct_title" class="text-danger"></small>
            <br/>
            <br/>
            <label>Danh mục (<font style="color: red">*</font>)</label>
            <select name="id_category" id="id_category">
                <option value=""></option>
            </select>
            <br/>
            <br/>
            <label>Giá (<font style="color: red">*</font>)</label>
            <input type="text" name="product_sales_price" id="product_sales_price" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" />
            <small id="erproduct_sales_price" class="text-danger"></small>
            <br/>
            <br/>
            <label>Mô tả (<font style="color: red">*</font>)</label>
            <textarea name="product_description" id="product_description" class="form-control"></textarea>
            <small id="erproduct_description" class="text-danger"></small>
            <br/>
            <br/>
            <br/>
            <label>Mã sản phẩm (<font style="color: red">*</font>)</label>
            <input type="text" name="product_code" id="product_code" class="form-control" />
            <small id="erproduct_code" class="text-danger"></small>
            <br/>
            <br/>
            <label>Đơn vị tính (<font style="color: red">*</font>)</label>
            <select name="id_unit" id="id_unit">

            </select>

            <br/>

            <br/>
            <label>Điểm tích lũy (<font style="color: red">*</font>)</label>
            <input type="text" name="product_point" id="product_point" class="form-control" />
            <small id="erproduct_point" class="text-danger"></small>
            <br/>
            <br/>
            <label><label>Hình ảnh (<font style="color: red">*</font>)</label>
                <input type="file" id="product_img" onChange="return fileValidation()" name="select_file" class="form-control" multiple="multiple"  placeholder="Hình ảnh">
            </label>
            <br/>
            <span id="upload_ed_image"></span>
            <br/>
            <br/>
            <input type="submit" name="insert" id="insert_product" value="Thêm" class="btn btn-success" />
           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_insert" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>




       <div id="edit_product_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Cập nhật sản phẩm</h4>
          </div>
          <div class="modal-body">

           <form id="edit_product_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="0" name="check_upload_image" id="check_upload_image">
            <input type="hidden" value="" id="id_product" name="id_product">
            <label>Tên sản phẩm (<font style="color: red">*</font>)</label>
            <input type="text" name="product_title" id="eproduct_title" class="form-control" />
            <small id="eerproduct_title" class="text-danger"></small>
            <br/>
            <br/>
            <label>Danh mục (<font style="color: red">*</font>)</label>
            <select name="id_category" id="eid_category">
                <option value=""></option>
            </select>
            <br/>
            <br/>
            <label>Giá (<font style="color: red">*</font>)</label>
            <input type="text" name="product_sales_price" id="eproduct_sales_price" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" />
            <small id="eerproduct_sales_price" class="text-danger"></small>
            <br/>
            <br/>
            <label>Mô tả</label>
            <textarea name="product_description" id="eproduct_description" class="form-control"></textarea>
            <small id="eerproduct_description" class="text-danger"></small>
            <br/>
            <br/>
            <label>Mã sản phẩm (<font style="color: red">*</font>)</label>
            <input type="text" name="product_code" id="eproduct_code" class="form-control" />
            <small id="eerproduct_code" class="text-danger"></small>
            <br/>
            <br/>
            <label>Đơn vị tính (<font style="color: red">*</font>)</label>
            <select name="id_unit" id="eid_unit">

            </select>

            <br/>

            <br/>
            <label>Điểm tích lũy</label>
            <input type="text" name="product_point" id="eproduct_point" class="form-control" />
            <small id="eerproduct_point" class="text-danger"></small>
            <br/>
            <br/>
            <label><label>Hình ảnh (<font style="color: red">*</font>)</label>
                <input type="file" id="eproduct_img" onChange="return fileValidation2()" name="select_file" class="form-control" multiple="multiple"  placeholder="Hình ảnh">
            </label>
            <br/>
            <span id="eupload_ed_image"></span>
            <br/>
            <br/>
            <input type="submit" name="insert" id="edit_product" value="Cập nhật" class="btn btn-success" />
           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_edit" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>








       <div id="add_product_extra_Modal" class="modal fade">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Thêm món ăn kèm</h4>
          </div>
          <div class="modal-body">

            <meta name="csrf-token-extra" content="{{ csrf_token() }}" />
           <form id="insert_product_extra_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>Món ăn kèm</label>
            <select id="list_extra">
            </select>
            <div id="extra_content"></div>
            <br/>
            <input type="submit" name="insert" id="insert_product_extra" value="Thêm" class="btn btn-success" />
           </form>
          </div>
          <div class="modal-footer">
           <button type="button" id="close_modol_insert_extra" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
         </div>
        </div>
       </div>
    </body>
    <script src="{{ asset('backend/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_product_product.js') }}"></script>
@endsection
