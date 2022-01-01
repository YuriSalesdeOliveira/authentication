export class Api
{
    constructor(base_url)
    {
        this.base_url = base_url
    }

    async get(endpoint)
    {
        const myRequest = { method: 'GET' }

        try {

            const reponse = await fetch(this.base_url + endpoint, myRequest)

            const data = await reponse.json()

            return data

        } catch (error) {
            console.log(error)
        }
    }

    async post(endpoint, data)
    {
        const myRequest =  { method: 'POST', body: data }

        try {

            const reponse = await fetch(this.base_url + endpoint, myRequest)

            const data = await reponse.json()

            return data

        } catch (error) {
            console.log(error)
        }
    }
}