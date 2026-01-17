// Form Validation
class FormValidator {
  constructor() {
    this.initializeValidation()
  }

  initializeValidation() {
    const forms = document.querySelectorAll("form")
    forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault()
        }
      })

      // Real-time validation
      const inputs = form.querySelectorAll("input, select, textarea")
      inputs.forEach((input) => {
        input.addEventListener("blur", () => {
          this.validateField(input)
        })
        input.addEventListener("input", () => {
          this.clearError(input)
        })
      })
    })
  }

  validateForm(form) {
    let isValid = true
    const inputs = form.querySelectorAll("input[required], select[required], textarea[required]")

    inputs.forEach((input) => {
      if (!this.validateField(input)) {
        isValid = false
      }
    })

    return isValid
  }

  validateField(field) {
    const value = field.value.trim()
    const fieldType = field.type
    const fieldName = field.name
    let isValid = true
    let errorMessage = ""

    // Clear previous errors
    this.clearError(field)

    // Required field validation
    if (field.hasAttribute("required") && !value) {
      errorMessage = "Este campo es obligatorio"
      isValid = false
    }
    // Email validation
    else if (fieldType === "email" && value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(value)) {
        errorMessage = "Por favor ingrese un email válido"
        isValid = false
      }
    }
    // Password validation
    else if (fieldType === "password" && value) {
      if (value.length < 6) {
        errorMessage = "La contraseña debe tener al menos 6 caracteres"
        isValid = false
      }
    }
    // Phone validation
    else if (fieldName === "phone" && value) {
      const phoneRegex = /^[+]?[1-9][\d]{0,15}$/
      if (!phoneRegex.test(value.replace(/[\s\-$$$$]/g, ""))) {
        errorMessage = "Por favor ingrese un número de teléfono válido"
        isValid = false
      }
    }
    // Year validation
    else if (fieldName === "year" && value) {
      const currentYear = new Date().getFullYear()
      const year = Number.parseInt(value)
      if (year < 2000 || year > currentYear + 1) {
        errorMessage = `El año debe estar entre 2000 y ${currentYear + 1}`
        isValid = false
      }
    }
    // Price validation
    else if (fieldName === "price" && value) {
      const price = Number.parseFloat(value)
      if (price <= 0) {
        errorMessage = "El precio debe ser mayor a 0"
        isValid = false
      }
      if (price > 10000) {
        errorMessage = "El precio parece demasiado alto para un producto óptico"
        isValid = false
      }
    }
    // Stock validation (using mileage field as stock)
    else if (fieldName === "mileage" && value) {
      const stock = Number.parseInt(value)
      if (stock < 0) {
        errorMessage = "El stock no puede ser negativo"
        isValid = false
      }
      if (stock > 1000) {
        errorMessage = "El stock parece demasiado alto"
        isValid = false
      }
    }

    if (!isValid) {
      this.showError(field, errorMessage)
    }

    return isValid
  }

  showError(field, message) {
    field.classList.add("error")

    // Remove existing error message
    const existingError = field.parentNode.querySelector(".error-message")
    if (existingError) {
      existingError.remove()
    }

    // Add new error message
    const errorDiv = document.createElement("div")
    errorDiv.className = "error-message"
    errorDiv.textContent = message
    field.parentNode.appendChild(errorDiv)
  }

  clearError(field) {
    field.classList.remove("error")
    const errorMessage = field.parentNode.querySelector(".error-message")
    if (errorMessage) {
      errorMessage.remove()
    }
  }
}

// Confirmation Dialogs
class ConfirmationDialog {
  static confirm(message, callback) {
    if (confirm(message)) {
      callback()
    }
  }

  static deleteConfirm(itemName, deleteUrl) {
    const message = `¿Está seguro que desea eliminar "${itemName}"? Esta acción no se puede deshacer.`
    if (confirm(message)) {
      window.location.href = deleteUrl
    }
  }
}

// Auto-hide messages
class MessageHandler {
  constructor() {
    this.initializeMessages()
  }

  initializeMessages() {
    const messages = document.querySelectorAll(".message")
    messages.forEach((message) => {
      // Auto-hide success messages after 5 seconds
      if (message.classList.contains("message-success")) {
        setTimeout(() => {
          this.fadeOut(message)
        }, 5000)
      }

      // Add close button
      const closeBtn = document.createElement("span")
      closeBtn.innerHTML = "&times;"
      closeBtn.style.cssText = "float: right; cursor: pointer; font-size: 1.2em; font-weight: bold;"
      closeBtn.onclick = () => this.fadeOut(message)
      message.insertBefore(closeBtn, message.firstChild)
    })
  }

  fadeOut(element) {
    element.style.transition = "opacity 0.5s ease"
    element.style.opacity = "0"
    setTimeout(() => {
      element.remove()
    }, 500)
  }
}

// Mobile Menu Toggle
class MobileMenu {
  constructor() {
    this.initializeMobileMenu()
  }

