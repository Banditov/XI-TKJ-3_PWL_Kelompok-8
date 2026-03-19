document.addEventListener('DOMContentLoaded', function() {
    const mobileNavBtn = document.getElementById('mobileNavBtn');
    const mobileStngBtn = document.getElementById('mobileStngBtn');
    const mobileNav = document.getElementById('mobileNav');
    const mobileStng = document.getElementById('mobileStng');
    const mobileNavClsBtn = document.getElementById('mobileNavClsBtn');
    const mobileStngClsBtn = document.getElementById('mobileStngClsBtn');

    mobileNavBtn.addEventListener('click', function() {
        mobileNav.style.display = 'flex';
        setTimeout(() => mobileNav.style.opacity = "1", 100)
    });

    mobileNavClsBtn.addEventListener('click', function() {
        mobileNav.style.opacity = "0";
        setTimeout(() => mobileNav.style.display = 'none', 300)
    });

    mobileStngBtn.addEventListener('click', function() {
        mobileStng.style.display = 'flex';
        setTimeout(() => mobileStng.style.opacity = "1", 100)
    });

    mobileStngClsBtn.addEventListener('click', function() {
        mobileStng.style.opacity = "0";
        setTimeout(() => mobileStng.style.display = 'none', 300)
    });
});