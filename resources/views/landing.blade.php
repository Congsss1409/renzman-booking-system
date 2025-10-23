@extends('layouts.app')

@section('title', 'Welcome to Renzman')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
<style>
    :root { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    :root{
        --primary-from: #06b6d4; /* cyan-500 */
        --primary-via: #14b8a6;  /* teal-500 */
        --primary-to: #10b981;   /* emerald-500 */
        --accent: #065f46;
    }
    body, html { min-height: 100vh; }
    /* Use store4.jpg as a full fixed background for the whole page */
    body {
        background: url('{{ asset('images/store4.jpg') }}') center center / cover no-repeat fixed, linear-gradient(135deg, var(--primary-from), var(--primary-via) 45%, var(--primary-to));
        -webkit-font-smoothing:antialiased;
        -moz-osx-font-smoothing:grayscale;
    }

    .hero-bg {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: #083344;
        background: transparent; /* background comes from body */
    }
    .main-navbar {
        background: rgba(0,0,0,0.18);
        color: #f8fafc;
        padding: 0.6rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 30;
        backdrop-filter: blur(6px);
        border-radius: 9999px;
        margin: 1rem auto;
        width: calc(100% - 48px);
        max-width: 1200px;
    }
    .main-navbar .mobile-toggle { display:none; background:transparent; border:none; color:inherit; font-size:1.2rem; }
    .main-navbar .logo { font-size: 1.1rem; font-weight: 800; display:flex; align-items:center; gap:0.5rem; }
    .main-navbar .logo img { height: 36px; display:block; }
    .main-navbar .logo .icon { font-size:1.4rem; }
    .main-navbar nav { display:flex; gap:1.25rem; align-items:center; }
    .main-navbar nav a { color: rgba(255,255,255,0.95); font-weight:600; text-decoration:none; padding:6px 8px; border-radius:8px; }
    .main-navbar nav a:hover, .main-navbar nav a.active { background: rgba(255,255,255,0.06); }
    .main-navbar nav a:focus { outline: 3px solid rgba(255,255,255,0.12); outline-offset:4px; }
    .main-navbar .nav-right { display:flex; align-items:center; gap:0.75rem; }
    .main-navbar .social { display:flex; gap:0.7rem; align-items:center; }
    .main-navbar .social a { color:#fff; display:inline-flex; width:36px; height:36px; align-items:center; justify-content:center; border-radius:8px; transition:background .12s, color .12s; }
    .main-navbar .social a:hover { background: rgba(255,255,255,0.06); }
    .hero-content { display:flex; gap:2rem; align-items:center; justify-content:space-between; flex:1 1 0%; padding:5.5rem 1rem 4rem; max-width:1200px; margin:0 auto; width:100%; }
    .hero-left { flex:1 1 0%; padding:2rem; display:flex; flex-direction:column; align-items:flex-start; justify-content:center; }
    .hero-title { font-size:4rem; font-weight:900; line-height:1.02; margin-bottom:0.8rem; color:#fff; text-shadow: 0 8px 28px rgba(0,0,0,0.22); }
    .hero-desc { font-size:1.05rem; margin-bottom:1.6rem; color: rgba(255,255,255,0.92); max-width:520px; }
    .hero-btn { background:#ffffff; color:#000 !important; font-weight:800; border-radius:9999px; padding:0.9rem 1.8rem; font-size:1rem; box-shadow:0 10px 30px rgba(0,0,0,0.08); transition:transform .12s ease, box-shadow .12s ease; }
    .hero-btn:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(0,0,0,0.12); }
    .hero-btn:focus { outline: 3px solid rgba(0,0,0,0.12); outline-offset:6px; }
    .hero-right { flex:1 1 0%; display:flex; align-items:center; justify-content:center; padding:2rem; }
    .hero-img { max-width:620px; width:100%; border-radius:1.25rem; box-shadow:0 30px 80px rgba(2,6,23,0.14); background:#fff; object-fit:cover; border:8px solid rgba(255,255,255,0.22); }
    @media (max-width: 960px) {
        .hero-content { flex-direction:column-reverse; gap:1.5rem; padding:2rem 1rem; }
        .hero-left, .hero-right { padding:1rem; text-align:center; align-items:center; }
        .hero-title { font-size:2rem; }
        .hero-img { max-width:360px; }
    }
    @media (max-width: 520px) {
        .main-navbar { width: calc(100% - 20px); margin: 0.6rem auto; }
        .hero-title { font-size:1.5rem; }
        .hero-img { max-width:220px; }
        .main-navbar { padding:0.6rem; }
        .main-navbar nav { display:none; }
        .main-navbar .mobile-toggle { display:block; }
        /* mobile dropdown nav */
        .main-navbar nav {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: rgba(0,0,0,0.14);
            padding: 14px 16px;
            border-radius: 18px;
            width: calc(100% - 40px);
            max-width: 420px;
            box-shadow: 0 8px 30px rgba(2,6,23,0.12);
            z-index: 50;
        }
        .main-navbar nav a { padding: 10px 12px; }
        .main-navbar.open nav { display: flex; }
    }

    /* responsive cards layout */
    .grid-responsive { display:grid; grid-template-columns: repeat(3, 1fr); gap:1.25rem; }
    @media (max-width: 992px) { .grid-responsive { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .grid-responsive { grid-template-columns: 1fr; } }
    .section { padding:4rem 0; }
    @media (max-width:640px) { .section { padding:2rem 0; } }

    /* Text color rules: only black and white */
    body { color: #000 !important; }
    /* Force white for header and hero text */
    .main-navbar, .main-navbar * { color: #fff !important; }
    /* limit white forcing to title and description only, allow buttons and other elements to override */
    .hero-left .hero-title, .hero-left .hero-desc { color: #fff !important; }
    /* Sections should default to white headings and black card text */
    section.scroll-section h2, section.scroll-section .section-sub { color: #fff !important; }
    .glass-panel, .service-card, .testimonial-card { color: #000 !important; }
    /* Remove teal accent classes by overriding common utility selectors */
    .text-cyan-100, .text-cyan-200, .text-teal-600, .text-cyan-100 * { color: inherit !important; }

    /* Sections styling to match the hero look */
    section.scroll-section { padding:4rem 1rem; position:relative; }
    .glass-panel { background: rgba(255,255,255,0.06); border-radius:1rem; padding:1rem; border:1px solid rgba(255,255,255,0.08); }
    .section-inner { max-width:1200px; margin:0 auto; }
    h2.section-title { font-size:2rem; color:#062425; margin-bottom:0.5rem; }
    p.section-sub { color: rgba(3,15,15,0.7); margin-bottom:1.25rem; }
    .service-card { background: rgba(255,255,255,0.9); border-radius:1rem; padding:1rem; box-shadow:0 8px 30px rgba(2,6,23,0.06); }
    .branch-card { border-radius:0.75rem; overflow:hidden; box-shadow:0 8px 30px rgba(2,6,23,0.06); }
    .testimonial-card { background: rgba(255,255,255,0.95); padding:1rem; border-radius:1rem; box-shadow:0 6px 24px rgba(2,6,23,0.06); }
    footer .glass-panel { background: rgba(255,255,255,0.04); }
</style>


<div class="hero-bg">
    <header class="main-navbar">
        <div class="logo">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman logo" />
            </a>
        </div>
        <button class="mobile-toggle" id="mobileToggle" aria-expanded="false" aria-controls="mainNav">☰</button>
        <nav id="mainNav">
            <a href="#" class="active">Home</a>
            <a href="#services">Services</a>
            <a href="#branches">Branches</a>
            <a href="#testimonials">Testimonials</a>
            <a href="{{ route('about') }}">About Us</a>
        </nav>
        <div class="nav-right">
            <div class="social" aria-hidden="false">
                <a href="#" aria-label="Facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.09 5.66 21.19 10.44 22v-7.03H8.07v-2.9h2.37V9.41c0-2.35 1.39-3.64 3.52-3.64 1.02 0 2.09.18 2.09.18v2.3h-1.18c-1.16 0-1.52.72-1.52 1.46v1.75h2.59l-.41 2.9h-2.18V22C18.34 21.19 22 17.09 22 12.07z" fill="#fff"/></svg>
                </a>
                <a href="#" aria-label="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 6.2a4.8 4.8 0 100 9.6 4.8 4.8 0 000-9.6zm4.9-2.5a1.1 1.1 0 11-2.2 0 1.1 1.1 0 012.2 0z" fill="#fff"/></svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M22 5.92c-.6.27-1.24.45-1.92.53a3.32 3.32 0 001.45-1.84 6.56 6.56 0 01-2.08.8 3.28 3.28 0 00-5.59 2.99A9.31 9.31 0 013 4.86a3.28 3.28 0 001.02 4.37c-.5-.02-.97-.15-1.38-.38v.04c0 1.6 1.13 2.92 2.63 3.23a3.28 3.28 0 01-1.48.06c.42 1.3 1.64 2.24 3.09 2.27A6.57 6.57 0 012 19.54a9.27 9.27 0 005.03 1.47c6.03 0 9.33-4.99 9.33-9.32v-.43c.64-.46 1.2-1.04 1.64-1.7-.58.26-1.2.45-1.84.53z" fill="#fff"/></svg>
                </a>
            </div>
        </div>
    </header>
    <div class="hero-content">
        <div class="hero-left">
            <div class="hero-title">IT'S TIME<br>FOR THAT <span style="color:#fff; background:#a259e6; border-radius:0.5rem; padding:0 0.5rem;">RENZMAN</span> MASSAGE!</div>
            <div class="hero-desc">Escape the everyday and discover a new level of peace and rejuvenation. Experience the art of healing touch at Renzman.</div>
            <a href="{{ route('booking.create.step-one') }}" class="hero-btn">Book an Appointment</a>
        </div>
        <div class="hero-right">
            <img src="{{ asset('images/store1.jpg') }}" alt="Renzman Blind Massage" class="hero-img" />
        </div>
    </div>
</div>

    <!-- Page 2: Services Section -->
    <section id="services" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Our Signature Services</h2>
                <p class="mt-2 text-cyan-100 px-4">Tailored treatments designed for your ultimate comfort.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                     @forelse($services->take(3) as $service)
                        <div class="glass-panel rounded-2xl p-4 sm:p-6 text-center shadow-lg flex flex-col transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ $service->image_url ?? 'https://placehold.co/400x500/FFFFFF/333333?text=' . urlencode($service->name) }}" alt="{{ $service->name }}" class="w-full h-40 sm:h-48 object-cover rounded-lg mb-4">
                            <div class="flex-grow flex flex-col">
                                <h3 class="text-lg sm:text-xl font-bold">{{ $service->name }}</h3>
                                <p class="text-cyan-200 mt-2 text-xs sm:text-sm flex-grow">{{ $service->description }}</p>
                                <div class="my-4 sm:my-6">
                                    <span class="text-2xl sm:text-3xl font-bold">₱{{ number_format($service->price, 2) }}</span>
                                    <span class="text-cyan-100 text-sm">/ {{ $service->duration }} mins</span>
                                </div>
                                <a href="{{ route('booking.create.step-one') }}" class="mt-auto inline-block bg-white/20 hover:bg-white/30 font-semibold py-2 px-4 text-sm sm:py-3 sm:px-6 rounded-full transition border border-white/30">
                                    Book This Service
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center">Our services will be listed here soon.</p>
                    @endforelse
                </div>
                 @if(count($services) > 3)
                    <div class="text-center mt-8 sm:mt-12">
                        <a href="{{ route('services') }}" class="font-semibold bg-white/20 hover:bg-white/30 py-2 px-4 rounded-full">View All Services &rarr;</a>
                    </div>
                 @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Page 3: Our Branches Section -->
    <section id="branches" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Visit Our Branches</h2>
                <p class="mt-2 text-cyan-100 px-4">Find a sanctuary near you.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    @forelse($branches as $branch)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->name . ', ' . $branch->address) }}" target="_blank" rel="noopener noreferrer" class="block">
                            <div class="relative rounded overflow-hidden shadow-lg">
                                <img src="{{ $branch->image_url ?? asset('images/branch-placeholder.svg') }}" alt="{{ $branch->name }}" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-black opacity-25"></div>
                                <div class="absolute bottom-0 left-0 p-4 text-white">
                                    <h3 class="text-xl font-bold">{{ $branch->name }}</h3>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full text-center">Our branches will be listed here soon.</p>
                    @endforelse
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Page 4: Testimonials & Footer Section -->
    <section id="testimonials" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/35"></div>
            <div class="relative z-10 flex flex-col">
             @if($feedbacks->isNotEmpty())
                <div class="text-center mb-4 sm:mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold">What Our Clients Say</h2>
                </div>
                <div class="flex-1 overflow-y-auto py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                        @foreach($feedbacks as $feedback)
                            <div class="glass-panel rounded-2xl p-6 sm:p-8 shadow-lg">
                                <div class="flex text-xl sm:text-2xl text-amber-300 mb-4">@for ($i = 0; $i < 5; $i++)<span>{{ $i < $feedback->rating ? '★' : '☆' }}</span>@endfor</div>
                                <p class="text-cyan-100 italic mb-6 text-sm sm:text-base">"{{ $feedback->feedback }}"</p>
                                <div class="text-right">
                                    <p class="font-bold text-sm sm:text-base">{{ $feedback->client_name }}</p>
                                    <p class="text-xs sm:text-sm text-cyan-200">for {{ $feedback->service->name ?? 'a service' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <footer class="w-full mt-auto pt-8 sm:pt-12">
                <div class="glass-panel rounded-2xl p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">About Renzman</h3>
                            <p class="text-xs sm:text-sm text-cyan-200 mt-2">Renzman Blind Massage Therapy offers professional and relaxing massage services delivered by skilled visually impaired therapists. Each session is designed to relieve tension, reduce stress, and promote overall well-being. We take pride in providing a welcoming and comfortable environment where clients can unwind and restore balance to both body and mind. Through our commitment to quality service and inclusivity, Renzman continues to promote relaxation, confidence, and empowerment—one soothing massage at a time. </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">Quick Links</h3>
                            <ul class="mt-2 space-y-1 text-xs sm:text-sm text-cyan-200">
                                <li><a href="#services" class="hover:text-white">Services</a></li>
                                <li><a href="#branches" class="hover:text-white">Branches</a></li>
                                <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">Contact Us</h3>
                            <ul class="mt-2 space-y-1 text-xs sm:text-sm text-cyan-200">
                                <li>Email: contact@renzman.com</li>
                                <li>Phone: (02) 8123-4567</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/20 mt-6 sm:mt-8 pt-6 text-center text-xs sm:text-sm text-cyan-200">
                        <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </section>
</div>

<script>
// Smooth programmatic scroll for the scroll-container with controllable duration/easing
(function(){
    const container = document.querySelector('.scroll-container');
    if (!container) return;

    const DURATION = 700; // ms
    const easeInOutCubic = t => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

    function animateScrollTo(targetY, duration = DURATION) {
        const startY = container.scrollTop;
        const diff = targetY - startY;
        const startTime = performance.now();

        function step(now) {
            const elapsed = now - startTime;
            const t = Math.min(1, elapsed / duration);
            container.scrollTop = Math.round(startY + diff * easeInOutCubic(t));
            if (t < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    // Intercept internal anchor clicks and animate the container instead of jumping
    document.addEventListener('click', function(e){
        const anchor = e.target.closest('a[href^="#"]');
        if (!anchor) return;
        const href = anchor.getAttribute('href');
        if (!href || href === '#') return;
        const id = href.slice(1);
        const target = document.getElementById(id);
        if (!target) return;

        // Only handle targets that are inside the scroll container
        if (!container.contains(target) && target !== container) return;

        e.preventDefault();

        // Compute target scrollTop relative to container
        const containerRect = container.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();
        const targetY = targetRect.top - containerRect.top + container.scrollTop;

        animateScrollTo(targetY, DURATION);

        // Update the URL hash without jumping
        try { history.replaceState(null, '', href); } catch (err) { /* ignore */ }

        // Focus target after animation completes for accessibility
        setTimeout(() => {
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        }, DURATION + 20);
    }, false);
})();

// Mobile nav toggle
(function(){
    const toggle = document.getElementById('mobileToggle');
    const nav = document.getElementById('mainNav');
    if (!toggle || !nav) return;
    toggle.addEventListener('click', function(){
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', String(!expanded));
        document.querySelector('.main-navbar').classList.toggle('open');
    });
})();
</script>

@endsection