  initializeMobileMenu() {
    const header = document.querySelector(".header")
    if (!header) return

    // Create mobile menu toggle button
    const toggleBtn = document.createElement("button")
    toggleBtn.className = "mobile-menu-toggle"
    toggleBtn.innerHTML = "☰"
    toggleBtn.style.cssText = `
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        `

    const headerContent = header.querySelector(".header-content")
    const navMenu = header.querySelector(".nav-menu")

    if (headerContent && navMenu) {
      headerContent.insertBefore(toggleBtn, navMenu)

      toggleBtn.addEventListener("click", () => {
        navMenu.classList.toggle("mobile-active")
      })

      // Show toggle button on mobile
      const mediaQuery = window.matchMedia("(max-width: 768px)")
      const handleMediaQuery = (e) => {
        if (e.matches) {
          toggleBtn.style.display = "block"
          navMenu.style.cssText = `
                        display: none;
                        position: absolute;
                        top: 100%;
                        left: 0;
                        right: 0;
                        background: #6a4c93;
                        flex-direction: column;
                        padding: 1rem;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    `
        } else {
          toggleBtn.style.display = "none"
          navMenu.style.cssText = ""
          navMenu.classList.remove("mobile-active")
        }
      }

      mediaQuery.addListener(handleMediaQuery)
      handleMediaQuery(mediaQuery)

      // Add CSS for mobile menu
      const style = document.createElement("style")
      style.textContent = `
                .nav-menu.mobile-active {
                    display: flex !important;
                }
            `
      document.head.appendChild(style)
    }
  }
}

// Form Enhancement
class FormEnhancer {
  constructor() {
    this.initializeFormEnhancements()
  }

  initializeFormEnhancements() {
    // Add loading state to forms
    const forms = document.querySelectorAll("form")
    forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]')
        if (submitBtn && this.validateFormBeforeSubmit(form)) {
          submitBtn.disabled = true
          submitBtn.textContent = "Procesando..."

          // Re-enable after 5 seconds as fallback
          setTimeout(() => {
            submitBtn.disabled = false
            submitBtn.textContent = submitBtn.dataset.originalText || "Enviar"
          }, 5000)
        }
      })
    })

    // Store original button text
    const submitButtons = document.querySelectorAll('button[type="submit"], input[type="submit"]')
    submitButtons.forEach((btn) => {
      btn.dataset.originalText = btn.textContent || btn.value
    })
  }

  validateFormBeforeSubmit(form) {
    const validator = new FormValidator()
    return validator.validateForm(form)
  }
}

// Price Formatter
class PriceFormatter {
  static format(price) {
    return new Intl.NumberFormat("es-MX", {
      style: "currency",
      currency: "MXN",
    }).format(price)
  }

  static initializePriceFormatting() {
    const priceElements = document.querySelectorAll(".car-price, .price")
    priceElements.forEach((element) => {
      const price = Number.parseFloat(element.textContent.replace(/[^0-9.]/g, ""))
      if (!isNaN(price)) {
        element.textContent = PriceFormatter.format(price)
      }
    })
  }
}

// Search and Filter
class SearchFilter {
  constructor() {
    this.initializeSearch()
  }

  initializeSearch() {
    const searchInput = document.querySelector("#search")
    const filterSelect = document.querySelector("#filter")
    const carCards = document.querySelectorAll(".car-card")

    if (searchInput || filterSelect) {
      const performFilter = () => {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : ""
        const filterValue = filterSelect ? filterSelect.value : ""

        carCards.forEach((card) => {
          const carTitle = card.querySelector(".car-title").textContent.toLowerCase()
          const carBrand = card.dataset.brand ? card.dataset.brand.toLowerCase() : ""
          const carModel = card.dataset.model ? card.dataset.model.toLowerCase() : ""

          const matchesSearch =
            !searchTerm ||
            carTitle.includes(searchTerm) ||
            carBrand.includes(searchTerm) ||
            carModel.includes(searchTerm)

          const matchesFilter =
            !filterValue ||
            card.dataset.brand === filterValue ||
            card.dataset.fuelType === filterValue ||
            card.dataset.transmission === filterValue

          if (matchesSearch && matchesFilter) {
            card.style.display = "block"
            card.style.animation = "fadeIn 0.5s ease"
          } else {
            card.style.display = "none"
          }
        })
      }

      if (searchInput) {
        searchInput.addEventListener("input", performFilter)
      }
      if (filterSelect) {
        filterSelect.addEventListener("change", performFilter)
      }
    }
  }
}

// Visual Effects for Optics
class OpticalEffects {
  constructor() {
    this.initializeEffects()
  }

  initializeEffects() {
    // Add glow effect to product cards
    const productCards = document.querySelectorAll(".car-card")
    productCards.forEach((card) => {
      card.classList.add("optical-effect")
    })

    // Improved hover effect for optical products
    productCards.forEach((card) => {
      card.addEventListener("mouseenter", () => {
        card.style.transform = "translateY(-10px) scale(1.02)"
      })

      card.addEventListener("mouseleave", () => {
        card.style.transform = "translateY(0) scale(1)"
      })
    })
  }
}

// Initialize all components when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  new FormValidator()
  new MessageHandler()
  new MobileMenu()
  new FormEnhancer()
  new SearchFilter()
  new OpticalEffects()
  PriceFormatter.initializePriceFormatting()

  // Add smooth scrolling
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
        })
      }
    })
  })

  // Add loading animation to images
  const images = document.querySelectorAll("img")
  images.forEach((img) => {
    img.addEventListener("load", function () {
      this.style.opacity = "1"
    })
    img.style.opacity = "0"
    img.style.transition = "opacity 0.3s ease"
  })

  // Add fade-in animation
  const style = document.createElement("style")
  style.textContent = `
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .card, .car-card {
      animation: fadeIn 0.6s ease forwards;
    }
  `
  document.head.appendChild(style)
})

// Global functions for inline event handlers
function confirmDelete(itemName, deleteUrl) {
  ConfirmationDialog.deleteConfirm(itemName, deleteUrl)
}

function showLoading(button) {
  button.disabled = true
  button.textContent = "Cargando..."
}

// Function specific for validating prescriptions
function validatePrescription(field) {
  const value = field.value.trim()
  if (value && !/^[+-]?\d*\.?\d+$/.test(value)) {
    return "Por favor ingrese un valor de graduación válido (ej: -2.5, +1.25)"
  }
  return null
}
