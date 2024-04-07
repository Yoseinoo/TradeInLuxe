import { Controller } from "@hotwired/stimulus";
import { useClickOutside } from "stimulus-use";

export default class extends Controller {
  static targets = ["burger", "menu", "closeBurger"];

  connect() {
    useClickOutside(this);
    window.addEventListener("resize", () => {
      this.handleResize();
    });
  }

  handleResize() {
    if (window.innerWidth > 430) {
        this.menuTarget.classList.contains('menuHide') ?  this.menuTarget.classList.remove('menuHide') :  this.menuTarget.classList.remove('menuShow');
        this.menuTarget.style.display = "";
        this.burgerTarget.style.display = "";
        this.closeBurgerTarget.style.display = "";
    }
  }

  showMenu() {
    if (window.innerWidth <= 430) {
    this.menuTarget.classList.remove('menuHide');
    this.menuTarget.classList.add('menuShow');
    this.menuTarget.style.display = "block";
    this.closeBurgerTarget.style.display = "block";
    this.burgerTarget.style.display = "none";
    }
  }

  closeMenu() {
    if (window.innerWidth <= 430) {
    this.menuTarget.classList.remove('menuShow');
    this.menuTarget.classList.add('menuHide');
    this.closeBurgerTarget.style.display = "none";
    this.burgerTarget.style.display = "block";
    }
  }

  clickOutside() {
    if (window.innerWidth <= 430) {
    this.menuTarget.style.display = "none";
    this.menuTarget.classList.remove('show');
    this.closeBurgerTarget.style.display = "none";
    this.burgerTarget.style.display = "block";
    }
  }

}