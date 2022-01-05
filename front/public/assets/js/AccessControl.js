import { Api } from "./Api.js"
import { Config } from "./Config.js"
import { Redirect } from "./Redirect.js"

const api = new Api(Config.api.root)
const redirect = new Redirect(Config.site.root)

export class AccessControl
{
    restricted()
    {
        api.get('/login/logged').then(data => {

            if (!data.status) redirect.to('/index.html')

        })
    }
}