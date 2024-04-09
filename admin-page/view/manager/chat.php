<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/animate.css">

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
                        <li>
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
                                <li><a href="brandlist.php">Brand List</a></li>
                                <li><a href="addbrand.php">Add Brand</a></li>
                                <li><a href="importproduct.php">Import Products</a></li>
                                <li><a href="barcode.php">Print Barcode</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/sales1.svg" alt="img"><span>
                                    Sales</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="saleslist.php">Sales List</a></li>
                                <li><a href="pos.php">POS</a></li>
                                <li><a href="pos.php">New Sales</a></li>
                                <li><a href="salesreturnlists.php">Sales Return List</a></li>
                                <li><a href="createsalesreturns.php">New Sales Return</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/purchase1.svg" alt="img"><span>
                                    Purchase</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="purchaselist.php">Purchase List</a></li>
                                <li><a href="addpurchase.php">Add Purchase</a></li>
                                <li><a href="importpurchase.php">Import Purchase</a></li>
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
                            <a href="javascript:void(0);"><img src="assets/img/icons/transfer1.svg" alt="img"><span>
                                    Transfer</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="transferlist.php">Transfer List</a></li>
                                <li><a href="addtransfer.php">Add Transfer </a></li>
                                <li><a href="importtransfer.php">Import Transfer </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/return1.svg" alt="img"><span>
                                    Return</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="salesreturnlist.php">Sales Return List</a></li>
                                <li><a href="createsalesreturn.php">Add Sales Return </a></li>
                                <li><a href="purchasereturnlist.php">Purchase Return List</a></li>
                                <li><a href="createpurchasereturn.php">Add Purchase Return </a></li>
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
                                <li><a href="storelist.php">Store List</a></li>
                                <li><a href="addstore.php">Add Store</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/places.svg" alt="img"><span>
                                    Places</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="newcountry.php">New Country</a></li>
                                <li><a href="countrieslist.php">Countries list</a></li>
                                <li><a href="newstate.php">New State </a></li>
                                <li><a href="statelist.php">State list</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="components.php"><i data-feather="layers"></i><span> Components</span> </a>
                        </li>
                        <li>
                            <a href="blankpage.php"><i data-feather="file"></i><span> Blank Page</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="alert-octagon"></i> <span> Error Pages
                                </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="error-404.php">404 Error </a></li>
                                <li><a href="error-500.php">500 Error </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="box"></i> <span>Elements </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="sweetalerts.php">Sweet Alerts</a></li>
                                <li><a href="tooltip.php">Tooltip</a></li>
                                <li><a href="popover.php">Popover</a></li>
                                <li><a href="ribbon.php">Ribbon</a></li>
                                <li><a href="clipboard.php">Clipboard</a></li>
                                <li><a href="drag-drop.php">Drag & Drop</a></li>
                                <li><a href="rangeslider.php">Range Slider</a></li>
                                <li><a href="rating.php">Rating</a></li>
                                <li><a href="toastr.php">Toastr</a></li>
                                <li><a href="text-editor.php">Text Editor</a></li>
                                <li><a href="counter.php">Counter</a></li>
                                <li><a href="scrollbar.php">Scrollbar</a></li>
                                <li><a href="spinner.php">Spinner</a></li>
                                <li><a href="notification.php">Notification</a></li>
                                <li><a href="lightbox.php">Lightbox</a></li>
                                <li><a href="stickynote.php">Sticky Note</a></li>
                                <li><a href="timeline.php">Timeline</a></li>
                                <li><a href="form-wizard.php">Form Wizard</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="bar-chart-2"></i> <span> Charts </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="chart-apex.php">Apex Charts</a></li>
                                <li><a href="chart-js.php">Chart Js</a></li>
                                <li><a href="chart-morris.php">Morris Charts</a></li>
                                <li><a href="chart-flot.php">Flot Charts</a></li>
                                <li><a href="chart-peity.php">Peity Charts</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="award"></i><span> Icons </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="icon-fontawesome.php">Fontawesome Icons</a></li>
                                <li><a href="icon-feather.php">Feather Icons</a></li>
                                <li><a href="icon-ionic.php">Ionic Icons</a></li>
                                <li><a href="icon-material.php">Material Icons</a></li>
                                <li><a href="icon-pe7.php">Pe7 Icons</a></li>
                                <li><a href="icon-simpleline.php">Simpleline Icons</a></li>
                                <li><a href="icon-themify.php">Themify Icons</a></li>
                                <li><a href="icon-weather.php">Weather Icons</a></li>
                                <li><a href="icon-typicon.php">Typicon Icons</a></li>
                                <li><a href="icon-flag.php">Flag Icons</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="columns"></i> <span> Forms </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="form-basic-inputs.php">Basic Inputs </a></li>
                                <li><a href="form-input-groups.php">Input Groups </a></li>
                                <li><a href="form-horizontal.php">Horizontal Form </a></li>
                                <li><a href="form-vertical.php"> Vertical Form </a></li>
                                <li><a href="form-mask.php">Form Mask </a></li>
                                <li><a href="form-validation.php">Form Validation </a></li>
                                <li><a href="form-select2.php">Form Select2 </a></li>
                                <li><a href="form-fileupload.php">File Upload </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="tables-basic.php">Basic Tables </a></li>
                                <li><a href="data-tables.php">Data Table </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/product.svg" alt="img"><span>
                                    Application</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="chat.php" class="active">Chat</a></li>
                                <li><a href="calendar.php">Calendar</a></li>
                                <li><a href="email.php">Email</a></li>
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
                                <li><a href="paymentsettings.php">Payment Settings</a></li>
                                <li><a href="currencysettings.php">Currency Settings</a></li>
                                <li><a href="grouppermissions.php">Group Permissions</a></li>
                                <li><a href="taxrates.php">Tax Rates</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                <div class="col-lg-12">
                    <div class="row chat-window">

                        <div class="col-lg-5 col-xl-4 chat-cont-left">
                            <div class="card mb-sm-3 mb-md-0 contacts_card flex-fill">
                                <div class="card-header chat-search">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="search_btn"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" placeholder="Search"
                                            class="form-control search-chat rounded-pill">
                                    </div>
                                </div>
                                <div class="card-body contacts_body chat-users-list chat-scroll">
                                    <a href="javascript:void(0);" class="media d-flex active">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-away">
                                                <img src="assets/img/customer/customer1.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Jeffrey Akridge</div>
                                                <div class="user-last-chat">Hey, How are you?</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">2 min</div>
                                                <div class="badge badge-success badge-pill">15</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media d-flex read-chat">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-online">
                                                <img src="assets/img/customer/customer2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Nancy Olson</div>
                                                <div class="user-last-chat">I'll call you later </div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">8:01 PM</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-away">
                                                <img src="assets/img/customer/customer3.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Ramona Kingsley</div>
                                                <div class="user-last-chat">Give me a full explanation about our project
                                                </div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">7:30 PM</div>
                                                <div class="badge badge-success badge-pill">3</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-online">
                                                <img src="assets/img/customer/customer4.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Ricardo Lung</div>
                                                <div class="user-last-chat">That's very good UI design</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">6:59 PM</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-offline">
                                                <img src="assets/img/customer/customer5.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Annette Silva</div>
                                                <div class="user-last-chat">Yesterday i completed the task</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">11:21 AM</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-online">
                                                <img src="assets/img/customer/customer6.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Stephen Wilson</div>
                                                <div class="user-last-chat">What is the major functionality?</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">10:05 AM</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-away">
                                                <img src="assets/img/customer/customer7.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Ryan Rodriguez</div>
                                                <div class="user-last-chat">This has allowed me to showcase not only my
                                                    technical skills</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">Yesterday</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-offline">
                                                <img src="assets/img/customer/customer8.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Lucile Devera</div>
                                                <div class="user-last-chat">Let's talk briefly in the evening. </div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">Sunday</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-online">
                                                <img src="assets/img/customer/customer1.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Roland Storey</div>
                                                <div class="user-last-chat">Do you have any collections? If so, what of?
                                                </div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">Saturday</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="media read-chat d-flex">
                                        <div class="media-img-wrap flex-shrink-0">
                                            <div class="avatar avatar-away">
                                                <img src="assets/img/customer/customer2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div>
                                                <div class="user-name">Lindsey Parmley</div>
                                                <div class="user-last-chat">Connect the two modules with in 1 day.</div>
                                            </div>
                                            <div>
                                                <div class="last-chat-time">Friday</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-7 col-xl-8 chat-cont-right">

                            <div class="card mb-0">
                                <div class="card-header msg_head">
                                    <div class="d-flex bd-highlight">
                                        <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <div class="img_cont">
                                            <img class="rounded-circle user_img" src="assets/img/customer/profile2.jpg"
                                                alt="">
                                        </div>
                                        <div class="user_info">
                                            <span><strong id="receiver_name">Jeffrey Akridge</strong></span>
                                            <p class="mb-0">Messages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body msg_card_body chat-scroll">
                                    <ul class="list-unstyled">
                                        <li class="media sent d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/customer5.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>Hello. What can I do for you?</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:30 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media received d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/profile2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>I'm just looking around.</p>
                                                        <p>Will you tell me something about yourself?</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:35 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="msg-box">
                                                    <div>
                                                        <p>Are you there? That time!</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:40 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="msg-box">
                                                    <div>
                                                        <div class="chat-msg-attachments">
                                                            <div class="chat-attachment">
                                                                <img src="assets/img/product/product12.jpg"
                                                                    alt="Attachment">
                                                                <a href="" class="chat-attach-download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </div>
                                                            <div class="chat-attachment">
                                                                <img src="assets/img/product/product13.jpg"
                                                                    alt="Attachment">
                                                                <a href="" class="chat-attach-download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:41 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media sent d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/customer5.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>Where?</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:42 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="msg-box">
                                                    <div>
                                                        <p>OK, my name is Limingqiang. I like singing, playing
                                                            basketballand so on.</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:42 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="msg-box">
                                                    <div>
                                                        <div class="chat-msg-attachments">
                                                            <div class="chat-attachment">
                                                                <img src="assets/img/product/product15.jpg"
                                                                    alt="Attachment">
                                                                <a href="" class="chat-attach-download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:50 AM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media received d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/profile2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>You wait for notice.</p>
                                                        <p>Consectetuorem ipsum dolor sit?</p>
                                                        <p>Ok?</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>8:55 PM</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="chat-date">Today</li>
                                        <li class="media received d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/profile2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>10:17 AM</span>
                                                                </div>
                                                            </li>
                                                            <li><a href="javascript:void(0);">Edit</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media sent d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/profile2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <p>Lorem ipsum dollar sit</p>
                                                        <div class="chat-msg-actions dropdown">
                                                            <a href="javascript:void(0);" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-elipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </div>
                                                        </div>
                                                        <ul class="chat-msg-info">
                                                            <li>
                                                                <div class="chat-time">
                                                                    <span>10:19 AM</span>
                                                                </div>
                                                            </li>
                                                            <li><a href="javascript:void(0);">Edit</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media received d-flex">
                                            <div class="avatar flex-shrink-0">
                                                <img src="assets/img/customer/profile2.jpg" alt="User Image"
                                                    class="avatar-img rounded-circle">
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="msg-box">
                                                    <div>
                                                        <div class="msg-typing">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <div class="input-group">
                                        <input class="form-control type_msg mh-auto empty_check"
                                            placeholder="Type your message...">
                                        <button class="btn btn-primary btn_send"><i class="fa fa-paper-plane"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="searchpart">
        <div class="searchcontent">
            <div class="searchhead">
                <h3>Search </h3>
                <a id="closesearch"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
            </div>
            <div class="searchcontents">
                <div class="searchparts">
                    <input type="text" placeholder="search here">
                    <a class="btn btn-searchs">Search</a>
                </div>
                <div class="recentsearch">
                    <h2>Recent Search</h2>
                    <ul>
                        <li>
                            <h6><i class="fa fa-search me-2"></i> Settings</h6>
                        </li>
                        <li>
                            <h6><i class="fa fa-search me-2"></i> Report</h6>
                        </li>
                        <li>
                            <h6><i class="fa fa-search me-2"></i> Invoice</h6>
                        </li>
                        <li>
                            <h6><i class="fa fa-search me-2"></i> Sales</h6>
                        </li>
                    </ul>
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

    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>