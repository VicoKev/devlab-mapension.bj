<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - Service Public de Gestion des Pensions au Bénin</title>

        <!-- Google Fonts (Inter) chargées de façon asynchrone -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="shortcut icon" href="{{ asset('assets/pictures/logo.png') }}">

        <style>
        /* ============================================
           VARIABLES CSS & RESET
        ============================================ */
        :root {
            /* Couleurs principales */
            --bleu-marine: #1A3A5A;
            --blanc-casse: #F8F9FA;
            --blanc: #FFFFFF;
            
            /* Couleurs d'accent (drapeau béninois) */
            --vert: #008751;
            --jaune: #FCD116;
            --rouge: #E8112D;
            
            /* Couleurs neutres */
            --gris-fonce: #333333;
            --gris-moyen: #666666;
            --gris-clair: #CCCCCC;
            
            /* Typographie MOBILE-FIRST */
            --font-family: 'Inter', system-ui, -apple-system, sans-serif;
            --font-size-xs: 0.75rem;    /* 12px */
            --font-size-sm: 0.875rem;   /* 14px */
            --font-size-base: 1rem;     /* 16px */
            --font-size-md: 1.125rem;   /* 18px */
            --font-size-lg: 1.375rem;   /* 22px */
            --font-size-xl: 1.75rem;    /* 28px */
            --font-size-xxl: 2.125rem;  /* 34px */
            
            /* Espacements MOBILE-FIRST */
            --space-xs: 0.5rem;   /* 8px */
            --space-sm: 0.75rem;  /* 12px */
            --space-md: 1rem;     /* 16px */
            --space-lg: 1.5rem;   /* 24px */
            --space-xl: 2rem;     /* 32px */
            --space-xxl: 3rem;    /* 48px */
            
            /* Ombres */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 2px 6px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 4px 12px rgba(0, 0, 0, 0.2);
            --shadow-xl: 0 10px 25px rgba(0, 0, 0, 0.25);
            
            /* Bordures */
            --border-radius-sm: 4px;
            --border-radius-md: 8px;
            --border-radius-lg: 12px;
            --border-radius-xl: 50%;
            
            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }
        
        /* Médias queries pour desktop */
        @media (min-width: 768px) {
            :root {
                --font-size-xs: 0.875rem;   /* 14px */
                --font-size-sm: 1rem;       /* 16px */
                --font-size-base: 1.125rem; /* 18px */
                --font-size-md: 1.375rem;   /* 22px */
                --font-size-lg: 1.75rem;    /* 28px */
                --font-size-xl: 2.5rem;     /* 40px */
                --font-size-xxl: 3rem;      /* 48px */
                
                --space-xs: 0.5rem;   /* 8px */
                --space-sm: 1rem;     /* 16px */
                --space-md: 1.5rem;   /* 24px */
                --space-lg: 2rem;     /* 32px */
                --space-xl: 3rem;     /* 48px */
                --space-xxl: 4rem;    /* 64px */
            }
        }
        
        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }
        
        body {
            font-family: var(--font-family);
            font-size: var(--font-size-base);
            line-height: 1.5;
            color: var(--gris-fonce);
            background-color: var(--blanc-casse);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--bleu-marine);
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: var(--space-sm);
        }
        
        h1 {
            font-size: var(--font-size-xxl);
        }
        
        h2 {
            font-size: var(--font-size-xl);
            margin-bottom: var(--space-md);
        }
        
        h3 {
            font-size: var(--font-size-lg);
        }
        
        p {
            margin-bottom: var(--space-sm);
            line-height: 1.6;
        }
        
        a {
            color: var(--bleu-marine);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        a:hover {
            color: var(--vert);
        }
        
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        
        ul, ol {
            margin-bottom: var(--space-sm);
            padding-left: var(--space-md);
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--space-md);
        }
        
        .section {
            padding: var(--space-xl) 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: var(--space-xl);
        }
        
        .section-title h2 {
            position: relative;
            display: inline-block;
            padding-bottom: var(--space-sm);
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--vert, var(--jaune var(--rouge))));
            border-radius: 2px;
        }
        
        .btn {
            display: inline-block;
            padding: var(--space-sm) var(--space-lg);
            font-weight: 600;
            text-align: center;
            border-radius: var(--border-radius-md);
            border: none;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: var(--font-size-sm);
            min-height: 44px; /* Taille minimale pour les doigts */
            touch-action: manipulation;
        }
        
        .btn-primary {
            background-color: var(--jaune);
            color: var(--bleu-marine);
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #f0b900;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background-color: var(--bleu-marine);
            color: var(--blanc);
        }
        
        .btn-secondary:hover,
        .btn-secondary:focus {
            background-color: #0f2a47;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        /* ============================================
           HEADER - Navigation MOBILE-FIRST
        ============================================ */
        .header {
            background-color: var(--vert);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-sm) var(--space-md);
            min-height: 64px;
        }
        
        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            min-height: 44px; /* Pour zone cliquable plus grande sur mobile */
        }
        
        .logo-placeholder {
            width: 40px;
            height: 40px;
            background-color: var(--blanc);
            color: var(--vert);
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius-sm);
            font-size: var(--font-size-xs);
            flex-shrink: 0;
        }
        
        .logo-text {
            color: var(--blanc);
            font-weight: 700;
            font-size: var(--font-size-md);
            line-height: 1.2;
        }
        
        /* Navigation principale - MOBILE FIRST */
        .nav {
            display: flex;
            align-items: center;
        }
        
        .nav-list {
            list-style: none;
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: var(--vert);
            flex-direction: column;
            padding: var(--space-md);
            box-shadow: var(--shadow-md);
            z-index: 1000;
        }
        
        .nav-list.active {
            display: flex;
        }
        
        .nav-link {
            color: var(--blanc);
            font-weight: 500;
            padding: var(--space-sm) 0;
            position: relative;
            display: block;
            font-size: var(--font-size-base);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-link:last-child {
            border-bottom: none;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--jaune);
            transition: width var(--transition-normal);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Bouton de connexion */
        .btn-login {
            background-color: var(--jaune);
            color: var(--bleu-marine);
            padding: var(--space-xs) var(--space-md);
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: var(--font-size-sm);
            display: none;
            min-height: 36px;
        }
        
        /* Menu burger pour mobile */
        .menu-toggle {
            display: flex;
            background: none;
            border: none;
            color: var(--blanc);
            font-size: var(--font-size-lg);
            cursor: pointer;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius-sm);
            transition: background-color var(--transition-fast);
            z-index: 1001;
        }
        
        .menu-toggle:hover,
        .menu-toggle:focus {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Bande drapeau en bas du header */
        .flag-band {
            height: 4px;
            width: 100%;
            background: linear-gradient(to right, var(--vert) 33%, var(--jaune) 33% 66%, var(--rouge )66%);
        }
        
        /* ============================================
           SECTION HERO - AVEC TEXTE SUPERPOSÉ SUR L'IMAGE
        ============================================ */
        .hero {
            background-color: var(--blanc-casse);
            padding: 0;
            position: relative;
            overflow: hidden;
            min-height: 85vh;
            display: flex;
            align-items: center;
        }
        
        .hero-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 100%;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(26, 58, 90, 0.65) 0%, rgba(26, 58, 90, 0.5) 100%);
            z-index: 1;
        }
        
        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            animation: zoomIn 20s ease infinite alternate;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            filter: brightness(1.1) contrast(1.05);
        }
        
        .hero-content {
            animation: fadeInUp 1s ease;
            width: 100%;
            max-width: 800px;
            text-align: center;
            padding: var(--space-xl) var(--space-md);
            position: relative;
            z-index: 2;
            color: var(--blanc);
        }
        
        .hero-title {
            font-size: var(--font-size-xxl);
            margin-bottom: var(--space-md);
            color: var(--blanc);
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            font-size: var(--font-size-lg);
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: var(--space-xl);
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Animation du zoom pour l'image hero */
        @keyframes zoomIn {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.05);
            }
        }
        
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* ============================================
           SECTION GARANTIES - MOBILE FIRST
        ============================================ */
        .guarantees {
            background-color: var(--blanc);
            padding: var(--space-xl) 0;
        }
        
        .guarantees-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-lg);
        }
        
        .guarantee-card {
            background-color: var(--blanc-casse);
            border-radius: var(--border-radius-lg);
            padding: var(--space-lg);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-normal);
            border-top: 4px solid transparent;
            height: 100%;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        
        .guarantee-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        
        .guarantee-card.security:hover {
            border-top-color: var(--vert);
        }
        
        .guarantee-card.accessibility:hover {
            border-top-color: var(--jaune);
        }
        
        .guarantee-card.transparency:hover {
            border-top-color: var(--rouge);
        }
        
        .guarantee-icon {
            font-size: 2rem;
            color: var(--bleu-marine);
            margin-bottom: var(--space-md);
            height: 70px;
            width: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(26, 58, 90, 0.1) 0%, rgba(0, 135, 81, 0.1) 100%);
            border-radius: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .guarantee-title {
            margin-bottom: var(--space-sm);
            color: var(--bleu-marine);
            font-size: var(--font-size-lg);
        }
        
        /* ============================================
           SECTION COMMENT ÇA MARCHE (USSD) - MOBILE FIRST
        ============================================ */
        .ussd {
            background-color: var(--blanc-casse);
            padding: var(--space-xl) 0;
        }
        
        .ussd-container {
            display: flex;
            flex-direction: column;
            gap: var(--space-xl);
            align-items: center;
        }
        
        .ussd-visual {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-lg);
            width: 100%;
        }
        
        .phone-illustration {
            position: relative;
            width: 100%;
            max-width: 280px;
            height: 400px;
            background-color: var(--gris-fonce);
            border-radius: 20px;
            padding: 15px;
            box-shadow: var(--shadow-lg);
            margin: 0 auto;
        }
        
        .phone-screen {
            width: 100%;
            height: 100%;
            background-color: var(--blanc-casse);
            border-radius: 12px;
            padding: var(--space-md);
            font-family: monospace;
            color: var(--gris-fonce);
            overflow: hidden;
            font-size: var(--font-size-sm);
        }
        
        .phone-screen::before {
            content: "MA PENSION USSD";
            display: block;
            text-align: center;
            font-weight: bold;
            color: var(--bleu-marine);
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-xs);
            border-bottom: 1px solid var(--gris-clair);
            font-size: var(--font-size-sm);
        }
        
        .phone-screen ul {
            list-style: none;
            padding-left: 0;
        }
        
        .phone-screen li {
            margin-bottom: var(--space-sm);
            padding: var(--space-xs);
            border-radius: var(--border-radius-sm);
            background-color: rgba(0, 135, 81, 0.05);
            font-size: var(--font-size-sm);
        }
        
        .ussd-code {
            display: inline-block;
            background-color: var(--bleu-marine);
            color: var(--blanc);
            font-family: monospace;
            font-size: var(--font-size-xl);
            font-weight: 700;
            padding: var(--space-sm) var(--space-lg);
            border-radius: var(--border-radius-md);
            letter-spacing: 1px;
            box-shadow: var(--shadow-md);
            text-align: center;
            min-width: 120px;
        }
        
        .ussd-content {
            animation: fadeInRight 1s ease;
            width: 100%;
        }
        
        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* ============================================
           SECTION FAQ (Accordéon) - MOBILE FIRST
        ============================================ */
        .faq {
            background-color: var(--blanc);
            padding: var(--space-xl) 0;
        }
        
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .faq-item {
            margin-bottom: var(--space-sm);
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gris-clair);
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-md);
            background-color: var(--blanc-casse);
            cursor: pointer;
            font-weight: 600;
            color: var(--bleu-marine);
            transition: background-color var(--transition-fast);
            font-size: var(--font-size-base);
            min-height: 56px;
            touch-action: manipulation;
        }
        
        .faq-question:hover {
            background-color: rgba(0, 135, 81, 0.05);
        }
        
        .faq-toggle {
            width: 20px;
            height: 20px;
            position: relative;
            flex-shrink: 0;
            margin-left: var(--space-sm);
        }
        
        .faq-toggle::before,
        .faq-toggle::after {
            content: '';
            position: absolute;
            background-color: var(--vert);
            transition: transform var(--transition-normal);
        }
        
        .faq-toggle::before {
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            transform: translateY(-50%);
        }
        
        .faq-toggle::after {
            top: 0;
            left: 50%;
            width: 2px;
            height: 100%;
            transform: translateX(-50%);
        }
        
        .faq-answer {
            padding: 0 var(--space-md);
            max-height: 0;
            overflow: hidden;
            transition: max-height var(--transition-normal), padding var(--transition-normal);
            background-color: var(--blanc);
            font-size: var(--font-size-base);
        }
        
        .faq-input {
            display: none;
        }
        
        .faq-input:checked + .faq-question {
            background-color: rgba(0, 135, 81, 0.1);
        }
        
        .faq-input:checked + .faq-question .faq-toggle::after {
            transform: translateX(-50%) rotate(90deg);
        }
        
        .faq-input:checked + .faq-question + .faq-answer {
            padding: var(--space-md);
            max-height: 1000px;
        }
        
        /* ============================================
           WIDGET CHATBOT "Alogo" - NOUVEAU DESIGN
        ============================================ */
        .chatbot {
            position: fixed;
            bottom: var(--space-md);
            right: var(--space-md);
            z-index: 1001;
        }
        
        .chatbot-toggle {
            width: 70px;
            height: 70px;
            border-radius: var(--border-radius-xl);
            background: linear-gradient(135deg, var(--vert) 0%, var(--vert) 100%);
            color: var(--blanc);
            border: 3px solid var(--blanc);
            cursor: pointer;
            box-shadow: var(--shadow-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: all var(--transition-normal);
            touch-action: manipulation;
            position: relative;
            overflow: hidden;
            animation: pulse 2s infinite;
        }
        
        .chatbot-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            z-index: 1;
        }
        
        .chatbot-toggle i {
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .chatbot-toggle:hover,
        .chatbot-toggle:focus {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            animation: none;
        }
        
        /* Badge de notification */
        .chatbot-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--rouge);
            color: var(--blanc);
            font-size: 0.7rem;
            font-weight: bold;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--blanc);
            z-index: 3;
            animation: badgePulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 10px 25px rgba(252, 209, 22, 0.5);
            }
            50% {
                box-shadow: 0 10px 30px rgba(232, 17, 45, 0.6);
            }
            100% {
                box-shadow: 0 10px 25px rgba(252, 209, 22, 0.5);
            }
        }
        
        @keyframes badgePulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(232, 17, 45, 0.7);
            }
            70% {
                transform: scale(1.1);
                box-shadow: 0 0 0 10px rgba(232, 17, 45, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(232, 17, 45, 0);
            }
        }
        
        .chatbot-window {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: calc(100vw - var(--space-md) * 2);
            max-width: 320px;
            height: 450px;
            max-height: 70vh;
            background-color: var(--blanc);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-xl);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.95);
            transition: all var(--transition-normal);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .chatbot-window.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        
        .chatbot-header {
            background: linear-gradient(90deg, var(--vert) 0%, var(--bleu-marine) 100%);
            color: var(--blanc);
            padding: var(--space-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            position: relative;
        }
        
        .chatbot-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--vert) 33%, var(--jaune) 33% 66%, var(--rouge) 66%);
        }
        
        .chatbot-header-content {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .chatbot-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--bleu-marine) 0%, var(--vert) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--blanc);
            flex-shrink: 0;
        }
        
        .chatbot-title {
            font-weight: 600;
            font-size: var(--font-size-sm);
        }
        
        .chatbot-subtitle {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        
        .chatbot-close {
            background: none;
            border: none;
            color: var(--blanc);
            font-size: var(--font-size-md);
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color var(--transition-fast);
            touch-action: manipulation;
            flex-shrink: 0;
        }
        
        .chatbot-close:hover,
        .chatbot-close:focus {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .chatbot-messages {
            flex-grow: 1;
            padding: var(--space-md);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: var(--space-sm);
            font-size: var(--font-size-sm);
            background-color: #f9fafb;
        }
        
        .chatbot-message {
            padding: var(--space-sm);
            border-radius: var(--border-radius-md);
            max-width: 85%;
            line-height: 1.4;
            word-wrap: break-word;
            animation: messageSlide 0.3s ease;
        }
        
        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chatbot-message.bot {
            background-color: var(--blanc);
            align-self: flex-start;
            border: 1px solid rgba(0, 135, 81, 0.2);
            box-shadow: var(--shadow-sm);
        }
        
        .chatbot-message.user {
            background-color: var(--bleu-marine);
            color: var(--blanc);
            align-self: flex-end;
            border: 1px solid rgba(26, 58, 90, 0.2);
            box-shadow: var(--shadow-sm);
        }
        
        .chatbot-message.bot strong {
            color: var(--vert);
            font-weight: 600;
        }
        
        .chatbot-message.bot em {
            font-style: italic;
        }
        
        .chatbot-message.bot code {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 2px 4px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 0.9em;
            color: var(--rouge);
        }
        
        .chatbot-message.bot .section-divider {
            border-top: 2px solid var(--vert);
            margin: 8px 0;
            opacity: 0.3;
        }
        
        .chatbot-message.bot .highlight {
            background-color: rgba(252, 209, 22, 0.2);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 500;
        }
        
        .chatbot-message.bot ul, 
        .chatbot-message.bot ol {
            margin-left: 15px;
            margin-bottom: 8px;
        }
        
        .chatbot-message.bot li {
            margin-bottom: 4px;
        }
        
        .chatbot-input-container {
            padding: var(--space-sm);
            border-top: 1px solid var(--gris-clair);
            display: flex;
            gap: var(--space-xs);
            flex-shrink: 0;
            background-color: var(--blanc);
        }
        
        .chatbot-input {
            flex-grow: 1;
            padding: var(--space-sm);
            border: 1px solid var(--gris-clair);
            border-radius: var(--border-radius-md);
            font-family: var(--font-family);
            font-size: var(--font-size-sm);
            min-height: 44px;
            transition: border-color var(--transition-fast);
        }
        
        .chatbot-input:focus {
            border-color: var(--vert);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 135, 81, 0.1);
        }
        
        .chatbot-send {
            background: linear-gradient(135deg, var(--vert) 0%, var(--bleu-marine) 100%);
            color: var(--blanc);
            border: none;
            border-radius: var(--border-radius-md);
            padding: 0 var(--space-md);
            cursor: pointer;
            transition: all var(--transition-fast);
            min-width: 44px;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }
        
        .chatbot-send:hover,
        .chatbot-send:focus {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .chatbot-bubble {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: calc(100vw - var(--space-md) * 2);
            max-width: 280px;
            background-color: var(--blanc);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-xl);
            padding: var(--space-md);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all var(--transition-normal);
            z-index: 1002;
            border: 1px solid rgba(0, 0, 0, 0.1);
            animation: bubblePulse 2s infinite;
        }
        
        @keyframes bubblePulse {
            0% {
                box-shadow: var(--shadow-xl);
            }
            50% {
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            }
            100% {
                box-shadow: var(--shadow-xl);
            }
        }
        
        .chatbot-bubble.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .chatbot-bubble::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid var(--blanc);
        }
        
        .chatbot-bubble-header {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-sm);
        }
        
        .chatbot-bubble-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--jaune) 0%, var(--rouge) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: var(--blanc);
            flex-shrink: 0;
        }
        
        .chatbot-bubble-title {
            font-weight: 600;
            color: var(--bleu-marine);
        }
        
        /* Indicateur de frappe du chatbot */
        .chatbot-typing {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: var(--space-sm);
            background-color: var(--blanc);
            border-radius: var(--border-radius-md);
            align-self: flex-start;
            margin-bottom: var(--space-sm);
            border: 1px solid rgba(0, 135, 81, 0.2);
            box-shadow: var(--shadow-sm);
        }
        
        .typing-dot {
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, var(--vert) 0%, var(--bleu-marine) 100%);
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        .typing-dot:nth-child(3) { animation-delay: 0s; }
        
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        /* ============================================
           FOOTER - MOBILE FIRST
        ============================================ */
        .footer {
            background-color: var(--vert);
            color: var(--blanc-casse);
            padding-top: var(--space-xl);
        }
        
        .footer-flag-band {
            height: 4px;
            width: 100%;
            background: linear-gradient(to right, var(--vert) 33%, var(--jaune) 33% 66%, var(--rouge) 66%);
        }
        
        .footer-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-xl);
        }
        
        .footer-column h3 {
            color: var(--blanc);
            font-size: var(--font-size-lg);
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-xs);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .footer-links {
            list-style: none;
            padding-left: 0;
            font-size: var(--font-size-sm);
        }
        
        .footer-links li {
            margin-bottom: var(--space-sm);
            line-height: 1.4;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.9);
            transition: color var(--transition-fast);
        }
        
        .footer-links a:hover,
        .footer-links a:focus {
            color: var(--jaune);
        }
        
        .footer-links i {
            width: 20px;
            margin-right: var(--space-xs);
            color: var(--jaune);
        }
        
        .footer-ussd {
            font-size: var(--font-size-xl);
            font-weight: 700;
            letter-spacing: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: var(--space-sm);
            border-radius: var(--border-radius-md);
            text-align: center;
            margin-top: var(--space-sm);
            margin-bottom: var(--space-sm);
        }
        
        .footer-bottom {
            margin-top: var(--space-xl);
            padding: var(--space-md) 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: var(--font-size-xs);
            line-height: 1.4;
        }
        
        /* ============================================
           RESPONSIVE DESIGN - TABLETTE (768px+)
        ============================================ */
        @media (min-width: 768px) {
            /* Header tablette/desktop */
            .menu-toggle {
                display: none;
            }
            
            .nav-list {
                display: flex !important;
                position: static;
                width: auto;
                background-color: transparent;
                padding: 0;
                flex-direction: row;
                gap: var(--space-md);
                box-shadow: none;
            }
            
            .nav-link {
                padding: var(--space-xs) 0;
                border-bottom: none;
                font-size: var(--font-size-sm);
            }
            
            .btn-login {
                display: inline-block;
            }
            
            /* Hero tablette/desktop */
            .hero-content {
                padding: var(--space-xxl) 0;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-subtitle {
                font-size: var(--font-size-xl);
                max-width: 700px;
            }
            
            /* Garanties tablette/desktop */
            .guarantees-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .guarantee-icon {
                font-size: 2.5rem;
                height: 80px;
                width: 80px;
            }
            
            /* USSD tablette/desktop */
            .ussd-container {
                flex-direction: row;
                align-items: center;
            }
            
            .ussd-visual {
                flex: 1;
            }
            
            .ussd-content {
                flex: 1;
            }
            
            /* Footer tablette/desktop */
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
            
            /* Chatbot tablette/desktop */
            .chatbot-window {
                width: 350px;
            }
            
            .chatbot-bubble {
                width: 300px;
            }
            
            .chatbot-toggle {
                width: 75px;
                height: 75px;
                font-size: 2rem;
            }
        }
        
        /* ============================================
           RESPONSIVE DESIGN - DESKTOP (992px+)
        ============================================ */
        @media (min-width: 992px) {
            /* Footer desktop */
            .footer-container {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .phone-illustration {
                height: 450px;
            }
            
            .hero-title {
                font-size: 3.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.5rem;
            }
        }
        
        /* ============================================
           PETITS ÉCRANS (moins de 400px)
        ============================================ */
        @media (max-width: 400px) {
            .logo-text {
                font-size: var(--font-size-base);
            }
            
            .hero-title {
                font-size: var(--font-size-xl);
            }
            
            .hero-subtitle {
                font-size: var(--font-size-base);
            }
            
            .section-title h2 {
                font-size: var(--font-size-lg);
            }
            
            .guarantee-card {
                padding: var(--space-md);
            }
            
            .phone-illustration {
                height: 350px;
                border-radius: 15px;
                padding: 12px;
            }
            
            .ussd-code {
                font-size: var(--font-size-lg);
                padding: var(--space-sm);
            }
            
            .chatbot-toggle {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .chatbot-window {
                bottom: 70px;
            }
            
            .chatbot-bubble {
                bottom: 70px;
            }
        }
        
        /* ============================================
           ACCESSIBILITÉ ET IMPROVEMENTS
        ============================================ */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            .chatbot-toggle,
            .chatbot-bubble,
            .chatbot-badge {
                animation: none !important;
            }
        }
        
        /* Focus styles pour la navigation au clavier */
        a:focus,
        button:focus,
        input:focus,
        textarea:focus {
            outline: 3px solid var(--jaune);
            outline-offset: 2px;
        }
        
        /* Amélioration pour les éléments interactifs */
        button,
        .btn,
        .nav-link,
        .faq-question {
            cursor: pointer;
            user-select: none;
        }
        
        /* Amélioration de la lisibilité */
        .guarantee-card,
        .faq-item,
        .chatbot-window {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* Optimisation pour les très grands écrans */
        @media (min-width: 1400px) {
            .container {
                max-width: 1300px;
            }
        }
        
        /* Correction pour iOS */
        input,
        textarea,
        button {
            -webkit-appearance: none;
            border-radius: 0;
        }
        
        /* Éviter le zoom sur les inputs iOS */
        @media screen and (max-width: 767px) {
            input,
            textarea,
            select {
                font-size: 16px; /* Évite le zoom automatique sur iOS */
            }
        }
    </style>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <!-- Header principal avec navigation -->
        

    <header class="header" role="banner">
        <div class="header-container container">
            <!-- Logo -->
            <a href="#accueil" class="logo">
                <div><img src="{{ asset('assets/pictures/logo-landing.png') }}" alt="logo" width="150px" height="100px"></div>
                
            </a>
            
            <!-- Menu burger pour mobile -->
            <button class="menu-toggle ml-auto flex items-center text-gray-700"
        aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav-list">
    <i class="fas fa-bars text-xl"></i>
</button>

            
            <!-- Navigation principale -->
            <nav class="nav" role="navigation" aria-label="Navigation principale">
                <ul class="nav-list" id="nav-list">
                    <li><a href="#accueil" class="nav-link active">Accueil</a></li>
                    <li><a href="#garanties" class="nav-link">Nos Garanties</a></li>
                    <li><a href="#comment-ca-marche" class="nav-link">Comment ça marche</a></li>
                    <li><a href="#faq" class="nav-link">FAQ</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>
            
            <!-- Bouton de connexion -->
            <a href="{{ route('bulk-payment.index') }}" class="btn-login" aria-label="Se connecter à l'espace personnel">Se Connecter</a>
        </div>
        
        <!-- Bande drapeau -->
        <div class="flag-band" aria-hidden="true"></div>
    </header>

    <main id="main-content" role="main">
        <!-- Section Hero avec texte superposé sur l'image -->
        <section id="accueil" class="hero section" aria-labelledby="hero-title">
            <!-- Image de fond avec overlay -->
            <div class="hero-bg">
                <img src="{{ asset('assets/pictures/background.jpg') }}" 
                     alt="Couple de retraités béninois souriants, consultant leur téléphone mobile" 
                     loading="lazy">
            </div>
            
            <div class="container hero-container">
                <div class="hero-content">
                    <h1 id="hero-title" class="hero-title">MaPension.BJ : Sécurité, Tranquillité, Accès.</h1>
                    <p class="hero-subtitle">Votre retraite, versée en toute sécurité et simplicité, directement sur votre mobile.</p>
                    <a href="#" class="btn btn-primary" aria-label="Accéder à mon espace sécurisé">
                        Accéder à Mon Espace Sécurisé
                    </a>
                </div>
            </div>
        </section>

        <!-- Section Nos Garanties -->
        <section id="garanties" class="guarantees section" aria-labelledby="garanties-title">
            <div class="container">
                <div class="section-title">
                    <h2 id="garanties-title">Votre pension est vivante : traçabilité et instantanéité garanties.</h2>
                </div>
                
                <div class="guarantees-grid">
                    <!-- Carte Sécurité -->
                    <article class="guarantee-card security">
                        <div class="guarantee-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3 class="guarantee-title">Sécurité</h3>
                        <p>Vos données personnelles et vos transactions sont protégées par les normes de sécurité les plus élevées du secteur public.</p>
                        <p>Authentification à deux facteurs et chiffrement de bout en bout.</p>
                    </article>
                    
                    <!-- Carte Accessibilité -->
                    <article class="guarantee-card accessibility">
                        <div class="guarantee-icon">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                        </div>
                        <h3 class="guarantee-title">Accessibilité</h3>
                        <p>Accédez à votre pension depuis votre téléphone mobile, avec ou sans connexion internet.</p>
                        <p>Interface adaptée à tous les âges et niveaux de familiarité avec le numérique.</p>
                    </article>
                    
                    <!-- Carte Transparence -->
                    <article class="guarantee-card transparency">
                        <div class="guarantee-icon">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </div>
                        <h3 class="guarantee-title">Transparence</h3>
                        <p>Suivez en temps réel chaque étape de votre dossier et recevez des notifications pour chaque transaction.</p>
                        <p>Historique complet accessible 24h/24.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Section Comment ça marche (USSD) -->
        <section id="comment-ca-marche" class="ussd section" aria-labelledby="ussd-title">
            <div class="container ussd-container">
                <div class="ussd-visual">
                    <!-- Illustration téléphone USSD -->
                    <div class="phone-illustration">
                        <div class="phone-screen">
                            <ul>
                                <li>1. Vérifier mon solde</li>
                                <li>2. Changer mon canal de paiement</li>
                                <li>3. Consulter mon historique</li>
                                <li>4. Modifier mes coordonnées</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Code USSD -->
                    <div class="ussd-code" aria-label="Code USSD pour accéder au service">*456#</div>
                </div>
                
                <div class="ussd-content">
                    <h2 id="ussd-title">Même sans smartphone, votre pension vous suit</h2>
                    <p>Composez <strong>*456#</strong> depuis n'importe quel téléphone mobile (même basique) pour accéder à toutes les fonctionnalités de gestion de votre pension.</p>
                    <p>Notre service USSD vous permet de :</p>
                    <ul>
                        <li>Vérifier votre solde en temps réel</li>
                        <li>Changer votre canal de paiement (mobile money, compte bancaire)</li>
                        <li>Consulter l'historique de vos versements</li>
                        <li>Mettre à jour vos coordonnées</li>
                    </ul>
                    <p>Aucune connexion internet n'est nécessaire. Le service est disponible 24h/24, 7j/7.</p>
                </div>
            </div>
        </section>

        <!-- Section FAQ -->
        <section id="faq" class="faq section" aria-labelledby="faq-title">
            <div class="container faq-container">
                <div class="section-title">
                    <h2 id="faq-title">Questions Fréquentes</h2>
                </div>
                
                <div class="faq-list" role="region" aria-labelledby="faq-title">
                    <!-- Question 1 -->
                    <div class="faq-item">
                        <input type="checkbox" id="faq1" class="faq-input">
                        <label for="faq1" class="faq-question" role="button" aria-expanded="false" aria-controls="faq-answer1">
                            Quand le versement arrive-t-il ?
                            <span class="faq-toggle" aria-hidden="true"></span>
                        </label>
                        <div id="faq-answer1" class="faq-answer" role="region">
                            <p>Les versements sont effectués entre le 1er et le 5 de chaque mois. Vous recevrez une notification SMS dès que votre pension a été créditée sur votre compte mobile money ou bancaire.</p>
                            <p>En cas de jour férié ou de week-end, le versement est effectué le dernier jour ouvrable précédant la date habituelle.</p>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="faq-item">
                        <input type="checkbox" id="faq2" class="faq-input">
                        <label for="faq2" class="faq-question" role="button" aria-expanded="false" aria-controls="faq-answer2">
                            Que faire si je change de numéro de téléphone ?
                            <span class="faq-toggle" aria-hidden="true"></span>
                        </label>
                        <div id="faq-answer2" class="faq-answer" role="region">
                            <p>Vous devez impérativement mettre à jour vos coordonnées dans votre espace personnel ou en appelant notre service client au 90 90 90 90 (appel gratuit).</p>
                            <p>Cette démarche est essentielle pour garantir la sécurité de votre compte et la continuité des versements.</p>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="faq-item">
                        <input type="checkbox" id="faq3" class="faq-input">
                        <label for="faq3" class="faq-question" role="button" aria-expanded="false" aria-controls="faq-answer3">
                            Comment se passe la Preuve de Vie semestrielle ?
                            <span class="faq-toggle" aria-hidden="true"></span>
                        </label>
                        <div id="faq-answer3" class="faq-answer" role="region">
                            <p>La preuve de vie semestrielle est une obligation de sécurité. Deux fois par an (en janvier et juillet), vous recevrez un SMS avec un code à composer sur votre téléphone.</p>
                            <p>Vous pouvez également valider votre preuve de vie en vous rendant dans l'un de nos points d'accueil agréés, ou en utilisant notre service USSD (*456#).</p>
                        </div>
                    </div>
                    
                    <!-- Question 4 -->
                    <div class="faq-item">
                        <input type="checkbox" id="faq4" class="faq-input">
                        <label for="faq4" class="faq-question" role="button" aria-expanded="false" aria-controls="faq-answer4">
                            Que signifie "paiement échoué" ?
                            <span class="faq-toggle" aria-hidden="true"></span>
                        </label>
                        <div id="faq-answer4" class="faq-answer" role="region">
                            <p>Un paiement peut échouer pour plusieurs raisons : numéro de téléphone incorrect, compte mobile money inactif, ou problème technique temporaire.</p>
                            <p>Dans ce cas, votre pension est conservée en sécurité et sera réessayée automatiquement sous 48h. Vous recevrez un SMS vous informant de la nouvelle tentative.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="footer" role="contentinfo">
        <!-- Bande drapeau en haut du footer -->
        <div class="footer-flag-band" aria-hidden="true"></div>
        
        <div class="container footer-container">
            <!-- Colonne 1 : Liens rapides -->
            <div class="footer-column">
                <h3>Liens rapides</h3>
                <ul class="footer-links">
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#garanties">Nos Garanties</a></li>
                    <li><a href="#comment-ca-marche">Comment ça marche</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#">Espace personnel</a></li>
                </ul>
            </div>
            
            <!-- Colonne 2 : Contact -->
            <div class="footer-column">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Avenue de la Pension, Cotonou, Bénin</li>
                    <li><i class="fas fa-phone" aria-hidden="true"></i>01 90 90 90 90 (appel gratuit)</li>
                    <li><i class="fas fa-envelope" aria-hidden="true"></i> contact@mapension.bj</li>
                    <li><i class="fas fa-clock" aria-hidden="true"></i> Lundi - Vendredi : 8h - 17h</li>
                </ul>
            </div>
            
            <!-- Colonne 3 : Ressources -->
            <div class="footer-column">
                <h3>Ressources</h3>
                <ul class="footer-links">
                    <li><a href="#">Guide du retraité</a></li>
                    <li><a href="#">Brochure d'information</a></li>
                    <li><a href="#">Rapports annuels</a></li>
                    <li><a href="#">Politique de confidentialité</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
            
            <!-- Colonne 4 : Code USSD -->
            <div class="footer-column">
                <h3>Accès direct</h3>
                <div class="footer-ussd" aria-label="Code USSD pour accéder au service">*456#</div>
                <p>Composez ce code depuis n'importe quel téléphone pour gérer votre pension.</p>
                <p>Service disponible 24h/24, 7j/7.</p>
            </div>
        </div>
        
        <!-- Footer bottom -->
        <div class="footer-bottom">
            <div class="container">
                @php
                        $startYear = 2025;
                        $currentYear = date('Y');
                    @endphp
                <p>&copy; {{ $startYear }} {{ $startYear != $currentYear ? ' - ' . $currentYear : '' }} MaPension.BJ - Service Public de Gestion des Pensions du Bénin. Tous droits réservés | Powered by Mojaloop</p>
            </div>
        </div>
    </footer>

    <!-- Widget Chatbot "Alogo" - NOUVEAU DESIGN -->
    <div class="chatbot" role="region" aria-label="Assistant virtuel Alogo">
        <!-- Bulle d'introduction améliorée -->
        <div class="chatbot-bubble" id="chatbot-bubble">
            <div class="chatbot-bubble-header">
                <div class="chatbot-bubble-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <div class="chatbot-bubble-title">Alogo - Assistant Ma PENSION</div>
                </div>
            </div>
            <p><strong>Bonjour !</strong> Je suis Alogo, votre assistant personnel pour toutes vos questions sur votre pension.</p>
            <p>Je peux vous aider avec :</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Vérification de votre solde</li>
                <li>Preuve de vie semestrielle</li>
                <li>Dates de versement</li>
                <li>Changement de coordonnées</li>
                <li>Utilisation du service USSD <code>*456#</code></li>
            </ul>
            <p>Cliquez sur le bouton coloré pour commencer !</p>
            <button class="btn btn-secondary" id="close-bubble" style="margin-top: 10px; width: 100%; min-height: 44px;">Fermer</button>
        </div>
        
        <!-- Fenêtre de chat améliorée -->
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">
                <div class="chatbot-header-content">
                    <div class="chatbot-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div>
                        <div class="chatbot-title">Alogo - Assistant Ma PENSION</div>
                        <div class="chatbot-subtitle">En ligne • Prêt à vous aider</div>
                    </div>
                </div>
                <button class="chatbot-close" id="chatbot-close" aria-label="Fermer le chat">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
            
            <div class="chatbot-messages" id="chatbot-messages">
                <div class="chatbot-message bot">
                    <strong>Bonjour !</strong> Je suis Alogo, l'assistant Ma Pension. 🤖
                </div>
                
            </div>
            
            <div class="chatbot-input-container">
                <input type="text" class="chatbot-input" id="chatbot-input" placeholder="Tapez votre message ici..." aria-label="Message pour l'assistant Alogo">
                <button class="chatbot-send" id="chatbot-send" aria-label="Envoyer le message">
                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        
        <!-- Bouton pour ouvrir/fermer le chatbot - NOUVEAU DESIGN -->
        <button class="chatbot-toggle" id="chatbot-toggle" aria-label="Ouvrir la conversation avec l'assistant Alogo">
            <i class="fas fa-comment-dots" aria-hidden="true"></i>
            <!-- Badge de notification -->
            <div class="chatbot-badge" id="chatbot-badge" style="display: none;">1</div>
        </button>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================
            // CONFIGURATION API OREUS (Artisan 2.0)
            // ============================================
            const API_KEY = "or_dd5c53131b2f4efda76cd0fd7e24e31f314077f105e4f212794f3ae5";
            const API_URL = "https://oreus-staging.dev2.dev-id.fr/api/v1/sdk/chat/completions";
            
            // ============================================
            // ÉLÉMENTS DU CHATBOT
            // ============================================
            const chatbotToggle = document.getElementById('chatbot-toggle');
            const chatbotWindow = document.getElementById('chatbot-window');
            const chatbotClose = document.getElementById('chatbot-close');
            const chatbotMessages = document.getElementById('chatbot-messages');
            const chatbotInput = document.getElementById('chatbot-input');
            const chatbotSend = document.getElementById('chatbot-send');
            const chatbotBubble = document.getElementById('chatbot-bubble');
            const closeBubble = document.getElementById('close-bubble');
            const chatbotBadge = document.getElementById('chatbot-badge');
            
            // ============================================
            // MENU BURGER POUR MOBILE
            // ============================================
            const menuToggle = document.querySelector('.menu-toggle');
            const navList = document.querySelector('.nav-list');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navList.classList.toggle('active');
                    const isExpanded = navList.classList.contains('active');
                    menuToggle.setAttribute('aria-expanded', isExpanded);
                    menuToggle.setAttribute('aria-label', isExpanded ? 'Fermer le menu' : 'Ouvrir le menu');
                    
                    // Changer l'icône du menu burger
                    const icon = menuToggle.querySelector('i');
                    if (isExpanded) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
                
                // Fermer le menu en cliquant sur un lien
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 768) {
                            navList.classList.remove('active');
                            menuToggle.setAttribute('aria-expanded', 'false');
                            menuToggle.setAttribute('aria-label', 'Ouvrir le menu');
                            const icon = menuToggle.querySelector('i');
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    });
                });
                
                // Fermer le menu en cliquant en dehors
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && navList.classList.contains('active')) {
                        if (!navList.contains(e.target) && !menuToggle.contains(e.target)) {
                            navList.classList.remove('active');
                            menuToggle.setAttribute('aria-expanded', 'false');
                            menuToggle.setAttribute('aria-label', 'Ouvrir le menu');
                            const icon = menuToggle.querySelector('i');
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
                
                // Fermer le menu si la fenêtre est redimensionnée au-dessus de 768px
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) {
                        navList.classList.remove('active');
                        menuToggle.setAttribute('aria-expanded', 'false');
                        menuToggle.setAttribute('aria-label', 'Ouvrir le menu');
                        const icon = menuToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
            
            // ============================================
            // FONCTIONS DE FORMATAGE DES RÉPONSES
            // ============================================
            
            // Fonction pour formater le texte Markdown en HTML
            function formatMessage(text) {
                // Échapper les caractères HTML pour la sécurité
                let formatted = text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
                
                // Convertir **texte** en <strong>texte</strong>
                formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                
                // Convertir *texte* en <em>texte</em> (italique)
                formatted = formatted.replace(/\*(?!\s)(.*?)\*/g, '<em>$1</em>');
                
                // Convertir `code` en <code>code</code>
                formatted = formatted.replace(/`(.*?)`/g, '<code>$1</code>');
                
                // Convertir --- en séparateur
                formatted = formatted.replace(/^---$/gm, '<div class="section-divider"></div>');
                
                // Convertir les listes à puces
                formatted = formatted.replace(/^\s*\*\s+(.*)$/gm, '<li>$1</li>');
                formatted = formatted.replace(/^\s*-\s+(.*)$/gm, '<li>$1</li>');
                
                // Grouper les éléments de liste
                let lines = formatted.split('\n');
                let inList = false;
                let result = [];
                
                for (let i = 0; i < lines.length; i++) {
                    if (lines[i].startsWith('<li>')) {
                        if (!inList) {
                            result.push('<ul>');
                            inList = true;
                        }
                        result.push(lines[i]);
                    } else {
                        if (inList) {
                            result.push('</ul>');
                            inList = false;
                        }
                        result.push(lines[i]);
                    }
                }
                
                if (inList) {
                    result.push('</ul>');
                }
                
                formatted = result.join('\n');
                
                // Convertir les retours à la ligne en <br>
                formatted = formatted.replace(/\n/g, '<br>');
                
                // Mettre en évidence les mots-clés importants
                const keywords = [
                    'important', 'urgent', 'attention', 'note', 'remarque',
                    'solution', 'étape', 'procédure', 'vérifiez', 'contactez',
                    'appelez', 'rendez-vous', 'immédiatement', 'prioritaire'
                ];
                
                keywords.forEach(keyword => {
                    const regex = new RegExp(`\\b(${keyword})\\b`, 'gi');
                    formatted = formatted.replace(regex, '<span class="highlight">$1</span>');
                });
                
                return formatted;
            }
            
            // ============================================
            // FONCTIONS DU CHATBOT
            // ============================================
            
            // Fonction pour ajouter un message au chat
            function addMessage(content, isUser = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chatbot-message ${isUser ? 'user' : 'bot'}`;
                
                if (isUser) {
                    messageDiv.textContent = content;
                } else {
                    messageDiv.innerHTML = formatMessage(content);
                }
                
                chatbotMessages.appendChild(messageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
            
            // Fonction pour afficher l'indicateur de frappe
            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.className = 'chatbot-typing';
                typingDiv.id = 'typing-indicator';
                typingDiv.innerHTML = `
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                `;
                chatbotMessages.appendChild(typingDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
            
            // Fonction pour supprimer l'indicateur de frappe
            function hideTypingIndicator() {
                const typingIndicator = document.getElementById('typing-indicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }
            
            // Fonction pour envoyer un message à l'API Oreus
            async function sendMessageToAPI(message) {
                try {
                    showTypingIndicator();
                    
                    const requestBody = {
                        model: 'Alogo',
                        messages: [
                            {
                                role: 'user',
                                content: message
                            }
                        ]
                    };

                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${API_KEY}`,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(requestBody)
                    });

                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    // Supprime l'indicateur de frappe
                    hideTypingIndicator();
                    
                    // Récupère la réponse de l'API
                    let botResponse = '';
                    if (data.choices && data.choices.length > 0) {
                        botResponse = data.choices[0].message.content;
                    } else if (data.content) {
                        botResponse = data.content;
                    } else {
                        botResponse = "Je n'ai pas pu comprendre la réponse de l'API.";
                    }
                    
                    return botResponse;
                    
                } catch (error) {
                    console.error('Erreur:', error);
                    hideTypingIndicator();
                    
                    // Retourne un message d'erreur convivial avec des réponses de secours
                    const messageLower = message.toLowerCase();
                    
                    // Réponses de secours basées sur les mots-clés
                    if (messageLower.includes('statut') || messageLower.includes('solde')) {
                        return "**Pour vérifier votre solde**, composez `*456#` depuis votre téléphone ou connectez-vous à votre espace personnel sur notre site.";
                    } else if (messageLower.includes('preuve') || messageLower.includes('vie')) {
                        return "**La preuve de vie semestrielle** est obligatoire. Vous pouvez la valider en composant `*456#` ou en vous rendant dans un point d'accueil agréé. Vous recevrez un SMS de rappel avant chaque échéance.";
                    } else if (messageLower.includes('contact')) {
                        return "**Vous pouvez nous contacter** au **90 90 90 90** (appel gratuit), par email à **contact@mapension.bj**, ou en vous rendant à notre agence principale à Cotonou. **Horaires :** Lundi-Vendredi, 8h-17h.";
                    } else if (messageLower.includes('versement') || messageLower.includes('paiement')) {
                        return "**Les versements** sont effectués entre le **1er et le 5 de chaque mois**. En cas de problème, contactez notre service client au **90 90 90 90**.";
                    } else if (messageLower.includes('changer') || messageLower.includes('numéro')) {
                        return "**Pour changer votre numéro de téléphone**, mettez à jour vos coordonnées dans votre espace personnel ou appelez le **90 90 90 90**. *Cette démarche est essentielle pour la sécurité de votre compte.*";
                    } else if (messageLower.includes('aide') || messageLower === '?') {
                        return "**Commandes disponibles :**\n\n* **Statut** : Vérifier votre solde\n* **Preuve de vie** : Validation semestrielle\n* **Contact** : Coordonnées du service\n* **Versement** : Date et modalités de paiement\n* **Changer numéro** : Mise à jour coordonnées\n* **FAQ** : Questions fréquentes\n* **USSD** : Utilisation du service `*456#`";
                    } else {
                        return "**Désolé, je rencontre des difficultés techniques.** Veuillez réessayer dans quelques instants ou contactez notre service client au **90 90 90 90** pour une assistance immédiate.";
                    }
                }
            }
            
            // Fonction pour gérer l'envoi de message
            async function handleSendMessage() {
                const message = chatbotInput.value.trim();
                
                if (!message) return;
                
                // Désactive le champ pendant le traitement
                chatbotInput.disabled = true;
                chatbotSend.disabled = true;
                
                // Ajoute le message de l'utilisateur au chat
                addMessage(message, true);
                
                // Efface le champ de saisie
                chatbotInput.value = '';
                
                // Envoie le message à l'API et récupère la réponse
                const botResponse = await sendMessageToAPI(message);
                
                // Ajoute la réponse du bot au chat
                addMessage(botResponse, false);
                
                // Réactive le champ de saisie
                chatbotInput.disabled = false;
                chatbotSend.disabled = false;
                chatbotInput.focus();
            }
            
            // ============================================
            // GESTIONNAIRES D'ÉVÉNEMENTS DU CHATBOT
            // ============================================
            
            // Ouvrir/fermer la fenêtre de chat
            if (chatbotToggle) {
                chatbotToggle.addEventListener('click', function() {
                    chatbotWindow.classList.toggle('active');
                    chatbotBubble.classList.remove('active');
                    
                    // Cacher le badge quand on ouvre le chat
                    if (chatbotBadge) {
                        chatbotBadge.style.display = 'none';
                    }
                    
                    // Focus sur l'input quand la fenêtre s'ouvre
                    if (chatbotWindow.classList.contains('active')) {
                        setTimeout(() => {
                            chatbotInput.focus();
                        }, 300);
                    }
                });
            }
            
            // Fermer la fenêtre de chat
            if (chatbotClose) {
                chatbotClose.addEventListener('click', function() {
                    chatbotWindow.classList.remove('active');
                });
            }
            
            // Fermer la bulle d'introduction
            if (closeBubble) {
                closeBubble.addEventListener('click', function() {
                    chatbotBubble.classList.remove('active');
                    localStorage.setItem('chatbotBubbleClosed', 'true');
                });
            }
            
            // Envoyer un message avec le bouton
            if (chatbotSend) {
                chatbotSend.addEventListener('click', handleSendMessage);
            }
            
            // Envoyer un message avec la touche Entrée
            if (chatbotInput) {
                chatbotInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handleSendMessage();
                    }
                });
            }
            
            // ============================================
            // LOGIQUE D'OUVERTURE PROACTIVE DE LA BULLE
            // ============================================
            // Vérifier si la bulle a déjà été fermée
            const bubbleClosed = localStorage.getItem('chatbotBubbleClosed');
            
            // Afficher la bulle après 3 secondes si elle n'a pas été fermée
            if (!bubbleClosed && chatbotBubble) {
                setTimeout(() => {
                    chatbotBubble.classList.add('active');
                    
                    // Fermer automatiquement après 15 secondes
                    setTimeout(() => {
                        if (chatbotBubble.classList.contains('active')) {
                            chatbotBubble.classList.remove('active');
                            localStorage.setItem('chatbotBubbleClosed', 'true');
                        }
                    }, 15000);
                }, 3000);
            }
            
            // ============================================
            // BADGE DE NOTIFICATION
            // ============================================
            // Afficher un badge de notification après 10 secondes si le chatbot n'a pas été ouvert
            setTimeout(() => {
                const hasInteracted = localStorage.getItem('chatbotInteracted');
                const bubbleWasShown = localStorage.getItem('chatbotBubbleClosed');
                
                if (!hasInteracted && bubbleWasShown && chatbotBadge) {
                    chatbotBadge.style.display = 'flex';
                }
            }, 10000);
            
            // Marquer l'interaction avec le chatbot
            function markChatbotInteraction() {
                localStorage.setItem('chatbotInteracted', 'true');
            }
            
            // Marquer l'interaction quand on ouvre le chat
            if (chatbotToggle) {
                chatbotToggle.addEventListener('click', markChatbotInteraction);
            }
            
            // Marquer l'interaction quand on envoie un message
            if (chatbotSend) {
                chatbotSend.addEventListener('click', markChatbotInteraction);
            }
            
            // ============================================
            // AMÉLIORATION DE L'ACCESSIBILITÉ
            // ============================================
            // Gestion de la navigation au clavier pour l'accordéon FAQ
            const faqQuestions = document.querySelectorAll('.faq-question');
            faqQuestions.forEach((question, index) => {
                question.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const inputId = this.getAttribute('for');
                        const input = document.getElementById(inputId);
                        if (input) {
                            input.checked = !input.checked;
                            this.setAttribute('aria-expanded', input.checked);
                            
                            // Déclencher l'événement change pour les lecteurs d'écran
                            input.dispatchEvent(new Event('change'));
                        }
                    }
                    
                    // Navigation par flèches dans l'accordéon
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = index < faqQuestions.length - 1 ? index + 1 : 0;
                        faqQuestions[nextIndex].focus();
                    }
                    
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = index > 0 ? index - 1 : faqQuestions.length - 1;
                        faqQuestions[prevIndex].focus();
                    }
                });
            });
            
            // Mise à jour des attributs ARIA pour l'accordéon
            const faqInputs = document.querySelectorAll('.faq-input');
            faqInputs.forEach(input => {
                const question = document.querySelector(`label[for="${input.id}"]`);
                if (question) {
                    question.setAttribute('aria-expanded', input.checked);
                }
                
                input.addEventListener('change', function() {
                    const question = document.querySelector(`label[for="${this.id}"]`);
                    if (question) {
                        question.setAttribute('aria-expanded', this.checked);
                    }
                });
            });
            
            // ============================================
            // GESTION DES LIENS INTERNES POUR UN DÉFILEMENT DOUX
            // ============================================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Ignorer les liens # qui ne pointent vers rien
                    if (href === '#') return;
                    
                    const targetElement = document.querySelector(href);
                    
                    if (targetElement) {
                        e.preventDefault();
                        
                        // Calculer la position de défilement en tenant compte du header fixe
                        const headerHeight = document.querySelector('.header').offsetHeight;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Mettre à jour l'URL sans recharger la page
                        history.pushState(null, null, href);
                    }
                });
            });
            
            // ============================================
            // ANIMATIONS AU DÉFILEMENT
            // ============================================
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.guarantee-card, .ussd-content, .faq-item');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Initialiser les styles pour l'animation
            const animatedElements = document.querySelectorAll('.guarantee-card, .ussd-content, .faq-item');
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            
            // Déclencher l'animation au chargement
            window.addEventListener('load', animateOnScroll);
            window.addEventListener('scroll', animateOnScroll);
            
            // ============================================
            // EXEMPLE DE MESSAGE AUTOMATIQUE POUR DÉMONSTRATION
            // ============================================
            setTimeout(() => {
                // Si seulement les messages initiaux sont présents, ajouter un message d'exemple
                if (chatbotMessages.children.length === 3) {
                    addMessage("**N'hésitez pas à me poser vos questions !** Je suis là pour vous aider à comprendre et gérer votre pension en toute simplicité. 😊", false);
                }
            }, 3000);
        });
    </script>
    </body>
</html>
