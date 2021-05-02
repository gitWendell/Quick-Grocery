window.onload=function() {
    const searchInput = document.getElementById('search_inventory');

    const toggleModal = () => {
        document.querySelector('.inventory-updateproduct-modal').classList.toggle('modal-updateproduct-hidden');
    };

    $(document).on('click','.updateProduct-modal', function(){
        $(".message-error").remove();
        $(".message-success").remove();
        var frm = document.getElementById('updateproduct-frm');
        toggleModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id-product').val(data[0]);
        $('#product').val(data[2]);
        $('#product_description').val(data[3]);
        $('#stock').val(data[4]);

        var origprice = data[5].replace("P", "");
        var origprice = origprice.replace(" ", "");
        $('#origprice').val(origprice);

        var profit = data[6].replace("P", "");
        var profit = profit.replace(" ", "");
        $('#profit').val(profit);

        frm.setAttribute("action", window.location.href + '/update/' + data[0]);
        $('#updateproduct-frm').attr('data-id' , data[0]);
    });

    document.querySelector('#updateproduct-modal-close').addEventListener('click', toggleModal);

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

    $(document).on('submit', '#updateproduct-frm', function (e) {

        e.preventDefault();
        var id = this.dataset.id;
        var formData = new FormData(this);

        swal({
            title: 'Are you sure?',
            text: 'This will update the product information!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/inventorymanagement/update/"+id,
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
                        swal('Message', 'Product Successfully Updated', 'success');

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
            }
        });
    })


}
