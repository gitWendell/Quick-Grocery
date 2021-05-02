window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.update-reusable-modal').classList.toggle('update-reusable-hidden');
    };

    $('.toggleModal-update-reusableCart').on('click', function(){
        var _token = $('input[name="_token"]').val();
        var id = this.dataset.id;
        toggleModal();

        load(id).done(function(data) {
            $('#current-reusable-list').html(data);
        });

    });

    document.querySelector('#update-reusable-modal-close').addEventListener('click', toggleModal);

    $('.store-select').on('click', function(){
        var id = this.dataset.id;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/reusable/product/load/"+id,
            method: "GET",
            data: { id:id, _token:_token },
            success:function(data){
                $('#reusable-product').html(data);
                document.getElementById("product-list").style.display = "flex";
            }});
    });
    $(document).on('click', '.reusable-id', function (e) {
        e.preventDefault();
        let reusable_id = this.dataset.id;

        $.ajax({
            url: "/reusable/addtocart/"+reusable_id,
            method: "GET",
            data: {reusable_id:reusable_id},
            success:function(data){
                swal('Message', 'Successfully Added!', 'success');
            }
        });

    })

    $(document).on('click', '.reusable-delete-id', function (e) {
        e.preventDefault();

        const url = $(this).attr('href');

        swal({
            title: 'Message',
            text: 'Are you sure you want to delete this reusable cart ?',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: ""+url,
                    method: "GET",
                    success:function(data){
                        $("#reusable-table").load(location.href + " #reusable-table");
                        swal("Message", "Delete successfully", "success");
                    }
                });
            }
        });
    })

    $(document).on('click', '.product-select',function(){
        const cartList_id = document.querySelector('.cartList_id');

        var product_id = this.dataset.id;
        var qty = document.getElementById('qty-id-'+product_id).value;
        var reusableListId = cartList_id.dataset.id;
        var cartListId = cartList_id.dataset.cartid;

        $.ajax({
            url: "/reusable/product/add/"+product_id,
            method: "GET",
            data: {
                product_id:product_id, reusableListId:reusableListId,
                cartListId:cartListId, qty:qty },
            success:function(data){
                $('#message-success').html(data);

                load(cartListId).done(function(data) {
                    $('#current-reusable-list').html(data);
                });
            }});
    })

    $(document).on('change', '.qty-change',function(){
        const cartList_id = document.querySelector('.cartList_id');

        var cartListId = cartList_id.dataset.cartid;
        var product_id = this.dataset.id;
        var qty = $(this).val();

        $.ajax({
            url: "/reusable/product/product-change/"+product_id,
            method: "GET",
            data: {product_id:product_id, cartListId:cartListId, qty:qty },
            success:function(data){
                $('#message-success').html(data);

                load(cartListId).done(function(data) {
                    $('#current-reusable-list').html(data);
                });
            }});
    })

    function load(id) {

        return $.ajax({
            cache:      false,
            url:        "/reusablecart/load/"+id,
            type:       "get",
            data:       id
        });
    }
}
