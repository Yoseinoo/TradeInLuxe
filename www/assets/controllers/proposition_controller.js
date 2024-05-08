import { Controller } from "stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
  connect() {}
  
  submit(event) {
    event.preventDefault();

    Swal.fire({
      title: "Êtes-vous sûr ?",
      text: "Voulez-vous vraiment utiliser vos points ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Oui",
      cancelButtonText: "Annuler",
    }).then((result) => {
      if (result.isConfirmed) {
        this.element.submit();
      }
    });
  }
}
