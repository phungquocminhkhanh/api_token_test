@extends('admin.dashboard')
@section('admin_content')
   <body>
    {{-- <?php $idbussin = Auth::user()->id_business;
    ?> --}}
    <div style="clear: both; height: 61px;"></div>
    <div class="wrapper wrapper-content animated fadeInRight">

         <div class="row">
            <div class="col-sm-8">
               <div class="inqbox">
                  <div class="inqbox-content">
                           <span class="text-muted small pull-right"><i class="fa fa-clock-o"></i></span>
                           <h2>Nhân viên</h2>

                           <div class="clients-list">
                              <ul class="nav nav-tabs tab-border-top-danger">
                                 <li class="active"><a data-toggle="tab" href="#tab-account"><i class="fa fa-user"></i>Tài khoản</a></li>
                                 <li class="active"> <button type="button" onclick="clear_data()" name="x" id="x" data-toggle="modal" data-target="#add_account_Modal" class="btn btn-warning">+</button></li>
                              </ul>
                              <div class="tab-content" >

                                 <div id="tab-account" class="tab-pane active" >
                                    <div class="full-height-scroll">
                                       <div class="table-responsive">
                                          <table class="table table-striped table-hover">

                                            <tr onclick="show_detail_account(${v.id})">
                                                <td>Tên</td>
                                                <td>Loại tài khoản</td>
                                                <td>Số điện thoại</td>
                                                <td>Trạng thái</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tbody id="content-account">

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
    <meta name="csrf-token-get-permission" content="{{ csrf_token() }}" />
    <meta name="csrf-token-disable-account" content="{{ csrf_token() }}" />
    <meta name="csrf-token-detail" content="{{ csrf_token() }}" />
        <div id="add_account_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Thêm Nhân Viên</h4>
              </div>
              <div class="modal-body">
                <meta name="csrf-token-insert" content="{{ csrf_token() }}" />
               <form method="post" id="insert_account_form">
                <input type="hidden" name="id_business" id="" value="{{Auth::user()->id_business}}">
                <label>Username (<font style="color: red">*</font>)</label>
                <input type="text" name="account_username" id="username" class="form-control" />
                <small id="erusername" class="text-danger"></small>
                <br />
                <br />
                <label>Password (<font style="color: red">*</font>)</label>

                <div class="input-group" id="show_hide_password_insert">
                    <input class="form-control" type="password" name="account_password" id="password" onkeyup="passwordChanged()">

                    <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    </div>
                <small id="erpassword" class="text-danger"></small>
                <br />
                <br />
                <label>Họ và tên đầy đủ (<font style="color: red">*</font>)</label>
                <input type="text" name="account_fullname" id="fullname" class="form-control" />
                <small id="erfullname" class="text-danger"></small>
                <br />
                <br />
                <label>Email</label>
                <input type="text" name="account_email" id="email" class="form-control" />
                <small id="eremail" class="text-danger"></small>
                <br />
                <br />
                <label>Số điện thoại</label>
                <input type="tel" id="phone" name="account_phone" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup="KT_sodienthoai(this.value)" maxlength="10" class="form-control">
                <small id="ersdt" class="text-danger"></small>
                <br />
                <label>Loại nhân viên (<font style="color: red">*</font>)</label>
                <select id="type_account" name="id_type">

                </select>
                <br />
                <input type="submit" name="insert" id="insert_account" value="Thêm" class="btn btn-success" />
               </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_insert" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>


           <div id="edit_account_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Nhân Viên</h4>
              </div>
              <div class="modal-body">
                <meta name="csrf-token-edit" content="{{ csrf_token() }}" />
               <form id="edit_account_form">
                <label>Username (<font style="color: red">*</font>)</label>
                <input type="text" name="account_username" id="eusername" class="form-control" />
                <small id="eerusername" class="text-danger"></small>
                <br />
                <br />
                <label>Họ và tên đầy đủ (<font style="color: red">*</font>)</label>
                <input type="text" name="account_fullname" id="efullname" class="form-control" />
                <small id="eerfullname" class="text-danger"></small>
                <br />
                <br />

                <label>Email</label>
                <input type="text" name="account_email" id="eemail" class="form-control" />
                <br />
                <label>Số điện thoại</label>
                <input type="tel" id="ephone" name="account_phone" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup="KT_esodienthoai(this.value)" maxlength="10" class="form-control">
                <small id="eersdt" class="text-danger"></small>
                <br />
                <br />

                <label>Loại nhân viên (<font style="color: red">*</font>)</label>
                <select id="etype_account" name="id_type">

                </select>
                <br />
                <input id="id_edit_account" value="" type="hidden">
                <input type="submit" name="edit" id="edit_account" value="Cập nhật" class="btn btn-success" />
               </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_edit" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>


           <div id="author_account_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Phân quyền nhân viên</h4>
              </div>
              <div class="modal-body">

                <form id="author_account_form">
                <meta name="csrf-token-author" content="{{ csrf_token() }}" />
                <div class="inqbox-content">
                    <table class="table table-striped">
                       <thead>
                          <tr>
                             <th></th>
                             <th></th>
                          </tr>
                       </thead>
                       <tbody id="account_permission">
                       </tbody>
                    </table>
                 </div>
                 <input id="id_author_account" value="" type="hidden">
                <br />
                <input type="submit" name="edit" id="btn_author_account" value="Cập nhật" class="btn btn-success" />
                {{-- <button type="button" id="btn-author_account" class="btn btn-success">Phân quyền</button> --}}
                </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_author" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>


           <div id="change_password_account_Modal" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Đổi lại mật khẩu</h4>
              </div>
              <div class="modal-body">

                <form id="change_password_account_form">
                <meta name="csrf-token-change-password" content="{{ csrf_token() }}" />
                <div class="inqbox-content">

                <label>Mật khẩu mới</label>
                    <div class="input-group" id="show_hide_password4">
                    <input class="form-control" type="password" name="account_password" id="epassword_change" onkeyup="passwordChanged2()">
                    <br />
                    <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    </div>
                    <small id="cerpassword" class="text-danger"></small>
                    <br />
                    <br />
                <label>Nhập lại mật khẩu</label>
                    <div class="input-group" id="show_hide_password5">
                    <input class="form-control" type="password" name="account_password" id="epassword_change2">

                    <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                    </div>
                    <small id="cerpassword2" class="text-danger"></small>
                    <br />
                    <br />
                <input type="submit" name="edit" id="btn_change_password_account" value="Cập nhật" class="btn btn-success" />
                </form>
              </div>
              <div class="modal-footer">
               <button type="button" id="close_modol_changge_password" class="btn btn-default" data-dismiss="modal">Đóng</button>
              </div>
             </div>
            </div>
           </div>

           <div class="modal" id="alert_change_pass" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="background-color: darkgray">
              <div class="modal-content">
                </div>
                <div class="modal-body" id="content_alert">

                </div>
                <div class="modal-footer">
                  <button type="button" id="ok_alert" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
          </div>

    </body>
    <script src="{{ asset('backend/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/main/admin_account.js') }}"></script>
@endsection
