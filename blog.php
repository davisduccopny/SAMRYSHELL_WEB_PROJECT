<?php 
    require_once('admin-page/config/database.php');
    require_once('admin-page/model/blog_model.php');
    $blogModel = new BlogModel($conn);
    $showBlog = $blogModel->showBlog();
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">
<?php require_once('main/head.php'); ?>
<body>
<!--== Header Area Start ==-->
<?php require_once('main/header.php'); ?>
<!--== Header Area End ==-->

<!--== Search Box Area Start ==-->
<?php require_once('main/search_box.php'); ?>
<!--== Search Box Area End ==-->

<!--== Page Title Area Start ==-->
<div id="page-title-area">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="page-title-content">
                    <h1>Blog</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="blog.php" class="active">Blog</a></li>
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
            <!-- Blog Page Content Start -->
            <div class="col-lg-8">
                <div class="blog-content-wrap">
                    <!-- Single Blog Item Start -->
                    <?php foreach ($products as $product): ?>
                    <div class="single-blog-wrap">
                        <figure class="blog-thumb">
                            <a href="single-blog.php"><img src="assets/img/blog-thumb.jpg" alt="blog"
                                                            class="img-fluid"/></a>
                            <figcaption class="blog-icon">
                                <a href="single-blog.php"><i class="fa fa-file-image-o"></i></a>
                            </figcaption>
                        </figure>

                        <div class="blog-details">
                            <h3><a href="single-blog.php">Mirum est notare quam</a></h3>
                            <span class="post-date">20/June/2018</span>
                            <p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit
                                litterarum. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur
                                debitis, deserunt distinctio doloremque explicabo fuga maiores necessitatibus quisquam
                                quos repudiandae suscipit tempore totam voluptatibus.</p>
                            <a href="single-blog.php" class="btn-long-arrow">Read More</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- Single Blog Item End -->

                    <!-- Single Blog Item Start -->
                    <div class="single-blog-wrap">
                        <figure class="blog-thumb">
                            <a href="single-blog.php"><img src="assets/img/blog-thumb-2.jpg" alt="blog"
                                                            class="img-fluid"/></a>
                            <figcaption class="blog-icon">
                                <a href="single-blog.php"><i class="fa fa-file-image-o"></i></a>
                            </figcaption>
                        </figure>

                        <div class="blog-details">
                            <h3><a href="single-blog.php">Mirum est notare quam</a></h3>
                            <span class="post-date">20/June/2018</span>
                            <p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit
                                litterarum. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur
                                debitis, deserunt distinctio doloremque explicabo fuga maiores necessitatibus quisquam
                                quos repudiandae suscipit tempore totam voluptatibus.</p>
                            <a href="single-blog.php" class="btn-long-arrow">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog Item End -->

                    <!-- Single Blog Item Start -->
                    <div class="single-blog-wrap">
                        <figure class="blog-thumb">
                            <a href="single-blog.php"><img src="assets/img/blog-thumb-3.jpg" alt="blog"
                                                            class="img-fluid"/></a>
                            <figcaption class="blog-icon">
                                <a href="single-blog.php"><i class="fa fa-file-image-o"></i></a>
                            </figcaption>
                        </figure>

                        <div class="blog-details">
                            <h3><a href="single-blog.php">Mirum est notare quam</a></h3>
                            <span class="post-date">20/June/2018</span>
                            <p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit
                                litterarum. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequuntur
                                debitis, deserunt distinctio doloremque explicabo fuga maiores necessitatibus quisquam
                                quos repudiandae suscipit tempore totam voluptatibus.</p>
                            <a href="single-blog.php" class="btn-long-arrow">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog Item End -->
                </div>

                <!--  Pagination Area Start -->
                <div class="page-pagination mt-5 pt-5">
                    <ul class="pagination justify-content-center">
                        <li><a href="#" aria-label="Previous">«</a></li>
                        <li><a class="current" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">....</a></li>
                        <li><a href="#">88</a></li>
                        <li><a href="#" aria-label="Next">»</a></li>
                    </ul>
                </div>
                <!--  Pagination Area End -->
            </div>
            <!-- Blog Page Content End -->

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
                                        <h2><a href="single-blog.php">Lorem ipsum is dolor sit amet, consectetur
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
                                        <h2><a href="single-blog.php">Lorem ipsum is dolor sit amet, consectetur
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
<?php require_once('./footter.php'); ?>
<!-- Footer Area End -->

<!-- Scroll to Top Start -->
<a href="#" class="scrolltotop"><i class="fa fa-angle-up"></i></a>
<!-- Scroll to Top End -->


<!--=======================Javascript============================-->
<!--=== Jquery Min Js ===-->
<script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
<!--=== Jquery Migrate Min Js ===-->
<script src="assets/js/vendor/jquery-migrate-1.4.1.min.js"></script>
<!--=== Popper Min Js ===-->
<script src="assets/js/vendor/popper.min.js"></script>
<!--=== Bootstrap Min Js ===-->
<script src="assets/js/vendor/bootstrap.min.js"></script>
<!--=== Plugins Min Js ===-->
<script src="assets/js/plugins.js"></script>

<!--=== Active Js ===-->
<script src="assets/js/active.js"></script>
</body>

</html>