import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["chaussure", "sac", "vetement"];

  connect() {
    if (window.innerWidth > 430) {
      const defaultSrcChaussure = this.chaussureTarget
        .querySelector("img")
        .getAttribute("src");
      const defaultSrcSac = this.sacTarget
        .querySelector("img")
        .getAttribute("src");
      const defaultSrcVetement = this.vetementTarget
        .querySelector("img")
        .getAttribute("src");

      this.chaussureTarget.addEventListener("mouseenter", () =>
        this.changeImage(this.chaussureTarget)
      );
      this.chaussureTarget.addEventListener("mouseleave", () =>
        this.resetImage(this.chaussureTarget, defaultSrcChaussure)
      );

      this.sacTarget.addEventListener("mouseenter", () =>
        this.changeImage(this.sacTarget)
      );
      this.sacTarget.addEventListener("mouseleave", () =>
        this.resetImage(this.sacTarget, defaultSrcSac)
      );

      this.vetementTarget.addEventListener("mouseenter", () =>
        this.changeImage(this.vetementTarget)
      );
      this.vetementTarget.addEventListener("mouseleave", () =>
        this.resetImage(this.vetementTarget, defaultSrcVetement)
      );
    }
    window.addEventListener("scroll", () => {
      this.detectScroll();
    });
    window.addEventListener("resize", () => {
      this.handleResize();
      this.handleScreenSizeChange();
    });
    this.syncSearch();
    this.initSlickSlider();
  }

  handleResize() {
    if (window.innerWidth > 430) {
      var nameSite = document.getElementById("nameSite");
      nameSite.style.display = "";
    }
  }

  changeImage(target) {
    const newSrc = target.dataset.accueilChemin;
    target.querySelector("img").src = newSrc;
  }

  resetImage(target, defaultSrc) {
    target.querySelector("img").src = defaultSrc;
  }

  detectScroll() {
    var produitsSection = document.querySelector(".produits");
    var produitsSectionPosition = produitsSection.getBoundingClientRect().top;

    // Récupérer la barre de recherche de la barre de navigation
    var navSearchBar = document.getElementById("navSearchBar");
    var nameSite = document.getElementById("nameSite");

    // Hauteur de défilement à partir du haut de la fenêtre
    var scrollHeight = window.scrollY;
    // Si l'écran est plus petit que 430px, affiche la barre de recherche
    if (window.innerWidth <= 430) {
      if (produitsSectionPosition <= scrollHeight) {
        navSearchBar.style.display = "block";
        nameSite.style.display = "none";
      } else {
        navSearchBar.style.display = "none";
        nameSite.style.display = "block";
      }
    } else {
      // Si la section des produits est visible dans la fenêtre, affiche la barre de recherche
      if (produitsSectionPosition <= scrollHeight) {
        navSearchBar.style.display = "block";
      } else {
        navSearchBar.style.display = "none";
      }
    }
  }

  syncSearch() {
    const input1 = document.querySelector('.navigationLogo .accueilContentSearchFormContentInput');
    const input2 = document.querySelector('.accueilContent .accueilContentSearchFormContentInput');
  
    let isSyncing = false; 
  
    input1.addEventListener('input', function() {
      if (!isSyncing) {
        isSyncing = true;
        input2.value = this.value;
        input2.dispatchEvent(new Event('input'));
        isSyncing = false;
      }
    });
  
    input2.addEventListener('input', function() {
      if (!isSyncing) {
        isSyncing = true;
        input1.value = this.value;
        input1.dispatchEvent(new Event('input'));
        isSyncing = false;
      }
    });
  }

  initSlickSlider() {
    const isMobile = window.matchMedia("(max-width: 430px)").matches;

    if (isMobile) {
      $(".fonctionnementContentCards").slick({
        infinite: false,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
      });
    }
  }

  handleScreenSizeChange() {
    const isMobile = window.matchMedia("(max-width: 430px)").matches;
    const slickInitialized = $(".fonctionnementContentCards").hasClass("slick-initialized");
    if (isMobile && !slickInitialized) {
      this.initSlickSlider();
    } else if (!isMobile && slickInitialized) {
      $(".fonctionnementContentCards").slick("unslick");
    }
  }
  
}
