window.addEventListener("load", function () {

    $('#account-update').submit(function (e) {

        e.preventDefault();
        var id = this.dataset.id;
        var formData = new FormData(this);
        swal({
            title: 'Message',
            text: 'Are you sure you want to update ?',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/customer/accountdetails/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#account-refresh").load(location.href + " #account-refresh");

                        $(".message-error").remove();
                        $(".message-success").remove();
                        console.log(data)
                        if(data == 'Email is used by other user') {
                            $('#account-message').append('<div class="message-error">'+data+'</div>');
                        } else {
                            swal('Message', 'Update successfully', 'success');
                        }

                    }, error:function (err) {

                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#account-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });
    })
})
