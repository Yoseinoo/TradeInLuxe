import { Controller } from "stimulus";

export default class extends Controller {
  connect() {
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");

    closeBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      this.menuBtnChange(closeBtn, sidebar);
    });
  }

  menuBtnChange(closeBtn, sidebar) {
    if (sidebar.classList.contains("open")) {
      closeBtn.innerHTML = `
      <path d="m4 4 16 16"></path>
      <path d="M4 20 20 4"></path>
 `;
    } else {
        closeBtn.innerHTML = `
        <path d="M3.975 5.975h16"></path>
<path d="M3.975 11.975h16"></path>
<path d="M3.975 17.975h16"></path>
   `;
    }
  }
}
