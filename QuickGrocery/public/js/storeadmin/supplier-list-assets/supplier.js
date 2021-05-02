window.onload=function() {
    $('#supplier-create').parsley();
    $('#supplier-update').parsley();

    const searchInput = document.getElementById('search_supplier');

    const toggleRegisterSupplierModal = () => {
        document.querySelector('.register-supplier-modal').classList.toggle('register-supplier-hidden');
    };

    document.querySelector('#togglemodal-registersupplier').addEventListener('click', toggleRegisterSupplierModal);
    document.querySelector('#registersupplier-modal-close').addEventListener('click', toggleRegisterSupplierModal);

    const toggleUpdateSupplierModal = () => {
        document.querySelector('.update-supplier-modal').classList.toggle('update-supplier-hidden');
    };

    $(document).on('click', '.toggleModal-updateSupplier', function(){
        $(".message-error").remove();
        $(".message-success").remove();

        var frm = document.getElementById('supplier-update');

        toggleUpdateSupplierModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[0]);
        $('#updateName').val(data[1]);
        $('#updateEmail').val(data[2]);
        $('#updateContact').val(data[3]);
        $('#updateStatus').val(data[4]);

        frm.setAttribute("action", window.location.href + '/update/' + data[0]);
        frm.setAttribute("data-id", data[0]);

    });

    document.querySelector('#updatesupplier-modal-close').addEventListener('click', toggleUpdateSupplierModal);

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

    $(document).on('submit', '#supplier-create', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/supplier/create",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#storeDatatable").load(location.href + " #storeDatatable");

                $(".message-error").remove();
                $(".message-success").remove();

                $("#storeDatatable").load(location.href + " #storeDatatable");
                toggleRegisterSupplierModal();
                swal('Message', 'Successfully Added!', 'success');;

            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#supplier-create-message').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })

    $(document).on('submit', '#supplier-update', function (e) {
        e.preventDefault();

        var id = this.dataset.id;
        var formData = new FormData(this);
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanently deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/supplier/update/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleUpdateSupplierModal();
                        $("#supplier-update-refresh").load(location.href + " #supplier-update-refresh");
                        swal('Message', 'Successfully Updated!', 'success')

                    }, error:function (err) {

                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#supplier-update-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });
    })

    $(document).on('click', '.delete-supplier', function (e) {
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
