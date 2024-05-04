import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

export default class extends Controller {
  connect() {
    const checkboxes = this.element.querySelectorAll("input[name='favorite[]']");

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            this.sendFormDataFavoris(checkbox.checked, checkbox.value);
        });
      });
  }

  sendFormDataFavoris(checked, value) {
    console.log(`Checkbox value: ${value}, checked: ${checked}`);
    const form = this.element.querySelector('form.produitContentGridLike');
    const target = document.getElementById('targetFav');
    const url = form.getAttribute('action');
    const formData = new FormData();
    formData.append('checked', checked);
    formData.append('value', value);

    $.ajax({
        url: url,
        method: 'POST', 
        data: formData, 
        processData: false,
        contentType: false, 
        success: (response) => {
            if(target){
                $(target).html(response);
            }
            
          console.log('Succès de la requête AJAX');
        },
        error: function(error) {
          console.error('Erreur lors de la requête AJAX :', error);
        }
      });
  }

}