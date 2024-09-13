
let functionsAUTH = {
    auth: true
}

class Auth {
    static async check(returnUserData = false, location = '') {
        if (functionsAUTH.auth) {
            functionsAUTH.auth = false

            try {
                const data = new URLSearchParams()
                data.append('route', window.location.pathname + location)

                let result = await http.get('api/auth', data)

                if (result.response.ok && result.data.status === true) {
                    localStorage.setItem('user', JSON.stringify(result.data.user))

                    functionsAUTH.auth = true

                    if (returnUserData) {
                        return result.data.user
                    } else {
                        return true
                    }
                }

                if (localStorage.getItem('user') !== null) {
                    localStorage.removeItem('user')
                }

                functionsAUTH.auth = true

                return false
            } catch (error) {
                if (localStorage.getItem('user') !== null) {
                    localStorage.removeItem('user')
                }

                functionsAUTH.auth = true

                return false
            }
        }
    }
}