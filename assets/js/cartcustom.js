

function cartreduceQuantity(price_id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/webservice/cartpage/reduce-item',
        data: {
            price_id: price_id,
            quantity: 1,
            page: 'cart',
        },
        success: function (data) {


            var deleted = data.data.deleted;
            if (deleted) {
                showSuccessNotifier(data.message);
                setTimeout( function() { location.reload(); }, 3000);
                // setInterval(location.reload(), 5000);
            } else {
                var itemNewTotal = data.data.itemNewTotal;
                var itemNewTotalPrice = data.data.itemNewTotalPrice;
                var shippingCost = data.data.shippingCost;
                var cartGrandTotalPrice = data.data.cartGrandTotalPrice;
                document.getElementById('cartquantity' + price_id).value = itemNewTotal;
                document.getElementById('singlePriceTotal' + price_id).innerHTML = itemNewTotalPrice;
                document.getElementById('shippingSpan').innerHTML = shippingCost;
                document.getElementById('cartGrandTotalPrice').innerHTML = cartGrandTotalPrice;
                document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
                showSuccessNotifier(data.message);
            }
        }
    });



}

function cartaddQuantity(price_id) {
    // var quantity = document.getElementById('cartquantity' + price_id).value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/webservice/cartpage/add-item',
        data: {
            price_id: price_id,
            quantity: 1,
            page: 'cart'
        },
        success: function (data) {
            // var image = data.data.image;
            var itemNewTotal = data.data.itemNewTotal;
            var itemNewTotalPrice = data.data.itemNewTotalPrice;
            var shippingCost = data.data.shippingCost;
            var cartGrandTotalPrice = data.data.cartGrandTotalPrice;
            document.getElementById('cartquantity' + price_id).value = itemNewTotal;
            document.getElementById('singlePriceTotal' + price_id).innerHTML = itemNewTotalPrice;
            document.getElementById('shippingSpan').innerHTML = shippingCost;
            document.getElementById('cartGrandTotalPrice').innerHTML = cartGrandTotalPrice;
            document.getElementById("cartGrandTotal").innerHTML = data.data.cartGrandTotal;
            showSuccessNotifier(data.message);

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