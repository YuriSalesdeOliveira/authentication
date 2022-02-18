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

    document.querySelector('#dropdown-photo').src = data.data.user.photo
    document.querySelector('#dropdown-username').innerHTML = data.data.user.name

    document.querySelector('#form-photo-preview').src = data.data.user.photo
    document.querySelector('#form-username').value = data.data.user.name
    document.querySelector('#form-bio').innerHTML = data.data.user.bio
    document.querySelector('#form-phone').value = data.data.user.phone
    document.querySelector('#form-email').value = data.data.user.email

})

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
    if (newPhoto) { reader.readAsDataURL(newPhoto) }

})

const form = document.querySelector('form')

form.addEventListener('submit', function(e) {
    
    e.preventDefault()

    const formData = new FormData(this)
    
    api.post('/users/1', formData).then(console.log).catch(console.log)

})