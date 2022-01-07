import { AccessControl } from "./AccessControl.js";
import { Api } from "./Api.js";
import { Config } from "./Config.js";
import { Redirect } from "./Redirect.js";

const accessControl = new AccessControl()
const redirect = new Redirect(Config.site.root)
const api = new Api(Config.api.root)

accessControl.restricted()

const redirectProfileEdit = document.querySelector('#redirect-profile-edit')
redirectProfileEdit.addEventListener('click', () => {
    redirect.to('/profileEdit.html')
})

const buttonLogout = document.querySelector('#logout')
buttonLogout.addEventListener('click', () => {
    api.get('/login/logout').then(data => {
        if (data.status) { redirect.to('/index.html') }
    })
})
