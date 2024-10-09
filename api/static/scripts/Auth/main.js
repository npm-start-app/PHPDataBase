const token = "token";
const role = "role";

let tasks = 0
let functions = {
    login: true,
    signin: true,
    checktoken: true
}

const setBackgroundImageAndVideo = (remove, add) => {
    // Left class boxes
    document.getElementById('leftbox1').classList.remove(remove[0])
    document.getElementById('leftbox1').classList.add(add[0])
    document.getElementById('leftbox1').classList.remove(remove[3])
    document.getElementById('leftbox1').classList.add(add[3])

    document.getElementById('leftbox2').classList.remove(remove[0])
    document.getElementById('leftbox2').classList.add(add[0])

    document.getElementById('leftbox3').classList.remove(remove[0])
    document.getElementById('leftbox3').classList.add(add[0])
    document.getElementById('leftbox3').classList.remove(remove[3])
    document.getElementById('leftbox3').classList.add(add[3])

    document.getElementById('leftbox4').classList.remove(remove[0])
    document.getElementById('leftbox4').classList.add(add[0])
    document.getElementById('leftbox4').classList.remove(remove[2])
    document.getElementById('leftbox4').classList.add(add[2])

    // Right class boxes
    document.getElementById('rightbox1').classList.remove(remove[1])
    document.getElementById('rightbox1').classList.add(add[1])
    document.getElementById('rightbox1').classList.remove(remove[2])
    document.getElementById('rightbox1').classList.add(add[2])

    document.getElementById('rightbox2').classList.remove(remove[1])
    document.getElementById('rightbox2').classList.add(add[1])

    document.getElementById('rightbox3').classList.remove(remove[1])
    document.getElementById('rightbox3').classList.add(add[1])
    document.getElementById('rightbox3').classList.remove(remove[2])
    document.getElementById('rightbox3').classList.add(add[2])
}

if (!localSettings.get("authBackgroundAnimation")) {
    setBackgroundImageAndVideo(['animationRightLeft', 'animationLeftRight', 'tans3s', 'tans4s'],
        ['animationRightLeftI', 'animationLeftRightI', 'tans3sI', 'tans4sI'])

    document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="backgroundIcon fa-solid fa-photo-film icon"></i>`
} else {
    document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="backgroundIcon fa-regular fa-images icon"></i>`
}

const backgroundAnimationSwitcher = () => {
    localSettings.set("authBackgroundAnimation", !localSettings.get("authBackgroundAnimation"))

    document.getElementById('authBack').remove()

    if (!localSettings.get("authBackgroundAnimation")) {
        setBackgroundImageAndVideo(['animationRightLeft', 'animationLeftRight', 'tans3s', 'tans4s'],
            ['animationRightLeftI', 'animationLeftRightI', 'tans3sI', 'tans4sI'])

        document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="backgroundIcon fa-solid fa-photo-film icon"></i>`
    } else {
        setBackgroundImageAndVideo(['animationRightLeftI', 'animationLeftRightI', 'tans3sI', 'tans4sI'],
            ['animationRightLeft', 'animationLeftRight', 'tans3s', 'tans4s'])

        document.getElementById("Icons").innerHTML += `<i onclick="backgroundAnimationSwitcher()" id="authBack" class="backgroundIcon fa-regular fa-images icon"></i>`
    }
}

document.getElementById('logo').addEventListener("mouseover", (e) => {
    document.getElementById('rightbox2').classList.remove('box-background--blue')
    document.getElementById('rightbox2').classList.add('box-background--blueH')

    document.getElementById('leftbox2').classList.remove('box-background--blue')
    document.getElementById('leftbox2').classList.add('box-background--blueH')
})
document.getElementById('logo').addEventListener("mouseleave", (e) => {
    document.getElementById('rightbox2').classList.remove('box-background--blueH')
    document.getElementById('rightbox2').classList.add('box-background--blue')

    document.getElementById('leftbox2').classList.remove('box-background--blueH')
    document.getElementById('leftbox2').classList.add('box-background--blue')
})

const checkTheAuthToken = async () => {
    if (functions.checktoken) {
        disableButton('button')
        functions.checktoken = false

        const params = new URLSearchParams();
        params.append('token', document.getElementById("token").value);

        let result = await http.get('api/auth/checkToken', params)

        document.getElementById("errorMSG").innerHTML = `${(result.data.status === true) ? Success(result.data.role) : "Your token is not correct."}`

        functions.checktoken = true
        enableButton('button')
    }
}

const dataValidation = async () => {
    if (functions.signin) {
        disableButton('button')
        functions.signin = false

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

        functions.signin = true
        enableButton('button')
    }
}

const disableButton = (buttonId) => {
    document.getElementById('loader').style.display = 'block'
    document.getElementById(buttonId).disabled = true
    tasks++
}

const enableButton = (buttonId) => {
    tasks--
    if (tasks === 0) document.getElementById('loader').style.display = 'none'
    document.getElementById(buttonId).disabled = false
}

const dataValidationLogin = async () => {
    if (functions.login) {
        disableButton('button')
        functions.login = false

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

        functions.login = true
        enableButton('button')
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
