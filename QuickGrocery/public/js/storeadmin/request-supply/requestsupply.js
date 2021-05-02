window.onload=function() {

    const searchInput = document.getElementById('search_requestsupply');
    const toggleUpdateRequestModal = () => {
        document.querySelector('.update-requestSupply-modal').classList.toggle('update-requestSupply-hidden');
    };

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

    // Add Brand Modal Controller
    $(document).on('click', '.toggleModal-updateRequestSupply', function(){
        $(".message-error").remove();
        $(".message-success").remove();

        var frm = document.getElementById('requestSupply-update');

        toggleUpdateRequestModal();

        // Get the Data Set
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log($tr);
        $('#product_name').val(data[2]);
        $('#request_qty').val(data[3]);
        $('#status').val(data[4]);


        frm.setAttribute("action", window.location.href + '/update/' + data[0]);
        frm.setAttribute("data-id", data[0]);

    });

    document.querySelector('#requestSupply-modal-close').addEventListener('click', toggleUpdateRequestModal);

    $(document).on('submit', '#requestSupply-update', function (e) {
        e.preventDefault();

        var id = this.dataset.id;
        var formData = new FormData(this);

        swal({
            title: 'Are you sure?',
            text: '!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: "/storeadmin/supply/update/"+id,
                    method: "POST",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#storeDatatable").load(location.href + " #storeDatatable");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        toggleUpdateRequestModal();
                        $("#request-supply-update").load(location.href + " #request-supply-update");
                        swal('Message', 'Successfully Updated!', 'success');


                    }, error:function (err) {

                        if (err.status == 500) {
                            console.log(err.responseJSON);
                            $(".message-error").remove();
                            $(".message-success").remove();

                            $.each(err.responseJSON.errors, function (i, error) {
                                $('#requestSupply-update-message').append('<div class="message-error">'+error[0]+'</div>');
                            });
                        }
                    }
                });
            }
        });

    })
}
