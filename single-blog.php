<?php 
require './admin-page/config/database.php';
require './admin-page/model/product_model.php';
require './admin-page/model/cart_model.php';
$cartmodel = new CartModel($conn);
session_start();
if(isset($_SESSION['email_customer'])) {
    $emaillist = $_SESSION['email_customer'];
    $listcart = $cartmodel->getCart($emaillist);
    $countcart = count($listcart);
}
// if (isset($_GET['productid'])) {
//     $id = $_GET['productid'];

// $productModel2 = new ProductModel($conn);
// $productInfo= $productModel2->getProduct($id);


// }
// else {
//     echo '<script>alert("Không tìm thấy sản phẩm");</script>';
//     header('Location: shop.php');
//     exit();
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['login_addcart'])){
    if (!isset($_SESSION['email_customer']) || empty($_SESSION['email_customer'])) {
        echo "<script> alert('Bạn chưa đăng nhập!')</script>";
        header("refresh:1.5;url=login-register.php");
    }
    else {

    $quantity_addcart = $_POST['quantity_addcart'];
    // CHECK PRODUCT
    $checkarrayproduct = [];
    foreach ($listcart  as $check) {
        $checkarrayproduct[] = $check['product_id'];
    }
    
    function checkProduct($productid, $id) {
        $found = false;
    
        for ($i = 0; $i < count($productid); $i++) {
            if ($productid[$i] == $id) {
                $found = true;
                break;
            }
        }

        return $found;
    }
      // CHECK PRODUCT
    $checkproduct = checkProduct($checkarrayproduct, $id);
    if ($checkproduct) {
        $updatecart = $cartmodel->updateCart($id,$quantity_addcart,$emaillist);
        if ($updatecart){
            header("Refresh:0");
            
        }
     
    }
    else {
      
    $addcart = $cartmodel->insertCart($id,$quantity_addcart,$emaillist);
    if ($addcart){
        header("Refresh:0");
    }
    }

    }
}
    if (isset($_POST['delete_cart'])){
        $product_id = $_POST['product_id_delete'];
        $deletecontroller = $cartmodel->deleteCart($product_id,$emaillist);
        if ($deletecontroller){
            header("Refresh:0");
        }
    }
}
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="meta description">

    <title>Blog Details :: DNX - Jewelry Store e-Commerce Bootstrap 4 Template</title>

    <!--=== Favicon ===-->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon"/>

    <!--== Google Fonts ==-->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Droid+Serif:400,400i,500,700,700i"/>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i"/>

    <!--=== Bootstrap CSS ===-->
    <link href="assets/css/vendor/bootstrap.min.css" rel="stylesheet">
    <!--=== Font-Awesome CSS ===-->
    <link href="assets/css/vendor/font-awesome.css" rel="stylesheet">
    <!--=== Plugins CSS ===-->
    <link href="assets/css/plugins.css" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!--== Header Area Start ==-->
