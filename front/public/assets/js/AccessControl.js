import { Api } from "./Api.js"
import { redirect } from "./Redirect.js"

let api = new Api('http://localhost/authentication/back/api')

export class AccessControl
{
    restricted()
    {
        api.get('/login/logged').then(data => {

            if (!data.status) redirect('index')

        })
    }
}