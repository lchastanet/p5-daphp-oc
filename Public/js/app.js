let elements = document.getElementsByClassName('pagination')

if (elements.length > 0){
    let page = window.location.href.split('/')

    page = page[page.length - 1]

    links = document.getElementsByClassName('page-item')

    for (var i = 0; i < links.length; i++) {
        if (links[i].firstChild.innerHTML == page){
            links[i].classList.add("active")
        }      
    }
}