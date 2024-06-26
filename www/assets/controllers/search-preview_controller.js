import { Controller } from "stimulus";
import { useClickOutside, useDebounce } from "stimulus-use";

export default class extends Controller {
  static values = {
    url: String,
  };
  static targets = ["result", "input", "iconSearch", "iconDelete"];
  static debounces = ["search"];

  connect() {
    useClickOutside(this);
    useDebounce(this);
  }

  onSearchInput(event) {
    
    const inputValue = this.inputTarget.value.trim();
    if (inputValue === "") {
      this.iconSearchTarget.style.display = "block";
      this.iconDeleteTarget.style.display = "none";
      this.resultTarget.innerHTML = "<div class='resultatLien'>Aucun résultat trouvé !</div>";
      return;
    } else {
      this.search();
      this.iconSearchTarget.style.display = "none";
      this.iconDeleteTarget.style.display = "block";
    }
  }

  async search() {
    const params = new URLSearchParams({
      q: this.inputTarget.value,
      preview: 1,
    });

    const response = await fetch(`${this.urlValue}?${params.toString()}`);

    this.resultTarget.innerHTML = await response.text();
  }

  clickOutside(event) {
    const result = document.querySelectorAll(".accueilContentSearchFormContentPreview")

    result.forEach(element => {
      element.innerHTML="";
    });
    // this.resultTarget.innerHTML = "";
  }

  deleteResearch(event) {
    this.inputTarget.value = "";
    this.iconSearchTarget.style.display = "block";
    this.iconDeleteTarget.style.display = "none";
    this.search();
  
    // Synchroniser également le deuxième champ de recherche
    const input2 = document.querySelector('.accueilContent .accueilContentSearchFormContentInput');
    input2.value = "";
    input2.dispatchEvent(new Event('input'));
  }
}
