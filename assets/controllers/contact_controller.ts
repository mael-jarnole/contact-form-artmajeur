import { Controller } from '@hotwired/stimulus';

export default class extends Controller<HTMLFormElement> {

    connect() {
        this.element.addEventListener('change', () => {
            console.log('isFormValid', this.isFormValid());
            if (this.isFormValid()) {
                // do something
            } else {
                // do something
            }
        })
    }

    isFormValid(): boolean {
        return this.element.checkValidity();
    }
}
