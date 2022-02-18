export class Api
{
    constructor(base_url)
    {
        this.base_url = base_url
    }

    async get(endpoint, myRequest = {})
    {
        const defaultRequest = { method: 'GET' }

        try {

            const reponse = await fetch(
                this.base_url + endpoint,
                {...defaultRequest, ...myRequest}
            )

            const data = await reponse.json()

            return data

        } catch (error) {
            console.log(error)
        }
    }

    async post(endpoint, myRequest)
    {
        const defaultRequest =  { method: 'POST' }

        try {

            const reponse = await fetch(
                this.base_url + endpoint,
                {...defaultRequest, ...myRequest}
            )

            const data = await reponse.json()

            return data

        } catch (error) {
            console.log(error)
        }
    }
}