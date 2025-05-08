document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.getElementById('preloader');
    const mainContent = document.getElementById('main-content');
    const minimumTime = 3000; 

   
    document.body.classList.add('preloader-active');

    function hidePreloader() {
        if (preloader) {
            preloader.classList.add('hidden');
        }
        if (mainContent) {
            mainContent.style.display = 'block';
        }

        document.body.classList.remove('preloader-active');
    }

    const startTime = performance.now();

    window.addEventListener('load', () => {
         const loadTime = performance.now() - startTime;
         const remainingTime = Math.max(0, minimumTime - loadTime);
         setTimeout(hidePreloader, remainingTime);
    });
 

    setTimeout(() => {
         if (preloader && !preloader.classList.contains('hidden')) {
             console.warn("Preloader timeout fallback triggered.");
             hidePreloader();
         }
    }, 8000);

});