<header id="header-area" class="header__3">
    <div class="ruby-container">
        <div class="row">
            <!-- Logo Area Start -->
            <div class="col-3 col-lg-1 col-xl-2 m-auto">
                <a href="index.html" class="logo-area">
                    <img src="assets/img/logo-black.png" alt="Logo" class="img-fluid"/>
                </a>
            </div>
            <!-- Logo Area End -->

            <!-- Navigation Area Start -->
            <div class="col-3 col-lg-9 col-xl-8 m-auto">
                <div class="main-menu-wrap">
                    <nav id="mainmenu">
                        <ul>
                            <li ><a href="index.php">Home</a>
                            </li>
                            <li class="dropdown-show"><a href="shop.php">Shop</a>
                            </li>
                            <li ><a href="about.php">About</a>
                            </li>
                            <li class="dropdown-show"><a href="#">Pages</a>
                                <ul class="dropdown-nav">
                                    <li><a href="about.php">About</a></li>
                                    <li><a href="my-account.php">My Account</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-show"><a href="#">Category</a>
                                <ul class="mega-menu-wrap dropdown-nav">
                                    <li class="mega-menu-item"><a href="shop-left-full-wide.php"
                                                                  class="mega-item-title">Shirt</a>
                                        <ul>
                                            <li><a href="shop.php">Tops & Tees</a></li>
                                            <li><a href="shop.php">Polo Short Sleeve</a></li>
                                            <li><a href="shop.php">Graphic T-Shirts</a></li>
                                            <li><a href="shop.php">Jackets & Coats</a></li>
                                            <li><a href="shop.php">Fashion Jackets</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li ><a href="single-blog.php">Blog</a>
                            </li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Navigation Area End -->

            <!-- Header Right Meta Start -->
            <div class="col-6 col-lg-2 m-auto">
                <div class="header-right-meta text-right">
                    <ul>
                        <li><a href="#" class="modal-active"><i class="fa fa-search"></i></a></li>
                        <li class="settings"><a href="#"><i class="fa fa-cog"></i></a>
                            <div class="site-settings d-block d-sm-flex">
                                <dl class="currency">
                                    <dt>Currency</dt>
                                    <dd class="current"><a href="#">USD</a></dd>
                                    <dd><a href="#">AUD</a></dd>
                                    <dd><a href="#">CAD</a></dd>
                                    <dd><a href="#">BDT</a></dd>
                                </dl>

                                <dl class="my-account">
                                    <dt>My Account</dt>
                                    <dd><a href="#">Dashboard</a></dd>
                                    <dd><a href="#">Profile</a></dd>
                                    <dd><a href="#">Sign</a></dd>
                                </dl>

                                <dl class="language">
                                    <dt>Language</dt>
                                    <dd class="current"><a href="#">English (US)</a></dd>
                                    <dd><a href="#">English (UK)</a></dd>
                                    <dd><a href="#">Chinees</a></dd>
                                    <dd><a href="#">Bengali</a></dd>
                                    <dd><a href="#">Hindi</a></dd>
                                    <dd><a href="#">Japanees</a></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="shop-cart"><a href="#"><i class="fa fa-shopping-bag"></i> <span
                                class="count"><?php echo isset($countcart) ? $countcart : 0; ?></span></a>
                            <div class="mini-cart">
                                <div class="mini-cart-body">
                                <?php if (isset($listcart) && is_array($listcart) && !empty($listcart)): ?>
                                        <?php foreach ($listcart as $product): ?>
                                            <div class="single-cart-item d-flex">
                                                <figure class="product-thumb">
                                                    <a href="#"><img class="img-fluid" src="<?php $strfirt = './admin-page';$image_path = isset($product['image']) ? $strfirt . substr($product['image'], 2) : '';  echo $image_path;?>"
                                                                    alt="Products"/></a>
                                                </figure>

                                                <div class="product-details">
                                                    <h2><a href="#"><?php echo $product['name']; ?></a></h2>
                                                    <div class="cal d-flex align-items-center">
                                                        <span class="quantity"><?php echo $product['quantity']; ?></span>
                                                        <span class="multiplication">X</span>
                                                        <span class="price">$<?php echo $product['price']; ?></span>
                                                    </div>
                                                </div>
                                                <form method="post">
                                                    <input type="hidden" value="<?php echo $product['product_id']; ?>" name="product_id_delete">
                                                    <button name="delete_cart" href="#" class="remove-icon" type="submit"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Không có sản phẩm trong giỏ hàng.</p>
                                    <?php endif; ?>

                                    <input type="hidden"  name="email_login_insert_cart" id="email_login_insert_cart" value="<?php echo $emaillist; ?>">
                                </div>
                                <div class="mini-cart-footer">
                                    <a onclick="AddSaleCart(event)" class="btn-add-to-cart">Checkout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Header Right Meta End -->
        </div>
    </div>
</header>
<!--== Header Area End ==-->

<!--== Search Box Area Start ==-->
<div class="body-popup-modal-area">
    <span class="modal-close"><img src="assets/img/cancel.png" alt="Close" class="img-fluid"/></span>
    <div class="modal-container d-flex">
        <div class="search-box-area">
            <div class="search-box-form">
                <form action="#" method="post">
                    <input type="search" placeholder="type keyword and hit enter"/>
                    <button class="btn" type="button"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--== Search Box Area End ==-->

<!--== Page Title Area Start ==-->
<div id="page-title-area">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="page-title-content">
                    <h1>Blog Details</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="#" class="active">Financial Investment: The Right Way</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--== Page Title Area End ==-->

