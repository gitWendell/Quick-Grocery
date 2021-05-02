
window.onload=function() {

    const toggleUpdateModal = () => {
        document.querySelector('.update-request-stock-modal').classList.toggle('update-request-stock-hidden');
    };

    // Update Request Stock
    $('.toggleModal-updateRequestStock').on('click', function(){
        var frm = document.getElementById('update-request-stock-form');

        toggleUpdateModal();
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#name').val(data[1]);
        $('#stock').val(data[3]);
        $('#status').val(data[4]);

        frm.setAttribute("action",window.location.href + '/update/' + data[0]);


    });

    document.querySelector('#updateRequestStock-modal-close').addEventListener('click', toggleUpdateModal);

}


