import { Controller } from "@hotwired/stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
  connect() {
    const buttonDeletes = this.element.querySelectorAll(".produitContentGridActionDelete");

    buttonDeletes.forEach((buttonDelete) => {
        buttonDelete.addEventListener("click", () => {
            this.sendFormDataDelete();
        });
    });

  }
sendFormDataDelete() {
    const form = this.element.querySelector("form.produitContentGridAction");

    Swal.fire({
        title: 'Êtes-vous sûr de vouloir supprimer cette demande ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer !'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
}