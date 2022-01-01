import { Api } from "./Api.js";

let api = new Api('http://localhost/authentication/back/api')

const form = document.querySelector('form')

form.addEventListener('submit', (e) => {
    
    e.preventDefault()

    let formData = new FormData(this)

    const email = document.querySelector('input[type="email"]').value
    const password = document.querySelector('input[type="password"]').value

    formData.append('email', email)
    formData.append('password', password)
    // verificar retorno e executar os caminhos
    api.post('/login', formData).then(console.log)

})
