function popup (params = {}) {
    if (params.reload == undefined) {
        params.reload = true
    }
    if (params.remove == undefined) {
        params.remove = true
    }
    if (params.class == undefined) {
        params.class = ''
    }
    if (params.id == undefined || typeof params.id != 'string') {
        params.id = Date.now()
    }
    else {
        params.id = params.id.replace(/[\s.,%]/g, '')
    }
    if (params.title == undefined) {
        params.title = ''
    }
    if (params.content == undefined) {
        params.content = ''
    }
    if (params.buttons == undefined || typeof params.buttons != 'object') {
        params.buttons = []
    }

    let existWrapper = document.querySelectorAll('.popup-wrapper')

    if (existWrapper && params.reload) {
        existWrapper.forEach(wrapElem => {
            wrapElem.remove();
        })
    }

    const wrapper = document.createElement('div')
    wrapper.className = 'popup-wrapper'
    if (params.class != '') {
        wrapper.className += ' ' + params.class;
    }
    wrapper.id = 'popup_' + params.id
    wrapper.style.position = 'fixed'
    wrapper.style.top = 0
    wrapper.style.bottom = 0
    wrapper.style.left = 0
    wrapper.style.right = 0
    wrapper.style.zIndex = 10000

    const box = document.createElement('div')
    box.className = 'popup-box'

    const container = document.createElement('div')
    container.className = 'popup-content'
    container.insertAdjacentHTML('afterbegin',params.content)

    const header = document.createElement('div')
    header.className = 'popup-header'

    if (params.title != '') {
        const title = document.createElement('div')
        title.className = 'popup-title'
        title.insertAdjacentHTML('afterbegin',params.title)
        header.append(title)
    }

    const closeBut = document.createElement('div')
    closeBut.className = 'popup-close'
    closeBut.addEventListener('click',close)

    const buttonBox = document.createElement('div')
    buttonBox.className = 'popup-button-box'

    if (params.buttons.length > 0) {
        params.buttons.forEach(button => {
            if (!button.title) {
                return
            }
            let buttonElem = document.createElement('button')
            buttonElem.innerHTML = button.title

            if (button.class !== undefined) {
                buttonElem.className = button.class
            }
            if (button.callback !== undefined) {
                if (button.callback == 'close') {
                    button.callback = close
                }
                buttonElem.addEventListener('click',button.callback)
            }
            buttonBox.append(buttonElem)
        })
    }

    box.append(closeBut)
    box.append(header)
    box.append(container)
    box.append(buttonBox)
    wrapper.append(box)

    function close() {
        if (params.remove) {
            wrapper.remove()
        }
        else {
            wrapper.style.display = 'none';
        }
    }


    document.body.append(wrapper)
}

function inputFileImg (input) {
    if (!input) {
        console.log('err')
        return false
    }
    const wrapper = input.closest('.image-button')
    if (wrapper) {
        const img = wrapper.querySelector('.image-button-img img')
        const text = wrapper.querySelector('.image-button-text')

        function deleteImage (wrap) {
            const del = wrap.querySelector('.delete-image')
            const hid = wrap.closest('.input-wrapper').querySelector('input[type="hidden"]')
            if (del) {
                del.addEventListener('click',function(){
                    if (img) {
                        img.src = '/images/icons/upload.png'
                    }
                    if (hid) {
                        hid.value = null
                    }
                    input.value = null
                    this.classList.add('hidden')
                    text.innerHTML = 'Choose file';
                })
            }
        }

        deleteImage(wrapper)

        input.addEventListener('change',function(e){
            const files = e.target.files
            if (files) {
                if (text) {
                    text.innerHTML = files[0].name
                }
                if (FileReader && files && files.length) {
                    var fReader = new FileReader();
                    fReader.onload = function () {
                        if (img) {
                            img.src = fReader.result;
                        }
                        const del = wrapper.querySelector('.delete-image')
                        if (del) {
                            del.classList.remove('hidden')
                        }
                    }
                    fReader.readAsDataURL(files[0]);
                }
            }
            //deleteImage(wrapper)
        })
    }
}

