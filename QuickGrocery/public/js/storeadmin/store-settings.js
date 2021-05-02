window.addEventListener("load", function () {

    $(document).on('submit', '#store-setting-form', function (e) {
        e.preventDefault();

        var id = this.dataset.id;
        var formData = new FormData(this);
        swal({
            title: 'Are you sure?',
            text: 'This will update the setting!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/storemanagement/create/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#refresh-settings").load(location.href + " #refresh-settings");
                        console.log(data)
                        $(".message-error").remove();
                        $(".message-success").remove();

                        swal("Message", "Update succesfully", "success");

                    }, error:function (err) {
                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#setting-messages').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });
    })
})
