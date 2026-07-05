<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Laundry Management System - Professional Laundry Management. Streamline your laundry business with smart order tracking, customer management, and real-time reporting.">
    <title>Laundry Management System – Smart Laundry Management</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/laundry_icon.png') }}" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-main: #ffffff;
            --bg-card: #f8faff;
            --border-color: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --accent-blue: #3b82f6;
            --accent-cyan: #0ea5e9;
            --grad-accent: linear-gradient(135deg, #2563eb, #0ea5e9);
            --grad-button: linear-gradient(135deg, #2563eb, #0ea5e9);
            --shadow-glow: 0 0 40px rgba(37, 99, 235, 0.12);
            --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.07);
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ── NAVBAR ── */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 80px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            transition: padding 0.3s;
        }
        .nav.scrolled { padding: 14px 80px; background: rgba(255, 255, 255, 0.98); box-shadow: 0 2px 16px rgba(0,0,0,0.07); }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: #2563eb;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.5);
        }
        .nav-logo-text { font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 700; color: #0f172a; }
        .nav-logo-text span { background: var(--grad-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; align-items: center; gap: 40px; }
        .nav-links a { color: var(--text-secondary); text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: color 0.2s; }
        .nav-links a:hover { color: #0f172a; }
        .nav-cta { display: flex; align-items: center; gap: 16px; }
        .btn-outline {
            padding: 10px 24px; border-radius: 10px; border: 1.5px solid #cbd5e1;
            color: #0f172a; background: transparent; font-size: 0.9rem; font-weight: 500;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .btn-outline:hover { border-color: #2563eb; color: #2563eb; background: rgba(37, 99, 235, 0.05); }
        .btn-primary-nav {
            padding: 10px 26px; border-radius: 10px; border: none;
            background: var(--grad-button);
            color: white; font-size: 0.9rem; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        .btn-primary-nav:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 140px 80px 100px;
            position: relative; overflow: hidden;
            background: #ffffff;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 85% 50%, rgba(37, 99, 235, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 15% 70%, rgba(14, 165, 233, 0.05) 0%, transparent 60%);
            z-index: 0;
        }
        .hero-content { position: relative; z-index: 2; max-width: 620px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px; border-radius: 100px;
            background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.2);
            font-size: 0.8rem; font-weight: 600; color: #60a5fa;
            margin-bottom: 30px; letter-spacing: 0.5px;
        }
        .hero-badge-dot { width: 7px; height: 7px; border-radius: 50%; background: #60a5fa; animation: blink 2s infinite; }
        @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(1.3)} }
        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(3rem, 5.5vw, 4.5rem);
            font-weight: 800; line-height: 1.1;
            margin-bottom: 24px; letter-spacing: -0.02em;
        }
        .hero h1 .accent { background: var(--grad-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero h1 { color: #0f172a; }
        .hero p { font-size: 1.1rem; color: #475569; line-height: 1.7; margin-bottom: 44px; max-width: 540px; }
        .hero-actions { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 16px 38px; border-radius: 12px; border: none;
            background: var(--grad-button); color: white;
            font-size: 1rem; font-weight: 700; font-family: 'Outfit', sans-serif;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4);
            transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(37, 99, 235, 0.55); }
        .hero-visual {
            position: absolute; right: 0; top: 50%; transform: translateY(-50%);
            width: 48%; max-width: 680px;
            padding-right: 80px;
            z-index: 2;
        }
        .hero-dashboard {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 28px;
            box-shadow: var(--shadow-card), var(--shadow-glow);
            animation: floatAnim 6s ease-in-out infinite;
        }
        @keyframes floatAnim { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .dash-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .dash-title-bar { font-size: 0.9rem; color: #0f172a; font-weight: 700; font-family: 'Outfit', sans-serif; }
        .dash-badge { padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #34d399; }
        .dash-orders { display: flex; flex-direction: column; gap: 12px; }
        .dash-order-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-radius: 12px;
            background: #f8faff; border: 1px solid #e2e8f0;
        }
        .dash-order-info { display: flex; align-items: center; gap: 12px; }
        .dash-order-avatar {
            width: 36px; height: 36px; border-radius: 8px;
            background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.2);
            display: flex; align-items: center; justify-content: center; font-size: 16px; color: #60a5fa;
        }
        .dash-order-name { font-size: 0.9rem; font-weight: 600; color: #0f172a; }
        .dash-order-id { font-size: 0.75rem; color: #64748b; margin-top: 2px; }
        .dash-price { font-size: 0.9rem; font-weight: 700; color: #34d399; text-align: right; }
        .dash-items { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }

        .dash-progress-wrap { margin-top: 20px; }
        .dash-progress-labels { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .dash-progress-labels span { font-size: 0.75rem; color: #64748b; font-weight: 500; }
        .dash-progress-labels span.active { color: #2563eb; font-weight: 700; }
        .dash-progress-bar { height: 6px; background: #e2e8f0; border-radius: 100px; overflow: hidden; position: relative; }
        .dash-progress-fill { height: 100%; background: var(--grad-button); border-radius: 100px; width: 75%; }
        .dash-delivery-info { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
        .dash-delivery-time { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #34d399; font-weight: 500; }
        .dash-track-link { font-size: 0.8rem; color: #60a5fa; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px; }

        .hero-stats-strip { display: flex; gap: 48px; margin-top: 54px; flex-wrap: wrap; }
        .stat-item { display: flex; flex-direction: column; }
        .stat-val { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .stat-lbl { font-size: 0.85rem; color: #64748b; margin-top: 6px; }

        /* ── SECTIONS ── */
        .section { padding: 100px 80px; position: relative; z-index: 2; }
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.2rem, 3.8vw, 3rem);
            font-weight: 800; line-height: 1.15; letter-spacing: -0.02em; margin-bottom: 16px;
            text-align: center; color: #0f172a;
        }
        .section-subtitle { font-size: 1.05rem; color: #64748b; line-height: 1.7; margin-bottom: 60px; text-align: center; }
        .text-accent { background: var(--grad-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* ── SERVICES ── */
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
        .service-card {
            padding: 36px;
            background: #f8faff;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-lg);
            transition: all 0.3s; position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;
        }
        .service-card:hover { transform: translateY(-6px); border-color: rgba(37, 99, 235, 0.4); background: #eef3ff; box-shadow: 0 8px 32px rgba(37, 99, 235, 0.1); }
        .service-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 24px;
            background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.2);
            color: #60a5fa;
        }
        .service-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; font-family: 'Outfit', sans-serif; color: #0f172a; }
        .service-desc { font-size: 0.95rem; color: #64748b; line-height: 1.65; margin-bottom: 24px; }
        .service-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #e2e8f0; padding-top: 18px; margin-top: auto; }
        .service-status { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }
        .service-link { font-size: 0.85rem; color: #2563eb; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px; }

        /* ── PRICING ── */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
        .pricing-card {
            padding: 40px; border-radius: var(--radius-lg);
            border: 1px solid #e2e8f0;
            background: #f8faff;
            position: relative; overflow: hidden; transition: all 0.3s;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .pricing-card:hover { transform: translateY(-6px); border-color: rgba(37, 99, 235, 0.4); box-shadow: 0 8px 32px rgba(37, 99, 235, 0.1); }
        .pricing-header { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .pricing-header-icon { font-size: 24px; color: #60a5fa; display: flex; align-items: center; }
        .pricing-title { font-family: 'Outfit', sans-serif; font-size: 1.35rem; font-weight: 700; color: #0f172a; }
        .pricing-list { list-style: none; display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }
        .pricing-item { display: flex; align-items: center; justify-content: space-between; font-size: 0.95rem; color: #0f172a; }
        .pricing-item-label { color: #64748b; }
        .pricing-badge {
            padding: 4px 12px; border-radius: 100px; font-size: 0.8rem; font-weight: 600;
            background: rgba(6, 182, 212, 0.1); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.15);
        }
        .btn-pricing {
            width: 100%; padding: 14px; border-radius: 10px; border: none;
            font-size: 0.95rem; font-weight: 700; font-family: 'Outfit', sans-serif;
            cursor: pointer; text-decoration: none; display: block; text-align: center;
            background: var(--grad-button); color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); transition: all 0.3s;
        }
        .btn-pricing:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5); }

        /* ── TESTIMONIALS ── */
        .testimonial-card {
            max-width: 680px; margin: 0 auto; padding: 44px;
            background: #f8faff; border: 1px solid #e2e8f0;
            border-radius: var(--radius-xl); text-align: center; position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .testimonial-avatar-wrap {
            width: 68px; height: 68px; border-radius: 50%;
            padding: 3px; background: linear-gradient(135deg, #2563eb, #0ea5e9);
            margin: 0 auto 24px;
        }
        .testimonial-avatar { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
        .stars { display: flex; gap: 6px; justify-content: center; margin-bottom: 20px; }
        .stars span { color: #f59e0b; font-size: 18px; }
        .testimonial-text { font-size: 1.05rem; color: #334155; line-height: 1.7; margin-bottom: 24px; font-weight: 400; font-style: normal; }
        .author-name { font-weight: 700; font-size: 1.05rem; font-family: 'Outfit', sans-serif; margin-bottom: 4px; color: #0f172a; }
        .author-role { font-size: 0.85rem; color: #64748b; }
        .pagination-dots { display: flex; gap: 8px; justify-content: center; margin-top: 28px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #cbd5e1; cursor: pointer; transition: all 0.3s; }
        .dot.active { background: #2563eb; transform: scale(1.2); }

        /* ── FOOTER ── */
        footer {
            padding: 80px 80px 40px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
        }
        .footer-top { display: grid; grid-template-columns: 2fr 1fr 1.2fr 1.5fr; gap: 60px; margin-bottom: 60px; }
        .footer-brand { display: flex; flex-direction: column; gap: 20px; }
        .footer-brand-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .footer-desc { font-size: 0.9rem; color: #64748b; line-height: 1.7; }
        .footer-socials { display: flex; gap: 12px; }
        .social-btn {
            width: 36px; height: 36px; border-radius: 8px;
            background: #f1f5f9; border: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; font-size: 18px; text-decoration: none; transition: all 0.2s;
        }
        .social-btn:hover { color: #2563eb; background: #eef3ff; border-color: #bfdbfe; }
        .footer-links-col h4 { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: #0f172a; margin-bottom: 24px; }
        .footer-links-col ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
        .footer-links-col ul li a {
            color: #64748b; text-decoration: none; font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;
        }
        .footer-links-col ul li a:hover { color: #2563eb; }
        .footer-links-col ul li a iconify-icon { font-size: 16px; color: #2563eb; }
        .footer-contact-item { display: flex; gap: 12px; font-size: 0.9rem; color: #64748b; line-height: 1.6; }
        .footer-contact-item iconify-icon { font-size: 18px; color: #2563eb; margin-top: 2px; }
        .footer-bottom { border-top: 1px solid #e2e8f0; padding-top: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
        .footer-bottom p { font-size: 0.85rem; color: #94a3b8; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .nav { padding: 18px 40px; }
            .nav.scrolled { padding: 14px 40px; }
            .hero { padding: 120px 40px 80px; }
            .hero-visual { display: none; }
            .hero-content { max-width: 100%; }
            .section { padding: 80px 40px; }
            footer { padding: 60px 40px 40px; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 40px; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero h1 { font-size: 2.6rem; }
            .footer-top { grid-template-columns: 1fr; gap: 40px; }
        }
        @media (max-width: 480px) {
            .hero-actions { flex-direction: column; }
            .btn-hero-primary { width: 100%; justify-content: center; }
            .nav-cta .btn-outline { display: none; }
        }

        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

{{ $slot }}

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        var nav = document.getElementById('mainNav');
        if (nav) {
            if (window.scrollY > 30) { nav.classList.add('scrolled'); }
            else { nav.classList.remove('scrolled'); }
        }
    });

    // Intersection Observer for fade-up animations
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-up').forEach(function(el) {
        observer.observe(el);
    });
</script>

</body>
</html>