<!--== Page Content Wrapper Start ==-->
<div id="page-content-wrapper" class="p-9">
    <div class="container">
        <div class="row">
            <!-- Single Blog Page Content Start -->
            <div class="col-lg-8">
                <article class="single-blog-content-wrap">
                    <div class="post-header">
                        <figure class="post-thumbnail">
                            <img src="assets/img/single-blog.jpg" class="img-fluid" alt="Blog"/>
                        </figure>

                        <div class="post-meta">
                            <h2>Financial Investment: The Right Way</h2>
                            <div class="post-info">
                                <a href="#"><i class="fa fa-user"></i> Albert Flores</a>
                                <a href="#"><i class="fa fa-calendar"></i> 08/20/2018</a>
                            </div>
                        </div>
                    </div>

                    <div class="post-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit. Culpa, dolorem earum eius eum,
                            exercitationem explicabo facilis harum sillo ipsum isted odio placeated quaerated quisquam
                            ratione suscipit tempora temporibus veniam. Ab ad aliquam amet at blanditiis delectus
                            distinctio dolorem eaque eum, eveniet id, non nulla obcaecati perferendis ratione repellat
                            sapiente soluta.</p>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisici elit. Culpa, dolorem earum eius eum,
                            exercitationem explicabo facilis harum sillo ipsum isted odio placeated quaerated quisquam
                            ratione suscipit tempora temporibus veniam. Ab ad aliquam amet at blanditiis delectus
                            distinctio dolorem eaque eum, eveniet id, non nulla obcaecati perferendis ratione repellat
                            sapiente soluta.</p>

                        <blockquote class="blockquote">
                            <p>Placeated quaerated quisquam rationed suscipite tempora temporibus veniam. Ab ad aliquam
                                amet at blanditiis delectus distinctio dolorem eaque eum, eveniet id, non nulla
                                obcaecati perferendis ratione repellat sapiente soluta</p>
                        </blockquote>

                        <p>It is a long established fact that a reader will be distracted by the readable content of a
                            page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less normal distribution of letters, as posed to using Content here, content here',
                            making it look like readable</p>

                        <img src="assets/img/home_4_slide_2.jpg" class="img-fluid" alt="Blog"/>

                        <p>It is a long established fact that a reader will be distracted by the readable content of a
                            page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less normal distribution of letters, as posed to using Content here, content here',
                            making it look like readable</p>
                    </div>

                    <div class="post-footer d-block d-sm-flex justify-content-sm-between align-items-center">
                        <ul class="tags">
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Sale</a></li>
                            <li><a href="#">Investment</a></li>
                        </ul>

                        <div class="post-share mt-3 mt-sm-0">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-reddit"></i></a>
                            <a href="#"><i class="fa fa-digg"></i></a>
                        </div>
                    </div>
                </article>

                <!-- Comment Area Start -->
                <div class="comment-area-wrapper">
                    <div class="comments-preview-area comment-single-item">
                        <h2>Comments (3)</h2>

                        <div class="single-comment d-block d-md-flex">
                            <div class="comment-author">
                                <a href="#"><img src="assets/img/author-1.jpg" class="img-fluid"
                                                 alt="Comment User"/></a>
                            </div>
                            <div class="comment-info mt-3 mt-md-0">
                                <div class="comment-info-top d-flex justify-content-between">
                                    <h3>Houdai Man</h3>
                                    <a href="#" class="btn-add-to-cart"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                                <a href="#" class="comment-date">19 JULY 2017, 10:05 PM</a>
                                <p>On the other hand, we with righteous indignation and dislike men ware sobeguil andlo
                                    demized by the charms of pleasure of the moment.</p>
                            </div>
                        </div>

                        <div class="single-comment reply d-block d-md-flex">
                            <div class="comment-author">
                                <a href="#"><img src="assets/img/author-2.jpg" class="img-fluid"
                                                 alt="Comment User"/></a>
                            </div>
                            <div class="comment-info mt-3 mt-md-0">
                                <div class="comment-info-top d-flex justify-content-between">
                                    <h3>Alex Tuntuni</h3>
                                    <a href="#" class="btn-add-to-cart"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                                <a href="#" class="comment-date">19 JULY 2017, 10:05 PM</a>
                                <p>On the other hand indignation and dislike men ware sobeguil andlo demized by the
                                    charms of pleasure of the moment.</p>
                            </div>
                        </div>

                        <div class="single-comment d-block d-md-flex">
                            <div class="comment-author">
                                <a href="#"><img src="assets/img/author-3.jpg" class="img-fluid"
                                                 alt="Comment User"/></a>
                            </div>
                            <div class="comment-info mt-3 mt-md-0">
                                <div class="comment-info-top d-flex justify-content-between">
                                    <h3>Dig Kamla</h3>
                                    <a href="#" class="btn-add-to-cart"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                                <a href="#" class="comment-date">19 JULY 2017, 10:05 PM</a>
                                <p>On the other hand, we with righteous indignation and dislike men ware sobeguil andlo
                                    demized by the charms of pleasure of the moment.</p>
                            </div>
                        </div>
                    </div>

                    <div class="leave-comment-area comment-single-item">
                        <h2>Leave a Comment</h2>
                        <div class="comment-form-wrap">
                            <form action="#" method="get">
                                <div class="single-input-item">
                                    <textarea name="comment" id="comment" cols="30" rows="6"
                                              placeholder="Write your Comment"></textarea>
                                </div>

                                <div class="single-input-item">
                                    <input type="url" placeholder="Website" required/>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="text" placeholder="Name" required/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="email" placeholder="Email Address" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-input-item">
                                    <button type="submit" class="btn-add-to-cart">Submit Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Blog Page Content End -->

            <!-- Sidebar Area Start -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div id="sidebar-area-wrap">
                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">Search</h2>
                        <div class="sidebar-body">
                            <div class="sidebar-search">
                                <form action="#">
                                    <input type="search" placeholder="type keyword"/>
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->

                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">Recent Posts</h2>
                        <div class="sidebar-body">
                            <div class="small-product-list recent-post">
                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="#"><img class="img-fluid" src="assets/img/product-2.jpg"
                                                         alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-blog.html">Lorem ipsum is dolor sit amet, consectetur
                                            adipisicing elit.</a></h2>
                                        <span class="price">20, Aug 2018</span>
                                        <a href="#" class="btn-add-to-cart">Read More <i
                                                class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>

                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="#"><img class="img-fluid" src="assets/img/product-3.jpg"
                                                         alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="#">Set of Sprite Yoga Lorem ipsum dolor sit Straps</a></h2>
                                        <span class="price">20, Aug 2018</span>
                                        <a href="#" class="btn-add-to-cart">Read More <i
                                                class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>

                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="#"><img class="img-fluid" src="assets/img/product-4.jpg"
                                                         alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-blog.html">Lorem ipsum is dolor sit amet, consectetur
                                            adipisicing elit.</a></h2>
                                        <span class="price">20, Aug 2018</span>
                                        <a href="#" class="btn-add-to-cart">Read More <i
                                                class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->

                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">Categories</h2>
                        <div class="sidebar-body">
                            <ul class="sidebar-list">
                                <li><a href="#">Tops &amp; Tees</a></li>
                                <li><a href="#">Polo Short Sleeve</a></li>
                                <li><a href="#">Graphic T-Shirts</a></li>
                                <li><a href="#">Jackets &amp; Coats</a></li>
                                <li><a href="#">Fashion Jackets</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->

                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">Popular Tags</h2>
                        <div class="sidebar-body">
                            <ul class="tags">
                                <li><a href="#">Tops</a></li>
                                <li><a href="#">Tees</a></li>
                                <li><a href="#">Polo</a></li>
                                <li><a href="#">T-Shirts</a></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Jeans</a></li>
                                <li><a href="#">Pants</a></li>
                                <li><a href="#">Necessitatibus</a></li>
                                <li><a href="#">Jackets</a></li>
                                <li><a href="#">Coats</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->
                </div>
            </div>
            <!-- Sidebar Area End -->
        </div>
    </div>
