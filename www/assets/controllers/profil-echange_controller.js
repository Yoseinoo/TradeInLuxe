import { Controller } from "@hotwired/stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
  connect() {
    const buttonDeletes = this.element.querySelectorAll(".produitContentGridActionDelete");
    const buttonValidates = this.element.querySelectorAll(".produitContentGridActionValidate");

    buttonDeletes.forEach((buttonDelete) => {
        buttonDelete.addEventListener("click", () => {
            let texte = 'demande';
            if(buttonDelete.textContent == 'Refuser'){
                texte = 'offre'
            }
            this.sendFormDataDelete(texte);
        });
    });

    buttonValidates.forEach((buttonValidate) => {
        buttonValidate.addEventListener("click", () => {
            const isTransporteurButton = buttonValidate.hasAttribute('button-transporteur') && buttonValidate.getAttribute('button-transporteur') === 'transporteur';
        
            if (!isTransporteurButton) {
                this.sendFormDataValidate();
            }
        });
    });

  }
sendFormDataDelete(texte) {
    const form = this.element.querySelector("form.produitContentGridAction");
    if (texte === 'offre') {
        const inputHiddenAccept = form.querySelector("[name^='acceptOffreId']");
        if (inputHiddenAccept) {
            inputHiddenAccept.remove();
        }
    }
    Swal.fire({
        title: 'Êtes-vous sûr de vouloir supprimer cette '+texte+ '?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, supprimer !'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

sendFormDataValidate() {
    const form = this.element.querySelector("form.produitContentGridAction");
    const inputHiddenAccept = form.querySelector("[name^='deleteOffreId']");
    if (inputHiddenAccept) {
        inputHiddenAccept.remove();
    }


    Swal.fire({
        title: 'Êtes-vous sûr de vouloir valider cette offre ?',
        text: "Cette action est irréversible !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, valider !'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
}