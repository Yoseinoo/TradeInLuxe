import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

export default class extends Controller {
  connect() {
    // Trouvez tous les champs du formulaire
    const checkboxes = this.element.querySelectorAll("input[type='checkbox']");
    const select = document.getElementById('triProduits');
    const deleteFiltersButton = document.getElementById('deleteFilters'); 

    // Ajoutez un gestionnaire d'événements pour le clic sur chaque case à cocher
    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", () => {
          this.sendFormData();
      });
    });

    // Ajouter un gestionnaire d'événements pour le changement de sélection
    select.addEventListener("change", () => {
      this.sendFormData();
    });

    this.preselectFilters();

    deleteFiltersButton.addEventListener("click", () => {
      this.resetFiltres();
  });

    this.checkFilters();

  }

  sendFormData() {
    const formData = new FormData(this.element);
    const target = document.getElementById('targetProduit');
    const select = document.getElementById('triProduits');
    // Ajoutez la valeur du select dans les données du formulaire
    formData.append('triProduits', select.value);

    // Envoyez le formulaire en AJAX
    $.ajax({
      url: this.element.action,
      method: this.element.method,
      data: formData,
      processData: false,
      contentType: false, 
    success: (response) => {
      $(target).html(response);
  
      // Appelez la méthode pour vérifier les filtres après avoir reçu la réponse
      this.checkFilters(); 
  
      const paginationLinks = document.querySelectorAll('.pagination a');
  
      paginationLinks.forEach((link) => {
          const url = new URL(link.href);
          
          const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
          const checkedFilters = Array.from(checkboxes).map((checkbox) => checkbox.name);
  
          // Vérifier la valeur du select
          if (select.value) {
              url.searchParams.set('triProduits', select.value);
          } else {
              url.searchParams.delete('triProduits');
          }
  
          // Ajouter les paramètres correspondant aux cases cochées
          checkboxes.forEach((checkbox) => {
              url.searchParams.append(checkbox.name, checkbox.value);
          });
  
          // Supprimer les paramètres de l'URL qui ne sont pas dans les cases cochées
          const paramsToRemove = Array.from(url.searchParams.keys()).filter((key) => !checkedFilters.includes(key) && key !== 'triProduits');
          paramsToRemove.forEach((param) => url.searchParams.delete(param));
  
          link.href = url.href;
      });
  },
      error: function(error) {
        console.error('Erreur lors de la requête AJAX :', error);
      }
    });
  }

  preselectFilters() {
    const urlParams = new URLSearchParams(window.location.search);
    // Parcourez chaque champ de formulaire et pré-sélectionnez les valeurs des filtres
    urlParams.forEach((value, key) => {
      if (key === 'triProduits') {
        const option = document.querySelector(`select[name="${key}"] option[value="${value}"]`);
        if (option) {
          option.selected = true;
        }
      } 
    });
  }

  resetFiltres() {
    // Réinitialisez tous les filtres en décochant toutes les cases cochées et en sélectionnant la première option du select.
    const checkboxes = this.element.querySelectorAll("input[type='checkbox']");
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    const select = document.getElementById('triProduits');
    select.selectedIndex = 0; // Sélectionnez la première option du select.

    // Appelez la méthode d'envoi de formulaire pour mettre à jour les résultats.
    this.sendFormData();
  }

  checkFilters() {
    // Vérifiez s'il y a des filtres actifs au chargement de la page.
    const checkboxes = this.element.querySelectorAll("input[type='checkbox']");
    const select = document.getElementById('triProduits');

    let filterActive = false;

    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        filterActive = true;
      }
    });

    if (select.value) {
      filterActive = true;
    }

    // Affichez ou masquez le bouton en fonction de l'état des filtres.
    const deleteFiltersButton = document.getElementById('deleteFilters');
    if (filterActive) {
      deleteFiltersButton.classList.remove('hidden');
    } else {
      deleteFiltersButton.classList.add('hidden');
    }
  }
}