</div>
<!--== Page Content Wrapper End ==-->

<!-- Footer Area Start -->
<footer id="footer-area">
    <!-- Footer Call to Action Start -->
    <div class="footer-callto-action">
        <div class="ruby-container">
            <div class="callto-action-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <!-- Single Call-to Action Start -->
                        <div class="single-callto-action d-flex">
                            <figure class="callto-thumb">
                                <img src="assets/img/air-plane.png" alt="WorldWide Shipping"/>
                            </figure>
                            <div class="callto-info">
                                <h2>Free Shipping Worldwide</h2>
                                <p>On order over $150 - 7 days a week</p>
                            </div>
                        </div>
                        <!-- Single Call-to Action End -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Single Call-to Action Start -->
                        <div class="single-callto-action d-flex">
                            <figure class="callto-thumb">
                                <img src="assets/img/support.png" alt="Support"/>
                            </figure>
                            <div class="callto-info">
                                <h2>24/7 CUSTOMER SERVICE</h2>
                                <p>Call us 24/7 at 000 - 123 - 456k</p>
                            </div>
                        </div>
                        <!-- Single Call-to Action End -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Single Call-to Action Start -->
                        <div class="single-callto-action d-flex">
                            <figure class="callto-thumb">
                                <img src="assets/img/money-back.png" alt="Money Back"/>
                            </figure>
                            <div class="callto-info">
                                <h2>MONEY BACK Guarantee!</h2>
                                <p>Send within 30 days</p>
                            </div>
                        </div>
                        <!-- Single Call-to Action End -->
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Single Call-to Action Start -->
                        <div class="single-callto-action d-flex">
                            <figure class="callto-thumb">
                                <img src="assets/img/cog.png" alt="Guide"/>
                            </figure>
                            <div class="callto-info">
                                <h2>SHOPPING GUIDE</h2>
                                <p>Quis Eum Iure Reprehenderit</p>
                            </div>
                        </div>
                        <!-- Single Call-to Action End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Call to Action End -->

    <!-- Footer Follow Up Area Start -->
    <div class="footer-followup-area">
        <div class="ruby-container">
            <div class="followup-wrapper">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="follow-content-wrap">
                            <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="logo"/></a>
                            <p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum</p>

                            <div class="footer-social-icons">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-flickr"></i></a>
                            </div>

                            <a href="#"><img src="assets/img/payment.png" alt="Payment Method"/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Follow Up Area End -->

    <!-- Footer Image Gallery Area Start -->
    <div class="footer-image-gallery">
        <div class="ruby-container">
            <div class="image-gallery-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="imgage-gallery-carousel owl-carousel">
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-1.jpg" alt="Gallery"/></a>
                            </div>
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-2.jpg" alt="Gallery"/></a>
                            </div>
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-3.jpg" alt="Gallery"/></a>
                            </div>
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-4.jpg" alt="Gallery"/></a>
                            </div>
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-3.jpg" alt="Gallery"/></a>
                            </div>
                            <div class="gallery-item">
                                <a href="#"><img src="assets/img/gallery-img-2.jpg" alt="Gallery"/></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Image Gallery Area End -->

    <!-- Copyright Area Start -->
    <div class="copyright-area">
        <div class="ruby-container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright Area End -->