function translitSmall (string) {
    const symbols = [
        {in: 'а', out: 'a'},
        {in: 'б', out: 'b'},
        {in: 'в', out: 'v'},
        {in: 'г', out: 'g'},
        {in: 'д', out: 'd'},
        {in: 'е', out: 'e'},
        {in: 'ё', out: 'yo'},
        {in: 'ж', out: 'zh'},
        {in: 'з', out: 'z'},
        {in: 'и', out: 'i'},
        {in: 'й', out: 'y'},
        {in: 'к', out: 'k'},
        {in: 'л', out: 'l'},
        {in: 'м', out: 'm'},
        {in: 'н', out: 'n'},
        {in: 'о', out: 'o'},
        {in: 'п', out: 'p'},
        {in: 'р', out: 'r'},
        {in: 'с', out: 's'},
        {in: 'т', out: 't'},
        {in: 'у', out: 'u'},
        {in: 'ф', out: 'f'},
        {in: 'х', out: 'h'},
        {in: 'ц', out: 'ts'},
        {in: 'ч', out: 'ch'},
        {in: 'ш', out: 'sh'},
        {in: 'щ', out: 'sch'},
        {in: 'ъ', out: ''},
        {in: 'ы', out: 'y'},
        {in: 'ь', out: ''},
        {in: 'э', out: 'e'},
        {in: 'ю', out: 'yu'},
        {in: 'я', out: 'ya'},
    ];

    symbols.forEach(symb => {
        string = string.replace(new RegExp(symb.in,'gi'), symb.out)
    });

    return string
}

function slug (text, space = '-', translit = true) {
    if (typeof text === 'string' && text.length > 0) {

        text = text.trim().toLowerCase();

        if (translit === true) {
            text = translitSmall(text);
        }

        text = text.replace(/\s+/g, space).replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');

        return text;
    }

    return null;
}

function autoSlug (checkbox, translit = true, space = '-') {
    if (checkbox) {
        if (typeof checkbox === 'string') {
            checkbox = document.querySelectorAll(checkbox)
        }

        function slugAction (elem, space, translit) {
            let textElement = document.getElementById(elem.dataset.textId),
                slugElement = document.getElementById(elem.dataset.slugId)


            if (textElement && slugElement) {

                /* elem.addEventListener('click',function(e) {
                    if (this.checked) {
                        slugElement.value = slug(textElement.value, currentSpace, translit)
                    }
                }) */

                textElement.addEventListener('input',function(e) {
                    if (elem.checked) {
                        console.log(space);
                        slugElement.value = slug(this.value, space, translit)
                    }
                })

            }
        }

        if (typeof checkbox === 'object' && checkbox instanceof HTMLElement) {
            if (checkbox.dataset.slugSpace) {
                currentSpace = checkbox.dataset.slugSpace
            }
            else {
                currentSpace = space
            }
            slugAction(checkbox, currentSpace, translit)
        }
        else if (typeof checkbox === 'object' && checkbox instanceof NodeList) {

            checkbox.forEach(element => {
                if (element.dataset.slugSpace) {
                    currentSpace = element.dataset.slugSpace
                }
                else {
                    currentSpace = space
                }
                slugAction(element, currentSpace, translit)
            });

        }
    }
}

function inputSlugInit(space = '-', translit = true) {
    const inputs = document.querySelectorAll('input[data-isslug]')
    if (inputs) {
        inputs.forEach((elem) => {
            elem.addEventListener('input',function(){
                this.value = slug(this.value, space, translit)
            })
        })
    }
}

function hashTag(string = '', hash = true) {
    string = string.trim().toLowerCase().replace(/[^a-zA-Zа-яА-Я0-9]/g,'')
    if (hash) {
        string = '#' + string
    }
    return string
}

function tagInput (input, hash = false) {
    if (typeof input === 'string') {
        input = document.querySelectorAll(input)
    }

    function hashAction (elem) {
        elem.addEventListener('input',function () {
            this.value = hashTag(this.value, hash)
        })
    }

    if (typeof input === 'object' && input instanceof HTMLElement) {
        hashAction(input)
    }
    else if (typeof input === 'object' && input instanceof NodeList) {

        input.forEach(element => {
            hashAction(element)
        });

    }
}

