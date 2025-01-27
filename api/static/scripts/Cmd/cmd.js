
let _headers

let functionsCMD = {
    do: true,
    subdo: true
}

const uploadChunk = async (chunk, chunkIndex) => {
    let result = _doSubVar

    let _data

    _data = new FormData()

    _data.append('fileChunk', chunk);
    _data.append('chunkIndex', chunkIndex);
    _data.append('folderId', '14QCvpENKERdrIJKCZyXy9wQEHCSXeizp')

    if (result.data.data) {
        for (const param in result.data.data) {
            if (!isNaN(parseInt(param))) {
                // _data.append(result.data.data[param], document.getElementById('inputFile').files[0])
            } else {
                _data.append(param, result.data.data[param])
            }
        }
    }

    document.getElementById('inputFile').value = ''

    const response = await http[result.data.method]('drive/createFileChunk', _data, result.data.domain, _headers)

    if (response.response.ok) {
        console.log(`Chunk ${chunkIndex} success`);

        return response.data.result
    } else {
        console.error(`Chunk ${chunkIndex} error`);

        return false
    }
}

const loadChunk = async (driveToken, chunkId) => {
    const headers = {
        drivetoken: driveToken.data.driveToken,
        profileid: driveToken.data.profileId
    }

    const data = new URLSearchParams()
    data.append('fileId', chunkId)

    const response = await http.get('drive/getFile', data, http.getDriveDomain(), headers, false)

    return response.response.arrayBuffer()
}

const loadFileByChunks = async (json) => {
    const driveToken = (await http.get('api/auth/driveToken'))

    const partsArrayBuffers = [];

    for (const chunk in json.chunks) {
        const partBuffer = await loadChunk(driveToken, json.chunks[chunk])
        partsArrayBuffers.push(partBuffer)
    }

    const combinedArray = new Uint8Array(partsArrayBuffers.reduce((total, part) => total + part.byteLength, 0));
    let offset = 0;

    for (const part of partsArrayBuffers) {
        combinedArray.set(new Uint8Array(part), offset);
        offset += part.byteLength;
    }

    const blob = new Blob([combinedArray]);

    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = json.fileName;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
}

let _doSubVar

let _doSubFunc = async () => {
    if (functionsCMD.subdo) {
        functionsCMD.subdo = false

        document.body.onfocus = null

        try {
            document.getElementById('putIn').id = ''
        } catch (error) {
        }

        try {
            //

            const fileInput = document.getElementById('inputFile')
            const file = fileInput.files[0]
            const chunkSize = 0.1 * 1024 * 1024
            const totalChunks = Math.ceil(file.size / chunkSize)

            const chunkFile = {
                count: totalChunks,
                fileName: file.name,
                fileMime: file.type,
                chunks: {}
            }

            console.log(totalChunks)

            for (let i = 0; i < totalChunks; i++) {
                const start = i * chunkSize;
                const end = Math.min(start + chunkSize, file.size)
                const chunk = file.slice(start, end)

                const id = await uploadChunk(chunk, i)
                chunkFile.chunks['chunk_' + i] = id
            }

            const driveToken = (await http.get('api/auth/driveToken'))

            const data = new FormData()
            data.append('chunkFile', JSON.stringify(chunkFile))
            data.append('folderId', '14QCvpENKERdrIJKCZyXy9wQEHCSXeizp')

            const headers = {
                drivetoken: driveToken.data.driveToken,
                profileid: driveToken.data.profileId
            }
            const createMainChunk = await http.post('drive/createMainChunk', data, http.getDriveDomain(), headers)

            await Cmd.print([
                0, 0,
                'Server>', `${totalChunks} - chunks ${createMainChunk.data.result}`,
                0, 0,
                Cmd.user.login + '>',
                1
            ], () => {
                Cmd.canPrint = true
            })
            functionsCMD.subdo = true

            return

            //
            let result = _doSubVar

            let _data

            _data = new FormData()

            if (result.data.data) {
                for (const param in result.data.data) {
                    if (!isNaN(parseInt(param))) {
                        _data.append(result.data.data[param], document.getElementById('inputFile').files[0])
                    } else {
                        _data.append(param, result.data.data[param])
                    }
                }
            }

            document.getElementById('inputFile').value = ''

            let _result

            try {
                _result = await http[result.data.method](result.data.url, _data, result.data.domain, _headers)
            } catch (error) {
            }

            if (_result) {
                await Cmd.print([
                    0, 0,
                    'Server>', ...JSON.stringify(_result.data.result),
                    0, 0,
                    Cmd.user.login + '>',
                    1
                ], () => {
                    Cmd.canPrint = true
                })
            } else {
                await Cmd.print([
                    0, 0,
                    'Server>' + 'Server connection error. See logs for more details.',
                    0, 0,
                    Cmd.user.login + '>',
                    1
                ], () => {
                    Cmd.canPrint = true
                })
            }
        } catch (error) {
            console.log(error)

            document.getElementById('inputFile').files = ''

            await Cmd.print([
                0, 0,
                'Server>' + 'Client error. See logs for more details.',
                0, 0,
                Cmd.user.login + '>',
                1
            ], () => {
                Cmd.canPrint = true
            })
        }

        functionsCMD.subdo = true
    }
}

