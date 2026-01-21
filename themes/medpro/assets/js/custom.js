jQuery(document).ready(function($) {
    $.bvi({
        'bvi_target': '.vision',
        "bvi_theme": "white",
        "bvi_font": "arial",
        "bvi_font_size": 16,
    });

    $('.home-slider__slick').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
    });

    $('.gallery__slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        adaptiveHeight: true,
        asNavFor: '.gallery__slider-nav'
    });

    $('.gallery__slider-nav').slick({
        slidesToShow: 10,
        slidesToScroll: 1,
        asNavFor: '.gallery__slider-for',
        dots: false,
        focusOnSelect: true,
    });

});




class Particle {
    constructor(div, left, right, y, z, route, index) {
        this.left = Number(left);
        this.right = Number(right);
        this.y = Number(y);
        this.z = Number(z);
        this.div = div;
        this.index = index;

        this.speed = Number(z);
        this.route = Number(route);
    }

    //Метод движения частицы
    Move(scrollPosition) {

        let top = this.div.getBoundingClientRect().top;
        if (scrollPosition > top) {
            let rate = scrollPosition - top;
            this.y = Number(this.div.getAttribute('data-top')) + (rate / this.speed);

            if (this.right == 0) {
                this.left = Number(this.div.getAttribute('data-left')) + (this.route * rate / this.speed);
            } else {
                this.right = Number(this.div.getAttribute('data-right')) + (this.route * rate / this.speed);
            }

        }


    }
}

//Позиция полосы прокрутки
let scrollPosition = 0;

//Создаём массив с частицами
const particles = [];

let elements = document.querySelectorAll('.particle');

for (let elem of elements) {
    particles.push(new Particle(elem, elem.getAttribute('data-left'), elem.getAttribute('data-right'), elem.getAttribute('data-top'), elem.getAttribute('data-speed'), elem.getAttribute('data-route'), elem.getAttribute('data-z')));
}


//Это функция вывода частицы на страницу
Fill();

//При каждой прокрутке вызываем функцию Scroll(), которая двигает частицы
window.addEventListener("scroll", function(e) {
    Scroll(e);
});

function Scroll(e) {

    scrollPosition = window.pageYOffset;

    //Двигаем все частицы в заданном направлении
    for (let i = 0; i < particles.length; i++) {
        particles[i].Move(scrollPosition);
    }

    //Выводим всё на страницу
    Fill();
}

function Fill() {

    for (let i = 0; i < particles.length; i++) {

        if (particles[i].right == 0 || particles[i].right == undefined) {
            particles[i].div.setAttribute("style", "top: " + particles[i].y + "px; left: " + particles[i].left + "px; z-index: " + particles[i].index + ";  ");
        } else {
            particles[i].div.setAttribute("style", "top: " + particles[i].y + "px; right: " + particles[i].right + "px; z-index: " + particles[i].index + ";  ");
        }

    }
}