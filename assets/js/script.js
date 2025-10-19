(function(){
    const dropdownParents = document.querySelectorAll('.menu-item-has-children > a');
    dropdownParents.forEach(function(anchor){
        anchor.addEventListener('click', function(event){
            const parent = anchor.parentElement;
            if (window.innerWidth < 992) {
                event.preventDefault();
                parent.classList.toggle('open');
            }
        });
    });
})();