</footer>
<!-- Footer Area End -->

<!-- Scroll to Top Start -->
<a href="#" class="scrolltotop"><i class="fa fa-angle-up"></i></a>
<!-- Scroll to Top End -->


<!--=======================Javascript============================-->
<!--=== Jquery Min Js ===-->
<script src="admin-page/view/assets/js/jquery-3.6.0.min.js"></script>
<!--=== Jquery Migrate Min Js ===-->
<script src="assets/js/vendor/jquery-migrate-1.4.1.min.js"></script>
<!--=== Popper Min Js ===-->
<script src="assets/js/vendor/popper.min.js"></script>
<!--=== Bootstrap Min Js ===-->
<script src="assets/js/vendor/bootstrap.min.js"></script>
<!--=== Plugins Min Js ===-->
<script src="assets/js/plugins.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!--=== Active Js ===-->
<script src="assets/js/active.js"></script>

<script>
            function LoginManager(event){
            var EmailLoginManager = $('#EmailLoginManager').val();
            var passloginManager = $('#passloginManager').val();
            event.preventDefault();
            $.ajax({
                url: '../controller/signin_controller.php',
                type: 'POST',
                data: {
                    email: EmailLoginManager,
                    password: passloginManager,
                    login_manager: true
                },
                success: function(response){
                    console.log(response);
                    if(response == 'success'){
                        toastr.success('Đăng nhập thành công!', 'Thành công', {
                        timeOut: 1500, 
                        progressBar: true, 
                        positionClass: 'toast-top-right'
                    });
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 1500);
                    }
                    else{
                        toastr.error('Lỗi trong quá trình đăng nhập!', 'Lỗi', {
                            timeOut: 3000, 
                            progressBar: true, 
                            positionClass: 'toast-top-right'
                        });
                        return;
                    }
                }
            });
            
        }
function AddSaleCart(event) {
    var Emailinsert = $('#email_login_insert_cart').val();
    event.preventDefault();
    $.ajax({
        url: './admin-page/controller/signin_controller.php',
        type: 'POST',
        data: {
            login_status: 'check_login' 
        },
        success: function(response) {
            console.log(response);
            if (response == 'logged_in') { 
                $.ajax({
                    url: './admin-page/controller/signin_controller.php',
                    type: 'POST',
                    data: {
                        email: Emailinsert,
                        insert_salecart: true
                    },
                    success: function(response) {
                        console.log(response);
                        if (response === 'success') {
                            toastr.success('Đã gửi thông tin sản phẩm', 'Thành công', {
                                timeOut: 1500,
                                progressBar: true,
                                positionClass: 'toast-top-right'
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            toastr.error('Lỗi trong quá trình gửi thông tin!', 'Lỗi', {
                                timeOut: 3000,
                                progressBar: true,
                                positionClass: 'toast-top-right'
                            });
                        }
                    }
                });
            } else { // Nếu chưa đăng nhập
                toastr.error('Bạn chưa đăng nhập!', 'Lỗi', {
                    timeOut: 3000,
                    progressBar: true,
                    positionClass: 'toast-top-right'
                });
                setTimeout(() => {
                    window.location.href = 'login-register.php'; // Điều hướng đến trang đăng nhập
                }, 3000);
            }
        }
    });
}

</script>
</body>

</html>