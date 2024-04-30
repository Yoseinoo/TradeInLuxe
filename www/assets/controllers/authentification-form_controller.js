import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  
  static targets = ["password", "confirmPassword"]

  connect(){
    if(this.passwordTarget && document.getElementById('passwordRequirements')){
      this.passwordTarget.addEventListener('input', () => this.handlePasswordInput());
    }
  }

  showPassword() {
    this.passwordTarget.type = this.passwordTarget.type === 'password' ? 'text' : 'password';
    const spanElement = document.getElementById('spanIcon');

    if (spanElement.className == "s") {
      const svgContent = `<svg width="22" height="22" fill="none" stroke="#2e2e2e" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 8c.317.61.798 1.175 1.411 1.678C6.131 11.087 8.89 12 12 12c3.11 0 5.87-.913 7.589-2.322C20.202 9.175 20.683 8.61 21 8"></path>
        <path d="m14.489 12 1.035 3.864"></path>
        <path d="m18.677 10.677 2.828 2.828"></path>
        <path d="m2.5 13.505 2.828-2.828"></path>
        <path d="M8.464 15.864 9.499 12"></path>
      </svg>`;
        spanElement.className = "h"
        spanElement.innerHTML = svgContent;
  } else {
    const svgContent = `<svg width="20" height="20" fill="#2e2e2e" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M3.347 11.094a12.702 12.702 0 0 1 4.196-3.11A5.978 5.978 0 0 0 6 12a5.98 5.98 0 0 0 1.543 4.017 12.703 12.703 0 0 1-4.196-3.111 1.355 1.355 0 0 1 0-1.812Zm-.749-.662c1.704-1.929 4.943-4.386 9.313-4.431L12 6h.035c4.433 0 7.717 2.485 9.437 4.432a2.354 2.354 0 0 1 0 3.136C19.752 15.515 16.468 18 12.035 18h-.125c-4.37-.046-7.608-2.503-9.312-4.432a2.354 2.354 0 0 1 0-3.136ZM12.014 7h-.09a5 5 0 1 0 .09 0ZM18 12c0 1.57-.603 3-1.59 4.07 1.886-.83 3.353-2.078 4.312-3.164a1.355 1.355 0 0 0 0-1.812c-.96-1.086-2.426-2.334-4.313-3.163A5.979 5.979 0 0 1 18 12Zm-5.965 3a3 3 0 0 0 2.707-4.293 1 1 0 1 1-1.414-1.414A3 3 0 1 0 12.035 15Z" clip-rule="evenodd"></path>
      </svg>`;
      spanElement.className = "s"
      spanElement.innerHTML = svgContent;
  }
    if (this.hasConfirmPasswordTarget) {
      this.confirmPasswordTarget.type = this.confirmPasswordTarget.type === 'password' ? 'text' : 'password';
    }
  }

  disable(event) {
    event.target.disabled = true; 
    event.target.form.submit(); 
  }

  handlePasswordInput() {
    let passwordRequirements = document.getElementById('passwordRequirements');
    if (passwordRequirements.style.display === 'none') {
      passwordRequirements.style.display = 'flex';
    }
    this.updatePasswordCriteria();
  }

  updatePasswordCriteria() {
    this.checkAndApplyColor('lowercase', /(?=.*[a-z])/);
    this.checkAndApplyColor('uppercase', /(?=.*[A-Z])/);
    this.checkAndApplyColor('digit', /(?=.*\d)/);
    this.checkAndApplyColor('specialChar', /(?=.*[\W_])/);
    this.checkAndApplyColor('length', /^.{6,}$/);

    var allConditionsMet = Array.from(document.getElementById('passwordRequirements').children).every(function(element) {
      return element.classList.contains('valid');
    });

    if (allConditionsMet) {
      document.getElementById('passwordRequirements').style.display = 'none';
    } else {
      document.getElementById('passwordRequirements').style.display = 'flex';
    }
  }

  checkAndApplyColor(elementId, condition) {
    var element = document.getElementById(elementId);
    if (condition.test(this.passwordTarget.value)) {
      element.classList.remove('invalid');
      element.classList.add('valid');
    } else {
      element.classList.remove('valid');
      element.classList.add('invalid');
    }
  }
}