function removeTagFromList (th) {
    th.closest('.tag-item-box').remove()
}

function tagFormInit() {
    const tagForm = document.querySelectorAll('.tag-form-wrapper')
    let tagList = null;

    async function getTagList () {
        if (tagList !== null && typeof tagList == 'object') {
            return tagList;
        }
        let response = await fetch('/admin/blog/tags',{headers: {'X-Requested-With': 'XMLHttpRequest'}});
        tagList = await response.json();
        return tagList;
    }
    getTagList();

    function addTagToList (listBox,input,item) {
        const check = document.querySelector('.tag-item-box[data-id="'+item.id+'"]')
        if (!check) {
            const elem = `<div class="tag-item-box" data-id="${item.id}">
                <span class="tag-item-name">${item.name}</span>
                <span class="tag-item-remove" onclick="removeTagFromList(this)">&#215;</span>
                <input type="hidden" name="tags[]" value="${item.id}">
            </div>`;
            listBox.insertAdjacentHTML('beforeend',elem)
        }
    }


    if (tagForm) {
        tagForm.forEach(wrapBox => {
            let listBox = wrapBox.querySelector('.tag-list-box')
            let promptBox = wrapBox.querySelector('.tag-prompt-list')
            let inputBox = wrapBox.querySelector('.tag-input-box')
            let input = wrapBox.querySelector('input.tag-input')
            let button = wrapBox.querySelector('button.tag-add-button')
            input.addEventListener('input',function(){
                const th = this
                const list = tagList.filter((item) => {
                    if (item.name.indexOf(th.value) > -1 && th.value != '') {
                        return item
                    }
                })
                promptBox.innerHTML = '';
                list.forEach(item => {
                    let prompt = document.createElement('div');
                    prompt.classList.add('tag-prompt-item');
                    prompt.dataset.id = item.id;
                    prompt.innerHTML = item.name;
                    prompt.addEventListener('click',function(){
                        addTagToList (listBox,input,item)
                    });
                    promptBox.append(prompt);
                })
            })
            button.addEventListener('click',function(){
                const data = JSON.stringify({name:input.value});
                const token = document.querySelector("input[name='_token']").value;
                fetch('/admin/blog/tags/addnotexist',{
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    credentials: 'same-origin',
                    body: data
                }).then(
                    (result) => result.json()
                ).then (
                    (data) => {
                        if (data.result && data.data) {
                            if (data.result == 'success' && data.data.id) {
                                tagList.push(data.data)
                            }
                            if (data.data.id) {
                                addTagToList (listBox,input,data.data)
                            }
                        }
                    }
                ).catch(error => {
                    //
                });
            })
        })
    }
}

function fieldGroupInit() {
    const formSelect = document.querySelector('#form_id')
    const groupSelect = document.querySelector('#group_id')

    if (formSelect) {
        formSelect.addEventListener('change',function(){
            let val = this.value
            const token = document.querySelector("input[name='_token']").value;
            fetch('/admin/form/groups?form_id='+val,{
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token,
                },
                credentials: 'same-origin'
            }).then(
                (result) => result.json()
            ).then (
                (data) => {
                    let optionText = `
                        <option value="null">${elfLang.none}</option>
                    `;
                    data.forEach(elem => {
                        optionText += `
                        <option value="${elem.id}">${elem.name}</option>
                        `;
                    })
                    groupSelect.innerHTML = optionText;
                }
            ).catch(error => {
                //
            });
        })
    }

}

let elfLang = null;
async function getElfLang () {
    if (elfLang !== null && typeof elfLang == 'object') {
        return elfLang;
    }
    let elfLangResponse = await fetch('/admin/ajax/json/lang/elf',{headers: {'X-Requested-With': 'XMLHttpRequest'}});
    elfLang = await elfLangResponse.json();
    return elfLang;
}
getElfLang()

