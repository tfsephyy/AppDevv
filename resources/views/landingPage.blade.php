<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase — Emotional Support & Guidance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a3c5e;
            --secondary: #2a5c8a;
            --accent: #4a90e2;
            --accent-light: #6bb3ff;
            --accent-dark: #1e5f99;
            --text: #e6f0f7;
            --text-muted: #b8d0e0;
            --card-bg: rgba(255, 255, 255, 0.1);
            --glass: rgba(255, 255, 255, 0.15);
            --radius: 12px;
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #1a3c5e 0%, #2a5c8a 50%, #1a3c5e 100%);
            color: var(--text);
            line-height: 1.5;
            overflow-x: hidden;
            padding-top: 100px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: linear-gradient(135deg, rgba(26, 60, 94, 0.95), rgba(42, 92, 138, 0.95));
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 0;
        }
        
        header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        }
        
        .brand-text h1 {
            margin: 0;
            font-size: 24px;
            background: linear-gradient(to right, #ffffff, var(--accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .brand-text p {
            margin: 0;
            font-size: 13px;
            color: var(--text-muted);
        }
        
        nav {
            display: flex;
            gap: 20px;
        }
        
        nav a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }
        
        nav a:hover {
            color: white;
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: var(--transition);
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .hero-content h2 {
            font-size: 32px;
            margin-bottom: 15px;
            line-height: 1.2;
        }
        
        .hero-content p {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }
        
        .eyebrow {
            display: inline-block;
            padding: 6px 12px;
            background: var(--glass);
            color: white;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .cta-row {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(74, 144, 226, 0.6);
        }
        
        .btn-secondary {
            background: var(--glass);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .hero-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            height: 280px;
        }
        
        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: var(--transition);
        }
        
        .hero-image:hover img {
            transform: scale(1.03);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .section-title h2 {
            font-size: 28px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--accent), var(--accent-light));
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            font-size: 15px;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-color: rgba(74, 144, 226, 0.3);
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        .feature-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: white;
        }
        
        .feature-card p {
            color: var(--text-muted);
            flex-grow: 1;
            font-size: 14px;
        }
        
        .about {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 30px;
            margin-bottom: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }
        
        .about-text h2 {
            font-size: 26px;
            margin-bottom: 15px;
            color: white;
        }
        
        .about-text p {
            color: var(--text-muted);
            margin-bottom: 15px;
            font-size: 15px;
        }
        
        .about-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            height: 250px;
        }
        
        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .mission-vision {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .mission, .vision {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: var(--radius);
            border-left: 4px solid var(--accent);
        }
        
        .mission h3, .vision h3 {
            color: white;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }
        
        .mission p, .vision p {
            color: var(--text-muted);
            font-size: 14px;
        }
        
        footer {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-muted);
            font-size: 13px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
            font-size: 14px;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .social-icons a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .social-icons a:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hamburger button */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            flex-direction: column;
            gap: 5px;
            padding: 4px;
        }

        .menu-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text);
            border-radius: 2px;
            transition: var(--transition);
        }

        .menu-toggle.open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .menu-toggle.open span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-content h2 {
                font-size: 28px;
            }

            .cta-row {
                justify-content: center;
            }

            .features {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .mission-vision {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            header {
                padding: 10px 0;
            }

            header .container {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0;
            }

            .menu-toggle {
                display: flex;
            }

            nav {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 0;
                background: rgba(26, 60, 94, 0.98);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                margin-top: 10px;
                border-radius: 0 0 var(--radius) var(--radius);
            }

            nav.nav-open {
                display: flex;
            }

            nav a {
                padding: 14px 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                font-size: 15px;
            }

            nav a:last-child {
                border-bottom: none;
            }

            nav a::after {
                display: none;
            }

            .hero-content h2 {
                font-size: 24px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .about {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }

            .hero-content h2 {
                font-size: 22px;
            }

            .btn {
                padding: 10px 16px;
            }

            .footer-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="brand">
                <div class="logo">ME</div>
                <div class="brand-text">
                    <h1>MindEase</h1>
                    <p>Emotional Support & Guidance</p>
                </div>
            </div>
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav id="mainNav">
                <a href="#features">Features</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <section class="hero">
            <div class="hero-content">
                <span class="eyebrow">Your Safe Space Starts Here</span>
                <h2>A Digital Platform for Emotional Support & Guidance</h2>
                <p>
                    MindEase is an interactive guidance counseling system designed to help students manage emotional well-being. 
                    With journal entries, appointment scheduling, peer support, and counselor management tools, we create a supportive 
                    digital space that enhances both personal growth and mental wellness.
                </p>
                <div class="cta-row">
                    <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                    <a href="#features" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Students supporting each other">
            </div>
        </section>

        <section id="features">
            <div class="section-title">
                <h2>Key Features</h2>
                <p>MindEase integrates self-help features, professional counseling access, and community interaction into one unified system.</p>
            </div>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">📖</div>
                    <h3>Journaling</h3>
                    <p>Write personal entries and reflections in text or voice format. Choose between private entries for personal reflection or public entries to share experiences with others.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3>Appointment Booking</h3>
                    <p>Schedule, reschedule, or cancel counseling sessions through the Guidance Appointment feature. View counselor availability in real-time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3>Public Chat</h3>
                    <p>Interact with peers through posts, likes, comments, and shares in a safe, moderated environment that promotes openness and peer support.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📢</div>
                    <h3>Guidance Office Updates</h3>
                    <p>Stay informed about Guidance Office projects, activities, and announcements to stay connected with campus resources.</p>
                </div>
            </div>
        </section>

        <section id="about" class="about">
            <div class="about-content">
                <div class="about-text">
                    <h2>About MindEase</h2>
                    <p>MindEase was developed at Mindoro State University as a response to the growing need for accessible mental health support among students. Our platform combines emotional self-care tools with professional guidance support in a safe, digital environment.</p>
                    <p>We believe that everyone deserves access to mental health resources and a supportive community. MindEase provides features that help users manage stress and improve mental wellness through various tools and resources.</p>
                    
                    <div class="mission-vision">
                        <div class="mission">
                            <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
                            <p>To provide a safe digital space that promotes emotional resilience, encourages self-expression, and connects users to guidance services.</p>
                        </div>
                        <div class="vision">
                            <h3><i class="fas fa-eye"></i> Our Vision</h3>
                            <p>To create a world where mental health support is accessible, stigma-free, and integrated into educational environments.</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Students collaborating and supporting each other">
                </div>
            </div>
        </section>

        <footer id="contact">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="footer-links">
                <a href="#features">Features</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
            <p>MindEase © 2023 • All Rights Reserved</p>
            <p>Mindoro State University - College of Computer Studies</p>
        </footer>
    </div>

    <script>
        // Hamburger menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mainNav = document.getElementById('mainNav');

        menuToggle.addEventListener('click', function () {
            menuToggle.classList.toggle('open');
            mainNav.classList.toggle('nav-open');
        });

        // Close nav when a link is clicked on mobile
        mainNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function () {
                menuToggle.classList.remove('open');
                mainNav.classList.remove('nav-open');
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('nav a, .btn-secondary').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId && targetId !== '#') {
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Add animation to feature cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>
