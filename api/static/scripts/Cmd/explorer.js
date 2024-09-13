
let functionsEXP = {
    getfolderfiles: true
}

sessionStorage.removeItem('selectedFile')
sessionStorage.removeItem('files')

const getIcon = (mime) => {
    if (mime == 'application/vnd.google-apps.folder') {
        return `<i class="fa-solid fa-folder"></i>`
    } else if (mime.split('/')[0] == 'image') {
        return `<i class="fa-regular fa-image"></i>`
    } else {
        return `<i class="fa-regular fa-file"></i>`
    }
}

const setHtmlFile = (name, mime, divId, onclick) => {
    const divHtml = `
        <div class="file" id="${divId}" onclick="${onclick}">
            ${getIcon(mime)}
            <div class="Ftext">${name}</div>
        </div>
    `

    document.getElementById('explorer').innerHTML += divHtml
}

const path_onclick = async (e) => {
    if (e.attributes[0].textContent === 'application/vnd.google-apps.folder') {
        const target = document.getElementById('explorer')

        target.innerHTML = ''

        const target1 = document.getElementById('path')

        let nextSibling = e.nextElementSibling;
        while (nextSibling) {
            const siblingToRemove = nextSibling;
            nextSibling = siblingToRemove.nextElementSibling;
            target1.removeChild(siblingToRemove);
        }

        await getFolderFiles(e.id)

        sessionStorage.setItem('selectedFile', JSON.stringify({
            name: e.innerText,
            id: e.id,
            mimeType: e.attributes[0].textContent
        }))
    }
}

const div_onclick = async (e) => {
    const _do = async () => {
        document.getElementById('path').innerHTML += `<div class="_Spath_slash">-</div><div mime="${JSON.parse(sessionStorage.getItem('files'))[e.id].mimeType}" id="${JSON.parse(sessionStorage.getItem('files'))[e.id].id}" onclick="path_onclick(this)" class="_Spath">${JSON.parse(sessionStorage.getItem('files'))[e.id].name}</div>`

        sessionStorage.setItem('selectedFile', JSON.stringify(JSON.parse(sessionStorage.getItem('files'))[e.id]))

        if (JSON.parse(sessionStorage.getItem('selectedFile')).mimeType
            === 'application/vnd.google-apps.folder') {
            const target = document.getElementById('explorer')

            target.innerHTML = ''

            await getFolderFiles(JSON.parse(sessionStorage.getItem('selectedFile')).id)
        }
    }

    if (sessionStorage.getItem('selectedFile') == null) {
        await _do()
    } else {
        if (JSON.parse(sessionStorage.getItem('selectedFile')) != JSON.parse(sessionStorage.getItem('files'))[e.id]) {
            if (JSON.parse(sessionStorage.getItem('selectedFile')).mimeType
                !== 'application/vnd.google-apps.folder') {
                const target = document.getElementById('path')

                target.removeChild(target.lastChild)
                target.removeChild(target.lastChild)
            }

            await _do()
        }
    }
}

const getFolderFiles = async (folderId = 'root') => {
    if (functionsEXP.getfolderfiles) {
        functionsEXP.getfolderfiles = false
        
        const data = new URLSearchParams()
        data.append('folderId', folderId)

        let result = await http.get('drive/getFolderFiles', data, http.getDriveDomain())

        let folderFiles = result.data.result
        let _newFolderFiles = {}

        for (const file in folderFiles) {
            _newFolderFiles['exp_div_' + file] = folderFiles[file]
            setHtmlFile(folderFiles[file].name, folderFiles[file].mimeType, 'exp_div_' + file, 'div_onclick(this)')
        }

        sessionStorage.setItem('files', JSON.stringify(_newFolderFiles))

        functionsEXP.getfolderfiles = true
    }
}

getFolderFiles()