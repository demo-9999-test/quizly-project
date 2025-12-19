/**
 *
 * This file contains all theme JS functions
 *
 * @package
--------------------------------------------------------------
				   Contents
--------------------------------------------------------------
 * 01 -  Owl Caserol
            - Testimonial Slider


--------------------------------------------------------------*/

(function($) {
    "use strict";

  /* ================================= */
      /*===== Top Bar =====*/
  /* ================================= */
  document.addEventListener("DOMContentLoaded", function(){
      window.addEventListener('scroll', function() {
          if (window.scrollY > 50) {
              document.getElementById('top-bar').classList.add('fixed-top');
              let navbar_height = document.querySelector('.navbar').offsetHeight;
              document.body.style.paddingTop = navbar_height + 'px';
          } else {
              document.getElementById('top-bar').classList.remove('fixed-top');
              document.body.style.paddingTop = '0';
          }
      });
  });
  /* ================================= */
      /*===== Top Search Bar =====*/
  /* ================================= */
  $(document).ready(function(){
      var $searchIcon = $('.search-icon');
      var $searchInput = $('.search-input');
      $searchIcon.click(function(){
      $searchInput.toggleClass('open');
      });
  });

  /* ================================= */
      /*===== slick slider =====*/
  /* ================================= */
  $('.category-slider').slick({
    slidesToShow: 3,
    variableWidth: true,
    rtl:true,
    autoplay: true,
    arrows: false,
    dots: false,
    infinite: true,
    autoplaySpeed: 0,
    speed: 6000,
    cssEase: 'linear',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]
  });
  $('.discover-slider').slick({
    slidesToShow: 4,
    variableWidth: true,
    autoplay: true,
    rtl:true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: true,
    infinite: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerMode:true,
          centerPadding: '10px',
          slidesToShow: 1
        }
      }
    ]
  });
  $('.testimonial-slider').slick({
    slidesToShow: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    rtl:true,
    arrows: false,
    dots: true,
    infinite: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 2
        }
      },
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '80px',
          slidesToShow: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]
  });
  $('.get-more-slider').slick({
    slidesToShow: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 2
        }
      },
      {
        breakpoint: 767,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 1
        }
      },
    ]
  });

  $('.category-page-slider').slick({
    slidesToShow: 4,
    variableWidth: true,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: true,
    infinite: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]
  });

   /* ================================= */
      /*===== Multiple Choice Button =====*/
  /* ================================= */
  let labels = document.querySelectorAll('.options');

    labels.forEach(label => {
        label.addEventListener('click', () => {
            labels.forEach(l => l.classList.remove('active'));
            label.classList.add('active');
        });
    });

})(jQuery);


