
class LocalSettings {
    constructor() {
        this.key = "settings"
    }

    init() {
        const settings = {
            authBackgroundAnimation: true,
            blackTheme: true
        }

        localStorage.setItem(this.key, JSON.stringify(settings))
    }

    get(param) {
        if (localStorage.getItem(this.key) === null) {
            this.init()
        }

        return JSON.parse(localStorage.getItem(this.key))[param]
    }

    set(param, value) {
        if (localStorage.getItem(this.key) === null) {
            this.init()
        }

        try {
            const newSettings = JSON.parse(localStorage.getItem(this.key))
            newSettings[param] = value
            localStorage.setItem(this.key, JSON.stringify(newSettings))
        } catch (error) {
            return false
        }

        return true
    }

    getAll() {
        if (localStorage.getItem(this.key) === null) {
            this.init()
        }

        return JSON.parse(localStorage.getItem(this.key))
    }
}

const localSettings = new LocalSettings()