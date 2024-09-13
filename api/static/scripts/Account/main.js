
let pass = ''

let tasks = 0
let functions = {
    logout: true,
    generate: true,
    save: true,
    getPass: true
}

const disableExitButton = (buttonId) => {
    document.getElementById('loader').style.display = 'block'
    document.getElementById(buttonId).classList.add('disabled')
    document.getElementById(buttonId).onclick = null
    tasks++
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

const generateToken = async () => {
    if (functions.generate) {
        disableButton('buttonG')
        functions.generate = false

        const data = {
            token: document.getElementById('selectToken').value
        }

        const result = await http.post('api/auth/generateToken', JSON.stringify(data))

        if (result.data.status) {
            alert('Token was sent to email')
        }

        functions.generate = true
        enableButton('buttonG')
    }
}

const getPass = async () => {
    if (functions.getPass) {
        functions.getPass = false

        const result = await http.get('api/auth/getPass');

        if (result.response.ok && result.data.status) {
            document.getElementById('password').value = result.data.password
            pass = result.data.password
        }

        functions.getPass = true
    }
}

const showPass = () => {
    if (document.getElementById('password').type === 'password') {
        document.getElementById('password').type = 'text';
        document.getElementById('locker').classList.remove('fa-lock')
        document.getElementById('locker').classList.add('fa-unlock')
    } else {
        document.getElementById('password').type = 'password';
        document.getElementById('locker').classList.remove('fa-unlock')
        document.getElementById('locker').classList.add('fa-lock')
    }
}

const returnData = () => {
    document.getElementById('login').value = JSON.parse(localStorage.getItem('user')).login
    document.getElementById('password').value = pass
    document.getElementById('role').value = JSON.parse(localStorage.getItem('user')).role

    document.getElementById('errorMSG').innerHTML = ''
}

const editUserData = async () => {
    if (functions.save) {
        disableButton('buttonS')
        disableButton('buttonR')
        functions.save = false

        if (document.getElementById('login').value !== JSON.parse(localStorage.getItem('user')).login ||
            document.getElementById('password').value !== pass) {
            const data = {
                login: (document.getElementById('login').value !== JSON.parse(localStorage.getItem('user')).login) ? document.getElementById('login').value : false,
                password: (document.getElementById('password').value !== pass) ? document.getElementById('password').value : false
            }

            const result = await http.post('api/auth/editUserData', JSON.stringify(data))

            if (result.response.ok && result.data.status) {
                if (document.getElementById('login').value !== JSON.parse(localStorage.getItem('user')).login) {
                    localStorage.setItem('user', JSON.stringify(result.data.user))
                    document.getElementById('userName').innerHTML = result.data.user.login
                }
                if (document.getElementById('password').value !== pass) {
                    pass = document.getElementById('password').value
                }

                document.getElementById('errorMSG').innerHTML = ''
            } else {
                document.getElementById('errorMSG').innerHTML = result.data.message
            }
        } else {
            document.getElementById('errorMSG').innerHTML = ''
        }

        functions.save = true
        enableButton('buttonR')
        enableButton('buttonS')
    }
}

const logout = async () => {
    if (functions.logout) {
        disableExitButton('logoutI')
        functions.logout = false

        await http.get('api/auth/logout/')

        localStorage.removeItem("user")
        localStorage.removeItem("role")

        window.location.href = '/'
    }
}

if (localStorage.getItem('user') !== null) {
    document.getElementById("userName").innerHTML = `${JSON.parse(localStorage.getItem('user')).login}`
    document.getElementById("logoutI").style.display = 'block'

    document.getElementById('login').value = JSON.parse(localStorage.getItem('user')).login
    getPass()
    document.getElementById('role').value = JSON.parse(localStorage.getItem('user')).role
} else {
    window.location.href = '/'
}