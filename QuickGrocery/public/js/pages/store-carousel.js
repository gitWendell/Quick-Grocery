const slider = document.querySelector('.slider');

const arrowLeft = document.querySelector('.left');
const arrowRight = document.querySelector('.right');
const indicatorParents = document.querySelector('.slider-controller ul');

var slideIndex = 0;

function setIndex() {
    document.querySelector('.slider-controller .active').classList.remove('active');
    slider.style.transform = 'translate(' + (slideIndex) * -25 +'% )';
}

document.querySelectorAll('.slider-controller li').forEach(function(indicatior, ind){

    indicatior.addEventListener('click', function(){
        slideIndex = ind;
        setIndex();
        indicatior.classList.add('active');

    })
})


arrowRight.addEventListener('click', function(){
    slideIndex = ( slideIndex < 3 ) ? slideIndex + 1 : 3;
    indicatorParents.children[slideIndex].classList.add('active');
    setIndex();
})

arrowLeft.addEventListener('click', function(){
    slideIndex = ( slideIndex > 0 ) ? slideIndex - 1 : 0;
    indicatorParents.children[slideIndex].classList.add('active');
    setIndex();
})

