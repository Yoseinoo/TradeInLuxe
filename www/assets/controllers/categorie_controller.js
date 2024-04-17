import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["description", "showMoreButton", "showLessButton", "filtres"];

    connect() {
        if(this.hasDescriptionTarget){
            this.originalText = this.descriptionTarget.textContent.trim(); 
            this.toggleDescription(); 
        }

        if(this.hasFiltresTarget){
         this.filters = this.element.querySelectorAll("li");
         this.hideExtraFilters();
        }

    }

    showMore() {
        this.descriptionTarget.textContent = this.originalText; 
        this.showMoreButtonTarget.style.display = "none"; 
        this.showLessButtonTarget.style.display = ""; 
    }

    showLess() {
        this.toggleDescription(); 
        this.showMoreButtonTarget.style.display = ""; 
        this.showLessButtonTarget.style.display = "none"; 
    }

    toggleDescription() {
        const maxLength = 250; 
        let truncated = this.originalText.slice(0, maxLength);
        if (this.originalText.length > maxLength) {
            truncated += '...'; 
        }
        this.descriptionTarget.textContent = truncated;
    }

    hideExtraFilters() {
        const maxFiltersToShow = 6; 
        const filtersCount = this.filters.length;

        // Masquer les filtres supplémentaires s'il y en a plus que le maximum autorisé
        if (filtersCount > maxFiltersToShow) {
            for (let i = maxFiltersToShow; i < filtersCount; i++) {
                this.filters[i].style.display = "none"; 
            }

            // Créer un bouton "Voir tout" si aucun n'existe déjà
            if (!this.element.querySelector(".produitFiltreShow")) {
                const showAllButton = document.createElement("a");
                showAllButton.textContent = "Voir tout";
                showAllButton.classList.add("produitFiltreShow"); 
                showAllButton.addEventListener("click", () => {
                    if (showAllButton.textContent === "Voir tout") {
                        this.showAllFilters();
                        showAllButton.textContent = "Voir moins";
                    } else {
                        this.hideExtraFilters();
                        showAllButton.textContent = "Voir tout";
                    }
                });

                this.element.querySelector("ul").insertAdjacentElement('afterend', showAllButton);
            }
        }
    }

    showAllFilters() {
        this.filters.forEach(filter => {
            filter.style.display = "";
        });
    }
}
