window.onload=function() {
    const searchInput = document.getElementById('search_order');

    const toggleUpdateOrderModal = () => {
        document.querySelector('.order-update-modal').classList.toggle('order-update-hidden');
    };

    // Add Brand Modal Controller
    $(document).on('click','.toggleModal-updateOrder', function(){
        var frm = document.getElementById('updateOrder-frm');

        $(".message-error").remove();
        $(".message-success").remove();

        toggleUpdateOrderModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[0]);
        $('#cusName').val(data[1]);
        $('#itemxqty').val(data[2]);
        $('#total').val(data[3]);
        $('#method').val(data[4]);
        $('#billing').val(data[5]);

        frm.setAttribute("action", '/storeadmin/ordermanagement/update/' + data[0]);
        $('#updateOrder-frm').attr('data-id', data[0]);

    });

    document.querySelector('#updateorder-modal-close').addEventListener('click', toggleUpdateOrderModal);

    $(document).on('keyup', '#search_order', function(event){
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
    });

    $(document).on('submit', '#updateOrder-frm', function (e) {
        var id = this.dataset.id;
        e.preventDefault();

        var formData = new FormData(this);
        swal({
            title: 'Are you sure?',
            text: 'This will update the status of this order!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/ordermanagement/update/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");
                        console.log(data)
                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleUpdateOrderModal();
                        $("#update-order-store").load(location.href + " #update-order-store");
                        swal('Messange', 'Order Updated Successfully', 'success')

                    }, error:function (err) {

                        if (err.status == 422) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#update-order-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });
    })
}
