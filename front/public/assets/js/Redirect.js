const redirect = (endpoint, extension = 'html') => {

    window.location = `http://localhost/authentication/front/public/${endpoint}.${extension}`

}

export default redirect