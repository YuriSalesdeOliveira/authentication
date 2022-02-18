import { Api } from "./Api.js"
import { Config } from "./Config.js"
import { Redirect } from "./Redirect.js"

const api = new Api(Config.api.root)
const redirect = new Redirect(Config.site.root)

const form = document.querySelector('form')

form.addEventListener('submit', function(e) {
    
    e.preventDefault()

    let messageContainers = document.querySelectorAll('.message')

    messageContainers.forEach(container => {

        container.innerText = ''
        container.className = 'message'

    })

    const formData = new FormData(this)

    api.post('/login', {body: formData}).then(data => {

        if (data.status) {
            
            window.localStorage.setItem('token', data.data.token)

            redirect.to('/profile.html')
        }

        const error = data.error

        if (error.type === 'validation' || error.type !== 'secret') {

            if (error.data.login) {

                document.querySelector('#login-message').innerText = error.data.login
                document.querySelector('#login-message').classList.add('highlight')
                document.querySelector('#login-message').classList.add('danger')
            }

            if (error.data.email) {
                
                document.querySelector('#email-message').innerText = error.data.email
                document.querySelector('#email-message').classList.add('danger')
            }

            if (error.data.password) {

                document.querySelector('#password-message').innerText = error.data.password
                document.querySelector('#password-message').classList.add('danger')
            }
        }
    })

})
