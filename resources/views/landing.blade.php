@extends('layouts.app')

@section('title', 'Welcome to Renzman')

@section('content')
<style>
    :root{
        --primary-from: #06b6d4; /* cyan-500 */
        --primary-via: #14b8a6;  /* teal-500 */
        --primary-to: #10b981;   /* emerald-500 */
        --accent: #065f46;
    }
    body, html { min-height: 100vh; }
    .hero-bg {
        background: linear-gradient(135deg, var(--primary-from), var(--primary-via) 45%, var(--primary-to));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        color: #083344;
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
    .main-navbar .logo { font-size: 1.1rem; font-weight: 800; display:flex; align-items:center; gap:0.5rem; }
    .main-navbar .logo .icon { font-size:1.4rem; }
    .main-navbar nav { display:flex; gap:1.25rem; align-items:center; }
    .main-navbar nav a { color: rgba(255,255,255,0.95); font-weight:600; text-decoration:none; padding:6px 8px; border-radius:8px; }
    .main-navbar nav a:hover, .main-navbar nav a.active { background: rgba(255,255,255,0.06); }
    .main-navbar nav a:focus { outline: 3px solid rgba(255,255,255,0.12); outline-offset:4px; }
    .main-navbar .nav-right { display:flex; align-items:center; gap:0.75rem; }
    .main-navbar .search-box { background: rgba(255,255,255,0.95); border-radius:9999px; padding:6px 12px; border:none; font-size:0.95rem; color:#083344; min-width:140px; }
    .main-navbar .social {
        display: flex;
        gap: 0.7rem;
        align-items: center;
    }
    .main-navbar .social a {
        color: #fff;
        font-size: 1.2rem;
        transition: color 0.2s;
    }
    .main-navbar .social a:hover {
        color: #f6f6fa;
    }
    .hero-content { display:flex; gap:2rem; align-items:center; justify-content:space-between; flex:1 1 0%; padding:3.5rem 1rem; max-width:1200px; margin:0 auto; width:100%; }
    .hero-left { flex:1 1 0%; padding:2rem; color:#062425; display:flex; flex-direction:column; align-items:flex-start; justify-content:center; }
    .hero-title { font-size:3.25rem; font-weight:900; line-height:1.02; margin-bottom:0.8rem; color:#052f2b; text-shadow: 0 6px 18px rgba(4,16,18,0.08); }
    .hero-desc { font-size:1.05rem; margin-bottom:1.6rem; color: rgba(3,15,15,0.85); max-width:520px; }
    .hero-btn { background:#ffffff; color:var(--primary-via); font-weight:800; border-radius:9999px; padding:0.9rem 1.8rem; font-size:1rem; box-shadow:0 10px 30px rgba(16,185,129,0.06); transition:transform .12s ease, box-shadow .12s ease; }
    .hero-btn:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(16,185,129,0.12); }
    .hero-btn:focus { outline: 3px solid rgba(6,182,212,0.16); outline-offset:6px; }
    .hero-right { flex:1 1 0%; display:flex; align-items:center; justify-content:center; padding:2rem; }
    .hero-img { max-width:520px; width:100%; border-radius:1.25rem; box-shadow:0 20px 60px rgba(2,6,23,0.12); background:#fff; object-fit:cover; border:8px solid rgba(255,255,255,0.22); }
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
        .main-navbar nav { display:none; }
    }
</style>


<div class="hero-bg">
    <header class="main-navbar">
        <div class="logo">
            <span class="icon">👐</span> Renzman
        </div>
        <nav>
            <a href="#" class="active">Home</a>
            <a href="#services">Services</a>
            <a href="#branches">Branches</a>
            <a href="#testimonials">Testimonials</a>
            <a href="{{ route('about') }}">About Us</a>
        </nav>
        <div class="nav-right">
            <input type="text" class="search-box" placeholder="Search" />
            <div class="social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
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
                            <p class="text-xs sm:text-sm text-cyan-200 mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
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
</script>

@endsection

