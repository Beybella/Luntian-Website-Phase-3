/* =========================================
   1. NAVIGATION & UI INTERACTION
   ========================================= */

// Set active nav link based on current page
function setActiveNavLink() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        link.classList.remove('active');
        if (href === currentPage || (currentPage === '' && href === 'index.php')) {
            link.classList.add('active');
        }
    });
}
document.addEventListener('DOMContentLoaded', setActiveNavLink);

// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');

if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });
}

// Navbar background change on scroll
const navbar = document.querySelector('.navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.style.backgroundColor = 'rgba(58, 61, 47, 0.98)';
            navbar.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
        } else {
            navbar.style.backgroundColor = 'var(--olivewood)';
            navbar.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        }
    });
}

/* =========================================
   2. SEARCH & FILTERS
   ========================================= */

// Search Bar Functionality
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');

if (searchInput && searchBtn) {
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') performSearch();
    });
}

function performSearch() {
    const searchTerm = searchInput.value.trim().toLowerCase();
    if (searchTerm) {
        window.location.href = `products.php?search=${encodeURIComponent(searchTerm)}`;
    }
}

// Product Filter Functionality
const filterButtons = document.querySelectorAll('.filter-btn');
const productCards = document.querySelectorAll('.product-card');

if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            const filterValue = button.getAttribute('data-filter');
            
            productCards.forEach(card => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

/* =========================================
   3. SHOPPING CART LOGIC (DATABASE READY)
   ========================================= */

let cart = [];

// Load cart from localStorage
function loadCartFromLocalStorage() {
    const savedCart = localStorage.getItem('luntianCart');
    if (savedCart) {
        try {
            cart = JSON.parse(savedCart);
        } catch (e) {
            console.error('Error parsing cart:', e);
            cart = [];
        }
    }
}
loadCartFromLocalStorage();

function saveCartToLocalStorage() {
    localStorage.setItem('luntianCart', JSON.stringify(cart));
}

function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => el.textContent = totalItems);
}

// UPDATED: Now accepts ID
function addToCart(id, productName, productPrice) {
    const price = parseFloat(productPrice.replace(/[₱,]/g, ''));
    
    // Check if product exists by ID
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: id,
            name: productName,
            price: price,
            quantity: 1
        });
    }
    
    saveCartToLocalStorage();
    updateCartCount();
    console.log('Cart Updated:', cart);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    saveCartToLocalStorage();
    updateCartCount();
    renderCart();
}

function updateQuantity(index, change) {
    if (cart[index]) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            removeFromCart(index);
        } else {
            saveCartToLocalStorage();
            updateCartCount();
            renderCart();
        }
    }
}

function updateQuantityDirect(index, value) {
    const quantity = parseInt(value);
    if (quantity > 0) {
        cart[index].quantity = quantity;
        saveCartToLocalStorage();
        updateCartCount();
        renderCart();
    }
}

