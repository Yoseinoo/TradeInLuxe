import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    // Sélection de tous les champs input de type "file"
    const fileInputs = this.element.querySelectorAll("input[type='file']");

    // Écouteur d'événement pour chaque champ input de type "file"
    fileInputs.forEach(input => {
      input.addEventListener("change", () => {
        this.updateFileInputsRequired(fileInputs);
      });
    });
  }

  // Méthode pour mettre à jour l'attribut "required" des champs input de type "file"
  updateFileInputsRequired(fileInputs) {
    // Vérification si au moins un champ input de type "file" est rempli
    const atLeastOneFilled = Array.from(fileInputs).some(input => input.files.length > 0);

    // Affectation de l'attribut "required" à tous les champs input de type "file"
    fileInputs.forEach(input => {
      input.required = atLeastOneFilled;
    });
  }
}
