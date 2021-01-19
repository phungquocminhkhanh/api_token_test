<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CÔNG TY CỔ PHẦN INFORMATICS QTC</title>
        <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/fonts/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
        <!-- Toastr style -->
        <link href="{{ asset('backend/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
        <!-- Gritter -->
        <link href="{{ asset('backend/js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">
        <!-- morris -->
        <link href="{{ asset('backend/css/plugins/morris/morris-0.4.3.min.css')}}" rel="stylesheet">
        <link href="{{ asset('backend/css/animate.css')}}" rel="stylesheet">
        <link href="{{ asset('backend/css/style.css')}}" rel="stylesheet">
        <link href="{{ asset('backend/css/forms/kforms.css')}}" rel="stylesheet">

    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side fixed-menu" role="navigation">
                <div class="sidebar-collapse">
                    <div id="hover-menu"></div>
                    <ul class="nav metismenu" id="side-menu">
                        <li>
                            <div class="logopanel" style="margin-left: 0px; z-index: 99999">
                                <div class="profile-element">
                                    <h2><a href="{{ URL::to('/dashboard') }}">QTC ADMIN</a></h2>
                                </div>
                                <div class="logo-element">

                                </div>
                            </div>
                        </li>

                        <li>
                            <!-- START : Left sidebar -->
                            <div class="nano left-sidebar">
                                <div class="nano-content">
                                    <ul class="nav nav-pills nav-stacked nav-inq" id="list_manage">


                                        <li class="active">
                                            <a href="{{ URL::to('/dashboard') }}"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
                                        </li>
                                    @foreach ($permission as $k=>$v)

                                        @if($v->permission=="module_employee")
                                        <li class="nav-parent">

                                            <a href="#"><img src="{{asset('/images/2.png')}}" width="25px" height="25px">&nbsp;&nbsp;<span class="nav-label">Quản lý Tài Khoản</span></a>
                                            <ul class="children nav">
                                                <li><a href="{{ URL::to('admin/manage-account') }}">Danh sách Tài khoản</a></li>
                                            </ul>
                                        </li>
                                        @elseif ($v->permission=="module_product")
                                        <li class="nav-parent">

                                            <a href="#"><img src="{{asset('images/5.png')}}"  width="25px" height="25px">&nbsp;&nbsp;<span class="nav-label">Quản lý sản phẩm</span></a>
                                            <ul class="children nav">
                                                <li><a href="{{ URL::to('admin/manage-product-category') }}">Danh mục sản phẩm</a></li>
                                                <li><a href="{{ URL::to('admin/manage-product-product') }}">Danh sách sản phẩm</a></li>
                                                <li><a href="{{ URL::to('admin/manage-product-unit') }}">Đơn vị sản phẩm</a></li>
                                            </ul>
                                        </li>
                                        @elseif ($v->permission=="module_floor")
                                        <li class="nav-parent">
                                            <a href="#"><img src="{{asset('/images/4.png')}}"  width="25px" height="25px">&nbsp;&nbsp;<span class="nav-label">Quản lý các tầng</span></a>
                                            <ul class="children nav">
                                                <li><a href="{{ URL::to('admin/manage-floor-table') }}">Danh sách tầng</a></li>
                                            </ul>
                                        </li>

                                        @elseif ($v->permission=="module_customer")
                                        <li class="nav-parent">
                                            <a href="#"><img src="{{asset('/images/3.png')}}"  width="25px" height="25px">&nbsp;&nbsp;<span class="nav-label">Quản lý khách hàng</span></a>
                                            <ul class="children nav">
                                                <li><a href="{{ URL::to('admin/manage-customer') }}">Danh sách khách hàng</a></li>
                                                <li><a href="{{ URL::to('admin/manage-customer-level') }}">Cấp độ khách hàng</a></li>


                                            </ul>
                                        </li>
                                        @elseif ($v->permission=="module_force")

                                        @elseif ($v->permission=="module_setting")

                                        @else($v->permission=="module_order")
                                        <li class="nav-parent">
                                            <a href="#"><img src="{{asset('/images/1.png')}}"  width="25px" height="25px">&nbsp;&nbsp;<span class="nav-label">Quản lý đơn hàng</span></a>
                                            <ul class="children nav">
                                                <li><a href="{{ URL::to('admin/manage-order') }}">Danh sách đơn hàng</a></li>

                                            </ul>
                                        </li>
                                        @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <!-- END : Left sidebar -->
                        </li>
                    </ul>
                </div>
            </nav>

            <meta name="csrf-token-force-sign" content="{{ csrf_token() }}" />
            <div id="change_password_dashboard_account_Modal" class="modal fade">
                <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Đổi lại mật khẩu</h4>
                  </div>
                  <div class="modal-body">

                    <form id="change_password_dashboard_account_form">
                    <meta name="csrf-token-change-password-dashboard" content="{{ csrf_token() }}" />
                    <div class="inqbox-content">
                        <label>Mật khẩu cũ</label>
                            <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" name="old_password" id="old_password">

                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            </div>
                            <small id="erold_password" class="text-danger"></small><br /><br />

                             <label>Mật khẩu mới</label>
                            <div class="input-group" id="show_hide_password2">
                            <input class="form-control" type="password" name="account_password" id="dashpassword_change">
                            <br />
                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            </div>
                            <small id="dasherpassword" class="text-danger"></small>
                            <br />
                            <br />
                        <label>Nhập lại mật khẩu</label>
                            <div class="input-group" id="show_hide_password3">
                            <input class="form-control" type="password" name="account_password" id="dashpassword_change2">

                            <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            </div>
                            <small id="dasherpassword2" class="text-danger"></small>
                            <br />
                            <br />
                    <input type="submit" name="edit" id="btn_change_password_dashboard_account" value="Cập nhật" class="btn btn-success" />
                    </form>
                  </div>
                  <div class="modal-footer">
                   <button type="button" id="close_modol_changge_password_dashboard" class="btn btn-default" data-dismiss="modal">Đóng</button>
                  </div>
                 </div>
                </div>
               </div>



            <div class="modal" id="alert_change_pass_dashboard" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="background-color: #87CEEB">
                  <div class="modal-content">
                    </div>
                    <div class="modal-body" id="content_alert_das">

                    </div>
                    <div class="modal-footer">
                      <button type="button" id="ok_alert_das" class="btn btn-secondary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal" id="logout-dasboard" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="background-color: #87CEEB">
                  <div class="modal-content">
                    </div>
                    <div class="modal-body" id="content_alert_das">
                       <h3> Bạn có muốn đăng xuất không</h3>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ URL::to('/page/logout') }}" method="get">
                            <button type="submid" class="btn btn-secondary">Yes</button>
                            <button type="button"class="btn btn-secondary" data-dismiss="modal">No</button>
                        </form>


                    </div>
                  </div>
                </div>
              </div>


              <div class="modal" id="force-sign-out-dasboard" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="background-color: #A9A9A9">
                  <div class="modal-content">
                    </div>
                    <div class="modal-body">
                       <img src="{{ asset('images/force_sign_out.png') }}" alt="" width="100%">
                    </div>

                        <button type="submid" class="btn btn-secondary" style="margin-left: 30%" data-toggle="modal" data-target="#force-manage">Thoát quản lý</button>
                        <button type="button"class="btn btn-secondary" data-toggle="modal" data-target="#force-employ">Thoát nhân viên</button>


                  </div>
                </div>
              </div>
              <div class="modal" id="force-manage" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="background-color: #87CEEB">
                  <div class="modal-content">
                    </div>
                    <div class="modal-body" id="content_alert_das">
                       <h3>Bạn có muốn cưỡng chế hết tài khoản quản lý trong ứng dụng này không</h3>
                    </div>
                    <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" onclick="force_sign('account')">Yes</button>
                            <button type="button"class="btn btn-secondary" id="close_force_manage" data-dismiss="modal">No</button>



                    </div>
                  </div>
                </div>
              </div>
              <div class="modal" id="force-employ" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="background-color: #87CEEB">
                  <div class="modal-content">
                    </div>
                    <div class="modal-body" id="content_alert_das">
                       <h3>Bạn có muốn cưỡng chế hết tài khoản nhân viên trong ứng dụng này không</h3>
                    </div>
                    <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" onclick="force_sign('employ')">Yes</button>
                            <button type="button"class="btn btn-secondary" id="close_force_employ" data-dismiss="modal">No</button>



                    </div>
                  </div>
                </div>
              </div>

              <meta name="csrf-token-get-permission-das" content="{{ csrf_token() }}" />

            <div id="page-wrapper" class="gray-bg">
                <!-- BEGIN HEADER -->
                <div id="header">
                    <nav class="navbar navbar-fixed-top white-bg show-menu-full" id="nav" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">

                            <form role="search" class="navbar-form-custom">
                                <div class="form-group">
                                    <div class="kform inq">
                                        <div>
                                            <label class="field append-icon">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown hidden-xs">

                                <ul class="dropdown-menu dropdown-messages">
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="mailbox.html" class="animated animated-short fadeInUp">
                                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown hidden-xs">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">

                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <li>
                                        <a href="mailbox.html" class="animated animated-short fadeInUp">
                                            <div>
                                                <i class="fa fa-envelope fa-fw"></i>
                                                <span class="pull-right text-muted small"></span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="dropdown pull-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <span class="pl15"><img src="{{ asset('images/iconuser.png') }}" height="20px" width="30px" alt=""><?php $ten = Auth::user()->account_username;if($ten) echo $ten; ?></span>
                                    <span class="caret caret-tp"></span>
                                    <input type="hidden" id="id_bu" value="{{ Auth::user()->id_business }}">
                                    <input type="hidden" id="id_ac" value="{{ Auth::user()->id }}">
                                </a>
                                <ul class="dropdown-menu animated m-t-xs">
                                    <li><a  class="animated animated-short fadeInUp" onclick="clear_data_pass()" data-toggle="modal" data-target="#change_password_dashboard_account_Modal">Đổi mật khẩu</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" class="animated animated-short fadeInUp" data-toggle="modal" data-target="#logout-dasboard"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                                    @foreach ($permission as $k=>$v)
                                    @if($v->permission=="module_force")
                                        <input type="hidden" id="xxxxx" value="xx11xx">
                                        <li><a href="#" class="animated animated-short fadeInUp" data-toggle="modal" data-target="#force-sign-out-dasboard"><i class="fa fa-sign-out"></i>Cưỡng chế đăng xuất</a></li>
                                    @endif
                                    @endforeach

                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>





                @yield('admin_content')




                <div class="footer">
               <div class="pull-right">
                  <strong></strong>
               </div>
               <div>
                  <strong></strong>  &copy;
               </div>
            </div>



            </div>
            <!-- Mainly scripts -->
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="{{ asset('backend/js/laravel_echo.js') }}"></script>
<script src="{{ asset('backend/js/socket.js') }}"></script>

            <script src="{{ asset('backend/js/jquery-2.1.1.js')}}"></script>
            <script src="{{ asset('backend/js/bootstrap.min.js')}}"></script>
            <script src="{{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
            <script src="{{ asset('backend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
            <script src="{{ asset('backend/js/main/admin_dashboard.js') }}"></script>
            <!-- Morris -->

            <script src="{{ asset('backend/js/plugins/morris/morris.js')}}"></script>
            <!-- Chartist -->

            <!-- Custom and plugin javascript -->
            <script src="{{ asset('backend/js/main.js')}}"></script>
            <script src="{{ asset('backend/js/plugins/pace/pace.min.js')}}"></script>
            <!-- Jvectormap -->
            <script src="{{ asset('backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
            <script src="{{ asset('backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
            <!-- Sparkline -->
            <script src="{{ asset('backend/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
            <!-- Sparkline demo data  -->
            <script src="{{ asset('backend/js/demo/sparkline-demo.js')}}"></script>
            <script src="{{ asset('backend/js/plugins/chartJs/Chart.min.js')}}"></script>
    </body>



</html>
