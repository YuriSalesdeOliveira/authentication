import { AccessControl } from "./AccessControl.js";
import { Config } from "./Config.js";
import { Redirect } from "./Redirect.js";

const accessControl = new AccessControl()
const redirect = new Redirect(Config.site.root)

accessControl.restricted()

const redirectProfileEdit = document.querySelector('#redirect-profile-edit')
redirectProfileEdit.addEventListener('click', () => {
    redirect.to('/profileEdit.html')
})
