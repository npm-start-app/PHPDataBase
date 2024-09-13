
let functions = {
    logout: true,
    auth: true
}

const disableExitButton = (buttonId) => {
    document.getElementById('loader').style.display = 'block'
    document.getElementById(buttonId).classList.add('disabled')
    document.getElementById(buttonId).onclick = null
}

const checkAuth = async () => {
    if (functions.auth) {
        functions.auth = false

        const result = await Auth.check()

        if (result) {
            document.getElementById("userName").innerHTML = `${JSON.parse(localStorage.getItem('user')).login}`

            document.getElementById("logoutI").style.display = 'block'

            document.getElementById('user').href = '/account'
        } else {
            document.getElementById('navbar').innerHTML += `
            <li>
                <div><a href="${http.getDomain()}auth?login">Log in</a></div>
                <div><a href="${http.getDomain()}auth?login">Log in</a></div>
            </li>
            <li>
                <div><a href="${http.getDomain()}auth?reg">Sign in</a></div>
                <div><a href="${http.getDomain()}auth?reg">Sign in</a></div>
            </li>
        `
        }

        functions.auth = true
    }
}

const logout = async () => {
    if (functions.logout) {
        functions.logout = false
        disableExitButton('logoutI')

        await http.get('api/auth/logout/')

        localStorage.removeItem("user")
        localStorage.removeItem("role")

        window.location = '/'
    }
}

checkAuth()