// Render Cart on cart.php
function renderCart() {
    const cartTableBody = document.getElementById('cartItemsTable');
    const emptyMessage = document.getElementById('emptyCartMessage');
    const cartTableWrapper = document.querySelector('.cart-table');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('totalPrice');
    
    if (!cartTableBody) return; // Stop if not on cart page
    
    cartTableBody.innerHTML = '';
    
    if (cart.length === 0) {
        emptyMessage.classList.add('show');
        if (cartTableWrapper) cartTableWrapper.style.display = 'none';
        if (subtotalEl) subtotalEl.textContent = '₱0.00';
        if (totalEl) totalEl.textContent = '₱0.00';
        return;
    }
    
    emptyMessage.classList.remove('show');
    if (cartTableWrapper) cartTableWrapper.style.display = 'table';
    
    let subtotal = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="cart-item-name">${item.name}</td>
            <td>₱${item.price.toFixed(2)}</td>
            <td>
                <div class="quantity-controls">
                    <button onclick="updateQuantity(${index}, -1)">−</button>
                    <input type="number" class="quantity-input" value="${item.quantity}" min="1" onchange="updateQuantityDirect(${index}, this.value)">
                    <button onclick="updateQuantity(${index}, 1)">+</button>
                </div>
            </td>
            <td>₱${itemTotal.toFixed(2)}</td>
            <td><button class="remove-btn" onclick="removeFromCart(${index})">Remove</button></td>
        `;
        cartTableBody.appendChild(row);
    });

    // Update Summary
    const deliveryFee = 150;
    const total = subtotal + deliveryFee;

    if (subtotalEl) subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
    if (totalEl) totalEl.textContent = `₱${total.toFixed(2)}`;
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    if (window.location.pathname.includes('cart.php')) {
        renderCart();
    }
});

/* =========================================
   4. MODAL & ADD TO CART CLICKS
   ========================================= */

const modal = document.getElementById('inquiryModal');
const closeModal = document.getElementById('closeModal');
const modalProductName = document.getElementById('modalProductName');
const modalProductPrice = document.getElementById('modalProductPrice');

// Event Delegation for Add to Cart Buttons
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('add-to-cart-btn')) {
        const card = e.target.closest('.product-card');
        
        // GET DATA
        const id = card.getAttribute('data-id');
        const name = card.querySelector('h3').innerText;
        const price = card.querySelector('.product-price').innerText;

        // Add to cart
        addToCart(id, name, price);

        // Show Modal
        if (modal) {
            modalProductName.innerText = name;
            modalProductPrice.innerText = price;
            const modalMessage = modal.querySelector('.modal-message');
            if(modalMessage) {
                modalMessage.innerHTML = `<strong>${name}</strong> added to cart!`;
            }
            modal.style.display = "flex";
        }
    }
});

if (closeModal) {
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });
}
const modalOkBtn = document.getElementById("modalOkBtn");
if (modalOkBtn) {
    modalOkBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });
}
window.addEventListener("click", function (e) {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});

/* =========================================
   5. CHECKOUT LOGIC
   ========================================= */

const checkoutBtn = document.getElementById('checkoutBtn');
const checkoutForm = document.getElementById('checkoutForm');
const hiddenCartData = document.getElementById('hiddenCartData');

if (checkoutBtn && checkoutForm && hiddenCartData) {
    checkoutBtn.addEventListener('click', (e) => {
        // 1. Prevent default submission initially to check cart status
        e.preventDefault();

        // 2. Check if cart is empty
        if (cart.length === 0) {
            alert('Your cart is empty! Please add items before checking out.');
            return;
        }

        // 3. Serialize the cart array to JSON string
        const cartJSON = JSON.stringify(cart);
        
        // 4. Put the JSON string into the hidden input
        hiddenCartData.value = cartJSON;
        
        console.log("Submitting cart data:", cartJSON); // Debugging

        // 5. Manually submit the form to go to checkout.php
        checkoutForm.submit();
    });
}

/* =========================================
   6. PROFILE DROPDOWN & LOGOUT
   ========================================= */

const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');

if (profileBtn && profileDropdown) {
    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('show');
    });

    window.addEventListener('click', (e) => {
        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('show');
        }
    });
}

function confirmLogout(e) {
    if(e) e.preventDefault();
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
    }
}

/* =========================================
   AUTO-SCROLL GALLERY
   ========================================= */
window.addEventListener('load', function() {
    const gallery = document.querySelector('.featured-gallery');
    if (!gallery) {
        console.log('Gallery element not found');
        return;
    }

    console.log('Gallery element found, starting auto-scroll');
    
    // Get original items
    const items = Array.from(gallery.querySelectorAll('.gallery-item'));
    const originalCount = items.length;
    
    // Clone items at the end for seamless loop
    items.forEach(item => {
        const clone = item.cloneNode(true);
        gallery.appendChild(clone);
    });
    
    let isAutoScrolling = true;
    let scrollSpeed = 0.5;

    // Function to scroll
    function scroll() {
        if (isAutoScrolling && gallery.scrollWidth > gallery.clientWidth) {
            gallery.scrollLeft += scrollSpeed;
            
            // Calculate the width of one complete set (all original items)
            const itemElements = gallery.querySelectorAll('.gallery-item');
            const singleSetWidth = (gallery.scrollWidth / 2);
            
            // When we've scrolled through one complete set, jump back to start
            // but the cloned items look identical so it's seamless
            if (gallery.scrollLeft >= singleSetWidth - 5) { // -5 for tolerance
                gallery.scrollLeft = 0;
            }
        }
        requestAnimationFrame(scroll);
    }

    // Start animation loop
    scroll();

    // Pause on hover
    gallery.addEventListener('mouseenter', function() {
        isAutoScrolling = false;
    });

    // Resume on mouse leave
    gallery.addEventListener('mouseleave', function() {
        isAutoScrolling = true;
    });
});