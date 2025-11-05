function loadQuickView(product) {
    var prices;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'GET',
        url: '/webservice/check-product/' + product.id,
        async: false,

        success: function (data) {
            prices = data.data.cartItems;
        }
    });


    $('#quickViewModal').modal('show');
    document.getElementById("quickViewName").innerHTML = product.name;
    document.getElementById("quickViewDescription").innerHTML = product.description;
    document.getElementById("quickViewModalImage").src = product.image;
    var html = '<div class="price-table"><table class="table"><thead><tr><th>Size</th><th>Price</th><th>Options</th> <th>Total In Cart</th> </tr></thead>';
    prices.forEach(function (price) {

        html += "<tbody><tr class=product-box-contain'><td>" + price.size + "</td><td>" + price.fprice
            + "</td> <td><div class='cart_qty'> <div id='pricebutton' class='input-group'> <button type='button' onclick='reduceQuantity(" + price.id + ")'  class='btn qty-left-minus' data-type='minus' data-field=''><i class='fa fa-minus ms-0' aria-hidden='true'></i></button> <input  class='form-control input-text qty-input'  id=cartquantity" + price.id + "  type='number' name='quantity' value='1'> <button type='button' class='btn qty-right-plus' data-type='plus' onclick='addQuantity(" + price.id + ")'  data-field=''> <i class='fa fa-plus ms-0' aria-hidden='true'></i> </button></div> </div></td> <td id=carttotal" + price.id + " >" + price.total + "</td> </tr></tbody";
    });
    html += '</table></div>';
    document.getElementById('quickViewContainer').innerHTML = html;
}

function reduceQuantity(price_id) {
    var quantity = document.getElementById('cartquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/cart/reduce-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            var image = data.data.image;
            var itemNewTotal = data.data.itemNewTotal;
            document.getElementById('carttotal' + price_id).innerHTML = itemNewTotal;
            document.getElementById("addedTotCartMessage").innerHTML = data.message;
            document.getElementById("addedToCartImage").src = image;
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            document.getElementById("cartGrandTotalCost").innerHTML = data.data.cartGrandTotalCost;
            $(".add-cart-box-quick-view").removeClass("addCartHide");
            setTimeout(function () {
                console.log('added to car');
                $(".add-cart-box-quick-view").addClass("addCartHide");
            }, 5000);

        }
    });



}

function addQuantity(price_id) {
    var quantity = document.getElementById('cartquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cart/add-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            var image = data.data.image;
            var itemNewTotal = data.data.itemNewTotal;
            document.getElementById('carttotal' + price_id).innerHTML = itemNewTotal;
            document.getElementById("addedTotCartMessage").innerHTML = data.message;
            document.getElementById("addedToCartImage").src = image;
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            document.getElementById("cartGrandTotalCost").innerHTML = data.data.cartGrandTotalCost;
            $(".add-cart-box-quick-view").removeClass("addCartHide");
            setTimeout(function () {
                console.log('added to car');
                $(".add-cart-box-quick-view").addClass("addCartHide");
            }, 5000);

        }
    });
}
function reduceQuantityProductPage(price_id) {
    var quantity = document.getElementById('cartquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/cart/reduce-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            var image = data.data.image;
            var itemNewTotal = data.data.itemNewTotal;
            document.getElementById('carttotal' + price_id).innerHTML = itemNewTotal;
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            showSuccessNotifier(data.message);

        }
    });



}

function addQuantityProductPage(price_id) {
    var quantity = document.getElementById('cartquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cart/add-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            var image = data.data.image;
            var itemNewTotal = data.data.itemNewTotal;
            document.getElementById('carttotal' + price_id).innerHTML = itemNewTotal;
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            showSuccessNotifier(data.message);


        }
    });
}

function addQuantityOnHome(price_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cart/add-item',
        data: {
            price_id: price_id,
        },
        success: function (data) {
            // var image = data.data.image;
            // var itemNewTotal = data.data.itemNewTotal;
            showSuccessNotifier(data.message);
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            document.getElementById("cartGrandTotalCost").innerHTML = data.data.cartGrandTotalCost;
        }
    });
}



