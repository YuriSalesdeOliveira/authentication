import { Api } from "./Api.js"
import { Config } from "./Config.js"
import { Redirect } from "./Redirect.js"

const api = new Api(Config.api.root)
const redirect = new Redirect(Config.site.root)

const form = document.querySelector('form')

form.addEventListener('submit', function(e) {
    
    e.preventDefault()

    const formData = new FormData(this)

    api.post('/login', formData).then(data => {
        console.log(data)
        // if (data.status) { redirect.to('/profile.html') }

        // const error = data.error

        // if (error.type === 'validation') {

        //     console.log(error.data)
        // }

    })

})