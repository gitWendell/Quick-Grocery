window.addEventListener("load", function () {
    var checkout = document.querySelector('.not-avail');

    $(document).on('click', '.cart-qty-reduce', function () {

        var _token = $('input[name="_token"]').val();

        var id = this.dataset.id;
        var store = this.dataset.store;
        var qty = this.dataset.qty;

        $.ajax({
            url: "/cart/reduce/" + id,
            method: "POST",
            data: {id: id, qty: qty, _token: _token},
            dataType: "json",
            success: function (data) {

                if (data['remove'] === 1) {
                    $("#cmm-" + store).remove();
                    $("#ccsn-" + store).remove();
                    document.getElementById("cart-details-" + id).remove();
                } else {
                    document.getElementById("cart-qty-input-" + id).value = data['qty'];
                    document.getElementById("qty-details-" + id).innerText = data['qty'];
                }

                if (data['store_total'] < 500) {
                    check(data, store);
                    document.getElementById("cart-checkout").href = "#";
                    document.getElementById("cart-checkout").classList.add("not-avail");
                }

                document.getElementById("cart-qty").innerText = data['total_qty'];
                document.getElementById("totalqty").innerText = data['total_qty'];
                document.getElementById("cart-subtotal").innerText = data['sub_total'];
                document.getElementById("store-total-" + store).innerText = data['store_total'];


            }
        });
    });

    $(document).on('click', '.cart-qty-increase', function () {

        var _token = $('input[name="_token"]').val();
        var id = this.dataset.id;
        var store = this.dataset.store;
        var qty = this.dataset.qty;

        $.ajax({
            url: "/cart/increase/" + id,
            method: "POST",
            data: {id: id, qty: qty, _token: _token},
            dataType: "json",
            success: function (data) {

                if (data['error'] === 1) {
                    swal("Oops something went wrong", data['message'], "error");
                }

                if (data['store_total'] < 500) {
                    check(data, store);
                    $("cart-checkout").href = "#";
                    document.getElementById("cart-checkout").classList.add("not-avail");
                } else {
                    $("#cmm-" + store).remove();
                    document.getElementById("cart-checkout").href = "/checkout";
                    document.getElementById("cart-checkout").classList.remove("not-avail");
                }

                document.getElementById("cart-qty-input-" + id).value = data['qty'];
                document.getElementById("qty-details-" + id).innerText = data['qty'];
                document.getElementById("cart-qty").innerText = data['total_qty'];
                document.getElementById("totalqty").innerText = data['total_qty'];
                document.getElementById("cart-subtotal").innerText = data['sub_total'];
                document.getElementById("store-total-" + store).innerText = data['store_total'];
            }
        });
    });

    $(document).on('change', '.cart-qty-input', function (e) {
        e.preventDefault();

        var _token = $('input[name="_token"]').val();
        var store = this.dataset.store;
        var id = this.dataset.id;
        var qty = this.value;

        $.ajax({
            url: "/cart/change/" + id,
            method: "POST",
            data: {id: id, qty: qty, _token: _token},
            dataType: "json",
            success: function (data) {

                if (data['remove'] === 1) {
                    $("#cmm-" + store).remove();
                    $("#ccsn-" + store).remove();
                    document.getElementById("cart-details-" + id).remove();
                } else if (data['error'] === 1) {
                    swal("Oops something went wrong", data['message'], "error");
                } else {
                    document.getElementById("cart-qty-input-" + id).value = data['qty'];
                    document.getElementById("qty-details-" + id).innerText = data['qty'];
                }

                if (data['store_total'] < 500) {
                    check(data, store);

                    document.getElementById("cart-checkout").href = "#";
                    document.getElementById("cart-checkout").classList.add("not-avail");
                } else {
                    $("#cmm-" + store).remove();
                    document.getElementById("cart-checkout").href = "/checkout";
                    document.getElementById("cart-checkout").classList.remove("not-avail");
                }

                document.getElementById("cart-qty").innerText = data['total_qty'];
                document.getElementById("totalqty").innerText = data['total_qty'];
                document.getElementById("cart-subtotal").innerText = data['sub_total'];
                document.getElementById("store-total-" + store).innerText = data['store_total'];
            }
        });
    });

    function check(data, store) {
        var left = 500 - data['store_total'];
        var div_id = 'cmm-' + store + '';

        if ($('#cmm-' + store).children().length <= 0) {
            $('#ccsn-' + store).append('' +
                '<div id=' + div_id + ' class="cart-minimum-message">' +
                '<strong id="lacking-' + store + '">Add ₱ ' + left + '</strong> to reach minimum order.' +
                '</div>' +
                '');
        } else {
            document.getElementById("lacking-" + store).innerText = 'Add ₱ ' + left;
        }
    }

    $(document).on('click', '.not-avail', function (e) {
        e.preventDefault();

        swal('Oops someting went wrong!', 'Cannot Order Below P 500.00. Please check total price each store.', 'error');
    })

    $(document).on('submit', '#disabled-me', function (e) {
        e.preventDefault();
    })

    $(document).on('click', '#cart-reusable', function (e) {
        e.preventDefault();

        $.ajax({
            url: "/cart/savetoreusablecart",
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data['success'] === 0){
                    swal('Oops someting went wrong!', data['message'], 'error');
                } else {
                    swal('Message', data['message'], 'success');
                }
            }
        });
    })

    const toggleRegisterModal = () => {
        document.querySelector('.update-compare-product').classList.toggle('compare-product-hidden');
    };

    // Add Reward Modal Controller
    document.querySelector('#toggleModal-viewproduct').addEventListener('click', toggleRegisterModal);
    document.querySelector('#compare-product-modal-close').addEventListener('click', toggleRegisterModal);

})