let _do = async (command) => {
    if (functionsCMD.do) {
        functionsCMD.do = false

        try {
            document.getElementById('putIn').id = ''
        } catch (error) {
        }

        try {
            const params = new FormData()
            params.append('command', command.replaceAll('&nbsp;', ' '))

            let result = await http.post('api/cmd', params)

            if (result.response.status == 403) {
                window.location.href = '/'
            }
            if (result.response.ok) {
                if (result.data.recall) {
                    _headers = {}

                    if (result.data.headers) {
                        for (const param in result.data.headers) {
                            _headers[param] = result.data.headers[param]
                        }
                    } else {
                        await Cmd.print([
                            0, 0,
                            'Server>' + 'Wrong response.',
                            0, 0,
                            Cmd.user.login + '>',
                            1
                        ], () => {
                            Cmd.canPrint = true
                        })

                        functionsCMD.do = true

                        return;
                    }

                    if (result.data.file) {
                        await Cmd.print([
                            0, 0,
                            'Server>', ...result.data.result
                        ])

                        _doSubVar = result

                        document.getElementById('inputFile').click()
                    } else {
                        await Cmd.print([
                            0, 0,
                            'Server>', ...result.data.result
                        ])

                        let _data

                        _data = new URLSearchParams()

                        if (result.data.data) {
                            for (const param in result.data.data) {
                                _data.append(param, result.data.data[param])
                            }
                        }

                        let _result

                        try {
                            _result = await http[result.data.method](result.data.url, _data, result.data.domain, _headers, false)
                        } catch (error) {
                        }

                        if (_result) {
                            const contentDisposition = _result.response.headers.get('Content-Disposition');

                            if (contentDisposition !== null) {
                                let filename = 'unknown';
                                if (contentDisposition) {
                                    const matches = /filename="([^"]+)"/.exec(contentDisposition);
                                    if (matches && matches[1]) {
                                        filename = matches[1];
                                    }
                                }

                                if (filename == '#chunk#.json') {
                                    await loadFileByChunks(await _result.response.json())
                                } else {
                                    const blob = await _result.response.blob()
                                    const a = document.createElement('a');
                                    const url = window.URL.createObjectURL(blob);
                                    a.href = url;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                    window.URL.revokeObjectURL(url);
                                    document.body.removeChild(a);
                                }

                                await Cmd.print([
                                    0, 0,
                                    'Server>', 'File was successfully sent',
                                    0, 0,
                                    Cmd.user.login + '>',
                                    1
                                ], () => {
                                    Cmd.canPrint = true
                                })
                            } else {
                                await Cmd.print([
                                    0, 0,
                                    'Server>', ...(await _result.response.json()).result,
                                    0, 0,
                                    Cmd.user.login + '>',
                                    1
                                ], () => {
                                    Cmd.canPrint = true
                                })
                            }
                        } else {
                            await Cmd.print([
                                0, 0,
                                'Server>' + 'Server connection error. See logs for more details',
                                0, 0,
                                Cmd.user.login + '>',
                                1
                            ], () => {
                                Cmd.canPrint = true
                            })
                        }
                    }
                } else {
                    await Cmd.print([
                        0, 0,
                        'Server>', ...result.data.result,
                        0, 0,
                        Cmd.user.login + '>',
                        1
                    ], () => {
                        Cmd.canPrint = true
                    })
                }
            } else {
                await Cmd.print([
                    0, 0,
                    'Server>' + 'Server connection error. See logs for more details',
                    0, 0,
                    Cmd.user.login + '>',
                    1
                ], () => {
                    Cmd.canPrint = true
                })
            }
        } catch (error) {
            console.log(error)

            await Cmd.print([
                0, 0,
                'Server>' + 'Client error. See logs for more details',
                0, 0,
                Cmd.user.login + '>',
                1
            ], () => {
                Cmd.canPrint = true
            })
        }

        functionsCMD.do = true
    }
}

class Cmd {
    static cmd = document.getElementById('cmd')

    static version = 0.65

    static canPrint = false
    static cmdVersion = ['DataBase admin console [', [4, ['orange', 'Version ' + this.version]], ']']
    static _htmlElements = {
        0: () => { return '</br>' },
        1: () => { return '<div style="display:inline;"><div class="cmdText" id="putIn"></div><div id="cursor" class="cursor" style="background-color:white;width:9px;height:3px;display:inline-block;"></div></div>' },
        2: () => { return '<div style="display:inline;" id="ld">─</div>' },
        3: () => { return '&nbsp;' },
        4: (color) => { return `<p id="_p_4" style="color:${color};display:inline;"></p>` }
    }

    static user = ''

