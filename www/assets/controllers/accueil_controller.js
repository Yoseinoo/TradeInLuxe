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
  }

  changeImage(target) {
    const newSrc = target.dataset.accueilChemin;
    target.querySelector("img").src = newSrc;
  }

  resetImage(target, defaultSrc) {
    target.querySelector("img").src = defaultSrc;
  }
}
