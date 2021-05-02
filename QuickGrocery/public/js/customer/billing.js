window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.add-billing-modal').classList.toggle('add-billing-hidden');
    };

    // Add Brand Modal Controller
    document.querySelector('#addbilling-modal').addEventListener('click', toggleModal);

    document.querySelector('#addbilling-modal-close').addEventListener('click', toggleModal);

    $(document).on('submit', '#customer-billing', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/customer/addresses",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#customer-address-id").load(location.href + " #customer-address-id");

                $(".message-error").remove();
                $(".message-success").remove();

                toggleModal();
                $("#store-modal-body").load(location.href + " #store-modal-body");
                swal('Message', 'Successfully Added!', 'success');

            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#customer-billing-message').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })

    $(document).on('click', '#cust-billing-delete', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanently deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: ""+url,
                    method: "GET",
                    dataType: "json",
                    success:function(data){
                        $("#customer-address-id").load(location.href + " #customer-address-id");

                        if(data['error'] === 1) {
                            swal('Whoops, Something went wrong!', data['message'], 'error');

                        }

                        if (data['error'] === 0){
                            swal("Message", "Delete successfully", "success");
                        }
                    }
                });
            }
        });
    })
}
