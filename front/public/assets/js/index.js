import { Api } from "./Api.js"
import { Config } from "./Config.js"
import { Redirect } from "./Redirect.js"

let api = new Api(Config.api.root)
let redirect = new Redirect(Config.site.root)

const form = document.querySelector('form')

form.addEventListener('submit', (e) => {
    
    e.preventDefault()

    let formData = new FormData(this)

    const email = document.querySelector('input[type="email"]').value
    const password = document.querySelector('input[type="password"]').value

    formData.append('email', email)
    formData.append('password', password)

    api.post('/login', formData).then(data => {

        if (data.status) { redirect.to('/profile.html') }

        const errors = data.errors

        if (errors.type === 'validation') {

            console.log(errors.data)
        }

    })

})
