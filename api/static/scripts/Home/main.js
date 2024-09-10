
const startAnim = () => {
    window.location.href = '#r'

    const el = document.getElementById("animTestLine")
    if (el.classList.contains("_anim")) return el.classList.remove("_anim")

    el.classList.add("_anim")
    setTimeout(() => {
        const el = document.getElementById("animTestMainLine")
        const el1 = document.getElementById("animTestSupLine")

        el.classList.add("_anim1")
        el1.classList.add("_anim")

        setTimeout(() => {
            const el = document.getElementById("animTestSup1Line")

            el.classList.add("_anim")
        }, 300);
    }, 300);
}

const checkAuth = async () => {
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
}

const logout = async () => {
    await http.get('api/auth/logout/')

    localStorage.removeItem("user")
    localStorage.removeItem("role")

    window.location = '/'
}

checkAuth()