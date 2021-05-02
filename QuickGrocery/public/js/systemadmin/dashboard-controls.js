window.addEventListener("load", function () {
    $('.dashboard-closer-span').on('click', function(){
        document.querySelector('.systemadmin-sidebar').style.display ="none";
        document.querySelector('.dashboard-opener-span').style.display ="block";

        document.querySelector('.systemadmin-sidebar-content').style.width = "90%";
        document.querySelector('.systemadmin-sidebar-content').style.margin = "50px auto ";
        document.querySelector('.systemadmin-sidebar-content').style.minHeight = "700px";
    });

    $('.dashboard-opener-span').on('click', function(){
        document.querySelector('.systemadmin-sidebar').style.display ="block";
        document.querySelector('.dashboard-opener-span').style.display ="none";

        if ($(window).width() < 768) {

        }
        else {
            document.querySelector('.systemadmin-sidebar-content').style.width = "70%";
            document.querySelector('.systemadmin-sidebar-content').style.margin = "50px auto ";
            document.querySelector('.systemadmin-sidebar-content').style.height = "auto";
        }

    });

})
