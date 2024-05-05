import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = [ 'fields', 'field', 'addButton' ]

    static values = {
        prototype: String,
        maxItems: Number,
        itemsCount: Number,
        autoload: Boolean
    };
  connect() {
    this.index = this.itemsCountValue = this.fieldTargets.length;

    if (this.autoloadValue) {

      const maxItems = this.maxItemsValue;

      for (let i = this.itemsCountValue; i < maxItems; i++) {
          this.addItem();
      }
    }
  }

  addItem() {
    let prototype = JSON.parse(this.prototypeValue);
    const newField = prototype.replace(/__name__/g, this.index);
    this.fieldsTarget.insertAdjacentHTML("beforeend", newField);

    this.index++;
    this.itemsCountValue++;
}

}