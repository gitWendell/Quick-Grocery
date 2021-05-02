window.onload=function() {
    const searchInput = document.getElementById('search_account');

    const toggleUpdateModal = () => {
        document.querySelector('.update-account-modal').classList.toggle('modal-updateaccount-hidden');
    };


    // Update Modal Controller
    $(document).on('click', '.toggleModal-updateAccount', function(){
        var frm = document.getElementById('update-account-form');

        toggleUpdateModal();
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#modal-update-account-id').val(data[0]);
        $('#modal-update-account-displayname').val(data[1]);
        $('#modal-update-account-email').val(data[2]);
        $('#modal-update-account-role').val(data[3]);
        $('#modal-update-account-status').val(data[4]);
        frm.setAttribute("action",'/systemadmin/accountmanagement/' + data[0]);
        frm.setAttribute("data-id", data[0]);

    });

    $(document).on('submit', '#update-account-form', function (e) {
        e.preventDefault();

        let id = this.dataset.id;
        let formData = new FormData(this);

        swal({
            title: 'Are you sure?',
            text: 'If you want to continue, click Yes!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/systemadmin/accountmanagement/"+id,
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
                        swal("Message", "User successfully updated", "success");
                    }, error:function (err) {
                        if (err.status == 500) {
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

    document.querySelector('#updateaccount-modal-close').addEventListener('click', toggleUpdateModal);

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
}


