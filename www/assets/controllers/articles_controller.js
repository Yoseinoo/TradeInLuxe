import { Controller } from "@hotwired/stimulus";
import $ from "jquery";
import Swal from "sweetalert2";

export default class extends Controller {
  connect() {
    const buttonUpdates = this.element.querySelectorAll(".produitContentGridActionUpdate");
    const buttonDeletes = this.element.querySelectorAll(".produitContentGridActionDelete");

    buttonUpdates.forEach((buttonUpdate) => {
        buttonUpdate.addEventListener("click", () => {
            this.sendFormDataUpdate(buttonUpdate.id);
        });
    });

    buttonDeletes.forEach((buttonDelete) => {
        buttonDelete.addEventListener("click", () => {
            this.sendFormDataDelete(buttonDelete.id);
        });
    });

  }
  setPreview(articleId, url){
    const targetPreview = document.getElementById("targetPreview");
    const formData = new FormData();
    formData.append("article", articleId);
    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
            if (targetPreview) {
                targetPreview.style.display = "";
                $(targetPreview).html(response);
              }
            console.log("Succès de la requête AJAX de suppression");
        },
        error: function (error) {
            console.error("Erreur lors de la requête AJAX de suppression :", error);
        },
    });
  }

  sendFormDataUpdate(buttonId) {
    const form = this.element.querySelector("form.produitContentGridAction");
    const url = form.getAttribute("action");
    const urlPreview = form.getAttribute("url-preview");
    const target = document.getElementById("targetArticleUpdate") ?? document.getElementById("targetUpdateProduit") ;
    const inputId = "inputHidden_" + buttonId.split("_")[1];
    const inputHidden = document.getElementById(inputId);
    const articleId = inputHidden.value;
    const formData = new FormData();
    let type = 'article';
    if (form.id == 'formGestion') {
      type = 'produit';
    }
    formData.append(type, articleId);
    formData.append("action", 'update');
console.log(type,   articleId    ,target, form.id   , urlPreview )
    Swal.fire({
        title: 'Êtes-vous sûr de vouloir modifier cet élément ?',
        text: "Cela est sans risque !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, modifier !'
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if (target) {
                        $(target).html(response);
                        if(form.id !== 'formGestion'){
                            this.setPreview(articleId, urlPreview);
                        }
                        
                      }
                    console.log("Succès de la requête AJAX d'update");
                },
                error: function (error) {
                    console.error("Erreur lors de la requête AJAX de suppression :", error);
                },
            });
        }
    });
  }

  

  sendFormDataDelete(buttonId) {
    const form = this.element.querySelector("form.produitContentGridAction");
    const url = form.getAttribute("action");
    const target = document.getElementById("targetArticle") ?? document.getElementById("targetUpdateProduit") ;
    const inputId = "inputHidden_" + buttonId.split("_")[1];
    const inputHidden = document.getElementById(inputId);
    const articleId = inputHidden.value;
    const formData = new FormData();
    let type = 'article';
    if (form.id == 'formGestion') {
      type = 'produit';
    }
    formData.append(type, articleId);
    formData.append("action", 'delete');

    Swal.fire({
        title: 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Annuler',
        confirmButtonText: 'Oui, supprimer !'
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if (target) {
                        $(target).html(response);
                      }
                    console.log("Succès de la requête AJAX de suppression");
                },
                error: function (error) {
                    console.error("Erreur lors de la requête AJAX de suppression :", error);
                },
            });
        }
    });
}

}
