import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.carousel();
    }

    showCertif(){
        const hiddenText = document.getElementById('hiddenCertif');
        const chevronUp = document.getElementById('chevronUp');
        const chevronDown = document.getElementById('chevronDown');

        if (hiddenText.style.display === 'block') {
            hiddenText.style.display = 'none';
            chevronUp.style.display = 'none';
            chevronDown.style.display = 'block';
            
        } else {
            hiddenText.style.display = 'block';
            chevronDown.style.display = 'none';
            chevronUp.style.display = 'block';
        }
    }

    showEngagement(){
        const hiddenText = document.getElementById('hiddenEngagement');
        const chevronUp = document.getElementById('chevronUp2');
        const chevronDown = document.getElementById('chevronDown2');

        if (hiddenText.style.display === 'block') {
            hiddenText.style.display = 'none';
            chevronUp.style.display = 'none';
            chevronDown.style.display = 'block';
            
        } else {
            hiddenText.style.display = 'block';
            chevronDown.style.display = 'none';
            chevronUp.style.display = 'block';
        }
    }

    carousel(){
        $(".slider-for").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            // asNavFor: ".slider-nav"
            });
            $(".slider-nav").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: ".slider-for",
            dots: false,
            centerMode: true,
            focusOnSelect: true
            });
    }
}
