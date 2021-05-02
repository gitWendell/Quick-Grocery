window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.inventory-attribute-modal').classList.toggle('modal-attribute-hidden');
    };

    const toggleValueModal = () => {
        document.querySelector('.inventory-attributevalue-modal').classList.toggle('modal-attributevalue-hidden');
    };

    // Add Attribute Controllers
    document.querySelector('#togglemodal-addattribute').addEventListener('click', toggleModal);
    document.querySelector('#addattribute-modal-close').addEventListener('click', toggleModal);

    // Add Attribute Value Controllers
    $(document).on('click', '.togglemodal-addattributevalue', function(){
        var frm = document.getElementById('attribute-value');

        toggleValueModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[0]);
        $('#name').val(data[1]);

        frm.setAttribute("action", window.location.href + '/' + data[0]);
        frm.setAttribute("data-id", data[0]);
    });

    $(document).on('submit', '#add-attribute', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/inventorymanagement/attribute",
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
                $("#add-attributes").load(location.href + " #add-attributes");
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

    document.querySelector('#addattributevalue-modal-close').addEventListener('click', toggleValueModal);

    $(document).on('click', '.delete-attribute', function (e) {
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

    $(document).on('click', '.view-value', function (e) {

        let id = this.dataset.id;
        let subcat = document.querySelectorAll(".value-view-"+id);

        for(var i = 0; i < subcat.length; i++) {
            if (subcat[i].style.display === 'none'){
                subcat[i].style.display = 'table-row';
            }else {
                subcat[i].style.display = 'none';
            }
        }
    })

    $(document).on('click', '.delete-subcategory', function (e) {
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
                            swal("Message", data['message'], "success");
                        }
                    }
                });
            }
        });
    })

    $(document).on('submit', '#attribute-value', function (e) {
        e.preventDefault();
        let id = this.dataset.id;
        let formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/inventorymanagement/attribute/"+id,
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#storeDatatable").load(location.href + " #storeDatatable");

                $(".message-error").remove();
                $(".message-success").remove();

                toggleValueModal();
                $("#add-subcategory").load(location.href + " #add-subcategory");
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
}
