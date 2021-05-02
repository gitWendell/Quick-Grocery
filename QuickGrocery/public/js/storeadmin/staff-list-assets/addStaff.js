window.onload=function() {

    $('#add-staff-form').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/staffmanagement/addstaff",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#refresh-form").load(location.href + " #refresh-form");

                $(".message-error").remove();
                $(".message-success").remove();

                swal('Message', 'Staff successfully registered!', 'success');

            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#add-staff-message').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })
}
