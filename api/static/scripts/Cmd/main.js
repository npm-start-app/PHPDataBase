
const logout = async () => {
    await http.get('api/auth/logout/')

    localStorage.removeItem("user")
    localStorage.removeItem("role")

    window.location.href = '/'
}

if (localStorage.getItem('user') !== null) {
    document.getElementById("userName").innerHTML = `${JSON.parse(localStorage.getItem('user')).login}`
    document.getElementById("logoutI").style.display = 'block'
} else {
    window.location.href = '/'
}