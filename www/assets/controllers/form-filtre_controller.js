import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

export default class extends Controller {
  connect() {
    // Trouvez tous les champs du formulaire
    const checkboxes = this.element.querySelectorAll("input[type='checkbox']");
    const target = document.getElementById('targetProduit')

    // Ajoutez un gestionnaire d'événements pour le clic sur chaque case à cocher
    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", () => {
        // Sérialisez les données du formulaire
        const formData = $(this.element).serialize();

        // Envoyez le formulaire en AJAX
        $.ajax({
          url: this.element.action,
          method: this.element.method,
          data: formData,
          success: function(response) {
            $(target).html(response);
          },
          error: function(error) {
          }
        });
      });
    });
  }
}
