import { Api } from "./Api.js";
import { Config } from "./Config.js";
import { Redirect } from "./Redirect.js";

const redirect = new Redirect(Config.site.root)
const api = new Api(Config.api.root)

api.get(
    '/users/authenticate',
    {
        headers: {
            Authorization: window.localStorage.getItem('token')
        }
    }
).then(data => {

    if (!data.status) {

    }

    document.querySelector('#dropdown-username').innerHTML = data.data.user.name
    document.querySelector('#dropdown-photo').src = data.data.user.photo
    document.querySelector('#profile-photo').src = data.data.user.photo

    document.querySelector('#profile-username').innerHTML = data.data.user.name
    document.querySelector('#profile-bio').innerHTML = data.data.user.bio
    document.querySelector('#profile-phone').innerHTML = data.data.user.phone
    document.querySelector('#profile-email').innerHTML = data.data.user.email

})

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
