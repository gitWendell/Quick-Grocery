window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.inventory-brand-modal').classList.toggle('modal-brand-hidden');
    };

    // Add Brand Modal Controller
    document.querySelector('#togglemodal-addbrand').addEventListener('click', toggleModal);

    document.querySelector('#registerstore-modal-close').addEventListener('click', toggleModal);

    $(document).on('submit', '#add-brand-frm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/inventorymanagement/brand",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#storeDatatable").load(location.href + " #storeDatatable");

                $(".message-error").remove();
                $(".message-success").remove();

                toggleModal();
                $("#add-brand").load(location.href + " #add-brand");
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

    $(document).on('click', '.delete-brand', function (e) {
        e.preventDefault();
        let url = this.href;
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
                        $("#storeDatatable").load(location.href + " #storeDatatable");
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
