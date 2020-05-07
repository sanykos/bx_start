document.addEventListener('DOMContentLoaded', function() {

    let resource = document.querySelectorAll('.lazy-resource');
    
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    }

    function handleRes(res, observer) {
        res.forEach(resSingle => {
            if(resSingle.intersectionRatio > 0) {
                loadRes(resSingle.target);
            }
        })
    }

    function loadRes(res) {
        res.src = res.getAttribute('data-res');
    }
 

    const observer = new IntersectionObserver(handleRes, options);
    resource.forEach(res => observer.observe(res));

})