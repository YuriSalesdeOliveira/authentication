import { AccessControl } from "./AccessControl.js";

let accessControl = new AccessControl()

accessControl.restricted()

let photo = document.querySelector('input[name="photo"]')

photo.addEventListener('change', function() {
    console.log(this.value)
})