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
    /* header glass style used on About page navbar */
    .header-glass {
        /* make header fully pill-shaped and tint to match landing palette */
        background: rgba(12, 92, 66, 0.12); /* subtle teal tint */
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 0.4rem 0.75rem;
        border-radius: 9999px !important; /* force pill shape on landing */
    }
    .mobile-nav {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
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
    .hero-content { display:flex; gap:2.5rem; align-items:center; justify-content:space-between; flex:1 1 0%; padding:7.5rem 1rem 6rem; max-width:1300px; margin:0 auto; width:100%; }

    /* Subtle page animations (reduced intensity + prefers-reduced-motion support) */
    @keyframes floatY { 0%{ transform: translateY(0);} 50%{ transform: translateY(-4px);} 100%{ transform: translateY(0);} }
    @keyframes pulseLift { 0%,100%{ transform: translateY(0) scale(1);} 50%{ transform: translateY(-2px) scale(1.01);} }
    @keyframes navIn { 0%{ transform: translateY(-10px); opacity:0;} 100%{ transform: translateY(0); opacity:1;} }

    .hero-img.animate-float { animation: floatY 5.5s ease-in-out infinite; }
    .hero-btn.animate-pulse { animation: pulseLift 2.8s ease-in-out infinite; }
    /* Late caption for therapist (cloud-like pill under the image) */
    .therapist-caption {
        /* centered pill (cloud-like) */
        position: relative;
        display: inline-block;
        text-align: center;
        background: rgba(255,255,255,0.98);
        color: #062425;
        padding: 0.9rem 1.4rem;
        font-weight:600;
        font-size:0.95rem;
        border-radius: 999px;
        box-shadow: 0 18px 40px rgba(2,6,23,0.10);
        transform: translateY(12px);
        opacity: 0;
        transition: opacity .6s cubic-bezier(.2,.9,.2,1) .12s, transform .6s cubic-bezier(.2,.9,.2,1) .12s;
        border: 1px solid rgba(0,0,0,0.06);
        backdrop-filter: blur(4px);
    }
    .therapist-caption.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    /* image wrapper: center contents so caption sits under the image */
    .hero-img-wrap { position: relative; display: block; text-align: center; }

    /* responsive: spacing for small screens */
    @media (max-width: 960px) {
        .therapist-caption { display: inline-block; margin: 0.8rem auto 0; transform: translateY(12px); }
    }

    header { animation: navIn 520ms cubic-bezier(.2,.9,.2,1) 120ms both; }

    /* fade-up reveal used across sections */
    .fade-up { opacity: 0; transform: translateY(12px); transition: opacity .6s ease, transform .6s ease; }
    .fade-up.in-view { opacity: 1; transform: translateY(0); }

    /* staggered children reveal */
    .staggered > * { opacity: 0; transform: translateY(6px); transition: transform .5s ease, opacity .5s ease; }
    .staggered.in-view > * { opacity: 1; transform: translateY(0); }
    .staggered.in-view > *:nth-child(1){ transition-delay: .05s; }
    .staggered.in-view > *:nth-child(2){ transition-delay: .10s; }
    .staggered.in-view > *:nth-child(3){ transition-delay: .15s; }
    .staggered.in-view > *:nth-child(4){ transition-delay: .20s; }
    .staggered.in-view > *:nth-child(5){ transition-delay: .25s; }
    .staggered.in-view > *:nth-child(6){ transition-delay: .30s; }

    /* small hover lift for social icons */
    .nav-right .social a { transition: transform .18s ease, box-shadow .18s ease; }
    .nav-right .social a:hover { transform: translateY(-2px); }

    /* Respect user preference to reduce motion */
    @media (prefers-reduced-motion: reduce) {
        .hero-img.animate-float,
        .hero-btn.animate-pulse,
        header,
        .fade-up,
        .staggered,
        .nav-right .social a { animation: none !important; transition: none !important; transform: none !important; }
    }
    .hero-left { flex:1 1 0%; padding:2rem; display:flex; flex-direction:column; align-items:flex-start; justify-content:center; }
    .hero-title { font-size:5.25rem; font-weight:900; line-height:0.98; margin-bottom:0.6rem; color:#fff; text-shadow: 0 10px 36px rgba(0,0,0,0.26); }
    .hero-desc { font-size:1.05rem; margin-bottom:1.6rem; color: #000 !important; max-width:520px; }
    .hero-btn { background:#ffffff; color:#000 !important; font-weight:800; border-radius:9999px; padding:0.9rem 1.8rem; font-size:1rem; box-shadow:0 10px 30px rgba(0,0,0,0.08); transition:transform .12s ease, box-shadow .12s ease; }
    .hero-btn:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(0,0,0,0.12); }
    .hero-btn:focus { outline: 3px solid rgba(0,0,0,0.12); outline-offset:6px; }
        /* limit white forcing to title only; hero description should be black for readability */
        .hero-left .hero-title { color: #fff !important; }
        .hero-left .hero-desc { color: #000 !important; }
    .hero-right { flex:1 1 0%; display:flex; align-items:center; justify-content:center; padding:2rem; }
    /* Center and style hero image as wide glass card (80-90% width) with smaller border */
    .hero-img {
        display:block;
        margin:0 auto 1.4rem;
        width:90%;          /* occupy 80-90% of the hero column */
        max-width:760px;    /* don't get too wide on very large screens */
        height:auto;        /* keep aspect ratio */
        border-radius:1rem;
        object-fit:cover;
        background:#fff;
        border:6px solid rgba(255,255,255,0.98); /* reduced border */
        box-shadow:0 28px 70px rgba(2,6,23,0.18), 0 8px 22px rgba(2,6,23,0.08);
    }
    @media (max-width: 1200px) {
        .hero-content { padding:6rem 1rem 4.5rem; }
        .hero-title { font-size:4rem; }
        .hero-img { width:88%; max-width:640px; height:auto; }
    }
    @media (max-width: 960px) {
        .hero-content { flex-direction:column-reverse; gap:1.5rem; padding:2.5rem 1rem; }
        .hero-left, .hero-right { padding:1rem; text-align:center; align-items:center; }
        .hero-title { font-size:2.25rem; }
        .hero-img { width:86%; max-width:520px; height:auto; }
    }
    @media (max-width: 520px) {
        .main-navbar { width: calc(100% - 20px); margin: 0.6rem auto; }
        .hero-title { font-size:1.5rem; }
    .hero-img { width:80%; max-width:360px; height:auto; }
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
        .hero-left .hero-title { color: #fff !important; }
    /* Sections should default to white headings and black card text */
    section.scroll-section h2, section.scroll-section .section-sub { color: #fff !important; }
    .glass-panel, .service-card, .testimonial-card { color: #000 !important; }
    /* Remove teal accent classes by overriding common utility selectors */
    .text-cyan-100, .text-cyan-200, .text-teal-600, .text-cyan-100 * { color: inherit !important; }

    /* Sections styling to match the hero look */
    section.scroll-section { padding:4rem 1rem; position:relative; }
    /* Glassy cards with subtle blur for better contrast while preserving background */
    .glass-panel {
        position: relative;
        overflow: hidden;
        background: rgba(255,255,255,0.78);
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
        border-radius: 1rem;
        padding: 1rem;
        /* remove outer border-image (caused visible outer line on some backgrounds) and use inset stroke instead */
        border: none;
        box-shadow: 0 8px 30px rgba(2,6,23,0.06), 0 0 28px rgba(162,89,230,0.02), inset 0 0 0 1px rgba(255,255,255,0.35);
    }
    /* glossy sheen to suggest glass */
    .glass-panel::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(180deg, rgba(255,255,255,0.20) 0%, rgba(255,255,255,0.03) 36%, rgba(255,255,255,0) 100%);
        mix-blend-mode: overlay;
        opacity: 1;
    }
    /* soft top-left highlight */
    .glass-panel::after {
        content: "";
        position: absolute;
        top: -40%;
        left: -40%;
        width: 80%;
        height: 80%;
        background: radial-gradient(circle at 28% 28%, rgba(255,255,255,0.22), rgba(255,255,255,0) 55%);
        transform: rotate(-12deg);
        pointer-events: none;
        opacity: 0.95;
    }
    .section-inner { max-width:1200px; margin:0 auto; }
    h2.section-title { font-size:2rem; color:#062425; margin-bottom:0.5rem; }
    p.section-sub { color: rgba(3,15,15,0.7); margin-bottom:1.25rem; }
    .service-card { background: rgba(255,255,255,0.78); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); border-radius:1rem; padding:1rem; box-shadow:0 8px 30px rgba(2,6,23,0.06), inset 0 0 0 1px rgba(255,255,255,0.32); border: none; }
    .branch-card { border-radius:0.75rem; overflow:hidden; box-shadow:0 8px 30px rgba(2,6,23,0.06); }
    .testimonial-card { background: rgba(255,255,255,0.8); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); padding:1rem; border-radius:1rem; box-shadow:0 6px 24px rgba(2,6,23,0.06), inset 0 0 0 1px rgba(255,255,255,0.30); border: none; }
    footer .glass-panel { background: rgba(255,255,255,0.04); }

    /* Force black headings for key sections so they read clearly over the background */
    section#services h2,
    section#branches h2,
    section#testimonials h2 { color: #062425 !important; }
</style>


<div class="hero-bg">
    @include('partials.header')
    <div class="hero-content fade-up">
        <div class="hero-left">
            <div class="hero-title">IT'S TIME<br>FOR THAT <span style="color:#fff; background:#a259e6; border-radius:0.5rem; padding:0 0.5rem;">RENZMAN</span> MASSAGE!</div>
            <div class="hero-desc">Escape the everyday and discover a new level of peace and rejuvenation. Experience the art of healing touch at Renzman.</div>
            <a href="{{ route('booking.create.step-one') }}" class="hero-btn">Book an Appointment</a>
        </div>
        <div class="hero-right">
            <div class="hero-img-wrap">
                <img src="{{ asset('images/thera.png') }}" alt="Our therapists at Renzman" class="hero-img" />
                <!-- Late animated caption representing our visually-impaired therapist (accessible, non-intrusive) -->
                <div class="therapist-caption" role="note" aria-label="Our therapists are visually impaired and trained">👩‍🦯 Our therapists are visually impaired — highly trained &amp; compassionate</div>
            </div>
        </div>
    </div>
</div>

    <!-- Page 2: Services Section -->
    <section id="services" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <!-- overlay removed to keep section background clean -->
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Our Signature Services</h2>
                <p class="mt-2 text-cyan-100 px-4">Tailored treatments designed for your ultimate comfort.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 staggered">
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
            <!-- overlay removed to keep section background clean -->
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Visit Our Branches</h2>
                <p class="mt-2 text-cyan-100 px-4">Find a sanctuary near you.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 staggered">
                    @forelse($branches as $branch)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->name . ', ' . $branch->address) }}" target="_blank" rel="noopener noreferrer" class="block">
                            <div class="relative rounded overflow-hidden shadow-lg">
                                <img src="{{ $branch->image_url ?? asset('images/branch-placeholder.jpg') }}" alt="{{ $branch->name }}" class="w-full h-64 object-cover">
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
            <!-- overlay removed to keep testimonials background clean -->
            <div class="relative z-10 flex flex-col">
             @if($feedbacks->isNotEmpty())
                <div class="text-center mb-4 sm:mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold">What Our Clients Say</h2>
                </div>
                <div class="flex-1 overflow-y-auto py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 staggered">
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
                <div class="glass-panel rounded-2xl p-6 sm:p-8 fade-up">
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
                                <li>Email: renzman@renzman-massage.com</li>
                                <li>Phone: 0932-423-3517/0977-392-6564</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/20 mt-6 sm:mt-8 pt-6 text-center text-xs sm:text-sm text-cyan-200">
                        <p>&copy; {{ date('Y') }} Renzman. All rights reserved. <span class="mx-2">|</span> <a href="{{ url('/login') }}" class="hover:text-white underline">Admin Login</a></p>
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
 
// Simple reveal and subtle motion for liveliness
(function(){
    // Fade-up / staggered reveal using IntersectionObserver
    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.fade-up, .staggered').forEach(el => io.observe(el));

    // Add small floating/pulse animations to hero elements after load
    window.addEventListener('load', () => {
        const img = document.querySelector('.hero-img');
        const btn = document.querySelector('.hero-btn');
        if (img) img.classList.add('animate-float');
        if (btn) btn.classList.add('animate-pulse');
        // Late reveal for therapist caption to give a subtle, delayed appearance
        const caption = document.querySelector('.therapist-caption');
        if (caption) {
            // Delay slightly longer than other hero animations for a 'late' effect
            setTimeout(() => caption.classList.add('in-view'), 950);
        }
    });
})();
</script>

@endsection