    static init() {
        document.getElementById('inputFile').addEventListener('cancel', async () => {
            await Cmd.print([
                0, 0,
                'Server>' + 'File was not selected. Cancel recalling.',
                0, 0,
                Cmd.user.login + '>',
                1
            ], () => {
                Cmd.canPrint = true
            })
        })

        this.print([
            ...this.cmdVersion,
            0,
            0,
            'DataBase Server Connection - ',
            2
        ], async () => {
            document.getElementById('ld').innerHTML = ''

            if (localStorage.getItem('user') !== null) {
                await Cmd.print([[4, ['lightgreen', 'Success']]], () => document.getElementById('ld').id = '', 'ld')

                Cmd.user = JSON.parse(localStorage.getItem('user'))

                let roots = ((JSON.parse(localStorage.getItem('user')).roots < 100) ? 'limited' : 'Full Access') + ` (${JSON.parse(localStorage.getItem('user')).roots})`

                await Cmd.print([
                    0,
                    0,
                    [4, ['lightblue', 'User {']],
                    0,
                    3, 3, 3, 3,
                    'login: ', [4, ['orange', Cmd.user.login]],
                    0,
                    3, 3, 3, 3,
                    'role: ', [4, ['orange', Cmd.user.role]],
                    0,
                    [4, ['lightblue', '}']],
                    0, 0,
                    [4, ['lightgreen', `Roots - ${roots}`]],
                    0, 0,
                    Cmd.user.login + '>',
                    1
                ], () => {
                    Cmd.canPrint = true
                })
            } else {
                await Cmd.print([[4, ['red', 'Auth was failed']]], () => document.getElementById('ld').id = '', 'ld')

                await Cmd.print([0, 0, 'Result - No Access'])
            }
        })
    }

    static async print(str, f = () => { }, id = 'cmd') {
        try {
            const sleep = ms => new Promise(r => setTimeout(r, ms));

            const target = document.getElementById(id)
            const time = 10

            for (const symbol of str) {
                if (this.isNumber(symbol) || Array.isArray(symbol)) {
                    if (Array.isArray(symbol)) {
                        this.cmd.innerHTML += this._htmlElements[symbol[0]](symbol[1][0])

                        for (const letter of symbol[1][1]) {
                            document.getElementById("_p_4").innerHTML += letter
                            document.getElementById('cmd').scrollTop = document.getElementById('cmd').scrollHeight
                            await sleep(time)
                        }

                        document.getElementById("_p_4").id = ''
                    } else {
                        target.innerHTML += this._htmlElements[symbol]()
                    }

                    document.getElementById('cmd').scrollTop = document.getElementById('cmd').scrollHeight
                } else {
                    for (const letter of symbol) {
                        document.getElementById('cmd').scrollTop = document.getElementById('cmd').scrollHeight
                        target.innerHTML += letter
                        await sleep(time)
                    }
                }
            }

            f()
        } catch (error) {
            console.log(error)

            await Cmd.print([
                0, 0,
                'Server>' + 'Print error. See logs for more details',
                0, 0,
                Cmd.user.login + '>',
                1
            ], () => {
                Cmd.canPrint = true
            })
        }
    }

    static keyboardListener(event) {
        if (Cmd.canPrint) {
            if (event.ctrlKey) {
            } else {
                if (event.key == '/') {
                    event.preventDefault()
                    document.getElementById('putIn').innerHTML += '/'
                } else if ((event.key >= 'a' && event.key <= 'z') || (event.key >= 'а' && event.key <= 'я')) {
                    document.getElementById('putIn').innerHTML += event.key
                } else if (event.key >= '0' && event.key <= '9') {
                    document.getElementById('putIn').innerHTML += event.key
                } else if (event.code === 'Space') {
                    document.getElementById('putIn').innerHTML += '&nbsp;'
                } else if (event.code === 'Backspace') {
                    document.getElementById('putIn').innerHTML = document.getElementById('putIn').innerHTML.slice(0, (document.getElementById('putIn').innerHTML.substr(document.getElementById('putIn').innerHTML.length - 6) === '&nbsp;') ? -6 : -1)
                } else if (event.code == 'Enter') {
                    if (Cmd.canPrint) Cmd.canPrint = false
                    document.getElementById('cursor').remove()
                    _do(document.getElementById('putIn').innerHTML)
                } else if (((event.key >= 'A' && event.key <= 'Z') || (event.key >= 'А' && event.key <= 'Я'))
                    && (event.code.startsWith('Key'))) {
                    document.getElementById('putIn').innerHTML += event.key
                }
            }
        }
    }

    static isNumber(value) {
        return typeof value === 'number';
    }
}

document.addEventListener('keydown', Cmd.keyboardListener);

Cmd.init()

let ld = setInterval(() => {
    if (document.getElementById('ld')) {
        if (document.getElementById('ld').innerHTML == '─') {
            document.getElementById('ld').innerHTML = '\\'
        } else if (document.getElementById('ld').innerHTML == '\\') {
            document.getElementById('ld').innerHTML = '|'
        } else if (document.getElementById('ld').innerHTML == '|') {
            document.getElementById('ld').innerHTML = '/'
        } else if (document.getElementById('ld').innerHTML == '/') {
            document.getElementById('ld').innerHTML = '─'
        }
    }
}, 250);

document.addEventListener('paste', evt => {
    document.getElementById('putIn').innerHTML += evt.clipboardData.getData('text/plain');
});
