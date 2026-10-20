document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const toggleBtn = document.querySelector('.mobile-toggle');
    const overlay = document.querySelector('.mobile-menu-overlay');
    const closeBtn = document.querySelector('.menu-close');
    const body = document.body;
    const mainNav = document.getElementById('mainNav');
    const navLinks = document.querySelectorAll('.main-nav a');
    const dropdownLinks = document.querySelectorAll('.has-dropdown > a');
    const mobileMedia = window.matchMedia('(max-width: 960px)');

    const syncToggle = (isOpen) => {
        if (!toggleBtn) return;
        toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    };

    const closeMenu = () => {
        body.classList.remove('nav-open');
        if (mainNav) mainNav.classList.remove('is-open');
        syncToggle(false);
        document.querySelectorAll('.has-dropdown.open').forEach(item => item.classList.remove('open'));
    };

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isOpen = body.classList.toggle('nav-open');
            if (mainNav) mainNav.classList.toggle('is-open', isOpen);
            syncToggle(isOpen);
        });
    }
    syncToggle(body.classList.contains('nav-open'));

    if (overlay) {
        overlay.addEventListener('click', closeMenu);
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }

    if (navLinks.length) {
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const isTopDropdownTrigger = !!link.closest('.has-dropdown') && !!link.parentElement && link.parentElement.classList.contains('has-dropdown');
                if (isTopDropdownTrigger && mobileMedia.matches) return;
                closeMenu();
            });
        });
    }

    // Mobile dropdown toggle
    dropdownLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (!mobileMedia.matches) return;
            e.preventDefault();
            const parent = link.closest('.has-dropdown');
            const isOpen = parent.classList.contains('open');
            document.querySelectorAll('.has-dropdown.open').forEach(item => item.classList.remove('open'));
            if (!isOpen) parent.classList.add('open');
        });
    });

    // FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all
            faqItems.forEach(i => i.classList.remove('active'));
            
            // Toggle current
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });

});
