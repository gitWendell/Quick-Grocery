window.onload=function() {
    const searchInput = document.getElementById('search_store');

    const toggleRegisterModal = () => {
        document.querySelector('.register-store-modal').classList.toggle('modal-registerstore-hidden');
    };

    const toggleUpdateModal = () => {
        document.querySelector('.update-store-modal').classList.toggle('modal-updatestore-hidden');
    };

    // Register Modal Controller
    document.querySelector('#togglemodal-registerstore').addEventListener('click', toggleRegisterModal);
    document.querySelector('#registerstore-modal-close').addEventListener('click', toggleRegisterModal);

    // Update Modal Controller
    $(document).on('click','.toggleModal-updateStore', function(){
        $(".message-error").remove();
        $(".message-success").remove();

        var frm = document.getElementById('update-store-form');

        toggleUpdateModal();
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#modal-update-id').val(data[0]);
        $('#modal-update-email').val(data[1]);
        $('#modal-update-name').val(data[2]);
        $('#modal-update-description').val(data[4]);
        $('#modal-update-status').val(data[5]);

        frm.setAttribute("action",window.location.href + '/' + data[0]);


    });

    document.querySelector('#updatestore-modal-close').addEventListener('click', toggleUpdateModal);


    searchInput.addEventListener("keyup", function (event) {
        const rows = document.querySelectorAll("tbody tr");
        const q = event.target.value.toLowerCase();

        rows.forEach((row) =>{
            const rowsTds = row.querySelectorAll("td");
            var found = 0;

            rowsTds.forEach((rowTd) =>{

                rowTd.textContent.toLowerCase().includes(q)
                    ? found++
                    : '';

                found > 0 ? row.style.display = "table-row" : row.style.display = "none";
                console.log('found:'+found)
            })

        })
    })

    $('#createStore').submit(function (e) {

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/systemadmin/storemanagement",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#storeDatatable").load(location.href + " #storeDatatable");
                $("#register-store").load(location.href + " #register-store");

                $(".message-error").remove();
                $(".message-success").remove();

                swal("Message", "Store successfully registered", "success");

            }, error:function (err) {
                if (err.status == 422) {

                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#store-modal-header').append('<div class="message-error">'+error[0]+'</div>');
                    });
                } else if (err.status == 500) {

                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#store-modal-header').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })

    $(document).on('submit', '#update-store-form', function (e) {
        e.preventDefault();

        var id = $('input[name="store-Id"]').val();
        var formData = new FormData(this);

        swal({
            title: 'Are you sure?',
            text: 'This user will be restricted to the system!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/systemadmin/storemanagement/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleUpdateModal();
                        $("#update-store").load(location.href + " #update-store");
                        swal("Message", "Store successfully updated", "success");
                    }, error:function (err) {
                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#store-update-header').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        })
    })
}