function showOptionsSelect (select,optionBox,hiddenClass='hidden') {
    if (typeof select === 'string') {
        select = document.querySelector(select)
    }

    function selectInit (select,optionBox,hiddenClass='hidden') {
        function setVisible(optionBox,hiddenClass,visible=false) {
            if (typeof optionBox === 'string') {
                optionBox = document.querySelector(optionBox)
            }
            if (optionBox) {
                if (visible === true) {
                    optionBox.classList.remove(hiddenClass)
                }
                else {
                    if (!optionBox.classList.contains(hiddenClass)) {
                        optionBox.classList.add(hiddenClass)
                    }
                }
            }
        }


        if (select.selectedIndex) {
            if (select.options[select.selectedIndex].text == 'select' || select.options[select.selectedIndex].text == 'radio') {
                setVisible(optionBox,hiddenClass,true)
            }
            else {
                setVisible(optionBox,hiddenClass,false)
            }
        }

    }


    if (typeof select === 'object' && select instanceof HTMLElement) {
        selectInit (select,optionBox,hiddenClass)
        select.addEventListener('change',function () {
            selectInit (this,optionBox,hiddenClass)
        })
    }


}

let optionNextLine = 0

function optionBoxInit(addSelector = '#addoptionline', line = 0) {
    optionNextLine = line

    const addButton = document.querySelector(addSelector)
    if (addButton) {
        addButton.addEventListener('click',function(){
            const lastLine = document.querySelector('.options-table-string-line[data-line="'+optionNextLine+'"]')
            optionNextLine++
            const htmlLine = `
            <div class="options-table-string-line" data-line="${optionNextLine}">
                <div class="options-table-string">
                    <input type="text" name="options_new[${optionNextLine}][value]" id="option_new_value_${optionNextLine}" data-option-value>
                </div>
                <div class="options-table-string">
                    <input type="text" name="options_new[${optionNextLine}][text]" id="option_new_text_${optionNextLine}" data-option-text>
                </div>
                <div class="options-table-string">
                    <input type="checkbox" name="options_new[${optionNextLine}][selected]" id="option_new_selected_${optionNextLine}" data-option-selected>
                </div>
                <div class="options-table-string">
                    <input type="checkbox" name="options_new[${optionNextLine}][disabled]" id="option_new_disabled_${optionNextLine}" data-option-disabled>
                </div>
                <div class="options-table-string">
                    <input type="checkbox" name="options_new[${optionNextLine}][deleted]" id="option_new_deleted_${optionNextLine}" data-option-deleted>
                </div>
                <div class="options-table-string"></div>
            </div>
            `
            if (lastLine) {
                lastLine.insertAdjacentHTML('afterend',htmlLine)
                setTimeout(function () {
                    onlyOneCheckedInit('#option_new_selected_'+optionNextLine,'[data-option-selected]')
                },1000)
            }
        })
    }
}

function eventParamBoxInit(addSelector = '#addparamline', line = 0) {
    paramNextLine = line

    const addButton = document.querySelector(addSelector)
    if (addButton) {
        addButton.addEventListener('click',function(){
            console.log(paramNextLine);
            const lastLine = document.querySelector('.params-table-string-line[data-line="'+paramNextLine+'"]')
            paramNextLine++
            const htmlLine = `
            <div class="params-table-string-line" data-line="${paramNextLine}">
                <div class="params-table-string">
                    <input type="text" name="params_new[${paramNextLine}][name]" id="param_new_name_${paramNextLine}" data-param-name>
                </div>
                <div class="params-table-string">
                    <input type="text" name="params_new[${paramNextLine}][value]" id="param_new_value_${paramNextLine}" data-param-value>
                </div>
                <div class="params-table-string">
                    <button type="button" class="default-btn" onclick="eventParamDelete(${paramNextLine})">&#215;</button>
                </div>
            </div>
            `

            if (lastLine) {
                lastLine.insertAdjacentHTML('afterend',htmlLine)
            }
        })
    }
}

function eventParamDelete(line) {
    const lineBox = document.querySelector('.params-table-string-line[data-line="'+line+'"]');
    if (lineBox) {
        lineBox.remove();
    }
}

