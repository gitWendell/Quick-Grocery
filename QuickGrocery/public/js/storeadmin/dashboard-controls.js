window.addEventListener("load", function () {
    $('.dashboard-closer-span').on('click', function(){
        document.querySelector('.store-sidebar').style.display ="none";
        document.querySelector('.dashboard-opener-span').style.display ="block";

        document.querySelector('.store-sidebar-content').style.width = "90%";
        document.querySelector('.store-sidebar-content').style.margin = "50px auto ";
        document.querySelector('.store-sidebar-content').style.height = "700px";
    });

    $('.dashboard-opener-span').on('click', function(){
        document.querySelector('.store-sidebar').style.display ="block";
        document.querySelector('.dashboard-opener-span').style.display ="none";

        if ($(window).width() < 768) {

        }
        else {
            document.querySelector('.store-sidebar-content').style.width = "70%";
            document.querySelector('.store-sidebar-content').style.margin = "50px auto ";
            document.querySelector('.store-sidebar-content').style.height = "auto";
        }
    });
})
