/**
 * Handles navigation, loading animations, scroll effects, and parallax
 */

(function () {
    'use strict';

    // Toggle function of Menu
    const menuList = document.getElementById('menuList');

    if (menuList) {
        menuList.style.maxHeight = '0px';
    }

    window.togglemenu = function () {
        if (!menuList) return;

        if (menuList.style.maxHeight === '0px') {
            menuList.style.maxHeight = '200px';
        } else {
            menuList.style.maxHeight = '0px';
        }
    };

    // Close menu when clicking outside
    document.addEventListener('click', function (e) {
        if (!menuList) return;

        const menuIcon = document.querySelector('.menu-icon');
        if (!menuList.contains(e.target) && e.target !== menuIcon) {
            menuList.style.maxHeight = '0px';
        }
    });

    // Loading animation via PaceJS Framework
    const paceOptions = {
        ajax: true,
        document: true,
        eventLag: false,
    };

    if (typeof Pace !== 'undefined') {
        Pace.on('done', function () {
            if (typeof $ !== 'undefined' && typeof $.bez !== 'undefined') {
                $('.p').animate(
                    {
                        top: '30%',
                        opacity: '0',
                    },
                    3000,
                    $.bez([0.19, 1, 0.22, 1]),
                );

                $('#preloader').animate(
                    {
                        top: '-100%',
                    },
                    2000,
                    $.bez([0.19, 1, 0.22, 1]),
                );
            }
        });
    }

    // Appear on Scroll via ScrollOut Framework
    if (typeof ScrollOut !== 'undefined') {
        ScrollOut({
            threshold: 0.2,
            once: true,
        });
    }

    // Parallax mouse movement on Homepage
    // Only apply on larger screens for performance
    if (window.innerWidth > 768) {
        const controller = document.querySelector('.controller');

        if (controller) {
            let ticking = false;

            document.addEventListener('mousemove', function (e) {
                if (!ticking) {
                    window.requestAnimationFrame(function () {
                        parallax(e);
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
    }

    function parallax(e) {
        const img = document.querySelector('.controller');
        if (!img) return;

        const speed = parseFloat(img.getAttribute('data-speed')) || -2.5;
        const x = (window.innerWidth - e.pageX * speed) / 100;
        const y = (window.innerHeight - e.pageY * speed) / 100;

        img.style.transform = `translate(${x}px, ${y}px)`;
    }

    // Escape key closes menu
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && menuList) {
            menuList.style.maxHeight = '0px';
        }
    });
})();
