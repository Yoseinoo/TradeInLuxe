import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    // Intersection Observer pour les éléments .produitsContentGridLeft et .produitsContentGridRight > .imageBox
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    // Observer les éléments .produitsContentGridLeft et .produitsContentGridRight > .imageBox
    const elementsToAnimate = this.element.querySelectorAll('.produitsContentGridLeft, .produitsContentGridRight > .imageBox');
    elementsToAnimate.forEach(element => {
      observer.observe(element);
    });

    // Afficher les .fonctionnementContentCardsItem lors du défilement
    const cards = this.element.querySelectorAll('.fonctionnementContentCardsItem');
    
    const isVisible = (element) => {
      const rect = element.getBoundingClientRect();
      const windowHeight = window.innerHeight || document.documentElement.clientHeight;
      return rect.top <= windowHeight * 0.75;
    };

    const showCardsOnScroll = () => {
      cards.forEach(card => {
        if (isVisible(card)) {
          card.classList.add('visible');
        }
      });
    };

    window.addEventListener('scroll', showCardsOnScroll);
    showCardsOnScroll();
  }
}
