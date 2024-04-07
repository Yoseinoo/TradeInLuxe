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
