import { AccessControl } from "./AccessControl.js";
import { Api } from "./Api.js";
import { Config } from "./Config.js";
import { Redirect } from "./Redirect.js";

const accessControl = new AccessControl()
const redirect = new Redirect(Config.site.root)
const api = new Api(Config.api.root)

accessControl.restricted()

const buttonBack = document.querySelector('#redirect-profile')
buttonBack.addEventListener('click', () => {
    redirect.to('/profile.html')
})

const buttonLogout = document.querySelector('#logout')
buttonLogout.addEventListener('click', () => {
    api.get('/login/logout').then(data => {
        if (data.status) { redirect.to('/index.html') }
    })
})

const photo = document.querySelector('input[name="photo"]')

photo.addEventListener('change', function() {
    
    const newPhoto = document.querySelector('input[name="photo"]').files[0]
    const photoPreview = document.querySelector('#form-photo-preview')

    const reader = new FileReader()

    reader.onloadend = function() {
        photoPreview.src = reader.result
    }
    // Adicionar filtro para receber somente imagens
    if (newPhoto) { reader.readAsDataURL(newPhoto)}

})

const form = document.querySelector('form')

form.addEventListener('submit', function(e) {
    
    e.preventDefault()

    const formData = new FormData(this)
    
    api.post('/users/1', formData).then(console.log).catch(console.log)

})