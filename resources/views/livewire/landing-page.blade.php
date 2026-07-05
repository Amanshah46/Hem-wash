<div>
    <!-- NAVBAR -->
    <nav class="nav" id="mainNav">
        <a href="{{ url('/') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <iconify-icon icon="mdi:washing-machine"></iconify-icon>
            </div>
            <span class="nav-logo-text">Laundry<span> management system</span></span>
        </a>
        <div class="nav-links">
            <a href="#services">Services</a>
            <a href="#pricing">Pricing</a>
            <a href="#reviews">Reviews</a>
        </div>
        <div class="nav-cta">
            <a href="{{ route('customer.login') }}" class="btn-outline">Customer Login</a>
            <a href="{{ route('customer.register') }}" class="btn-primary-nav">Register Now</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content fade-up visible">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Professional Clean & Fast Turnaround
            </div>
            <h1>Freshness Delivered<br>To <span class="accent">Your Doorstep</span></h1>
            <p>Hemwash offers premium laundry, dry cleaning, and ironing services. Schedule a pickup, track your clothes, and enjoy pristine laundry without lifting a finger.</p>
            <div class="hero-actions">
                <a href="{{ route('customer.login') }}" class="btn-hero-primary">
                    <span>Get Started</span>
                    <iconify-icon icon="mdi:arrow-right"></iconify-icon>
                </a>
            </div>
            <div class="hero-stats-strip">
                <div class="stat-item">
                    <span class="stat-val">24h</span>
                    <span class="stat-lbl">Average Turnaround</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">99.9%</span>
                    <span class="stat-lbl">Satisfaction Rate</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">Eco</span>
                    <span class="stat-lbl">Eco-friendly Solvents</span>
                </div>
            </div>
        </div>

        <!-- Dashboard Mockup -->
        <div class="hero-visual">
            <div class="hero-dashboard">
                <div class="dash-topbar">
                    <span class="dash-title-bar">Laundry Status</span>
                    <span class="dash-badge">Active Order</span>
                </div>
                <div class="dash-orders">
                    <div class="dash-order-row">
                        <div class="dash-order-info">
                            <div class="dash-order-avatar">
                                <iconify-icon icon="mdi:tshirt-crew-outline"></iconify-icon>
                            </div>
                            <div>
                                <div class="dash-order-name">Order #HW-7402</div>
                                <div class="dash-items">3 items</div>
                            </div>
                        </div>
                        <div>
                            <div class="dash-price">Rs24.50</div>
                            <div class="dash-items">Premium Wash & Dry</div>
                        </div>
                    </div>
                </div>

                <div class="dash-progress-wrap">
                    <div class="dash-progress-labels">
                        <span>Sorting</span>
                        <span>Washing</span>
                        <span class="active">Drying</span>
                        <span>Delivery</span>
                    </div>
                    <div class="dash-progress-bar">
                        <div class="dash-progress-fill"></div>
                    </div>
                </div>

                <div class="dash-delivery-info">
                    <div class="dash-delivery-time">
                        <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                        Delivering in 2 hours
                    </div>
                    <a href="{{ route('customer.login') }}" class="dash-track-link">
                        Track Live
                        <iconify-icon icon="mdi:chevron-right"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="section">
        <h2 class="section-title fade-up">Our <span class="text-accent">Premium Services</span></h2>
        <p class="section-subtitle fade-up">We treat your garments with utmost care. From standard daily wear to delicate fabrics, our expert dry cleaning and laundry processes ensure top quality results.</p>
        
        <div class="services-grid">
            @foreach($services as $service)
                <div class="service-card fade-up">
                    <div>
                        <div class="service-icon">
                            <iconify-icon icon="mdi:water-outline"></iconify-icon>
                        </div>
                        <h3 class="service-title">{{ ucfirst($service->service_name) }}</h3>
                        <p class="service-desc">Professional care and cleaning customized to your items. Get top notch treatment for your {{ strtolower($service->service_name) }} garments.</p>
                    </div>
                    <div class="service-footer">
                        <span class="service-status">Active Service</span>
                        <a href="#pricing" class="service-link">
                            View Pricing
                            <iconify-icon icon="mdi:chevron-right"></iconify-icon>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- PRICING -->
    <section id="pricing" class="section" style="border-top: 1px solid var(--border-color);">
        <h2 class="section-title fade-up"><span class="text-accent">Transparent Pricing</span></h2>
        <p class="section-subtitle fade-up">No hidden fees, simple flat pricing. Pay per item for premium laundry and dry cleaning services.</p>
        
        <div class="pricing-grid">
            @foreach($services as $service)
                @if($service->pricing->count() > 0)
                    <div class="pricing-card fade-up">
                        <div>
                            <div class="pricing-header">
                                <div class="pricing-header-icon">
                                    <iconify-icon icon="mdi:tshirt-crew-outline"></iconify-icon>
                                </div>
                                <h3 class="pricing-title">{{ ucfirst($service->service_name) }}</h3>
                            </div>
                            <ul class="pricing-list">
                                @foreach($service->pricing as $price)
                                    <li class="pricing-item">
                                        <span class="pricing-item-label">{{ ucfirst($price->service_type_name) }}</span>
                                        <span class="pricing-badge">Rs{{ number_format($price->service_price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('customer.login') }}" class="btn-pricing">Order Now</a>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section id="reviews" class="section" style="border-top: 1px solid var(--border-color);">
        <div class="testimonial-container" style="max-width: 680px; margin: 0 auto;">
            
            <!-- Slide 1 -->
            <div class="testimonial-slide" data-slide="0" style="display: block; opacity: 1; transition: opacity 0.4s ease;">
                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=120" alt="Sarah Jenkins" class="testimonial-avatar">
                    </div>
                    <p class="testimonial-text">"Hemwash completely changed my weekly routine. The 24 hour laundry return is super reliable, and my clothes always smell absolutely wonderful and look professionally folded!"</p>
                    <div class="stars">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <div class="author-name">Sarah Jenkins</div>
                    <div class="author-role">Regular Customer</div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="testimonial-slide" data-slide="1" style="display: none; opacity: 0; transition: opacity 0.4s ease;">
                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=120" alt="Ramesh Kumar" class="testimonial-avatar">
                    </div>
                    <p class="testimonial-text">"Laundry Box transformed how we manage our laundry shop. The POS system is lightning fast and the reports give us exactly the insights we need."</p>
                    <div class="stars">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <div class="author-name">Ramesh Kumar</div>
                    <div class="author-role">Owner, Fresh &amp; Clean Laundry</div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="testimonial-slide" data-slide="2" style="display: none; opacity: 0; transition: opacity 0.4s ease;">
                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=120" alt="Sunita Poudel" class="testimonial-avatar">
                    </div>
                    <p class="testimonial-text">"Our customers love the portal! They can track their orders and we've seen a big reduction in phone calls asking for status updates."</p>
                    <div class="stars">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <div class="author-name">Sunita Poudel</div>
                    <div class="author-role">Manager, CityWash Express</div>
                </div>
            </div>

            <div class="pagination-dots">
                <span class="dot active" data-dot="0"></span>
                <span class="dot" data-dot="1"></span>
                <span class="dot" data-dot="2"></span>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="footer-brand-logo">
                    <div class="nav-logo-icon">
                        <iconify-icon icon="mdi:washing-machine"></iconify-icon>
                    </div>
                    <span class="nav-logo-text">Laundry<span> management system</span></span>
                </a>
                <p class="footer-desc">Hemwash Laundry &amp; Dry Cleaning. Professional fabric care right at your doorstep. We wash, fold, clean, and press to perfection.</p>
                <div class="footer-socials">
                    <a href="#" class="social-btn"><iconify-icon icon="mdi:facebook"></iconify-icon></a>
                    <a href="#" class="social-btn"><iconify-icon icon="mdi:twitter"></iconify-icon></a>
                    <a href="#" class="social-btn"><iconify-icon icon="mdi:instagram"></iconify-icon></a>
                </div>
            </div>
            
            <div class="footer-links-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#services">Our Services</a></li>
                    <li><a href="#pricing">Pricing Matrix</a></li>
                </ul>
            </div>
            
            <div class="footer-links-col">
                <h4>Portal Access</h4>
                <ul>
                    <li>
                        <a href="{{ route('customer.login') }}">
                            <iconify-icon icon="mdi:account-outline"></iconify-icon>
                            Customer Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.register') }}">
                            <iconify-icon icon="mdi:account-plus-outline"></iconify-icon>
                            Customer Registration
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <iconify-icon icon="mdi:shield-key-outline"></iconify-icon>
                            Admin/Staff Sign In
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="footer-links-col">
                <h4>Get In Touch</h4>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div class="footer-contact-item">
                        <iconify-icon icon="mdi:map-marker-outline"></iconify-icon>
                        <span>address,<br>Itahari, koshi 691001, NP</span>
                    </div>
                    <div class="footer-contact-item">
                        <iconify-icon icon="mdi:phone-outline"></iconify-icon>
                        <span>9874563210</span>
                    </div>
                    <div class="footer-contact-item">
                        <iconify-icon icon="mdi:email-outline"></iconify-icon>
                        <span>store@store.com</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Laundry Box. All rights reserved.</p>
            <p>Built with &#10084; for premium fabric care.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.testimonial-slide');
            const dots = document.querySelectorAll('.dot');
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.style.display = 'block';
                        setTimeout(() => {
                            slide.style.opacity = '1';
                        }, 50);
                    } else {
                        slide.style.opacity = '0';
                        slide.style.display = 'none';
                    }
                });

                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });

                currentSlide = index;
            }

            function startSlideShow() {
                slideInterval = setInterval(function() {
                    let nextSlide = (currentSlide + 1) % slides.length;
                    showSlide(nextSlide);
                }, 5000);
            }

            function resetSlideShow() {
                clearInterval(slideInterval);
                startSlideShow();
            }

            dots.forEach((dot, i) => {
                dot.addEventListener('click', function() {
                    showSlide(i);
                    resetSlideShow();
                });
            });

            startSlideShow();
        });
    </script>
</div>
