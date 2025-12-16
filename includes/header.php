<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Luntian' : 'Luntian'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="script.js" defer></script>

    <style>
        /* Olive Garden Color Palette */
        :root {
            --parchment: #F5EFE7;
            --sand: #D8CDB5;
            --olive: #B4C4A1;
            --sage: #949F7F;
            --bark: #6B6047;
            --olivewood: #3A3D2F;
        }

        /* Reset & Base Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: var(--bark);
            background-color: var(--parchment);
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* Typography */
        h1, h2, h3, h4 { font-family: 'playfair display', serif; color: var(--olivewood); margin-bottom: 1rem; }
        h1 { font-size: 3rem; font-weight: 700; }
        h2 { font-size: 2.5rem; }
        h3 { font-size: 1.5rem; }

        /* Navigation */
        .navbar {
            background-color: var(--olivewood);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--parchment);
            letter-spacing: 1px;
            cursor: pointer;
        }

        .logo-img { height: 55px; width: auto; }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
            align-items: center;
        }

        .nav-links a {
            color: var(--parchment);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s, border-bottom 0.3s;
            padding: 0.5rem;
            border-bottom: 2px solid transparent;
        }

        .nav-links a:hover { color: var(--olive); }
        .nav-links a.active { color: var(--olive); border-bottom: 2px solid var(--olive); font-weight: 600; }

        /* Cart Icon */
        .cart-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: transform 0.3s;
            vertical-align: middle;
            padding: 0.5rem;
            transform: translateY(-6px);
        }
        .cart-icon:hover { transform: scale(1.1); }
        .cart-count {
            position: absolute;
            top: -8px; right: -8px;
            background-color: var(--olive);
            color: var(--olivewood);
            border-radius: 50%;
            width: 20px; height: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: bold;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .menu-toggle span { width: 25px; height: 3px; background-color: var(--parchment); transition: 0.3s; }

        /* --- PROFILE DROPDOWN STYLES --- */
        .profile-dropdown-container {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            width: 38px;
            height: 38px;
            background-color: var(--olive);
            color: var(--olivewood);
            border: 2px solid var(--parchment);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            user-select: none;
        }

        .profile-btn:hover {
            background-color: var(--parchment);
            color: var(--olivewood);
            border-color: var(--olive);
            transform: scale(1.05);
        }

        .dropdown-menu {
            display: none; /* Hidden by default */
            position: absolute;
            right: 0;
            top: 55px; /* Pushed down slightly */
            background-color: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 8px;
            z-index: 9999; /* Ensure it's on top */
            overflow: hidden;
        }

        /* The class added by JS to show the menu */
        .dropdown-menu.show {
            display: block !important;
            animation: fadeIn 0.2s ease-in-out;
        }

        .dropdown-menu a {
            color: var(--bark);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 0.95rem;
            transition: background-color 0.2s;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            text-align: left;
        }

        .dropdown-menu a:last-child { border-bottom: none; }
        .dropdown-menu a:hover { background-color: var(--parchment); color: var(--olivewood); }
        .dropdown-menu i { margin-right: 10px; width: 20px; text-align: center; color: var(--olive); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Search Bar */
        .search-bar-container {
            display: flex; align-items: center; gap: 0.3rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px; padding: 0.35rem 0.5rem;
            transition: background-color 0.3s; height: 32px;
        }
        .search-bar-container:hover { background-color: rgba(255, 255, 255, 0.15); }
        .search-input {
            background: transparent; border: none; color: var(--parchment);
            padding: 0.25rem 0.4rem; width: 140px; outline: none;
            font-size: 0.9rem; font-family: inherit; height: 100%;
        }
        .search-input::placeholder { color: rgba(241, 237, 230, 0.7); }
        .search-btn {
            background: none; border: none; color: var(--parchment);
            cursor: pointer; font-size: 0.95rem; padding: 0.25rem 0.4rem;
            transition: color 0.3s; display: flex; align-items: center;
            justify-content: center; height: 100%;
        }
        .search-btn:hover { color: var(--olive); }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            background-image: url('assets/HERO2.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(58, 61, 47, 0.3);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: var(--parchment);
            max-width: 800px;
            padding: 2rem;
        }

        .hero-title {
            font-size: 3.5rem;
            color: var(--parchment);
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            color: var(--parchment);
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 1s ease 0.4s backwards;
        }

        /* Buttons */
        .btn {
            padding: 0.9rem 2rem;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--olivewood);
            color: var(--parchment);
        }

        .btn-primary:hover {
            background-color: var(--bark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--parchment);
            border: 2px solid var(--parchment);
        }

        .btn-secondary:hover {
            background-color: var(--parchment);
            color: var(--olivewood);
        }

        .btn-small {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }

        /* Features Section */
        .flower, .truck, .pin, .money {
            padding-top: 2rem;
        }

        .features {
            padding: 5rem 0;
            background-color: var(--parchment);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: var(--olivewood);
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: var(--bark);
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            color: var(--olivewood);
        }

        .section-header p {
            color: var(--sage);
            font-size: 1.1rem;
        }

        /* About Section */
        .about {
            padding: 5rem 0;
            background-color: var(--sand);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-text h3 {
            color: var(--olivewood);
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
        }

        .about-text p {
            color: var(--bark);
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .about-image {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .about-real-image {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            object-fit: cover;
        }

        /* Team Section */
        .team {
            padding: 5rem 0;
            background-color: var(--parchment);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .team-card {
            background-color: white;
            border-radius: 12px;
            overflow: visible;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }

        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .team-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--sand);
            margin-bottom: 1.5rem;
            flex-shrink: 0;
        }

        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .team-card:hover .team-image img {
            transform: scale(1.05);
        }

        .team-card h3 {
            color: var(--olivewood);
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .team-role {
            color: var(--olive);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .team-bio {
            color: var(--bark);
            padding: 0 1.5rem 1.5rem;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Products Section */
        .products {
            padding: 5rem 0;
            background-color: var(--parchment);
        }

        .product-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.7rem 1.5rem;
            border: 2px solid var(--sage);
            background-color: transparent;
            color: var(--olivewood);
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: var(--olive);
            color: white;
            border-color: var(--olive);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-image {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
        }

        .product-info {
            padding: 1.5rem;
            background: var(--olive);
        }

        .product-info h3 {
            color: var(--olivewood);
            margin-bottom: 0.5rem;
        }

        .product-info p {
            color: var(--bark);
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--olivewood);
            margin-bottom: 1rem;
        }

        /* Season Section */
        .season {
            padding: 5rem 0;
            background-color: var(--sand);
        }

        .season-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .season-card {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .season-card h3 {
            color: var(--olivewood);
            margin-bottom: 1rem;
        }

        .season-card p {
            color: var(--bark);
            line-height: 1.8;
        }

        .season-list {
            list-style: none;
            padding: 0;
        }

        .season-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--sand);
            color: var(--bark);
        }

        .season-list li:last-child {
            border-bottom: none;
        }

        /* Contact Section */
        .contact {
            padding: 5rem 0;
            background-color: var(--parchment);
        }

        .contact-form-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            padding: 1rem;
            border: 2px solid var(--sand);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--olive);
        }

        .contact-form textarea {
            resize: vertical;
        }

        /* Featured Products Section */
        .featured-products {
            padding: 0;
            background-color: var(--olive);
        }

        .featured-products .section-header {
            padding: 3rem 0 2rem 0;
        }

        .featured-products .section-header h2 {
            color: white;
        }

        .featured-products .section-header p {
            color: var(--parchment);
        }

        .featured-gallery {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 2rem 20px;
            margin: 0;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .featured-gallery::-webkit-scrollbar {
            height: 8px;
        }

        .featured-gallery::-webkit-scrollbar-track {
            background: rgba(180, 196, 161, 0.2);
        }

        .featured-gallery::-webkit-scrollbar-thumb {
            background: var(--olive);
            border-radius: 4px;
        }

        .gallery-item {
            position: relative;
            height: 300px;
            min-width: 300px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            cursor: pointer;
            background: linear-gradient(135deg, var(--olive) 0%, var(--sage) 100%);
            flex-shrink: 0;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Map Section */
        .map-section {
            padding: 5rem 0;
            background-color: var(--sand);
        }

        .map-section .section-header h2 {
            color: var(--olivewood);
        }

        .map-section .section-header p {
            color: var(--sage);
        }

        .map-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .map-image {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .map-image iframe {
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 15px;
        }

        .map-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .map-address {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .map-address h3 {
            color: var(--olivewood);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .address-details p {
            color: var(--bark);
            line-height: 1.8;
            margin-bottom: 0.8rem;
            font-size: 1rem;
        }

        .address-details p strong {
            color: var(--olivewood);
            font-weight: 600;
        }

        .address-details .phone,
        .address-details .email,
        .address-details .Facebook,
        .address-details .Instagram,
        .address-details .TikTok {
            color: var(--olive);
            font-weight: 500;
        }

        .address-link,
        .address-details .phone a,
        .address-details .email a,
        .address-details .Facebook a,
        .address-details .Instagram a,
        .address-details .TikTok a {
            color: var(--olive);
            text-decoration: none;
            transition: color 0.3s;
        }

        .address-link:hover,
        .address-details .phone a:hover,
        .address-details .email a:hover,
        .address-details .Facebook a:hover,
        .address-details .Instagram a:hover,
        .address-details .TikTok a:hover {
            color: var(--olivewood);
            text-decoration: underline;
        }

        .address-link i,
        .address-details .phone a i,
        .address-details .email a i,
        .address-details .Facebook a i,
        .address-details .Instagram a i,
        .address-details .TikTok a i {
            margin-right: 0.5rem;
        }

        .address-details .hours {
            color: var(--olivewood);
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .address-details .note {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--sand);
            font-size: 0.95rem;
            font-style: italic;
            color: var(--sage);
        }

        /* Footer */
        .footer {
            background-color: var(--olivewood);
            color: var(--parchment);
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3,
        .footer-section h4 {
            color: var(--parchment);
            margin-bottom: 1rem;
        }

        .footer-section p {
            color: var(--sand);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: var(--sand);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: var(--olive);
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px; 
            padding: 0; 
            
            background-color: var(--bark);
            border-radius: 50%; 
            color: var(--parchment) !important;
            font-size: 1.2rem; 
            text-decoration: none !important;
            transition: background-color 0.3s, transform 0.3s;
        }

        .social-link,
        .social-link:visited,
        .social-link:active {
            color: var(--parchment) !important;
            text-decoration: none !important;
        }

        .social-link i,
        .social-link:visited i,
        .social-link:active i,
        .social-link:hover i,
        .social-link:focus i {
            color: var(--parchment) !important;
        }

        .social-link:hover {
            background-color: var(--sage);
            transform: translateY(-2px); 
        }

        .footer-bottom {
            border-top: 1px solid var(--bark);
            padding-top: 1rem;
            text-align: center;
            color: var(--sand);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #inquiryModal.modal-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: none; /* JS will set to flex */
            justify-content: center !important;
            align-items: center !important;
            background: rgba(0, 0, 0, 0.55) !important;
            backdrop-filter: blur(6px) !important;
            z-index: 999999 !important;
        }


        .modal-card {
            background: #ffffff;
            width: 330px;
            padding: 25px 25px 30px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            position: relative;
            animation: popIn 0.25s ease-out;
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: #555;
        }
        .close-btn:hover {
            color: #000;
        }

        .modal-price {
            color: var(--bark);
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .modal-message {
            color: #444;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .contact-btn {
            padding: 10px 16px;
            background: var(--sage);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }
        .contact-btn:hover {
            background: var(--bark);
        }

        .ok-btn {
            padding: 10px 18px;
            background: var(--olive);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .ok-btn:hover {
            background: var(--sage);
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .menu-toggle { display: flex; }
            .nav-links {
                position: fixed; left: -100%; top: 70px;
                flex-direction: column; background-color: var(--olivewood);
                width: 100%; text-align: center; transition: 0.3s;
                box-shadow: 0 10px 27px rgba(0,0,0,0.05); padding: 2rem 0;
            }
            .nav-links.active { left: 0; }
            .search-bar-container { width: 90%; margin: 1rem auto; }
            .search-input { width: 100%; }
            .hero-title { font-size: 2rem; }
            .hero-subtitle { font-size: 1rem; }
            .hero-buttons { flex-direction: column; align-items: center; }
            
            /* Profile Mobile */
            .profile-dropdown-container { width: 100%; display: flex; flex-direction: column; align-items: center; margin-top: 10px; }
            .dropdown-menu { position: static; width: 100%; background-color: rgba(0,0,0,0.05); box-shadow: none; text-align: center; }
            .dropdown-menu a { text-align: center; color: var(--parchment); }
            .dropdown-menu a:hover { background-color: rgba(255,255,255,0.1); }
        }

        /* Shopping Cart Page */
        .shopping-cart {
            min-height: 70vh;
            padding: 3rem 0;
            background-color: var(--parchment);
        }

        .cart-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            margin-top: 2rem;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .cart-table thead {
            background-color: var(--olivewood);
            color: var(--parchment);
        }

        .cart-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .cart-table td {
            padding: 1.5rem;
            border-bottom: 1px solid var(--sand);
        }

        .cart-table tr:last-child td {
            border-bottom: none;
        }

        .cart-table tbody tr:hover {
            background-color: var(--parchment);
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--olivewood);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            border: 1px solid var(--sage);
            background-color: white;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .quantity-controls button:hover {
            background-color: var(--olive);
            color: white;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid var(--sage);
            padding: 0.25rem;
            border-radius: 4px;
        }

        .remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .remove-btn:hover {
            background-color: #c0392b;
        }

        .empty-cart-message {
            display: none;
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .empty-cart-message.show {
            display: block;
        }

        .empty-cart-message i {
            font-size: 4rem;
            color: var(--olive);
            margin-bottom: 1rem;
        }

        .empty-cart-message p {
            font-size: 1.2rem;
            color: var(--bark);
            margin-bottom: 2rem;
        }

        .cart-summary {
            position: sticky;
            top: 100px;
        }

        .summary-card {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .summary-card h3 {
            color: var(--olivewood);
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: var(--bark);
        }

        .summary-divider {
            border-top: 2px solid var(--sand);
            margin: 1rem 0;
        }

        .total-row {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--olivewood);
            margin-bottom: 1.5rem;
        }

        .btn-checkout {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .cart-summary .btn-secondary {
            width: 100%;
        }

        @media (max-width: 768px) {
            .cart-content {
                grid-template-columns: 1fr;
            }
            
            .cart-summary {
                position: static;
            }
            
            .cart-table th,
            .cart-table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php">
                <div class="logo">
                    <img src="assets/LUNTIANLOGO.png" alt="Luntian Logo" class="logo-img">
                </div>
            </a>
            <button class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php" class="<?php echo ($activePage == 'home') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="<?php echo ($activePage == 'about') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="products.php" class="<?php echo ($activePage == 'products') ? 'active' : ''; ?>">Products</a></li>
                <li><a href="season.php" class="<?php echo ($activePage == 'season') ? 'active' : ''; ?>">Flowers Season</a></li>
                
                <li class="search-bar-container">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search products..." autocomplete="off">
                    <button class="search-btn" id="searchBtn"><i class="fas fa-search"></i></button>
                </li>
                
                <li><a href="cart.php" class="cart-icon <?php echo ($activePage == 'cart') ? 'active' : ''; ?>" id="cartIcon"><i class="fas fa-shopping-cart"></i><span class="cart-count">0</span></a></li>
                
                <?php if(isset($_SESSION['user_id'])): 
                    // Get first letter of name
                    $initial = isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : 'U';
                ?>
                    <li class="profile-dropdown-container">
                        <div class="profile-btn" id="profileBtn" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                            <?php echo $initial; ?>
                        </div>
                        <div class="dropdown-menu" id="profileDropdown">
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="admin_orders.php" style="color: var(--olive); font-weight: bold;"><i class="fas fa-crown"></i> Admin Panel</a>
                            <?php endif; ?>

                            <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                            
                            <?php if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                                <a href="my_orders.php"><i class="fas fa-box"></i> My Orders</a>
                            <?php endif; ?>

                            <a href="#" onclick="confirmLogout(event)"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="login.php" class="<?php echo ($activePage == 'login') ? 'active' : ''; ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>
</html>

    