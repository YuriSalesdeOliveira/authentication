export function redirect(endpoint, extension = 'html')
{
    window.location = `http://localhost/authentication/front/public/${endpoint}.${extension}`
}