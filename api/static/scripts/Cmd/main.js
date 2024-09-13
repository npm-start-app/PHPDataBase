
let functions = {
    logout: true
}

const disableExitButton = (buttonId) => {
    document.getElementById('loader').style.display = 'block'
    document.getElementById(buttonId).classList.add('disabled')
    document.getElementById(buttonId).onclick = null
}

const logout = async () => {
    if (functions.logout) {
        functions.logout = false
        disableExitButton('logoutI')

        await http.get('api/auth/logout/')

        localStorage.removeItem("user")
        localStorage.removeItem("role")

        window.location.href = '/'
    }
}

if (localStorage.getItem('user') !== null) {
    document.getElementById("userName").innerHTML = `${JSON.parse(localStorage.getItem('user')).login}`
    document.getElementById("logoutI").style.display = 'block'
} else {
    window.location.href = '/'
}