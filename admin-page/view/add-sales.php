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
?><?php
    require '../config/database.php';
    require '../model/usercustomer_model.php';
    require '../model/customer_model.php';
    require '../model/cagegoryproduct_model.php';
    require '../model/sale_model.php';
    $modelsale = new SaleModel($conn);
    $usercustomermodel = new UserCustomerModel($conn);
    $customermodel = new CustomerModel($conn);
    $listemailusercustomer = $usercustomermodel -> getEmailList();
    $listusercustomer = $customermodel -> listCustomers();
    $categoryModal = new CategoryProductModel($conn);
    $category_resultfinale = $categoryModal->showCategoryProducts();
    $ca_pro_finale_sub = $modelsale->showCategoryProducts_subSale();
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

    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="assets/css/animate.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .suggestions {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    width: 23%;
    max-height: 150px;
    overflow-y: auto;
    z-index: 9999;
    }

    .suggestion {
        padding: 5px 10px;
        cursor: pointer;
    }

    .suggestion:hover {
        background-color: #f0f0f0;
    }
    .product-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px;
    }
    .product-info img {
        max-width: 50px;
        max-height: 50px;
    }

    </style>
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
                        <h4>Add Sale</h4>
                        <h6>Add your new sale</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <select class="select" id="customernameselectadd" onchange="toggleInputADDcustomer()">
                                                <option value="">Choose</option>
                                                <?php foreach ($listusercustomer as $listusercustomers) {
                                                echo '<option value="'.$listusercustomers['email'].'">'.$listusercustomers['name'].'</option>';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="add-icon">
                                                <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email Customer</label>
                                    <input type="text" id="emailInput" placeholder="Enter customer email" name="emailcustomeruser">
                                    <div id="emailSuggestions" class="suggestions"></div>
                                </div>
                            </div>
                            <input type="hidden" id="emailListData" value="<?php echo htmlspecialchars($listemailusercustomer) ?>">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <div class="input-groupicon">
                                        <input type="text" placeholder="Choose Date" class="datetimepicker">
                                        <a class="addonset">
                                            <img src="assets/img/icons/calendars.svg" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select class="select">
                                        <option>Choose</option>
                                        <option>Supplier Name</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-12 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <div class="input-groupicon">
                                        <input type="text" placeholder="Please type product code and select...">
                                        <div class="addonset">
                                            <img src="assets/img/icons/scanners.svg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="select" name="categoryproduct_id" id="categorySelect" required onchange="handleSelectionChange(this, 'productSelect', 'selectedProductImage', 'selectedProductInfo')" >
                                        <option value="">Choose Category</option>
                                        <?php foreach ($category_resultfinale as $category_product) {
                                            echo '<option value="'.$category_product['categoryproduct_id'].'">'.$category_product['name'].'</option>';

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select class="select" name="productSelect" id="productSelect" required  >
                                        <option value="">Choose Product</option>
                                      
                                    </select>
                                </div>
                            </div>
                        </div>
                        <img id="selectedProductImage" src="" alt="Selected Product Image">

                            <div id="selectedProductInfo">
                                <!-- Product info will be displayed here -->
                            </div>
                        <input type="hidden" id="categoryAndSubcategoryData" value="<?php echo htmlspecialchars($ca_pro_finale_sub) ?>">
                        <div class="row">
                            <div class="table-responsive mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>QTY</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Tax</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="productimgname">
                                                <a class="product-img">
                                                    <img src="assets/img/product/product7.jpg" alt="product">
                                                </a>
                                                <a href="javascript:void(0);">Apple Earpods</a>
                                            </td>
                                            <td>1.00</td>
                                            <td>15000.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>1500.00</td>
                                            <td>
                                                <a href="javascript:void(0);" class="delete-set"><img
                                                        src="assets/img/icons/delete.svg" alt="svg"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="productimgname">
                                                <a class="product-img">
                                                    <img src="assets/img/product/product8.jpg" alt="product">
                                                </a>
                                                <a href="javascript:void(0);">iPhone 11</a>
                                            </td>
                                            <td>1.00</td>
                                            <td>1500.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>1500.00</td>
                                            <td>
                                                <a href="javascript:void(0);" class="delete-set"><img
                                                        src="assets/img/icons/delete.svg" alt="svg"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="productimgname">
                                                <a class="product-img">
                                                    <img src="assets/img/product/product1.jpg" alt="product">
                                                </a>
                                                <a href="javascript:void(0);">Macbook pro</a>
                                            </td>
                                            <td>1.00</td>
                                            <td>1500.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>1500.00</td>
                                            <td>
                                                <a href="javascript:void(0);" class="delete-set"><img
                                                        src="assets/img/icons/delete.svg" alt="svg"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Order Tax</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Shipping</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select">
                                        <option>Choose Status</option>
                                        <option>Completed</option>
                                        <option>Inprogress</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Order Tax</h4>
                                                <h5>$ 0.00 (0.00%)</h5>
                                            </li>
                                            <li>
                                                <h4>Discount </h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Shipping</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                            <li class="total">
                                                <h4>Grand Total</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

    <script src="assets/js/script.js"></script>
<script>
    function toggleInputADDcustomer() {
    var selectField = document.getElementById("customernameselectadd");
    var inputField = document.getElementById("emailInput");
    
    if (selectField.value !== "") {
        inputField.disabled = true;
        inputField.value = ""; // Reset the value
    } else {
        inputField.disabled = false;
    }
    
    if (inputField.value !== "") {
        selectField.disabled = true;
        selectField.selectedIndex = 0; // Reset the selected option
    } else {
        selectField.disabled = false;
    }
    }

        $(document).ready(function() {
            var emailList = JSON.parse($("#emailListData").val());
            var maxSuggestions = 5; // Số lượng kết quả gợi ý tối đa hiển thị

            $("#emailInput").on("input", function() {
                toggleInputADDcustomer();
                var query = $(this).val();
                var suggestions = [];
                for (var i = 0; i < emailList.length; i++) {
                    if (emailList[i].toLowerCase().includes(query.toLowerCase())) {
                        suggestions.push(emailList[i]);
                    }
                }

                var suggestionsHtml = "";
                for (var i = 0; i < Math.min(suggestions.length, maxSuggestions); i++) {
                    suggestionsHtml += "<div class='suggestion'>" + suggestions[i] + "</div>";
                }
                if (suggestions.length > maxSuggestions) {
                    suggestionsHtml += "<div id='moreSuggestions' class='suggestion'>See more suggestions...</div>";
                }
                $("#emailSuggestions").html(suggestionsHtml);
            });

            $("#emailSuggestions").on("click", ".suggestion", function() {
                var selectedEmail = $(this).text();
                $("#emailInput").val(selectedEmail);
                $("#emailSuggestions").html("");
            });

            $("#emailSuggestions").on("click", "#moreSuggestions", function() {
                var allSuggestionsHtml = "";
                for (var i = maxSuggestions; i < emailList.length; i++) {
                    allSuggestionsHtml += "<div class='suggestion'>" + emailList[i] + "</div>";
                }
                allSuggestionsHtml += "<div id='lessSuggestions' class='suggestion'>See fewer suggestions...</div>";
                $("#emailSuggestions").html(allSuggestionsHtml);
            });

            $("#emailSuggestions").on("click", "#lessSuggestions", function() {
                var suggestionsHtml = "";
                for (var i = 0; i < Math.min(emailList.length, maxSuggestions); i++) {
                    suggestionsHtml += "<div class='suggestion'>" + emailList[i] + "</div>";
                }
                if (emailList.length > maxSuggestions) {
                    suggestionsHtml += "<div id='moreSuggestions' class='suggestion'>See more suggestions...</div>";
                }
                $("#emailSuggestions").html(suggestionsHtml);
            });
        });

            function handleSelectionChange(selectElement, productSelectId, imageElementId, infoElementId) {
                var selectedId = parseInt(selectElement.value);

                var categoryAndSubcategoryDataInput = document.getElementById('categoryAndSubcategoryData');
                var categoryAndSubcategory = JSON.parse(categoryAndSubcategoryDataInput.value);

                var productSelect = document.getElementById(productSelectId);
                var selectedProductImage = document.getElementById(imageElementId);
                var selectedProductInfo = document.getElementById(infoElementId);

                // Clear the product selection, product image, and product info
                productSelect.innerHTML = '<option value="">Select Product</option>';
                selectedProductImage.src = "";
                selectedProductInfo.innerHTML = "";

                // Loop through categoryAndSubcategory data and find the selected item (category or product)
                categoryAndSubcategory.forEach(function (item) {
                    if (item.categoryproduct_id === selectedId) {
                        // Handle category change: update product list
                        item.products.forEach(function (product) {
                            var option = document.createElement('option');
                            option.value = product.product_id;
                            option.textContent = product.sku + " - " + product.pname;
                            productSelect.appendChild(option);
                        });
                    }
                    item.products.forEach(function (product) {
                        if (product.product_id === selectedId) {
                            // Handle product change: display product info
                            var productInfo = document.createElement('div');
                            productInfo.classList.add('product-info');

                            var productImage = document.createElement('img');
                            productImage.src = product.image;
                            productImage.alt = "Product Image";
                            productInfo.appendChild(productImage);

                            var productSku = document.createElement('span');
                            productSku.textContent = product.sku;
                            productInfo.appendChild(productSku);

                            var productName = document.createElement('span');
                            productName.textContent = product.pname;
                            productInfo.appendChild(productName);

                            selectedProductInfo.appendChild(productInfo);
                        }
                    });
                });
            }




</script>
</body>

</html>