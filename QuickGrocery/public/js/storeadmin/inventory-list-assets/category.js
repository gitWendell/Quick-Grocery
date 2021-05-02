window.onload=function() {

    const toggleModal = () => {
        document.querySelector('.inventory-category-modal').classList.toggle('modal-category-hidden');
    };

    const toggleSubModal = () => {
        document.querySelector('.inventory-subcategory-modal').classList.toggle('modal-subcategory-hidden');
    };

    // Add Category Controller
    document.querySelector('#togglemodal-addcategory').addEventListener('click', toggleModal);
    document.querySelector('#addcategory-modal-close').addEventListener('click', toggleModal);

    // Add Sub Category Controllers
    $(document).on('click', '.togglemodal-subcategory', function(){

        var frm = document.getElementById('subcategory-frm');

        toggleSubModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id-subcategory').val(data[0]);
        $('#category').val(data[1]);

        frm.setAttribute("action", window.location.href + '/' + data[0]);
        frm.setAttribute("data-id", data[0]);
    });

    $(document).on('click', '.display-subcat', function (e) {

        let id = this.dataset.id;
        let subcat = document.querySelectorAll(".subcategory-view-"+id);

        for(var i = 0; i < subcat.length; i++) {
            if (subcat[i].style.display === 'none'){
                subcat[i].style.display = 'table-row';
            }else {
                subcat[i].style.display = 'none';
            }
        }
    })

    $(document).on('submit', '#add-category-frm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/inventorymanagement/category",
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
                $("#add-category").load(location.href + " #add-category");
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

    $(document).on('click', '.delete-category', function (e) {
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

    document.querySelector('#addsubcategory-modal-close').addEventListener('click', toggleSubModal);

    $(document).on('submit', '#subcategory-frm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = this.dataset.id;

        $.ajax({
            url: "/storeadmin/inventorymanagement/category/"+id,
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#storeDatatable").load(location.href + " #storeDatatable");

                $(".message-error").remove();
                $(".message-success").remove();

                toggleSubModal();
                swal('Message', 'Sub Category Successfully Added', 'success');

            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#update-product-message').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
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
                            swal("Message", "Delete successfully", "success");
                        }
                    }
                });
            }
        });
    })
}
