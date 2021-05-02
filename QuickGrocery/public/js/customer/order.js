window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.update-orderCust-modal').classList.toggle('update-orderCust-hidden');
    };

    const toggleModalReview = () => {
        document.querySelector('.order-review-modal').classList.toggle('order-review-hidden');
    };


    $(document).on('click', '.toggleModal-update-orderCust', function(){

        var frm = document.getElementById('update-orderCust-frm');

        toggleModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#itemxqty').val(data[1]);
        $('#total').val(data[2]);
        $('#method').val(data[3]);
        $('#billing').val(data[4]);

        frm.setAttribute("action", '/customer/order/update/' + data[0]);
        frm.setAttribute("data-id", data[0]);

    });

    document.querySelector('#update-orderCust-modal-close').addEventListener('click', toggleModal);

    $(document).on('submit', '#update-orderCust-frm', function(e) {
        let id = this.dataset.id;
        e.preventDefault();

        var formData = new FormData(this);

        swal({
            title: 'Message',
            text: 'Are you sure you want to cancel this order ?',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/customer/order/update/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#customer-order-table").load(location.href + " #customer-order-table");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleModal();
                        swal("Message", "Update successfully", "success");

                    }, error:function (err) {

                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#customer-order-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });

    })
}
