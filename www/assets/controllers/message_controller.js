import { Controller } from "stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
    static values = {
        title: String,
        message: String,
        type: String
    }

    connect() {
        this.showSwal(this.titleValue, this.messageValue, this.typeValue);
    }

    showSwal(title, message, type) {
        Swal.fire({
            title: title,
            text: message,
            icon: type,
            confirmButtonText: 'Fermer'
        });
    }
}