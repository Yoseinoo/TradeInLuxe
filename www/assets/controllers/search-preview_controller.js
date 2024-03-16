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
    this.search();
    const inputValue = this.inputTarget.value.trim();
    if (inputValue === "") {
      this.iconSearchTarget.style.display = "block";
      this.iconDeleteTarget.style.display = "none";
    } else {
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
    this.resultTarget.innerHTML = "";
  }

  deleteResearch(event) {
    this.inputTarget.value = "";
    this.iconSearchTarget.style.display = "block";
    this.iconDeleteTarget.style.display = "none";
    this.search();
  }
}
