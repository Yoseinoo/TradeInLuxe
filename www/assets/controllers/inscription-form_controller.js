import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  
  static targets = ["password", "confirmPassword"]

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
}
