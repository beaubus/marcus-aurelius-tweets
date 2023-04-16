/**
 * Helper function to simplify fetching get queries in json
 *
 * @param url
 * @param params
 * @param callback
 * @param callbackError
 */
function get(url, params, callback, callbackError = null)
{
    fetch(url + '?' + new URLSearchParams(params), {
        method: 'GET',
    }).then(response => {
        if (!response.ok) {
            return response.json().then(error => {
                throw error
            })
        }
        return response.json()
    }).then(data => {
        callback(data)
    }).catch(error => {
        callbackError ? callbackError() : console.log(error?.message ?? error)
    })
}

export {get}