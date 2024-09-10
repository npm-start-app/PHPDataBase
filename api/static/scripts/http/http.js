
class http {
    static getDomain() {
        return window.location.href
    }

    static getDriveDomain() {
        return 'http://localhost:1111/'
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

    static async post(url, data, domain = this.getDomain()) {
        let contentType = (data instanceof FormData) ? null
            : ((this.isJSON(data)) ? 'application/json' : 'application/x-www-form-urlencoded')

        let response

        if (contentType === null) {
            response = await fetch(domain + url, {
                method: "POST",
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                headers: {
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
                headers: {
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

        return {
            response,
            data: result
        }
    }

    static async get(url, data = null, domain = this.getDomain()) {
        const response = await fetch(domain + url + ((data === null) ? '' : ('?' + data)), {
            method: "GET",
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                'token': this.getToken(),
                'profileId': this.getProfileId(),
                'csrf': this.getCsrf(),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            referrerPolicy: "no-referrer",
        })

        const result = await response.json()

        return {
            response,
            data: result
        }
    }
}
