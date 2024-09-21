
const maxHTTPrequests = 15
let requests = 0

class http {
    static getDomain() {
        return window.location.origin + '/'
    }

    static getDriveDomain() {
        return 'https://drive-snowy.vercel.app/'
    }

    static getToken() {
        return (localStorage.getItem('token') !== null) ? localStorage.getItem('token') : false
    }

    static getProfileId() {
        return (localStorage.getItem('profileId') !== null) ? localStorage.getItem('profileId') : false
    }

    static getCsrf() {
        return (document.getElementById('csrf') !== null) ? document.getElementById('csrf').value : false
    }

    static isJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }

    static async post(url, data, domain = this.getDomain(), headers = null) {
        if (requests > maxHTTPrequests) {
            return new Error("Request limit")
        }

        requests++

        try {
            let contentType = (data instanceof FormData) ? null
                : ((this.isJSON(data)) ? 'application/json' : 'application/x-www-form-urlencoded')

            if (headers && contentType) headers['Content-Type'] = contentType
            
            let response

            if (contentType === null) {
                response = await fetch(domain + url, {
                    method: "POST",
                    mode: "cors",
                    cache: "no-cache",
                    credentials: "same-origin",
                    headers: (headers) ? headers : {
                        'token': this.getToken(),
                        'profileId': this.getProfileId(),
                        'csrf': this.getCsrf(),
                    },
                    referrerPolicy: "no-referrer",
                    body: data
                })
            } else {
                response = await fetch(domain + url, {
                    method: "POST",
                    mode: "cors",
                    cache: "no-cache",
                    credentials: "same-origin",
                    headers: (headers) ? headers : {
                        'token': this.getToken(),
                        'profileId': this.getProfileId(),
                        'csrf': this.getCsrf(),
                        'Content-Type': contentType
                    },
                    referrerPolicy: "no-referrer",
                    body: data
                })
            }

            const result = await response.json()

            requests--

            return {
                response,
                data: result
            }
        } catch (error) {
            requests--

            return new Error('Request error')
        }
    }

    static async get(url, data = null, domain = this.getDomain(), headers = null) {
        if (requests > maxHTTPrequests) {
            return new Error("Request limit")
        }

        requests++

        try {
            if (headers) headers['Content-Type'] = 'application/x-www-form-urlencoded'

            const response = await fetch(domain + url + ((data === null) ? '' : ('?' + data)), {
                method: "GET",
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                headers: (headers) ? headers : {
                    'token': this.getToken(),
                    'profileId': this.getProfileId(),
                    'csrf': this.getCsrf(),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                referrerPolicy: "no-referrer",
            })

            const result = await response.json()

            requests--

            return {
                response,
                data: result
            }
        } catch (error) {
            requests--

            return new Error('Request error')
        }
    }
}