import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

export default class extends Controller {
  connect() {
    const button =  document.getElementById('button');

  
    button.addEventListener("click", () => {
        
      this.sendFormData();
    });
     
  }

  sendFormData() {
    const form = document.getElementById('formUser');
    const target = document.getElementById('targetUser');
    const url = form.getAttribute('action');
    const formData = new FormData();

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