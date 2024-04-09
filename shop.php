<?php 
require './admin-page/config/database.php';
require './admin-page/model/product_model.php';
require './admin-page/model/cagegoryproduct_model.php';
require 'controller/cart_controller.php';
$productModel = new ProductModel($conn);
$products= $productModel->showProduct();
$categoryproductModel = new CategoryProductModel($conn);
$categorylist = $categoryproductModel->showCategoryProducts()
?>
<!DOCTYPE html>
<html lang="zxx">

<?php require_once('main/head.php'); ?>
<body>
<!--== Header Area Start ==-->
<?php require_once('main/header.php');?>
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
                    <h1>Shop</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#" class="active">Shop</a></li>
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
            <!-- Sidebar Area Start -->
            <div class="col-lg-3 mt-5 mt-lg-0 order-last order-lg-first">
                <div id="sidebar-area-wrap">
                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">Shop By</h2>
                        <div class="sidebar-body">
                            <div class="shopping-option">
                                <h3>Shopping Options</h3>
                                <div class="shopping-option-item">
                                    <h4>Color</h4>
                                    <ul class="color-option-select d-flex">
                                        <li class="color-item black">
                                            <div class="color-hvr">
                                                <span class="color-fill"></span>
                                                <span class="color-name">Black</span>
                                            </div>
                                        </li>

                                        <li class="color-item green">
                                            <div class="color-hvr">
                                                <span class="color-fill"></span>
                                                <span class="color-name">green</span>
                                            </div>
                                        </li>

                                        <li class="color-item red">
                                            <div class="color-hvr">
                                                <span class="color-fill"></span>
                                                <span class="color-name">red</span>
                                            </div>
                                        </li>

                                        <li class="color-item yellow">
                                            <div class="color-hvr">
                                                <span class="color-fill"></span>
                                                <span class="color-name">yellow</span>
                                            </div>
                                        </li>

                                        <li class="color-item orange">
                                            <div class="color-hvr">
                                                <span class="color-fill"></span>
                                                <span class="color-name">Orange</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="shopping-option-item">
                                    <h4>MANUFACTURER</h4>
                                    <ul class="sidebar-list">
                                        <?php foreach ($categorylist as $category): ?>
                                        <li><a href="<?php echo "shopfilter.php?category=".$category['categoryproduct_id']; ?>"><?php echo $category['name']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                    <style> 
                                    .price-filter {
                                display: flex;
                                align-items: center;
                            }

                            .price-input {
                                width: 50%;
                                padding: 8px;
                                margin-right: 10px;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                            }

                            .price-separator {
                                margin-right: 10px;
                            }

                            .filter-btn {
                                padding: 8px 16px;
                                background-color: #f5740a;
                                color: #fff;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                            }

                            .filter-btn:hover {
                                background-color: #0056b3;
                            }
                            </style>
                                <div class="shopping-option-item">
                                    <h4>Price</h4>
                                    <div class="price-filter">
                                        <input type="text" id="minPrice" placeholder="Min price" class="price-input">
                                        <span class="price-separator">-</span>
                                        <input type="text" id="maxPrice" placeholder="Max price" class="price-input">
                                        <button id="filterBtn" class="filter-btn">Filter</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->

                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">My Wish List</h2>
                        <div class="sidebar-body">
                            <div class="small-product-list">
                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="#"><img class="mr-2 img-fluid" src="assets/img/product-2.jpg"
                                                         alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-product.php">Sprite Yoga Companion Kit</a></h2>
                                        <span class="price">$6.00</span>

                                    </div>
                                </div>

                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="single-product.php"><img class="mr-2 img-fluid"
                                                                           src="assets/img/product-3.jpg"
                                                                           alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-product.php">Set of Sprite Yoga Straps</a></h2>
                                        <span class="price">$88.00</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->

                    <!-- Single Sidebar Item Start -->
                    <div class="single-sidebar-wrap">
                        <h2 class="sidebar-title">MOSTVIEWED PRODUCTS</h2>
                        <div class="sidebar-body">
                            <div class="small-product-list">
                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="single-product.php"><img class="mr-2 img-fluid"
                                                                           src="assets/img/product-1.jpg"
                                                                           alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-product.php">Beginner's Yoga</a></h2>
                                        <span class="price">$50.00</span>
                                    </div>
                                </div>

                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="single-product.php"><img class="mr-2 img-fluid"
                                                                           src="assets/img/product-2.jpg"
                                                                           alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-product.php">Sprite Yoga Companion Kit</a></h2>
                                        <span class="price">$6.00</span>
                                    </div>
                                </div>

                                <div class="single-product-item">
                                    <figure class="product-thumb">
                                        <a href="single-product.php"><img class="mr-2 img-fluid"
                                                                           src="assets/img/product-3.jpg"
                                                                           alt="Products"/></a>
                                    </figure>
                                    <div class="product-details">
                                        <h2><a href="single-product.php">Set of Sprite Yoga Straps</a></h2>
                                        <span class="price">$88.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar Item End -->
                </div>
            </div>
            <!-- Sidebar Area End -->

            <!-- Shop Page Content Start -->
            <div class="col-lg-9">
                <div class="shop-page-content-wrap">
                    <div class="products-settings-option d-block d-md-flex">
                        <div class="product-cong-left d-flex align-items-center">
                            <ul class="product-view d-flex align-items-center">
                                <li class="current column-gird"><i class="fa fa-bars fa-rotate-90"></i></li>
                                <li class="box-gird"><i class="fa fa-th"></i></li>
                                <li class="list"><i class="fa fa-list-ul"></i></li>
                            </ul>
                            <span class="show-items">Items 1 - 9 of 17</span>
                        </div>

                        <div class="product-sort_by d-flex align-items-center mt-3 mt-md-0">
                            <label for="sort">Sort By:</label>
                            <select name="sort" id="sort">
                                <option value="Position">Relevance</option>
                                <option value="Name Ascen">Name, A to Z</option>
                                <option value="Name Decen">Name, Z to A</option>
                                <option value="Price Ascen">Price low to heigh</option>
                                <option value="Price Decen">Price heigh to low</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="shop-page-products-wrap">
                        <div class="products-wrapper">
                            <div class="row">
                            <?php foreach ($products as $product): ?>
                                <div class="col-lg-4 col-sm-6" id="<?php echo $product['id']  ?>">
                                    <!-- Single Product Item -->
                                    <div class="single-product-item text-center">
                                        <figure class="product-thumb">
                                            <a href="<?php echo "single-product.php?productid=".$product['id']  ?>"><img src="<?php
                                    $strfirt = './admin-page';  
                                    echo  $strfirt.mb_substr($product['image'], 2); ?>"
                                                                               alt="<?php echo $product['name']; ?>" class="img-fluid"></a>
                                        </figure>

                                        <div class="product-details">
                                            <h2><a href="<?php echo "single-product.php?productid=".$product['id']  ?>"><?php echo $product['name']; ?></a></h2>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                            <span class="price">$<?php echo $product['price']; ?></span>
                                            <p class="products-desc">Ideal for cold-weathered training worked lorem
                                                outdoors, the Chaz Hoodie promises superior warmth with every wear.
                                                Thick material blocks out the wind as ribbed cuffs and bottom band seal
                                                in body heat.</p>
                                            <a href="<?php echo "single-product.php?productid=".$product['id'];  ?>" class="btn btn-add-to-cart">+ Add to Cart</a>
                                            <a href="<?php echo "single-product.php?productid=".$product['id']; ?>" class="btn btn-add-to-cart btn-whislist">+
                                                Wishlist</a>
                                            <a href="<?php echo "single-product.php?productid=".$product['id'];  ?>" class="btn btn-add-to-cart btn-compare">+
                                                Compare</a>
                                        </div>

                                        <div class="product-meta">
                                            <button type="button" class="button_showdetail" data-toggle="modal" data-target="#quickView" data-product-id="<?php echo $product['id']; ?>" >
                                    <span data-toggle="tooltip" data-placement="left" title="Quick View"><i
                                            class="fa fa-compress"></i></span>
                                            </button>
                                            <a href="#" data-toggle="tooltip" data-placement="left"
                                               title="Add to Wishlist"><i
                                                    class="fa fa-heart-o"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="left" title="Compare"><i
                                                    class="fa fa-tags"></i></a>
                                        </div>
                                        <span class="product-bedge">New</span>
                                    </div>
                                    <!-- Single Product Item -->
                                </div>
                            <?php endforeach; ?>


                                
                            </div>
                        </div>
                    </div>


                    <div class="products-settings-option d-block d-md-flex">
                        <nav class="page-pagination">
                            <div id="pagination-container">
                            </div>
                        </nav>
                                    <script>
                                // Số sản phẩm trên mỗi trang
                            function setupPagination() {
                                var productsPerPage = 9;
                                var totalProducts = document.querySelectorAll('.col-lg-4.col-sm-6').length;
                                var totalPages = Math.ceil(totalProducts / productsPerPage);
                                var currentPage = 1;

                                function createPaginationButtons() {
                                var paginationContainer = document.getElementById('pagination-container');
                                var paginationList = document.createElement('ul');
                                paginationList.classList.add('pagination');

                                var prevButton = document.createElement('li');
                                var prevLink = document.createElement('a');
                                prevLink.href = '#';
                                prevLink.id = 'prevPage';
                                prevLink.setAttribute('aria-label', 'Previous');
                                prevLink.innerHTML = '&laquo;';
                                prevButton.appendChild(prevLink);
                                paginationList.appendChild(prevButton);

                                for (var i = 1; i <= totalPages; i++) {
                                    var pageButton = document.createElement('li');
                                    var pageLink = document.createElement('a');
                                    pageLink.href = '#';
                                    pageLink.id = 'page' + i;
                                    pageLink.textContent = i;
                                    pageButton.appendChild(pageLink);
                                    paginationList.appendChild(pageButton);
                                }

                                var nextButton = document.createElement('li');
                                var nextLink = document.createElement('a');
                                nextLink.href = '#';
                                nextLink.id = 'nextPage';
                                nextLink.setAttribute('aria-label', 'Next');
                                nextLink.innerHTML = '&raquo;';
                                nextButton.appendChild(nextLink);
                                paginationList.appendChild(nextButton);

                                paginationContainer.appendChild(paginationList);

                                var pageLinks = document.querySelectorAll('.pagination li a');
                                pageLinks.forEach(function(pageLink) {
                                    pageLink.addEventListener('click', function(event) {
                                        event.preventDefault();
                                        var targetPage = event.target.id;
                                        if (targetPage === 'prevPage') {
                                            goToPage(currentPage - 1);
                                        } else if (targetPage === 'nextPage') {
                                            goToPage(currentPage + 1);
                                        } else {
                                            var pageNumber = parseInt(event.target.textContent);
                                            goToPage(pageNumber);
                                        }
                                    });
                                });
                                }
                                function updateItemsInfo(startIndex, endIndex, totalProducts) {
                                    var startItem = startIndex + 1;
                                    var endItem = Math.min(endIndex, totalProducts);
                                    var itemsInfo = document.querySelector('.show-items');
                                    itemsInfo.textContent = "Items " + startItem + " - " + endItem + " of " + totalProducts;
                                }

                                function goToPage(pageNumber) {
                                currentPage = pageNumber;
                                hideAllProducts();
                                var startIndex = (pageNumber - 1) * productsPerPage;
                                var endIndex = Math.min(startIndex + productsPerPage, totalProducts);
                                showProducts(startIndex, endIndex);
                                updateItemsInfo(startIndex, endIndex, totalProducts);   
                                }

                                function hideAllProducts() {
                                var products = document.querySelectorAll('.col-lg-4.col-sm-6');
                                products.forEach(function(product) {
                                    product.style.display = 'none';
                                });
                                }

                                function showProducts(startIndex, endIndex) {
                                var products = document.querySelectorAll('.col-lg-4.col-sm-6');
                                for (var i = startIndex; i < endIndex; i++) {
                                    products[i].style.display = 'block';
                                }
                                }

                                createPaginationButtons();
                                goToPage(1);
                            };

                            setupPagination();

                            document.getElementById('filterBtn').addEventListener('click', function() {
                                var minPrice = parseFloat(document.getElementById('minPrice').value);
                                var maxPrice = parseFloat(document.getElementById('maxPrice').value);
                                var category = null;
                                function filterProductsByPrice(minPrice, maxPrice) {
                                    // Kiểm tra nếu minPrice hoặc maxPrice không hợp lệ thì không điều hướng
                                    if (isNaN(minPrice) || isNaN(maxPrice) || minPrice < 0 || maxPrice < 0 || minPrice > maxPrice) {
                                        alert("Vui lòng nhập giá trị minprice và maxprice hợp lệ.");
                                        return;
                                    }

                                    // Đường dẫn tới trang shopfilter với các tham số minprice và maxprice
                                    var url = "shopfilter.php?minprice=" + minPrice + "&maxprice=" + maxPrice;

                                    // Điều hướng đến trang mới với các tham số đã lọc
                                    window.location.href = url;
                                }
                                filterProductsByPrice(minPrice, maxPrice);
                            });




                                </script>

                        <div class="product-per-page d-flex align-items-center mt-3 mt-md-0">
                            <label for="show-per-page">Show Per Page</label>
                            <select name="sort" id="show-per-page">
                                <option value="9">9</option>
                                <option value="15">15</option>
                                <option value="21">21</option>
                                <option value="6">27</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Shop Page Content End -->
        </div>
    </div>
</div>
<!--== Page Content Wrapper End ==-->

<!-- Footer Area Start -->
<?php require_once('main/footer.php'); ?> 
<!-- Footer Area End -->

<!-- Start All Modal Content -->
<!--== Product Quick View Modal Area Wrap ==-->
<?php require_once('main/model_view.php'); ?> 
<!--== Product Quick View Modal Area End ==-->
<!-- End All Modal Content -->

<!-- Scroll to Top Start -->
<a href="#" class="scrolltotop"><i class="fa fa-angle-up"></i></a>
<!-- Scroll to Top End -->


<!--=======================Javascript============================-->
<?php require_once('main/src_js.php'); ?>

</body>

</html>