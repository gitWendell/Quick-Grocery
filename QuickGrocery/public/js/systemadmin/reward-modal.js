window.onload=function() {
    const searchInput = document.getElementById('search_reward');

    const toggleRegisterModal = () => {
        document.querySelector('.add-reward-modal').classList.toggle('add-reward-hidden');
    };

    // Add Reward Modal Controller
    document.querySelector('#togglemodal-addReward').addEventListener('click', toggleRegisterModal);
    document.querySelector('#add-reward-modal-close').addEventListener('click', toggleRegisterModal);

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

    $(document).on('submit', '#createReward', function (e) {

        e.preventDefault();

        var _token = $('input[name="_token"]').val();
        var code = $('input[name="code"]').val();
        var startDate = $('input[name="startDate"]').val();
        var endDate = $('input[name="endDate"]').val();
        var discount = $('input[name="discount"]').val();

        $.ajax({
            url: "/systemadmin/reward/create",
            method: "POST",
            data: { code:code, startDate:startDate, endDate:endDate, discount:discount, _token:_token },
            success:function(data){
                console.log(data)
                $("#storeDatatable").load(" #storeDatatable");
                $(".message-error").remove();

                $("#register-reward").load(" #register-reward");
                swal("Message", "Store successfully updated", "success");
            }, error:function (err) {
                if (err.status == 422) {
                    console.log(err.responseJSON);

                    $.each(err.responseJSON.errors, function (i, error) {
                        $(".message-error").remove();
                        $('#store-modal-header').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })

    $(document).on('click', '.delete-reward', function (e) {
        e.preventDefault();
        let url = this.href;

        swal({
            title: 'Are you sure?',
            text: 'This will delete the selected reward!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    url: ''+url,
                    method: "GET",
                    success:function(data){
                        $("#storeDatatable").load(" #storeDatatable");

                        $(".message-error").remove();
                        $(".message-success").remove();

                        swal("Message", "Reward successfully deleted", "success");
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


