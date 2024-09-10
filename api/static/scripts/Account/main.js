
let pass = '';

const generateToken = async () => {
    const data = {
        token: document.getElementById('selectToken').value
    }

    const result = await http.post('api/auth/generateToken', JSON.stringify(data))

    if (result.data.status) {
        alert('Token was sent to email')
    }
}

const getPass = async () => {
    const result = await http.get('api/auth/getPass');

    if (result.response.ok && result.data.status) {
        document.getElementById('password').value = result.data.password
        pass = result.data.password
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
}

const editUserData = async () => {
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
        }
    }
}

const logout = async () => {
    await http.get('api/auth/logout/')

    localStorage.removeItem("user")
    localStorage.removeItem("role")

    window.location.href = '/'
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