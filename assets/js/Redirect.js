export class Redirect
{
    constructor(base_url = null)
    {
        this.base_url = base_url
    }

    to(path_or_url)
    {
        window.location = this.base_url + path_or_url
    }
}
