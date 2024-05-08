import { Controller } from "@hotwired/stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
  connect() {
    const buttonDeletes = this.element.querySelectorAll(".produitContentGridActionDelete");
    const buttonValidates = this.element.querySelectorAll(".produitContentGridActionValidate");

    buttonDeletes.forEach((buttonDelete) => {
        buttonDelete.addEventListener("click", () => {
            this.sendFormDataDelete();
        });
    });

    buttonValidates.forEach((buttonValidate) => {
        buttonValidate.addEventListener("click", () => {
            this.sendFormDataValidate();
            
        });
    });

  }
sendFormDataDelete() {
    let form = this.element.querySelector("form.containerPreviewFormAction");
   
    Swal.fire({
        title: 'Êtes-vous sûr de vouloir refuser cette article ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, supprimer !'
    }).then((result) => {
        if (result.isConfirmed) {
            let inputHiddenPoints = form.querySelector("[name='points']");
            let inputHiddenAccept = form.querySelector("[name^='acceptOffreId']");
            if (inputHiddenPoints) {
                inputHiddenPoints.remove();
                inputHiddenAccept.remove();
            }
            form.submit();
        }
    });
}

sendFormDataValidate() {
    let form = this.element.querySelector("form.containerPreviewFormAction");

    Swal.fire({
        title: 'Êtes-vous sûr de vouloir valider cette article ?',
        text: "Cette action est irréversible !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, valider !'
    }).then((result) => {
        if (result.isConfirmed) {
            let inputHiddenDelete = form.querySelector("[name^='deleteOffreId']");
            let pointsInput = form.querySelector("#points");
            let points = pointsInput.value.trim();

            if (points !== "" && !isNaN(parseInt(points))) {
                if (inputHiddenDelete) {
                    inputHiddenDelete.remove();
                }
                form.submit();
            } else {
                Swal.fire({
                    title: 'Erreur',
                    text: 'La valeur des points doit être un entier non vide.',
                    icon: 'error'
                });
            }
        }
    });
}
}