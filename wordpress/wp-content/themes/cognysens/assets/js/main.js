/**
 * COGNYSENS - Main JavaScript
 */

(function() {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');

        if (!menuToggle || !navigation) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            navigation.classList.toggle('is-active');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navigation.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.setAttribute('aria-expanded', 'false');
                navigation.classList.remove('is-active');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navigation.classList.contains('is-active')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                navigation.classList.remove('is-active');
                document.body.classList.remove('menu-open');
            }
        });
    }

    /**
     * Sticky Header
     */
    function initStickyHeader() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollY = window.scrollY;
        const scrollThreshold = 100;

        window.addEventListener('scroll', function() {
            const currentScrollY = window.scrollY;

            if (currentScrollY > scrollThreshold) {
                header.classList.add('is-scrolled');
            } else {
                header.classList.remove('is-scrolled');
            }

            // Hide/show header on scroll direction
            if (currentScrollY > lastScrollY && currentScrollY > 300) {
                header.classList.add('is-hidden');
            } else {
                header.classList.remove('is-hidden');
            }

            lastScrollY = currentScrollY;
        }, { passive: true });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (!targetElement) return;

                e.preventDefault();

                const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            });
        });
    }

    /**
     * FAQ Accordion Enhancement
     */
    function initFaqAccordion() {
        const details = document.querySelectorAll('details');

        details.forEach(detail => {
            detail.addEventListener('toggle', function() {
                if (this.open) {
                    // Close other details in the same container
                    const parent = this.parentElement;
                    parent.querySelectorAll('details[open]').forEach(openDetail => {
                        if (openDetail !== this) {
                            openDetail.removeAttribute('open');
                        }
                    });
                }
            });
        });
    }

    /**
     * Form Validation Enhancement
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('.cognysens-contact-form, .cognysens-rdv-form');

        forms.forEach(form => {
            // Remove invalid class on input
            form.querySelectorAll('input, textarea, select').forEach(field => {
                field.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    // Hide any error message
                    const errorEl = this.parentElement.querySelector('.field-error');
                    if (errorEl) errorEl.remove();
                });
            });
        });
    }

    /**
     * Validate form fields
     */
    function validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalid = null;

        requiredFields.forEach(field => {
            // Clear previous error
            field.classList.remove('is-invalid');
            const existingError = field.parentElement.querySelector('.field-error');
            if (existingError) existingError.remove();

            // Check empty
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                if (!firstInvalid) firstInvalid = field;
                return;
            }

            // Check checkbox
            if (field.type === 'checkbox' && !field.checked) {
                isValid = false;
                field.classList.add('is-invalid');
                if (!firstInvalid) firstInvalid = field;
                return;
            }

            // Check radio groups
            if (field.type === 'radio') {
                const name = field.name;
                const group = form.querySelectorAll(`input[name="${name}"]`);
                const anyChecked = Array.from(group).some(r => r.checked);
                if (!anyChecked) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    if (!firstInvalid) firstInvalid = field;
                }
            }
        });

        // Email validation
        const emailField = form.querySelector('input[type="email"]');
        if (emailField && emailField.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value)) {
                isValid = false;
                emailField.classList.add('is-invalid');
                if (!firstInvalid) firstInvalid = emailField;
            }
        }

        // Phone validation (French format)
        const phoneField = form.querySelector('input[type="tel"]');
        if (phoneField && phoneField.value) {
            const cleanPhone = phoneField.value.replace(/[\s.-]/g, '');
            if (!/^(0|\+33)[1-9][0-9]{8}$/.test(cleanPhone)) {
                isValid = false;
                phoneField.classList.add('is-invalid');
                if (!firstInvalid) firstInvalid = phoneField;
            }
        }

        // Focus first invalid field
        if (firstInvalid) {
            firstInvalid.focus();
        }

        return isValid;
    }

    /**
     * AJAX Form Submission
     */
    function initAjaxForms() {
        // Contact Form
        const contactForm = document.querySelector('.cognysens-contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (validateForm(this)) {
                    submitForm(this, 'cognysens_contact');
                }
            });
        }

        // RDV Form
        const rdvForm = document.querySelector('.cognysens-rdv-form');
        if (rdvForm) {
            rdvForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (validateForm(this)) {
                    submitForm(this, 'cognysens_rdv');
                }
            });
        }
    }

    /**
     * Submit form via AJAX
     */
    function submitForm(form, action) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';
        submitBtn.classList.add('is-loading');

        // Collect form data
        const formData = new FormData(form);
        formData.append('action', action);
        formData.append('nonce', window.cognysensAjax?.nonce || '');

        // Send AJAX request
        fetch(window.cognysensAjax?.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            // Remove existing messages
            const existingMsg = form.querySelector('.form-message');
            if (existingMsg) existingMsg.remove();

            // Create message element
            const messageEl = document.createElement('div');
            messageEl.className = 'form-message ' + (data.success ? 'form-message--success' : 'form-message--error');
            messageEl.innerHTML = '<p>' + (data.data?.message || 'Une erreur est survenue.') + '</p>';

            // Insert before submit button
            submitBtn.parentElement.insertBefore(messageEl, submitBtn);

            if (data.success) {
                // Reset form on success
                form.reset();
                // Scroll to message
                messageEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            const existingMsg = form.querySelector('.form-message');
            if (existingMsg) existingMsg.remove();

            const messageEl = document.createElement('div');
            messageEl.className = 'form-message form-message--error';
            messageEl.innerHTML = '<p>Erreur de connexion. Veuillez reessayer.</p>';
            submitBtn.parentElement.insertBefore(messageEl, submitBtn);
        })
        .finally(() => {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            submitBtn.classList.remove('is-loading');
        });
    }

    /**
     * Intersection Observer for Animations
     */
    function initAnimations() {
        if (!('IntersectionObserver' in window)) return;

        const animatedElements = document.querySelectorAll('.card, .tarif-card, .zone-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(el => {
            el.classList.add('animate-on-scroll');
            observer.observe(el);
        });
    }

    /**
     * Lazy Loading Images
     */
    function initLazyLoad() {
        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading
            document.querySelectorAll('img[data-src]').forEach(img => {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
        } else if ('IntersectionObserver' in window) {
            // Fallback for older browsers
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Initialize all functions on DOM ready
     */
    function init() {
        initMobileMenu();
        initStickyHeader();
        initSmoothScroll();
        initFaqAccordion();
        initFormValidation();
        initAjaxForms();
        initAnimations();
        initLazyLoad();
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
