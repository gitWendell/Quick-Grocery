window.onload=function() {
    $(document).on('click', '.method-selected', function (e) {
        let billingSelect = document.querySelector('input[name="billing"]:checked') !== null;
        let methodSelect = document.querySelector('input[class="method-selected"]:checked') !== null;
        let store_id = this.dataset.id;

        $value = this.value;

        if ($value === '1') {
            if(!billingSelect) {
                swal('Message', 'In order for you to continue with the shipping method, you need to have a billing address added! Thank you', 'error');
                this.checked = false;
            } else {
                $('#response').append('<div class="message-success">Loading ...</div>');

                let billing = document.querySelector('input[name="billing"]:checked').value;
                let _token = $('input[name="_token"]').val();

                $.ajax({
                    type: 'POST',
                    url: '/checkout/shipping',
                    data: {billing:billing, store_id:store_id, _token:_token},
                })
                .done(function (data) {
                    $(".checkout-table").load(location.href + " .checkout-table");
                    $(".message-success").remove();
                })
            }

        } else {
            $('#response').append('<div class="message-success">Loading ...</div>');

            $.ajax({
                type: 'GET',
                url: '/checkout/pickup',
            })
            .done(function () {
                $(".checkout-table").load(location.href + " .checkout-table");
                $(".message-success").remove();

            })
        }
    })

    $(document).on('click', '#place-order', function (e) {

        let billingSelect = document.querySelector('input[name="billing"]:checked') !== null;
        let methodSelect = document.querySelector('input[class="method-selected"]:checked') !== null;

        if (billingSelect && methodSelect) {

         } else if(methodSelect && !billingSelect) {

           let method = document.querySelector('input[class="method-selected"]:checked').value;

            if(method === '1') {
                e.preventDefault();
                swal('Message', 'In order for you to continue with the shipping method, you need to have a billing address added! Thank you', 'error');
            }

        }

    })
}
