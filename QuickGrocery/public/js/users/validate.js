window.addEventListener("load", function () {

    const toggleRegisterModal = () => {
        document.querySelector('.update-compare-product').classList.toggle('compare-product-hidden');
    };

    // Add Reward Modal Controller
    document.querySelector('#toggleModal-viewproduct').addEventListener('click', toggleRegisterModal);
    document.querySelector('#compare-product-modal-close').addEventListener('click', toggleRegisterModal);

});