function menuAttrBoxInit(addSelector = '#addattributeline', line = 0) {
    attributeNextLine = line

    const addButton = document.querySelector(addSelector)
    if (addButton) {
        addButton.addEventListener('click',function(){
            console.log(attributeNextLine);
            const lastLine = document.querySelector('.attributes-table-string-line[data-line="'+attributeNextLine+'"]')
            attributeNextLine++
            const htmlLine = `
            <div class="attributes-table-string-line" data-line="${attributeNextLine}">
                <div class="attributes-table-string">
                    <input type="text" name="attributes_new[${attributeNextLine}][name]" id="attribute_new_name_${attributeNextLine}" data-attribute-name>
                </div>
                <div class="attributes-table-string">
                    <input type="text" name="attributes_new[${attributeNextLine}][value]" id="attribute_new_value_${attributeNextLine}" data-attribute-value>
                </div>
                <div class="attributes-table-string">
                    <button type="button" class="default-btn" onclick="menuAttrDelete(${attributeNextLine})">&#215;</button>
                </div>
            </div>
            `

            if (lastLine) {
                lastLine.insertAdjacentHTML('afterend',htmlLine)
            }
        })
    }
}

function menuAttrDelete(line) {
    const lineBox = document.querySelector('.attributes-table-string-line[data-line="'+line+'"]');
    if (lineBox) {
        lineBox.remove();
    }
}

function selectFilter(condition,target,parameter,defaultValue=null) {
    if (parameter) {
        if (typeof condition === 'string') {
            condition = document.querySelector(condition)
        }
        if (typeof condition === 'object' && condition instanceof HTMLElement) {
            if (typeof target === 'string') {
                target = document.querySelector(target)
            }
            if (typeof target === 'object' && target instanceof HTMLElement) {

                optionList = target.querySelectorAll('option')

                document.addEventListener('change',function (e) {

                    let count = 0;
                    let defaultIndex = 0;
                    optionList.forEach((element, index) => {
                        optionParam = element.getAttribute(parameter);
                        if (optionParam == condition.value) {
                            element.style.display = 'initial'
                            count++;
                        }
                        if (optionParam == defaultValue) {
                            element.style.display = 'initial'
                            defaultIndex = index
                            count++;
                        }
                        else {
                            element.style.display = 'none'
                        }
                    });
                    if (count == 0) {
                        target.selectedIndex = defaultIndex
                    }

                });

            }
            else {
                console.warn('Element not found');
            }
        }
        else {
            console.warn('Element not found');
        }
    }
    else {
        console.warn('Parameter not found');
    }
}

function oneCheked(element,list) {
    if (typeof element === 'string') {
        element = document.querySelector(element)
    }
    if (typeof element === 'object' && element instanceof HTMLElement) {

        if (typeof list === 'string') {
            list = document.querySelectorAll(list)
        }
        if (typeof list === 'object' && list instanceof NodeList) {
            console.log(element)
        }

    }

    return false
    /* if (typeof element === 'object' && element instanceof HTMLElement) {

    }
    else if (typeof input === 'object' && input instanceof NodeList) {

        input.forEach(element => {
            hashAction(element)
        });

    } */
}

function oneCheckedInit (selector,reinit=false) {
    elements = document.querySelectorAll(selector)
    if (elements) {
        elements.forEach(element => {
            if (reinit) {
                element.removeEventListener('click',oneCheked)
            }
            element.addEventListener('click',oneCheked(element,elements))
        });
    }
}

function onlyOneCheckedInit (elements,listSelector) {
    if (typeof elements === 'string') {
        elements = document.querySelectorAll(elements)
    }
    if (typeof elements === 'object' && elements instanceof NodeList) {

        /* if (typeof list === 'string') {
            list = document.querySelectorAll(list)
        } */
        //if (typeof list === 'object' && list instanceof NodeList) {
            /* elements.addEventListener('change',function () {
                console.log(this)
                //console.log(this.checked)
            }) */
            elements.forEach(element => {
                element.addEventListener('change',function () {

                    //console.log(this)
                    //console.log(this.checked)
                    if (this.checked) {
                        list = document.querySelectorAll(listSelector)
                        if (typeof list === 'object' && list instanceof NodeList) {
                            list.forEach(item => {
                                if (item !== element) {
                                    item.checked = false
                                }
                            });
                        }
                    }
                })
            });
        //}
    }
}


