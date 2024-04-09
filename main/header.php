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
                            <li ><a href="blog.php">Blog</a>
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
                                                    <a href="#"><img class="img-fluid" src="<?php
                                                        $strfirt = './admin-page';
                                                        echo  $strfirt . substr($product['image'], 2); ?>"
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