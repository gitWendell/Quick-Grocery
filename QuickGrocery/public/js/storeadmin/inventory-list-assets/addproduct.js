window.onload=function() {
    var addid = 0;
    $('#add-product-form').parsley();

    // Fetch Sub Category by Category  id
    $(document).on('change', '#category', function(){
        var category_id = $(this).val();
        var _token = $('input[name="_token"]').val();

        if(category_id != '') {
            $.ajax({
                url: "/storeadmin/inventorymanagement/addproduct/subcategory",
                method: "POST",
                data: {category_id:category_id, _token:_token},
                success:function(data){
                    $('#sub-category').fadeIn();
                    $('#sub-category').html(data);
                }
            });
        }
    });

    // Fetch Attribute Value by Attribute Id
    $(document).on('change','#attribute_id', function(){
        var attribute_id = $(this).val();
        var _token = $('input[name="_token"]').val();

        if(attribute_id != '') {
            $.ajax({
                url: "/storeadmin/inventorymanagement/addproduct/attribute",
                method: "POST",
                data: {
                    attribute_id:attribute_id, _token:_token},
                success:function(data){
                    $('#attribute-value').fadeIn();
                    $('#attribute-value').html(data);
                }
            });
        }
    });


    $('#add-product-form').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/storeadmin/inventorymanagement/addproduct",
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $("#refresh-form").load(location.href + " #refresh-form");

                $(".message-error").remove();
                $(".message-success").remove();

                swal('Message', 'Product Successfully Added!', 'success');

            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#add-product-message').append('<div class="message-error">'+error[0]+'</div>');
                    });
                }
            }
        });
    })

}
