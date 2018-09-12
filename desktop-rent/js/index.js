// Mask for phone number

// $('.cta__input').simpleMask({
//     'mask': '+7 (###) ###-##-##'
// })


// Email sending

$('.cta__input').on("focus",function(e){
    e.target.placeholder = "В любом формате";
    yaCounter50261107.reachGoal('ON_PHONE_FOCUS');
})
document.body.addEventListener('click', (e) => {
    if(e.target.classList.contains('cta__button')) {
        yaCounter50261107.reachGoal('ON_PHONE_SENT');
        $.ajax({
            url: '/order.php',
            method: 'POST',
            data: {mail: $(e.target).parent().prev().children().val()}
        }).done(() => {
            console.log('success')
            $(".cta__button").html('Заявка отправлена!');
            $('.modal').show()
            $('.cta--main').hide(200)
            $('.cta--success').show(200)
        })
    }
})

// Animation for menu links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: $(this.getAttribute('href')).offset().top - 88.6 }, 'slow');
    });
});

// Animation to top
document.querySelector('.logo').addEventListener('click', () => {
    scrollTo({
        top: 0,
        behavior: 'smooth'
    })
})

// Toggle animation for mobile menu
var btnMenu = document.querySelector('.btn__mobile-menu'),
    menu = document.querySelector('.mobile__version .menu__list');
    
menu.addEventListener('click', (e) => {
    menu.classList.remove('active');
});

btnMenu.addEventListener('click', (e) => {
    e.preventDefault();
    menu.classList.toggle('active');
})

// Show/hide modal
var vidgetBtn = document.querySelector('.widget');
var modal = document.querySelector('.modal');
var priceBtn = document.querySelector('.price__button');

vidgetBtn.addEventListener('click', () => {
    $('.modal').toggle();
    $('.widget').toggle();
})

priceBtn.addEventListener('click', () => {
    $('.modal').toggle();
    $('.widget').toggle();
})

window.addEventListener('click', (e) => {
    if(!e.target.classList.contains('cta__input')) {
        $('.cta__input').each(function(e) {
            $(this)[0].placeholder = 'Введите номер телефона'
        })
    }
    if (e.target == modal) {
        modal.style.display = "none";
        $('.widget').toggle();
    }
})

// SLick slider
$(document).ready(function(){

  $('.slider').slick({
    infinite: true,
    arrows: false,
    autoplay: true,
    dots: true,
    autoplaySpeed: 4000
  });
});