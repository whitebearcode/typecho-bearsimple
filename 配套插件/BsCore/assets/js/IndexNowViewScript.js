var uuid = uuidv4.call().split('-').join('');
var guid = document.getElementsByClassName("guid");
function handleGenerate() {
    uuid = uuidv4.call().split('-').join('');
    for (var i = 0; i < guid.length; i++) {
        var processedGuid = uuid
            .split('')
            .map(tranformGuidText)
            .join('');
        guid[i].innerHTML = `${processedGuid}`;
    }
    var keys = document.getElementsByClassName("key");
    for (var i = 0; i < keys.length; i++) {
        keys[i].innerHTML = uuid;
    }

    setUrlHref();
}

function tranformGuidText(character) {
    if (character >= '0' && character <= '9') {
        return `<text class="blue">${character}</text>`;
    } else {
        return `<text class="black">${character}</text>`;
    }
}



var downloadIcon = document.getElementById("download-icon");
downloadIcon.addEventListener("click", function () {
    var downloadMessage = "确认是否下载IndexNow密钥到本地?";
    if (confirm(downloadMessage)) {
        var filename = uuid + ".txt";
        var text = uuid;
        download(filename, text);
    }
})

function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}

function setUrlHref() {
    var urlWithKeys = document.getElementsByClassName("has-key");
    for (var i = 0; i < urlWithKeys.length; i++) {
        urlWithKeys[i].href = urlWithKeys[i].innerText;
    }
}

handleGenerate();


let accordion = document.getElementsByClassName("custom-accordion-header");
for (let i = 0; i < accordion.length; i++) {
    accordion[i].addEventListener("click", () => {
        if (accordion[i].classList.contains("show")) {
            accordion[i].classList.remove("show");
        } else {
            accordion[i].classList.add("show");
        }

        let accordionBody = accordion[i].nextElementSibling;
        if (accordionBody.classList.contains("d-none")) {
            accordionBody.classList.remove("d-none");
        } else {
            accordionBody.classList.add("d-none");
        }
    });
}

function toggleHamburger() {
    var mobileMenuList = document.getElementById("mobileMenu");
    if (mobileMenuList.classList.contains("d-none")) {
        mobileMenuList.classList.remove("d-none");
    } else {
        mobileMenuList.classList.add("d-none");
    }
}

function redirectToIndexNowFaq() {
    var faqUrl = "https://www.indexnow.org/faq"
    window.location.assign(faqUrl);
}
