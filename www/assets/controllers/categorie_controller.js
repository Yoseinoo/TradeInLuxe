import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["description", "showMoreButton", "showLessButton"];

    connect() {
        this.originalText = this.descriptionTarget.textContent.trim(); 
        this.toggleDescription(); 
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
    
}
