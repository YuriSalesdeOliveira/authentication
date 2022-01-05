(function() {

    const dropdownButton = document.querySelector('#dropdown-button')
    const dropdownContent = document.querySelector('#dropdown-content')
    
    dropdownButton.addEventListener('click', () => {

        if (dropdownContent.classList.contains('hidden')) {
            
            dropdownContent.classList.remove('hidden')
            dropdownContent.classList.add('flex')
            return
        }

        dropdownContent.classList.add('hidden')
        dropdownContent.classList.remove('flex')

    })

})()