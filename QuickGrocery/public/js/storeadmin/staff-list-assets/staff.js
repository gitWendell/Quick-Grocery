window.onload=function() {

    const toggleUpdateStaffModal = () => {
        document.querySelector('.inventory-updatestaff-modal').classList.toggle('modal-updatestaff-hidden');
    };

    // Add Brand Modal Controller
    $(document).on('click', '.toggleModal-updateStaff', function(){
        var permissions = ["OrderM-CREATE", "OrderM-READ", "OrderM-UPDATE", "OrderM-DELETE",
                           "InventoryM-CREATE", "InventoryM-READ", "InventoryM-UPDATE", "InventoryM-DELETE" ];

        var frm = document.getElementById('updatestaff-frm');
        $(".message-error").remove();
        $(".message-success").remove();

        toggleUpdateStaffModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[0]);
        $('#email').val(data[1]);
        $('#permission').val(data[2]);
        $('#status').val(data[3]);
        var strArray = data[2].split(" ");

        for(i=0; i < strArray.length; i++) {
            permissions.forEach(permision => {
                if(strArray[i] == permision){
                    document.getElementById(strArray[i]).checked = true;
                }
            });
        }

        frm.setAttribute("action", window.location.href + '/' + data[0]);
        $('#updatestaff-frm').attr('data-id' , data[0]);

    });

    document.querySelector('#updatestaff-modal-close').addEventListener('click', toggleUpdateStaffModal);

    $(document).on('submit', '#updatestaff-frm', function (e) {
        e.preventDefault();

        var id = this.dataset.id;
        var formData = new FormData(this);

        swal({
            title: 'Are you sure?',
            text: 'This will update the staff information!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/staffmanagement/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleUpdateStaffModal();
                        swal('Message', 'Successfully Updated', 'success');

                    }, error:function (err) {

                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#modal-staff-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });
    })

    $(document).on('click', '.delete-staff', function (e) {
        e.preventDefault();

        var id = this.dataset.id;
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
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");

                        swal("Message", "Delete successfully", "success");
                    }
                });
            }
        });
    })
}
