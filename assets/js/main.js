function LoginManager(event) {
  var EmailLoginManager = $("#EmailLoginManager").val();
  var passloginManager = $("#passloginManager").val();
  event.preventDefault();
  $.ajax({
    url: "../controller/signin_controller.php",
    type: "POST",
    data: {
      email: EmailLoginManager,
      password: passloginManager,
      login_manager: true,
    },
    success: function (response) {
      console.log(response);
      if (response == "success") {
        toastr.success("Đăng nhập thành công!", "Thành công", {
          timeOut: 1500,
          progressBar: true,
          positionClass: "toast-top-right",
        });
        setTimeout(() => {
          window.location.href = "index.php";
        }, 1500);
      } else {
        toastr.error("Lỗi trong quá trình đăng nhập!", "Lỗi", {
          timeOut: 3000,
          progressBar: true,
          positionClass: "toast-top-right",
        });
        return;
      }
    },
  });
}
function AddSaleCart(event) {
  var Emailinsert = $("#email_login_insert_cart").val();
  event.preventDefault();
  $.ajax({
    url: "./admin-page/controller/signin_controller.php",
    type: "POST",
    data: {
      login_status: "check_login",
    },
    success: function (response) {
      console.log(response);
      if (response == "logged_in") {
        $.ajax({
          url: "./admin-page/controller/signin_controller.php",
          type: "POST",
          data: {
            email: Emailinsert,
            insert_salecart: true,
          },
          success: function (response) {
            console.log(response);
            if (response === "success") {
              toastr.success("Đã gửi thông tin sản phẩm", "Thành công", {
                timeOut: 1500,
                progressBar: true,
                positionClass: "toast-top-right",
              });
              setTimeout(() => {
                window.location.reload();
              }, 1500);
            } else {
              toastr.error("Lỗi trong quá trình gửi thông tin!", "Lỗi", {
                timeOut: 3000,
                progressBar: true,
                positionClass: "toast-top-right",
              });
            }
          },
        });
      } else {
        // Nếu chưa đăng nhập
        toastr.error("Bạn chưa đăng nhập!", "Lỗi", {
          timeOut: 3000,
          progressBar: true,
          positionClass: "toast-top-right",
        });
        setTimeout(() => {
          window.location.href = "login-register.php"; // Điều hướng đến trang đăng nhập
        }, 3000);
      }
    },
  });
}
    document.addEventListener("DOMContentLoaded", function () {
    const data_product_id = document.querySelectorAll('.button_showdetail[data-toggle="modal"]');
    const modalshowproduct =document.getElementById('quickView');
    const modalTableBody = modalshowproduct.querySelector('.modal-body');

    data_product_id.forEach(link => {
        link.addEventListener('click', event => {
        const product_id = link.getAttribute('data-product-id');
        console.log(product_id);
        fetchProductData(product_id);
        });
    });

    function fetchProductData(Product_id) {
        modalTableBody.innerHTML = '';
        fetch(`controller/modal_show_productAPI.php?action=getProductDetailsbyid&product_id=${Product_id}`)
            .then(response => response.json())
            .then(data => {
                  modalTableBody.innerHTML = '';
                const detail = data;
                
                const row = document.createElement('div');
                row.classList.add('quick-view-content', 'single-product-page-content');
                row.innerHTML = `
                    <div class="row">
                        <!-- Product Thumbnail Start -->
                        <div class="col-lg-5 col-md-6">
                             <div class="product-thumbnail-wrap">
                                <div class="product-thumb-carousel">
                                  <div class="single-thumb-item">
                                    <a href="single-product.php">
                                        <img class="img-fluid" src="${'admin-page/' + detail.images[0].substring(2)}" alt="Product"/>
                                    </a>
                                </div>

                                </div>
                            </div>
                        </div>
                        <!-- Product Details Start -->
                    <div class="col-lg-7 col-md-6 mt-5 mt-md-0">
                        <div class="product-details">
                            <h2><a href="single-product.php">${detail.name}</a></h2>

                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half"></i>
                                <i class="fa fa-star-o"></i>
                            </div>

                            <span class="price">$${detail.price}</span>
                            <input value ="${detail.id}"  id="idproduct_addcart" hidden>
                            <div class="product-info-stock-sku">
                                <span class="product-stock-status">In Stock</span>
                                <span class="product-sku-status ml-5"><strong>SKU</strong> ${detail.sku}</span>
                            </div>

                            <p class="products-desc">${detail.short_description}</p>
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

                                    <li class="color-item orange">
                                        <div class="color-hvr">
                                            <span class="color-fill"></span>
                                            <span class="color-name">Orange</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="product-quantity d-flex align-items-center">
                                <div class="quantity-field">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty" min="1" max="100" value="1"/>
                                </div>

                                <a href="#" class="btn btn-add-to-cart">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                        <!-- Product Details End -->
                    </div>
                `;
                modalTableBody.appendChild(row);
            })
            
            .catch(error => {
                console.error('Error fetching payment data:', error);
            });
    }


    

    });




