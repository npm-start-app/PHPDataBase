const token = "token";
const role = "role";

if (!localSettings.get("authBackgroundAnimation")) {
    const link = document.createElement('link')

    link.id = 'backgroundLImage'
    link.rel = 'stylesheet'
    link.href = `${http.getDomain()}static/styles/Auth/backgroundWithoutAnim.css`

    document.head.appendChild(link)

    document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="fa-solid fa-photo-film"></i>`
} else {
    const link = document.createElement('link')

    link.id = 'backgroundLVideo'
    link.rel = 'stylesheet'
    link.href = `${http.getDomain()}static/styles/Auth/background.css`

    document.head.appendChild(link)

    document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="fa-regular fa-images"></i>`
}

const backgroundAnimationSwitcher = () => {
    localSettings.set("authBackgroundAnimation", !localSettings.get("authBackgroundAnimation"))

    if (document.getElementById("yellowBox1").classList.contains('transition')) {
        document.getElementById("yellowBox1").classList.remove('transition')
        document.getElementById("yellowBox2").classList.remove('transition')
    }
    document.getElementById('authBack').remove()

    if (!localSettings.get("authBackgroundAnimation")) {
        document.getElementById('backgroundLVideo').remove()

        const link = document.createElement('link')

        link.id = 'backgroundLImage'
        link.rel = 'stylesheet'
        link.href = `${http.getDomain()}static/styles/Auth/backgroundWithoutAnim.css`

        document.head.appendChild(link)

        document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="fa-solid fa-photo-film"></i>`
    } else {
        document.getElementById('backgroundLImage').remove()

        const link = document.createElement('link')

        link.id = 'backgroundLVideo'
        link.rel = 'stylesheet'
        link.href = `${http.getDomain()}static/styles/Auth/background.css`

        document.head.appendChild(link)

        document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="fa-regular fa-images"></i>`
    }
}

document.getElementById('logo').addEventListener("mouseover", (e) => {

    if (!document.getElementById("yellowBox1").classList.contains('transition')) {
        document.getElementById("yellowBox1").classList.add('transition')
        document.getElementById("yellowBox2").classList.add('transition')
    }

    if (!document.getElementById('tempLink')) {
        const link = document.createElement('link')

        link.id = 'tempLink'
        link.rel = 'stylesheet'
        link.href = `${http.getDomain()}static/styles/Auth/addBackground.css`

        document.head.appendChild(link)
    }
})
document.getElementById('logo').addEventListener("mouseleave", (e) => {
    document.getElementById('tempLink').remove()
})

const checkTheAuthToken = async () => {
    const params = new URLSearchParams();
    params.append('token', document.getElementById("token").value);

    let result = await http.get('api/auth/checkToken', params)

    document.getElementById("errorMSG").innerHTML = `${(result.data.status === true) ? Success(result.data.role) : "Your token is not correct."}`
}

const dataValidation = async () => {
    const data = {
        login: document.getElementById("login").value,
        password: document.getElementById("password").value
    }

    let result = await http.post('api/auth/signIn', JSON.stringify(data))

    if (result.data.status === true) {
        localStorage.setItem("user", result.data.user)
        localStorage.removeItem("token")

        window.location.href = '/';
    } else {
        document.getElementById("errorMSG").innerHTML = `${result.data.message}`
    }
}

const dataValidationLogin = async () => {
    const data = {
        login: document.getElementById("login").value,
        password: document.getElementById("password").value
    }

    let result = await http.post('api/auth/login', JSON.stringify(data))

    if (result.data.status === true) {
        localStorage.setItem("user", result.data.user)

        window.location.href = '/';
    } else {
        document.getElementById("errorMSG").innerHTML = `${result.data.message}`
    }
}

const setTokenFormValue = (token) => {
    document.getElementById('token').value = token
}

const tokenForm = () => {
    document.getElementById('inputs').innerHTML = `
        <div class="input">
            <label for="token">Token</label>
            <input type="text" id="token" name="token" required/>
        </div>
    `

    setTokenFormValue((localStorage.getItem(token) === null) ? "" : localStorage.getItem(token))

    document.getElementById('back').style.display = 'none'
    document.getElementById('button').onclick = () => checkTheAuthToken()
}

const regForm = () => {
    document.getElementById("inputs").innerHTML = `
        <div class="input">
            <label for="username">Username</label>
            <input type="text" id="login" name="username" required/>
        </div>
        <div class="input">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required/>
        </div>
        <div class="input">
            <label for="role">Role</label>
            <input type="text" id="role" name="role" value="${(localStorage.getItem(role) === null) ? "" : localStorage.getItem(role)}" readonly required/>
        </div>
    `
}

const Success = (role) => {
    localStorage.setItem("token", document.getElementById("token").value)
    localStorage.setItem("role", role)

    regForm()

    document.getElementById('back').style.display = 'flex'
    document.getElementById('button').onclick = () => dataValidation()

    return ''
}

if ((new URLSearchParams(document.location.search)).get("reg") !== null) {
    setTokenFormValue((localStorage.getItem(token) === null) ? "" : localStorage.getItem(token))
}

// if (localStorage.getItem('user') !== null) {
//     window.location.href = '/'
// }