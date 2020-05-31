let elements = document.getElementsByClassName('pagination')

if (elements.length > 0){
    let page = window.location.href.split('/')

    page = page[page.length - 1]

    links = document.getElementsByClassName('page-item')

    for (let i = 0; i < links.length; i++) {
        if (links[i].firstChild.innerHTML == page){
            links[i].classList.add('active')
        }      
    }
}

$('.deleteButton').click((e) => {
    e.preventDefault()
    e.stopPropagation()

    $('#mediumModal').modal('show')
    $('#deleteButton').attr('href', e.target.href)
})