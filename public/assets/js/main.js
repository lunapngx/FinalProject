/**
* Template Name: eStore
* Template URL: https://bootstrapmade.com/estore-bootstrap-ecommerce-template/
* Updated: Apr 26 2025 with Bootstrap v5.3.5
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Ecommerce CartController Functionality
   * Handles quantity changes and item removal
   */

  function ecommerceCartTools() {
    // Get all quantity buttons and inputs directly
    const decreaseButtons = document.querySelectorAll('.quantity-btn.decrease');
    const increaseButtons = document.querySelectorAll('.quantity-btn.increase');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const removeButtons = document.querySelectorAll('.remove-item');

    // Decrease quantity buttons
    decreaseButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const quantityInput = btn.closest('.quantity-selector').querySelector('.quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });
    });

    // Increase quantity buttons
    increaseButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const quantityInput = btn.closest('.quantity-selector').querySelector('.quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < parseInt(quantityInput.getAttribute('max'))) {
          quantityInput.value = currentValue + 1;
        }
      });
    });

    // Manual quantity inputs
    quantityInputs.forEach(input => {
      input.addEventListener('change', function() {
        let currentValue = parseInt(input.value);
        const min = parseInt(input.getAttribute('min'));
        const max = parseInt(input.getAttribute('max'));

        // Validate input
        if (isNaN(currentValue) || currentValue < min) {
          input.value = min;
        } else if (currentValue > max) {
          input.value = max;
        }
      });
    });

    // Remove item buttons
    removeButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        btn.closest('.CartButton-item').remove();
      });
    });
  }

  ecommerceCartTools();

  /**
   * ProductModel Image Zoom and Thumbnail Functionality
   */

  function productDetailFeatures() {
    // Initialize Drift for image zoom
    function initDriftZoom() {
      // Check if Drift is available
      if (typeof Drift === 'undefined') {
        console.error('Drift library is not loaded');
        return;
      }

      const driftOptions = {
        paneContainer: document.querySelector('.image-zoom-container'),
        inlinePane: window.innerWidth < 768 ? true : false,
        inlineOffsetY: -85,
        containInline: true,
        hoverBoundingBox: false,
        zoomFactor: 3,
        handleTouch: false
      };

      // Initialize Drift on the main Product image
      const mainImage = document.getElementById('main-Product-image');
      if (mainImage) {
        new Drift(mainImage, driftOptions);
      }
    }

    // Thumbnail click functionality
    function initThumbnailClick() {
      const thumbnails = document.querySelectorAll('.thumbnail-item');
      const mainImage = document.getElementById('main-Product-image');

      if (!thumbnails.length || !mainImage) return;

      thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
          // Get image path from data attribute
          const imageSrc = this.getAttribute('data-image');

          // Update main image src and zoom attribute
          mainImage.src = imageSrc;
          mainImage.setAttribute('data-zoom', imageSrc);

          // Update active state
          thumbnails.forEach(item => item.classList.remove('active'));
          this.classList.add('active');

          // Reinitialize Drift for the new image
          initDriftZoom();
        });
      });
    }

    // Image navigation functionality (prev/next buttons)
    function initImageNavigation() {
      const prevButton = document.querySelector('.image-nav-btn.prev-image');
      const nextButton = document.querySelector('.image-nav-btn.next-image');

      if (!prevButton || !nextButton) return;

      const thumbnails = Array.from(document.querySelectorAll('.thumbnail-item'));
      if (!thumbnails.length) return;

      // Function to navigate to previous or next image
      function navigateImage(direction) {
        // Find the currently active thumbnail
        const activeIndex = thumbnails.findIndex(thumb => thumb.classList.contains('active'));
        if (activeIndex === -1) return;

        let newIndex;
        if (direction === 'prev') {
          // Go to previous image or loop to the last one
          newIndex = activeIndex === 0 ? thumbnails.length - 1 : activeIndex - 1;
        } else {
          // Go to next image or loop to the first one
          newIndex = activeIndex === thumbnails.length - 1 ? 0 : activeIndex + 1;
        }

        // Simulate click on the new thumbnail
        thumbnails[newIndex].click();
      }

      // Add event listeners to navigation buttons
      prevButton.addEventListener('click', () => navigateImage('prev'));
      nextButton.addEventListener('click', () => navigateImage('next'));
    }

    // Initialize all features
    initDriftZoom();
    initThumbnailClick();
    initImageNavigation();
  }

  productDetailFeatures();

  /**
   * Price range slider implementation for price filtering.
   */
  function priceRangeWidget() {
    // Get all price range widgets on the page
    const priceRangeWidgets = document.querySelectorAll('.price-range-container');

    priceRangeWidgets.forEach(widget => {
      const minRange = widget.querySelector('.min-range');
      const maxRange = widget.querySelector('.max-range');
      const sliderProgress = widget.querySelector('.slider-progress');
      const minPriceDisplay = widget.querySelector('.current-range .min-price');
      const maxPriceDisplay = widget.querySelector('.current-range .max-price');
      const minPriceInput = widget.querySelector('.min-price-input');
      const maxPriceInput = widget.querySelector('.max-price-input');
      const applyButton = widget.querySelector('.filter-actions .btn-primary');

      if (!minRange || !maxRange || !sliderProgress || !minPriceDisplay || !maxPriceDisplay || !minPriceInput || !maxPriceInput) return;

      // Slider configuration
      const sliderMin = parseInt(minRange.min);
      const sliderMax = parseInt(minRange.max);
      const step = parseInt(minRange.step) || 1;

      // Initialize with default values
      let minValue = parseInt(minRange.value);
      let maxValue = parseInt(maxRange.value);

      // Set initial values
      updateSliderProgress();
      updateDisplays();

      // Min range input event
      minRange.addEventListener('input', function() {
        minValue = parseInt(this.value);

        // Ensure min doesn't exceed max
        if (minValue > maxValue) {
          minValue = maxValue;
          this.value = minValue;
        }

        // Update min price input and display
        minPriceInput.value = minValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Max range input event
      maxRange.addEventListener('input', function() {
        maxValue = parseInt(this.value);

        // Ensure max isn't less than min
        if (maxValue < minValue) {
          maxValue = minValue;
          this.value = maxValue;
        }

        // Update max price input and display
        maxPriceInput.value = maxValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Min price input change
      minPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMin;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure min doesn't exceed max
        if (value > maxValue) {
          value = maxValue;
        }

        // Update min value and range input
        minValue = value;
        this.value = value;
        minRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Max price input change
      maxPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMax;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure max isn't less than min
        if (value < minValue) {
          value = minValue;
        }

        // Update max value and range input
        maxValue = value;
        this.value = value;
        maxRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Apply button click
      if (applyButton) {
        applyButton.addEventListener('click', function() {
          // This would typically trigger a form submission or AJAX request
          console.log(`Applying price filter: $${minValue} - $${maxValue}`);

          // Here you would typically add code to filter products or redirect to a filtered URL
        });
      }

      // Helper function to update the slider progress bar
      function updateSliderProgress() {
        const range = sliderMax - sliderMin;
        const minPercent = ((minValue - sliderMin) / range) * 100;
        const maxPercent = ((maxValue - sliderMin) / range) * 100;

        sliderProgress.style.left = `${minPercent}%`;
        sliderProgress.style.width = `${maxPercent - minPercent}%`;
      }

      // Helper function to update price displays
      function updateDisplays() {
        minPriceDisplay.textContent = `$${minValue}`;
        maxPriceDisplay.textContent = `$${maxValue}`;
      }
    });
  }
  priceRangeWidget();

  /**
   * Ecommerce CheckoutController Section
   * This script handles the functionality of both multi-step and one-page Checkout processes
   */

  function initCheckout() {
    // Detect Checkout type
    const isMultiStepCheckout = document.querySelector('.Checkout-steps') !== null;
    const isOnePageCheckout = document.querySelector('.Checkout-section') !== null;

    // Initialize common functionality
    initInputMasks();
    initPromoCode();

    // Initialize Checkout type specific functionality
    if (isMultiStepCheckout) {
      initMultiStepCheckout();
    }

    if (isOnePageCheckout) {
      initOnePageCheckout();
    }

    // Initialize tooltips (works for both Checkout types)
    initTooltips();
  }

  initCheckout();

  // Function to initialize multi-step Checkout
  function initMultiStepCheckout() {
    // Get all Checkout elements
    const checkoutSteps = document.querySelectorAll('.Checkout-steps .step');
    const checkoutForms = document.querySelectorAll('.Checkout-form');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const editButtons = document.querySelectorAll('.btn-edit');
    const paymentMethods = document.querySelectorAll('.payment-method-header');
    const summaryToggle = document.querySelector('.btn-toggle-summary');
    const orderSummaryContent = document.querySelector('.order-summary-content');

    // Step Navigation
    nextButtons.forEach(button => {
      button.addEventListener('click', function() {
        const nextStep = parseInt(this.getAttribute('data-next'));
        navigateToStep(nextStep);
      });
    });

    prevButtons.forEach(button => {
      button.addEventListener('click', function() {
        const prevStep = parseInt(this.getAttribute('data-prev'));
        navigateToStep(prevStep);
      });
    });

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const editStep = parseInt(this.getAttribute('data-edit'));
        navigateToStep(editStep);
      });
    });

    // Payment Method Selection for multi-step Checkout
    paymentMethods.forEach(header => {
      header.addEventListener('click', function() {
        // Get the radio input within this header
        const radio = this.querySelector('input[type="radio"]');
        if (radio) {
          radio.checked = true;

          // Update active state for all payment methods
          const allPaymentMethods = document.querySelectorAll('.payment-method');
          allPaymentMethods.forEach(method => {
            method.classList.remove('active');
          });

          // Add active class to the parent payment method
          this.closest('.payment-method').classList.add('active');

          // Show/hide payment method bodies
          const allPaymentBodies = document.querySelectorAll('.payment-method-body');
          allPaymentBodies.forEach(body => {
            body.classList.add('d-none');
          });

          const selectedBody = this.closest('.payment-method').querySelector('.payment-method-body');
          if (selectedBody) {
            selectedBody.classList.remove('d-none');
          }
        }
      });
    });

    // Order Summary Toggle (Mobile)
    if (summaryToggle) {
      summaryToggle.addEventListener('click', function() {
        this.classList.toggle('collapsed');

        if (orderSummaryContent) {
          orderSummaryContent.classList.toggle('d-none');
        }

        // Toggle icon
        const icon = this.querySelector('i');
        if (icon) {
          if (icon.classList.contains('bi-chevron-down')) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
          } else {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
          }
        }
      });
    }

    // Form Validation for multi-step Checkout
    const forms = document.querySelectorAll('.Checkout-form-element');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If it's the final form and valid, show success message
        if (isValid && form.closest('.Checkout-form[data-form="4"]')) {
          // Hide form fields
          const formFields = form.querySelectorAll('.form-group, .review-sections, .form-check, .d-flex');
          formFields.forEach(field => {
            field.style.display = 'none';
          });

          // Show success message
          const successMessage = form.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');

            // Add animation
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });
    });

    // Function to navigate between steps
    function navigateToStep(stepNumber) {
      // Update steps
      checkoutSteps.forEach(step => {
        const stepNum = parseInt(step.getAttribute('data-step'));

        if (stepNum < stepNumber) {
          step.classList.add('completed');
          step.classList.remove('active');
        } else if (stepNum === stepNumber) {
          step.classList.add('active');
          step.classList.remove('completed');
        } else {
          step.classList.remove('active', 'completed');
        }
      });

      // Update step connectors
      const connectors = document.querySelectorAll('.step-connector');
      connectors.forEach((connector, index) => {
        if (index + 1 < stepNumber) {
          connector.classList.add('completed');
          connector.classList.remove('active');
        } else if (index + 1 === stepNumber - 1) {
          connector.classList.add('active');
          connector.classList.remove('completed');
        } else {
          connector.classList.remove('active', 'completed');
        }
      });

      // Show the corresponding form
      checkoutForms.forEach(form => {
        const formNum = parseInt(form.getAttribute('data-form'));

        if (formNum === stepNumber) {
          form.classList.add('active');

          // Scroll to top of form on mobile
          if (window.innerWidth < 768) {
            form.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        } else {
          form.classList.remove('active');
        }
      });
    }
  }

  // Function to initialize one-page Checkout
  function initOnePageCheckout() {
    // Payment Method Selection for one-page Checkout
    const paymentOptions = document.querySelectorAll('.payment-option input[type="radio"]');

    paymentOptions.forEach(option => {
      option.addEventListener('change', function() {
        // Update active class on payment options
        document.querySelectorAll('.payment-option').forEach(opt => {
          opt.classList.remove('active');
        });

        this.closest('.payment-option').classList.add('active');

        // Show/hide payment details
        const paymentId = this.id;
        document.querySelectorAll('.payment-details').forEach(details => {
          details.classList.add('d-none');
        });

        document.getElementById(`${paymentId}-details`).classList.remove('d-none');
      });
    });

    // Form Validation for one-page Checkout
    const checkoutForm = document.querySelector('.Checkout-form');

    if (checkoutForm) {
      checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');

            // Scroll to first invalid field
            if (isValid === false) {
              field.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
              field.focus();
              isValid = null; // Set to null so we only scroll to the first invalid field
            }
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If form is valid, show success message
        if (isValid === true) {
          // Hide form sections except the last one
          const sections = document.querySelectorAll('.Checkout-section');
          sections.forEach((section, index) => {
            if (index < sections.length - 1) {
              section.style.display = 'none';
            }
          });

          // Hide terms checkbox and place order button
          const termsCheck = document.querySelector('.terms-check');
          const placeOrderContainer = document.querySelector('.place-order-container');

          if (termsCheck) termsCheck.style.display = 'none';
          if (placeOrderContainer) placeOrderContainer.style.display = 'none';

          // Show success message
          const successMessage = document.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Scroll to success message
          const orderReview = document.getElementById('order-review');
          if (orderReview) {
            orderReview.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });

      // Add input event listeners to clear validation styling when user types
      const formInputs = checkoutForm.querySelectorAll('input, select, textarea');
      formInputs.forEach(input => {
        input.addEventListener('input', function() {
          if (this.value.trim()) {
            this.classList.remove('is-invalid');
          }
        });
      });
    }
  }

  // Function to initialize input masks (common for both Checkout types)
  function initInputMasks() {
    // Card number input mask (format: XXXX XXXX XXXX XXXX)
    const cardNumberInput = document.getElementById('card-number');
    if (cardNumberInput) {
      cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);

        // Add spaces after every 4 digits
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
          if (i > 0 && i % 4 === 0) {
            formattedValue += ' ';
          }
          formattedValue += value[i];
        }

        e.target.value = formattedValue;
      });
    }

    // Expiry date input mask (format: MM/YY)
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
      expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);

        // Format as MM/YY
        if (value.length > 2) {
          value = value.slice(0, 2) + '/' + value.slice(2);
        }

        e.target.value = value;
      });
    }

    // CVV input mask (3-4 digits)
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
      cvvInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        e.target.value = value;
      });
    }

    // Phone number input mask
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
      phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);

        // Format as (XXX) XXX-XXXX
        if (value.length > 0) {
          if (value.length <= 3) {
            value = '(' + value;
          } else if (value.length <= 6) {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3);
          } else {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3, 6) + '-' + value.slice(6);
          }
        }

        e.target.value = value;
      });
    }

    // ZIP code input mask (5 digits)
    const zipInput = document.getElementById('zip');
    if (zipInput) {
      zipInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.slice(0, 5);
        e.target.value = value;
      });
    }
  }

  // Function to handle promo code application (common for both Checkout types)
  function initPromoCode() {
    const promoInput = document.querySelector('.promo-code input');
    const promoButton = document.querySelector('.promo-code button');

    if (promoInput && promoButton) {
      promoButton.addEventListener('click', function() {
        const promoCode = promoInput.value.trim();

        if (promoCode) {
          // Simulate promo code validation
          // In a real application, this would make an API call to validate the code

          // For demo purposes, let's assume "DISCOUNT20" is a valid code
          if (promoCode.toUpperCase() === 'DISCOUNT20') {
            // Show success state
            promoInput.classList.add('is-valid');
            promoInput.classList.remove('is-invalid');
            promoButton.textContent = 'Applied';
            promoButton.disabled = true;

            // Update order total (in a real app, this would recalculate based on the discount)
            const orderTotal = document.querySelector('.order-total span:last-child');
            const btnPrice = document.querySelector('.btn-price');

            if (orderTotal) {
              // Apply a 20% discount
              const currentTotal = parseFloat(orderTotal.textContent.replace('$', ''));
              const discountedTotal = (currentTotal * 0.8).toFixed(2);
              orderTotal.textContent = '$' + discountedTotal;

              // Update button price if it exists
              if (btnPrice) {
                btnPrice.textContent = '$' + discountedTotal;
              }

              // Add discount line
              const orderTotals = document.querySelector('.order-totals');
              if (orderTotals) {
                const discountElement = document.createElement('div');
                discountElement.className = 'order-discount d-flex justify-content-between';
                discountElement.innerHTML = `
                <span>Discount (20%)</span>
                <span>-$${(currentTotal * 0.2).toFixed(2)}</span>
              `;

                // Insert before the total
                const totalElement = document.querySelector('.order-total');
                if (totalElement) {
                  orderTotals.insertBefore(discountElement, totalElement);
                }
              }
            }
          } else {
            // Show error state
            promoInput.classList.add('is-invalid');
            promoInput.classList.remove('is-valid');

            // Reset after 3 seconds
            setTimeout(() => {
              promoInput.classList.remove('is-invalid');
            }, 3000);
          }
        }
      });
    }
  }

  // Function to initialize Bootstrap tooltips
  function initTooltips() {
    // Check if Bootstrap's tooltip function exists
    if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    } else {
      // Fallback for when Bootstrap JS is not loaded
      const cvvHint = document.querySelector('.cvv-hint');
      if (cvvHint) {
        cvvHint.addEventListener('mouseenter', function() {
          this.setAttribute('data-original-title', this.getAttribute('title'));
          this.setAttribute('title', '');
        });

        cvvHint.addEventListener('mouseleave', function() {
          this.setAttribute('title', this.getAttribute('data-original-title'));
        });
      }
    }
  }

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  // Ensure the DOM is fully loaded before running script
  document.addEventListener('DOMContentLoaded', function() {
    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    if (profileDropdownToggle && profileDropdownMenu) {
      // Toggle the dropdown when the profile icon is clicked
      profileDropdownToggle.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent document click from immediately closing
        profileDropdownMenu.classList.toggle('show');

        // Update aria-expanded attribute for accessibility
        const isExpanded = profileDropdownMenu.classList.contains('show');
        profileDropdownToggle.setAttribute('aria-expanded', isExpanded);
      });

      // Close the dropdown if a click occurs outside of it
      document.addEventListener('click', function(event) {
        if (!profileDropdownMenu.contains(event.target) && !profileDropdownToggle.contains(event.target)) {
          profileDropdownMenu.classList.remove('show');
          profileDropdownToggle.setAttribute('aria-expanded', 'false');
        }
      });

      // Optional: Close dropdown if an item inside is clicked (and it's not a link that navigates)
      profileDropdownMenu.addEventListener('click', function(event) {
        // If the clicked element is a link, let it navigate. Otherwise, close the dropdown.
        if (!event.target.closest('a')) {
          profileDropdownMenu.classList.remove('show');
          profileDropdownToggle.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });
// js for my profile
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const contentSections = document.querySelectorAll('.content-section');
    const profilePicture = document.getElementById('profilePicture');
    const profilePictureInput = document.getElementById('profilePictureInput');
    const photoModal = document.getElementById('photoModal');
    const closeModal = document.getElementById('closeModal');
    const addPhotoOption = document.getElementById('addPhotoOption');
    const removePhotoOption = document.getElementById('removePhotoOption');
    const defaultProfilePicture = "https://placehold.co/80x80/e0f2fe/1d4ed8?text=GR"; // Default image source

    // For Account Settings (Personal Information)
    const firstNameInput = document.getElementById('firstName');
    const lastNameInput = document.getElementById('lastName');
    const emailInput = document.getElementById('email');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const saveChangesBtn = document.getElementById('saveChangesBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn'); // Added cancel button

    // For Password Settings
    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const editPasswordBtn = document.getElementById('editPasswordBtn');
    const savePasswordBtn = document.getElementById('savePasswordBtn');
    const cancelPasswordEditBtn = document.getElementById('cancelPasswordEditBtn');

    // Function to hide all content sections
    function hideAllContentSections() {
      contentSections.forEach(section => {
        section.classList.add('hidden');
      });
    }

    // Function to deactivate all sidebar links
    function deactivateAllSidebarLinks() {
      sidebarLinks.forEach(link => {
        link.classList.remove('active');
      });
    }

    // Add click event listener to each sidebar link
    sidebarLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior

        // Get the ID of the section to show
        const targetSectionId = this.getAttribute('data-section-id');
        const targetSection = document.getElementById(targetSectionId);

        // Hide all sections and deactivate all links
        hideAllContentSections();
        deactivateAllSidebarLinks();

        // Show the target section and activate the clicked link
        if (targetSection) {
          targetSection.classList.remove('hidden');
        }
        this.classList.add('active');

        // Update URL hash without page reload
        window.history.pushState(null, '', '#' + targetSectionId);
      });
    });

    // Handle sub-section navigation (for "Track Order" and "View Details")
    document.body.addEventListener('click', function(e) {
      const trackOrderBtn = e.target.closest('[data-sub-section-target="trackOrder"]');
      const viewDetailsBtn = e.target.closest('[data-sub-section-target="viewDetails"]');

      if (trackOrderBtn) {
        e.preventDefault();
        const orderId = trackOrderBtn.getAttribute('data-order-id');
        // Simulate fetching order data
        const orderData = getOrderData(orderId); // A function you'd need to implement
        if (orderData) {
          populateTrackOrderSection(orderData);
          hideAllContentSections();
          document.getElementById('trackOrderSection').classList.remove('hidden');
          window.history.pushState(null, '', '#trackOrderSection'); // Update hash for track order
        }
      } else if (viewDetailsBtn) {
        e.preventDefault();
        const orderId = viewDetailsBtn.getAttribute('data-order-id');
        const orderData = getOrderData(orderId);
        if (orderData) {
          populateViewDetailsSection(orderData);
          hideAllContentSections();
          document.getElementById('viewDetailsSection').classList.remove('hidden');
          window.history.pushState(null, '', '#viewDetailsSection'); // Update hash for view details
        }
      } else if (e.target.closest('[data-section-id="myOrders"]')) {
        // Handle "Back to My Orders" button clicks within track/view sections
        e.preventDefault();
        hideAllContentSections();
        document.getElementById('myOrders').classList.remove('hidden');
        // Optionally, reactivate "My Orders" sidebar link
        deactivateAllSidebarLinks();
        document.querySelector('.sidebar-link[data-section-id="myOrders"]').classList.add('active');
        window.history.pushState(null, '', '#myOrders'); // Update hash for my orders
      } else if (e.target.closest('[data-section-id="accountSettings"]')) {
        // Handle "Edit Profile" button click from "My Profile" section
        e.preventDefault();
        hideAllContentSections();
        document.getElementById('accountSettings').classList.remove('hidden');
        deactivateAllSidebarLinks();
        document.querySelector('.sidebar-link[data-section-id="accountSettings"]').classList.add('active');
        window.history.pushState(null, '', '#accountSettings'); // Update hash for account settings
      }
    });

    // Event listeners for Account Settings buttons (Personal Information)
    editProfileBtn.addEventListener('click', function() {
      firstNameInput.disabled = false;
      lastNameInput.disabled = false;
      emailInput.disabled = false;
      editProfileBtn.classList.add('hidden');
      saveChangesBtn.classList.remove('hidden');
      cancelEditBtn.classList.remove('hidden'); // Show cancel button
    });

    saveChangesBtn.addEventListener('click', function() {
      // In a real application, you would send this data to your backend
      console.log('Saving changes:', {
        firstName: firstNameInput.value,
        lastName: lastNameInput.value,
        email: emailInput.value
      });

      // After saving, disable fields and switch buttons back
      firstNameInput.disabled = true;
      lastNameInput.disabled = true;
      emailInput.disabled = true;
      saveChangesBtn.classList.add('hidden');
      cancelEditBtn.classList.add('hidden'); // Hide cancel button
      editProfileBtn.classList.remove('hidden');
      alert('Profile changes saved!'); // You might want a more subtle notification
    });

    cancelEditBtn.addEventListener('click', function() {
      // Revert fields to their original values if needed (you'd need to store them)
      // For now, just disable them and hide buttons
      firstNameInput.disabled = true;
      lastNameInput.disabled = true;
      emailInput.disabled = true;
      saveChangesBtn.classList.add('hidden');
      cancelEditBtn.classList.add('hidden');
      editProfileBtn.classList.remove('hidden');
    });

    // Start of Password Settings JavaScript (New addition)
    // Function to set password inputs editable or disabled
    function setPasswordInputsEditable(isEditable) {
      currentPasswordInput.disabled = !isEditable;
      newPasswordInput.disabled = !isEditable;
      confirmPasswordInput.disabled = !isEditable;
    }

    // Initialize password inputs as disabled when the page loads
    setPasswordInputsEditable(false);

    // Event listener for Edit Password button
    if (editPasswordBtn) {
      editPasswordBtn.addEventListener('click', function() {
        setPasswordInputsEditable(true); // Enable inputs
        editPasswordBtn.classList.add('hidden'); // Hide Edit button
        savePasswordBtn.classList.remove('hidden'); // Show Save button
        cancelPasswordEditBtn.classList.remove('hidden'); // Show Cancel button
      });
    }

    // Event listener for Save Changes (Password) button
    if (savePasswordBtn) {
      savePasswordBtn.addEventListener('click', function() {
        // TODO: Implement actual save logic here
        // Get values: currentPasswordInput.value, newPasswordInput.value, confirmPasswordInput.value
        // You'll want to add validation here (e.g., newPassword matches confirmPassword, meets complexity requirements)
        // Then, send data to backend (e.g., using fetch API)
        console.log('Saving password changes...');

        // For demonstration, let's assume success
        alert('Password changes saved! (This is a placeholder alert)');

        // After successful save, or on error, revert state
        setPasswordInputsEditable(false);
        editPasswordBtn.classList.remove('hidden');
        savePasswordBtn.classList.add('hidden');
        cancelPasswordEditBtn.classList.add('hidden');
        // Clear password fields for security
        currentPasswordInput.value = '';
        newPasswordInput.value = '';
        confirmPasswordInput.value = '';
      });
    }

    // Event listener for Cancel (Password) button
    if (cancelPasswordEditBtn) {
      cancelPasswordEditBtn.addEventListener('click', function() {
        // Revert inputs to original (disabled) state
        setPasswordInputsEditable(false);
        // Hide save and cancel buttons, show edit button
        editPasswordBtn.classList.remove('hidden');
        savePasswordBtn.classList.add('hidden');
        cancelPasswordEditBtn.classList.add('hidden');
        // Clear password fields
        currentPasswordInput.value = '';
        newPasswordInput.value = '';
        confirmPasswordInput.value = '';
        alert('Password changes cancelled.');
      });
    }
    // End of Password Settings JavaScript


    // Profile Picture Modal Logic (moved from inline script)
    profilePicture.addEventListener('click', function() {
      photoModal.style.display = 'flex'; // Use flex to center
    });

    profilePictureInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          profilePicture.src = e.target.result;
          console.log('New image selected:', file.name);
        };
        reader.readAsDataURL(file);
      }
    });


    closeModal.addEventListener('click', function() {
      photoModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
      if (event.target == photoModal) {
        photoModal.style.display = 'none';
      }
    });

    addPhotoOption.addEventListener('click', function() {
      profilePictureInput.click();
      photoModal.style.display = 'none';
    });

    removePhotoOption.addEventListener('click', function() {
      profilePicture.src = defaultProfilePicture;
      console.log('Profile picture removed.');
      photoModal.style.display = 'none';
    });
    // End Profile Picture Modal Logic


    // Dummy data and functions for demonstration (you would replace these with actual data fetching)
    function getOrderData(orderId) {
      const orders = {
        'ORD-2024-1278': {
          id: 'ORD-2024-1278',
          date: 'Feb 20, 2025',
          status: 'Processing',
          itemsCount: 3,
          total: '$789.99',
          images: [
            'https://placehold.co/60x60/fecaca/dc2626?text=Bag',
            'https://placehold.co/60x60/fecaca/dc2626?text=Chair',
            'https://placehold.co/60x60/fecaca/dc2626?text=Glasses'
          ],
          timeline: [
            { date: 'Feb 20, 2025', time: '10:00 AM', status: 'Order Placed', icon: 'fa-clipboard-list' },
            { date: 'Feb 20, 2025', time: '11:30 AM', status: 'Processing at Warehouse', icon: 'fa-warehouse' },
            { date: 'Feb 20, 2025', time: '01:00 PM', status: 'Payment Confirmed', icon: 'fa-money-check-alt' }
          ],
          paymentMethod: 'Credit Card (Visa ending in 1234)',
          shippingMethod: 'Standard Shipping',
          products: [
            { name: 'Elegant Leather Handbag', qty: 1, price: '$250.00', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Bag' },
            { name: 'Ergonomic Office Chair', qty: 1, price: '$400.00', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Chair' },
            { name: 'Stylish Blue Light Glasses', qty: 1, price: '$79.99', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Glasses' }
          ],
          subtotal: '$729.99',
          shipping: '$30.00',
          tax: '$30.00',
          address: '123 Main Street, Apt 4B, Springfield, IL 62701, United States'
        },
        'ORD-2024-1265': {
          id: 'ORD-2024-1265',
          date: 'Feb 15, 2025',
          status: 'Shipped',
          itemsCount: 2,
          total: '$459.99',
          images: [
            'https://placehold.co/60x60/fecaca/dc2626?text=Hoodie',
            'https://placehold.co/60x60/fecaca/dc2626?text=Shoes'
          ],
          timeline: [
            { date: 'Feb 15, 2025', time: '09:00 AM', status: 'Order Placed', icon: 'fa-clipboard-list' },
            { date: 'Feb 15, 2025', time: '10:00 AM', status: 'Shipped from Warehouse', icon: 'fa-truck' },
            { date: 'Feb 16, 2025', time: '08:00 AM', status: 'Out for Delivery', icon: 'fa-shipping-fast' }
          ],
          paymentMethod: 'PayPal',
          shippingMethod: 'Express Shipping',
          products: [
            { name: 'Comfortable Cotton Hoodie', qty: 1, price: '$80.00', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Hoodie' },
            { name: 'Running Shoes', qty: 1, price: '$350.00', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Shoes' }
          ],
          subtotal: '$430.00',
          shipping: '$20.00',
          tax: '$9.99',
          address: '456 Oak Avenue, Apt 10C, Metropolis, NY 10001, United States'
        },
        'ORD-2024-1252': {
          id: 'ORD-2024-1252',
          date: 'Feb 10, 2025',
          status: 'Delivered',
          itemsCount: 1,
          total: '$129.99',
          images: [
            'https://placehold.co/60x60/fecaca/dc2626?text=Watch'
          ],
          timeline: [
            { date: 'Feb 10, 2025', time: '09:00 AM', status: 'Order Placed', icon: 'fa-clipboard-list' },
            { date: 'Feb 10, 2025', time: '10:00 AM', status: 'Shipped from Warehouse', icon: 'fa-truck' },
            { date: 'Feb 12, 2025', time: '02:00 PM', status: 'Delivered', icon: 'fa-check-circle' }
          ],
          paymentMethod: 'Google Pay',
          shippingMethod: 'Standard Shipping',
          products: [
            { name: 'Smart Watch', qty: 1, price: '$120.00', image: 'https://placehold.co/60x60/fecaca/dc2626?text=Watch' }
          ],
          subtotal: '$120.00',
          shipping: '$5.00',
          tax: '$4.99',
          address: '789 Pine Lane, Unit 2A, Gotham, CA 90210, United States'
        }
      };
      return orders[orderId];
    }

    function populateTrackOrderSection(order) {
      document.getElementById('trackOrderId').textContent = `Order ID: #${order.id}`;
      document.getElementById('trackOrderDate').textContent = order.date;
      document.getElementById('trackOrderStatus').textContent = order.status;

      const trackOrderImagesContainer = document.getElementById('trackOrderImages');
      trackOrderImagesContainer.innerHTML = '';
      order.images.forEach(src => {
        const img = document.createElement('img');
        img.src = src;
        img.alt = 'Product Image';
        img.classList.add('rounded-md', 'w-16', 'h-16', 'object-cover');
        trackOrderImagesContainer.appendChild(img);
      });

      const trackOrderTimelineContainer = document.getElementById('trackOrderTimeline');
      trackOrderTimelineContainer.innerHTML = '';
      order.timeline.forEach((event, index) => {
        const isLast = index === order.timeline.length - 1;
        trackOrderTimelineContainer.innerHTML += `
                <div class="flex items-start">
                    <div class="flex flex-col items-center mr-4">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full ${isLast ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600'}">
                            <i class="fas ${event.icon}"></i>
                        </div>
                        ${!isLast ? '<div class="w-px bg-gray-300 h-10"></div>' : ''}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">${event.status}</p>
                        <p class="text-sm text-gray-500">${event.date} at ${event.time}</p>
                    </div>
                </div>
            `;
      });
    }

    function populateViewDetailsSection(order) {
      document.getElementById('viewDetailsPaymentMethod').textContent = order.paymentMethod;
      document.getElementById('viewDetailsShippingMethod').textContent = order.shippingMethod;
      document.getElementById('viewDetailsItemCount').textContent = order.itemsCount;

      const viewDetailsItemsContainer = document.getElementById('viewDetailsItems');
      viewDetailsItemsContainer.innerHTML = '';
      order.products.forEach(product => {
        viewDetailsItemsContainer.innerHTML += `
                <div class="flex items-center space-x-4">
                    <img src="${product.image}" alt="${product.name}" class="w-16 h-16 rounded-md object-cover flex-shrink-0">
                    <div>
                        <p class="font-semibold text-gray-800">${product.name}</p>
                        <p class="text-sm text-gray-600">Qty: ${product.qty} x $${parseFloat(product.price.replace('$', '')).toFixed(2)}</p>
                    </div>
                    <span class="ml-auto font-semibold text-gray-800">$${(parseFloat(product.price.replace('$', '')) * product.qty).toFixed(2)}</span>
                </div>
            `;
      });

      document.getElementById('viewDetailsSubtotal').textContent = order.subtotal;
      document.getElementById('viewDetailsShipping').textContent = order.shipping;
      document.getElementById('viewDetailsTax').textContent = order.tax;
      document.getElementById('viewDetailsTotal').textContent = order.total;
      document.getElementById('viewDetailsShippingAddress').innerHTML = order.address.replace(/, /g, '<br>');
    }

    // New: Handle initial section display based on URL hash
    const hash = window.location.hash.substring(1); // Get hash without '#'

    if (hash) {
      const targetSection = document.getElementById(hash);
      if (targetSection) {
        hideAllContentSections(); // Hide all other sections
        deactivateAllSidebarLinks(); // Deactivate all sidebar links
        targetSection.classList.remove('hidden'); // Show the target section

        // Activate the corresponding sidebar link if it exists
        const correspondingLink = document.querySelector(`.sidebar-link[data-section-id="${hash}"]`);
        if (correspondingLink) {
          correspondingLink.classList.add('active');
        }
      }
    } else {
      // If no hash, default to 'myProfileContent'
      hideAllContentSections();
      document.getElementById('myProfileContent').classList.remove('hidden');
      document.querySelector('.sidebar-link[data-section-id="myProfileContent"]').classList.add('active');
    }
  });
})();