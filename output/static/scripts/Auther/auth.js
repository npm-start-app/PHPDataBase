
class Auth {
    static async check(returnUserData = false, location = '') {
        try {
            const data = new URLSearchParams()
            data.append('route', window.location.pathname + location)

            let result = await http.get('api/auth', data)
    
            if (result.response.ok && result.data.status === true) {
                localStorage.setItem('user', JSON.stringify(result.data.user))

                if (returnUserData) {
                    return result.data.user
                } else {
                    return true
                }
            }

            if (localStorage.getItem('user') !== null) {
                localStorage.removeItem('user')
            }
            
            return false
        } catch (error) {
            if (localStorage.getItem('user') !== null) {
                localStorage.removeItem('user')
            }

            return false
        }
    }
}