function deleteConfirm(e) {
    e.preventDefault();
    let roleId = this.querySelector('[name="id"]').value,
        roleName = this.querySelector('[name="name"]').value,
        self = this
    popup({
        title: elfLang.deleting_of_element + roleId,
        content:'<p>' + elfLang.are_you_sure_to_deleting_role + '"' + roleName + '"' + '(ID ' + roleId + ')?</p>',
        buttons:[
            {
                title: elfLang.delete,
                class:'default-btn delete-button',
                callback: function(){
                    self.submit()
                }
            },
            {
                title: elfLang.cancel,
                class:'default-btn cancel-button',
                callback:'close'
            }
        ],
        class:'danger'
    })
}

function contextPopup(content, position = {}) {
    if (window.isContextPopup) {
        return false
    }
    window.isContextPopup = true
    let top = position.top ?? null
    let left = position.left ?? null
    let bottom = position.bottom ?? null
    let right = position.right ?? null

    const boxBg = document.createElement('div')
    boxBg.classList.add('context-popup-background')
    const box = document.createElement('div')
    box.classList.add('context-popup')
    const closeBox = document.createElement('div')
    closeBox.classList.add('context-popup-close')
    const close = document.createElement('span')
    close.innerHTML = '&#215;'
    const contentBox = document.createElement('div')
    contentBox.classList.add('context-popup-content')
    closeBox.append(close)
    box.append(closeBox)
    box.append(contentBox)
    if (typeof content === 'string') {
        contentBox.insertAdjacentHTML('beforeend',content)
    }
    else {
        contentBox.append(content)
    }
    close.addEventListener('click',function(){
        thisClose()
    })
    boxBg.addEventListener('contextmenu',function(e){
        e.preventDefault()
    })
    boxBg.addEventListener('click',function(e){
        thisClose()
    })
    box.addEventListener('contextmenu',function(e){
        e.preventDefault()
    })
    document.body.append(boxBg)
    document.body.append(box)
    document.body.style.overflowY = 'hidden'

    console.log(box.offsetHeight)

    if (top) {
        if (top + box.offsetHeight > window.innerHeight) {
            top = top - box.offsetHeight
        }
        box.style.top = top + 'px'
    }
    if (left) {
        if (left + box.offsetWidth > window.innerWidth) {
            left = left - box.offsetWidth
        }
        box.style.left = left + 'px'
    }
    if (bottom) {
        box.style.bottom = bottom + 'px'
    }
    if (right) {
        box.style.right = right + 'px'
    }

    function thisClose () {
        boxBg.remove()
        box.remove()
        document.body.style.overflowY = ''
        window.isContextPopup = false
    }
}

/* function datetimeFormat (dateString, seconds = true, dateformat = 'Y-M-D') {
    let current = new Date();
    let tz = current.getTimezoneOffset() * 60000;
    let dateFromString = new Date(Date.parse(dateString))
    let year = dateFromString.getFullYear(),
        month = dateFromString.getMonth(),
        day = dateFromString.getDate(),
        hour = dateFromString.getHours(),
        min = dateFromString.getMinutes(),
        sec = dateFromString.getSeconds()
    if (month < 0) {
        month = '0' + month
    }
    if (day < 0) {
        day = '0' + day
    }
    if (hour < 0) {
        hour = '0' + hour
    }
    if (min < 0) {
        min = '0' + min
    }
    if (sec < 0) {
        sec = '0' + sec
    }
    let time = hour + ':' + min
    if (seconds) {
        time =  + ':' + sec
    }
        console.log(year,month,day,hour,min,sec)
        console.log(time)
    let resultString = year + '-' + month + '-' + day + ' ' + time
    if (dateformat = 'D.M.Y') {
        resultString = day + '.' + month + '.' + year + ' ' + time
    }
    return resultString
} */
