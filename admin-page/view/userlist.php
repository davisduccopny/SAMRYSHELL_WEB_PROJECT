<?php
    session_start();
    if (!isset($_SESSION['email_manager']) &&  !$_SESSION['email_manager']) {
        echo "<script> alert('Bạn chưa đăng nhập!')</script>";
        header("refresh:1.5;url=signin.php");
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location:signin.php");
    }
    if (isset($_SESSION['role_manager']) && $_SESSION['role_manager'] !== 'admin'){
        $role_show_element = 'hidden';
        $role_active_element = 'disabled';
    }
    else {
        $role_show_element = '';
    }
?>﻿<?php
    require '../config/database.php';
    require '../model/usercustomer_model.php';
    $usercustomermodel = new UserCustomerModel($conn);
    $listusercustomer = $usercustomermodel -> listUserCustomers();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['user_id'])& isset($_POST['status'])) {

            $user_id = $_POST['user_id'];
            $status = $_POST['status'];
           $userchangestatus= $usercustomermodel->updateUserstatusCustomer($user_id,$status);
            if ($userchangestatus) {
                ob_clean();
                echo "success";
                exit();
            } else {
                echo "error";
            }
        }
        if ( isset($_POST['usercustomer_id'])){
            $usercustomer_id = $_POST['usercustomer_id'];
          $usercustomerdelete = $usercustomermodel ->deleteUserCustomer($usercustomer_id);
            // Xóa dữ liệu đầu ra hiện tại
            if ($usercustomerdelete) {
                ob_clean(); 
                echo "success";
                exit();
            } else {
                echo "error";
            }
        }
      
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/animate.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="index.php" class="logo">
                    <img src="assets/img/logo.png" alt="">
                </a>
                <a href="index.php" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv"><img src="assets/img/icons/search.svg" alt="img"></a>
                        </form>
                    </div>
                </li>


                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                        role="button">
                        <img src="assets/img/flags/us1.png" alt="" height="20">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/us.png" alt="" height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/fr.png" alt="" height="16"> French
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/es.png" alt="" height="16"> Spanish
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/de.png" alt="" height="16"> German
                        </a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="assets/img/icons/notification-bing.svg" alt="img"> <span
                            class="badge rounded-pill">4</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added
                                                    new task <span class="noti-title">Patient appointment booking</span>
                                                </p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="assets/img/profiles/avatar-03.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                                    changed the task name <span class="noti-title">Appointment booking
                                                        with payment gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="assets/img/profiles/avatar-06.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                                    added <span class="noti-title">Domenic Houston</span> and <span
                                                        class="noti-title">Claire Mapes</span> to project <span
                                                        class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="assets/img/profiles/avatar-17.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                                    completed task <span class="noti-title">Patient and Doctor video
                                                        conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.php">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt="" src="assets/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span>
                                                    added new task <span class="noti-title">Private chat module</span>
                                                </p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.php">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>John Doe</h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.php"> <i class="me-2" data-feather="user"></i> My
                                Profile</a>
                            <a class="dropdown-item" href="generalsettings.php"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.php"><img
                                    src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.php">Settings</a>
                    <a class="dropdown-item" href="signin.php">Logout</a>
                </div>
            </div>

        </div>



        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="index.php"><img src="assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/product.svg" alt="img"><span>
                                    Product</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="productlist.php">Product List</a></li>
                                <li><a href="addproduct.php">Add Product</a></li>
                                <li><a href="categorylist.php">Category List</a></li>
                                <li><a href="addcategory.php">Add Category</a></li>
                                <li><a href="subcategorylist.php">Sub Category List</a></li>
                                <li><a href="subaddcategory.php">Add Sub Category</a></li>
                                <li <?php echo $role_show_element; ?>><a href="manager/brandlist.php">Brand List</a></li>
                                <li <?php echo $role_show_element; ?>><a href="manager/addbrand.php">Add Brand</a></li>
                                <li <?php echo $role_show_element; ?>><a href="manager/importproduct.php">Import Products</a></li>
                                <li <?php echo $role_show_element; ?>><a href="manager/barcode.php">Print Barcode</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="saleslist.php" >Sales List</a></li>
                                <li><a href="pos.php">POS</a></li>
                                <!-- <li><a href="pos.php">New Sales</a></li> -->
                                <li><a href="salesreturnlist.php">Sales Return List</a></li>
                                <!-- <li><a href="createsalesreturn.php">New Sales Return</a></li> -->
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/expense1.svg" alt="img"><span>
                                    Expense</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="expenselist.php">Expense List</a></li>
                                <li><a href="createexpense.php">Add Expense</a></li>
                                <li><a href="expensecategory.php">Expense Category</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/quotation1.svg" alt="img"><span>
                                    Quotation</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="quotationList.php">Quotation List</a></li>
                                <li><a href="addquotation.php">Add Quotation</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/purchase1.svg" alt="img"><span>
                                    Blogs</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="bloglist.php">Blogs List</a></li>
                                <li><a href="addblog.php">Add Blogs</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/purchase1.svg" alt="img"><span>
                                    Public-info</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="publicinfo.php">Public-information</a></li>
                                <li <?php echo $role_show_element; ?>><a href="addpublicinfo.php">Add public</a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><img src="assets/img/icons/transfer1.svg" alt="img"><span>
                                    Transfer</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/transferlist.php">Transfer List</a></li>
                                <li><a href="manager/addtransfer.php">Add Transfer </a></li>
                                <li><a href="manager/importtransfer.php">Import Transfer </a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><img src="assets/img/icons/return1.svg" alt="img"><span>
                                    Return</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/salesreturnlist.php">Sales Return List</a></li>
                                <li><a href="manager/createsalesreturn.php">Add Sales Return </a></li>
                                <li><a href="manager/purchasereturnlist.php">Purchase Return List</a></li>
                                <li><a href="manager/createpurchasereturn.php">Add Purchase Return </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="img"><span>
                                    People</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="customerlist.php">Customer List</a></li>
                                <li><a href="addcustomer.php">Add Customer </a></li>
                                <li><a href="supplierlist.php">Supplier List</a></li>
                                <li><a href="addsupplier.php">Add Supplier </a></li>
                                <li><a href="userlist.php">User List</a></li>
                                <li><a href="adduser.php">Add User</a></li>
                                <!-- <li><a href="storelist.php">Store List</a></li>
                                <li><a href="addstore.php">Add Store</a></li> -->
                            </ul>
                        </li>
                        <!-- <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/places.svg" alt="img"><span>
                                    Places</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="newcountry.php">New Country</a></li>
                                <li><a href="countrieslist.php">Countries list</a></li>
                                <li><a href="newstate.php">New State </a></li>
                                <li><a href="statelist.php">State list</a></li>
                            </ul>
                        </li> -->
                        <li <?php echo $role_show_element; ?>>
                            <a href="components.php" ><i data-feather="layers"></i><span> Components</span> </a>
                        </li>
                        <li <?php echo $role_show_element; ?>>
                            <a href="blankpage.php"><i data-feather="file"></i><span> Blank Page</span> </a>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="alert-octagon"></i> <span> Error Pages
                                </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/error-404.php">404 Error </a></li>
                                <li><a href="manager/error-500.php">500 Error </a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="box"></i> <span>Elements </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/manager/sweetalerts.php">Sweet Alerts</a></li>
                                <li><a href="manager/manager/tooltip.php">Tooltip</a></li>
                                <li><a href="manager/manager/popover.php">Popover</a></li>
                                <li><a href="manager/manager/ribbon.php">Ribbon</a></li>
                                <li><a href="manager/manager/clipboard.php">Clipboard</a></li>
                                <li><a href="manager/drag-drop.php">Drag & Drop</a></li>
                                <li><a href="manager/rangeslider.php">Range Slider</a></li>
                                <li><a href="manager/rating.php">Rating</a></li>
                                <li><a href="manager/toastr.php">Toastr</a></li>
                                <li><a href="manager/text-editor.php">Text Editor</a></li>
                                <li><a href="manager/counter.php">Counter</a></li>
                                <li><a href="manager/scrollbar.php">Scrollbar</a></li>
                                <li><a href="manager/spinner.php">Spinner</a></li>
                                <li><a href="manager/notification.php">Notification</a></li>
                                <li><a href="manager/lightbox.php">Lightbox</a></li>
                                <li><a href="manager/stickynote.php">Sticky Note</a></li>
                                <li><a href="manager/timeline.php">Timeline</a></li>
                                <li><a href="manager/form-wizard.php">Form Wizard</a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="bar-chart-2"></i> <span> Charts </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/chart-apex.php">Apex Charts</a></li>
                                <li><a href="manager/chart-js.php">Chart Js</a></li>
                                <li><a href="manager/chart-morris.php">Morris Charts</a></li>
                                <li><a href="manager/chart-flot.php">Flot Charts</a></li>
                                <li><a href="manager/chart-peity.php">Peity Charts</a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="award"></i><span> Icons </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/icon-fontawesome.php">Fontawesome Icons</a></li>
                                <li><a href="manager/icon-feather.php">Feather Icons</a></li>
                                <li><a href="manager/icon-ionic.php">Ionic Icons</a></li>
                                <li><a href="manager/icon-material.php">Material Icons</a></li>
                                <li><a href="manager/icon-pe7.php">Pe7 Icons</a></li>
                                <li><a href="manager/icon-simpleline.php">Simpleline Icons</a></li>
                                <li><a href="manager/icon-themify.php">Themify Icons</a></li>
                                <li><a href="manager/icon-weather.php">Weather Icons</a></li>
                                <li><a href="manager/icon-typicon.php">Typicon Icons</a></li>
                                <li><a href="manager/icon-flag.php">Flag Icons</a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="columns"></i> <span> Forms </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/form-basic-inputs.php">Basic Inputs </a></li>
                                <li><a href="manager/form-input-groups.php">Input Groups </a></li>
                                <li><a href="manager/form-horizontal.php">Horizontal Form </a></li>
                                <li><a href="manager/form-vertical.php"> Vertical Form </a></li>
                                <li><a href="manager/form-mask.php">Form Mask </a></li>
                                <li><a href="manager/form-validation.php">Form Validation </a></li>
                                <li><a href="manager/form-select2.php">Form Select2 </a></li>
                                <li><a href="manager/form-fileupload.php">File Upload </a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/tables-basic.php">Basic Tables </a></li>
                                <li><a href="manager/data-tables.php">Data Table </a></li>
                            </ul>
                        </li>
                        <li class="submenu" <?php echo $role_show_element; ?>>
                            <a href="javascript:void(0);"><img src="assets/img/icons/product.svg" alt="img"><span>
                                    Application</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="manager/chat.php">Chat</a></li>
                                <li><a href="manager/calendar.php">Calendar</a></li>
                                <li><a href="manager/email.php">Email</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/time.svg" alt="img"><span>
                                    Report</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="purchaseorderreport.php">Purchase order report</a></li>
                                <li><a href="inventoryreport.php">Inventory Report</a></li>
                                <li><a href="salesreport.php">Sales Report</a></li>
                                <li><a href="invoicereport.php">Invoice Report</a></li>
                                <li><a href="purchasereport.php">Purchase Report</a></li>
                                <li><a href="supplierreport.php">Supplier Report</a></li>
                                <li><a href="customerreport.php">Customer Report</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="img"><span>
                                    Users</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="newuser.php">New User </a></li>
                                <li><a href="userlists.php">Users List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/settings.svg" alt="img"><span>
                                    Settings</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="generalsettings.php">General Settings</a></li>
                                <li><a href="emailsettings.php">Email Settings</a></li>
                                <li <?php echo $role_show_element; ?>><a href="paymentsettings.php">Payment Settings</a></li>
                                <li <?php echo $role_show_element; ?>><a href="currencysettings.php">Currency Settings</a></li>
                                <li <?php echo $role_show_element; ?>><a href="grouppermissions.php">Group Permissions</a></li>
                                <li <?php echo $role_show_element; ?>><a href="taxrates.php">Tax Rates</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>User List</h4>
                        <h6>Manage your User</h6>
                    </div>
                    <div class="page-btn">
                        <a href="adduser.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img"
                                class="me-2">Add User</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="assets/img/icons/filter.svg" alt="img">
                                        <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset">
                                        <img src="assets/img/icons/search-white.svg" alt="img">
                                    </a>
                                </div>
                            </div>
                            <div class="wordset">
                                <ul>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                src="assets/img/icons/pdf.svg" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                src="assets/img/icons/excel.svg" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                src="assets/img/icons/printer.svg" alt="img"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter User Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Disable</option>
                                                <option>Enable</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                        <div class="form-group">
                                            <a class="btn btn-filters ms-auto"><img
                                                    src="assets/img/icons/search-whites.svg" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Profile</th>
                                        <th>First name </th>
                                        <th>Last name </th>
                                        <th>Phone</th>
                                        <th>email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($listusercustomer as $usercustomer): ?>

                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="<?php echo $usercustomer['image']; ?>" alt="product">
                                            </a>
                                        </td>
                                        <td><?php echo $usercustomer['first_name']; ?></td>
                                        <td><?php echo $usercustomer['last_name']; ?> </td>
                                        <td><?php echo $usercustomer['phone']; ?></td>
                                        <td><?php echo $usercustomer['email']; ?></td>
                                        <td>
                                            <div
                                                class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="user<?php echo $usercustomer['id']; ?>" class="check" data-user-id="<?php echo $usercustomer['id']; ?>" <?php echo ($usercustomer['status'] == 1) ? 'checked' : ''; ?>>
                                                <label for="user<?php echo $usercustomer['id']; ?>" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="me-3" href="edituser.php?user_customerid=<?php echo $usercustomer['id']; ?>">
                                                <img src="assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a class="me-3 confirmusdfte-text"  data-usercustomer-id="<?php echo $usercustomer['id'] ?>">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="showpayment" tabindex="-1" aria-labelledby="showpayment" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Show Payments</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Amount </th>
                                    <th>Paid By </th>
                                    <th>Paid By </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bor-b1">
                                    <td>2022-03-07 </td>
                                    <td>INV/SL0101</td>
                                    <td>$ 1500.00 </td>
                                    <td>Cash</td>
                                    <td>
                                        <a class="me-2" href="javascript:void(0);">
                                            <img src="assets/img/icons/printer.svg" alt="img">
                                        </a>
                                        <a class="me-2" href="javascript:void(0);" data-bs-target="#editpayment"
                                            data-bs-toggle="modal" data-bs-dismiss="modal">
                                            <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-2 confirm-text" href="javascript:void(0);">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createpayment" tabindex="-1" aria-labelledby="createpayment" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Payment</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="input-group">
                                    <input type="text" value="2022-03-07" class="datetimepicker">
                                    <a class="scanner-set input-group-text">
                                        <img src="assets/img/icons/datepicker.svg" alt="img">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Reference</label>
                                <input type="text" value="INV/SL0101">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Received Amount</label>
                                <input type="text" value="1500.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Paying Amount</label>
                                <input type="text" value="1500.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Payment type</label>
                                <select class="select">
                                    <option>Cash</option>
                                    <option>Online</option>
                                    <option>Inprogress</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editpayment" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="input-group">
                                    <input type="text" value="2022-03-07" class="datetimepicker">
                                    <a class="scanner-set input-group-text">
                                        <img src="assets/img/icons/datepicker.svg" alt="img">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Reference</label>
                                <input type="text" value="INV/SL0101">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Received Amount</label>
                                <input type="text" value="1500.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Paying Amount</label>
                                <input type="text" value="1500.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Payment type</label>
                                <select class="select">
                                    <option>Cash</option>
                                    <option>Online</option>
                                    <option>Inprogress</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- <script src="https://gist.github.com/zhanglianxin/79b9fc200607d01d8bcce28fd095e7c9.js"></script> -->

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>



    <script src="assets/js/script.js"></script>
    <script>
    $(document).ready(function() {
        $(".check").on("change", function() {
            var status = this.checked ? 1 : 0;
            var userId = $(this).data("user-id");
            
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: { user_id: userId, status: status },
                success: function(response) {
                    console.log("Server response:", response);
                },
                error: function() {
                    console.log("An error occurred.");
                }
            });
        });
    });
</script>
</body>

</html>