function addQuantityOnHomeButtons(price_id) {
    var quantity = document.getElementById('homeviewquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cart/add-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            showSuccessNotifier(data.message);
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            document.getElementById("cartGrandTotalCost").innerHTML = data.data.cartGrandTotalCost;
        }
    });
}
function reduceQuantityOnHomeButtons(price_id) {
    var quantity = document.getElementById('homeviewquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cart/reduce-item',
        data: {
            price_id: price_id,
            quantity: quantity,
        },
        success: function (data) {
            showSuccessNotifier(data.message);
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            document.getElementById("cartGrandTotalCost").innerHTML = data.data.cartGrandTotalCost;
        }
    });
}


function loadOrder(order_id) {



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/dashboard/get-order-details',
        data: {
            order_id: order_id

        },

        success: function (data) {
            document.getElementById("rowdiv").innerHTML = data.items;
            document.getElementById("fetched_order_id").innerHTML = data.order.mask;
            document.getElementById("fetched_order_date").innerHTML = data.order.placed_on;
            document.getElementById("fetched_order_status").innerHTML = data.order.status;
            document.getElementById("fetched_order_total_cost").innerHTML = '₵' + data.order.total_amount;
            document.getElementById("fetched_order_total_items").innerHTML = data.order.total_items;
            // $("#rowdiv").html(html).show();
        }
    });
}
function showSuccessNotifier(message) {

    $.notify({
        icon: "fa fa-check",
        title: "Success!",
        message: message,
    }, {
        element: "body",
        position: null,
        type: "info",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: true,
        placement: {
            from: "top",
            align: "right",
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp",
        },
        icon_type: "class",
        template: '<div data-notify="container" class="col-xxl-3 col-lg-5 col-md-6 col-sm-7 col-12 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-info progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            "</div>" +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            "</div>",
    })

    getCartItemsTable();
}



function searchItem() {
    var search_name = document.getElementById('search_item').value;

    search_name = encodeURIComponent(search_name).replace('  ', '+');
    const url = '/search-results/?product=' + search_name


    window.location.replace(url);
    // window.location.replace("/search-results/?product=" + search_name);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/search/find-item',
        data: {
            search_name: search_name,

        },
        success: function (data) {
            // showSuccessNotifier(data.message);

        }
    });
}

function getCartItemsTable() {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: '/webservice/get-cart-items-table',
        data: {},
        success: function (data) {
            document.getElementById("cartNew").innerHTML = data.cartProductsTable;
        }
    });
}

/// wishlit functions
function AddToWishlist(price_id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/wishlist/add-item',
        data: {
            price_id: price_id,
        },
        success: function (data) {

            showSuccessNotifier(data.message);
            // setTimeout(function () {
            //     console.log('added to car');
            //     $(".add-cart-box-quick-view").addClass("addCartHide");
            // }, 5000);

        }
    });
}


function removeWishlistItem(wishlist_item_id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/wishlist/remove-item',
        data: {
            wishlist_item_id: wishlist_item_id,

        },
        success: function (data) {

            showSuccessNotifier(data.message);
            setTimeout(function () {
                location.reload();
            }, 3000);

        }
    });



}
function removeCartRow(cart_row_id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/cartpage/delete-row',
        data: {
            cart_row_id: cart_row_id,

        },
        success: function (data) {

            showSuccessNotifier(data.message);
            setTimeout(function () {
                location.reload();
            }, 1000);

        }
    });



}

function keepAlerts() {

    $(".add-cart-box-quick-view").removeClass("addCartHide");
    setTimeout(function () {
        console.log('added to car');
        $(".add-cart-box-quick-view").addClass("addCartHide");
    }, 5000);
    // $(".add-cart-box").addClass("show");
    // setTimeout(function () {
    //     console.log('added to car');
    //     $(".add-cart-box").removeClass("show");
    // }, 5000);
}