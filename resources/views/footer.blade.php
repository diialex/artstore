<footer class="bg-primary !text-light pt-10 pb-6 mt-16 w-full shadow-[0_-10px_20px_rgba(0,0,0,0.1)]">
    <div class="max-w-[1400px] mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <h2 class="text-2xl font-black tracking-widest text-white m-0">HANGER</h2>
                <div class="hidden md:block w-px h-6 bg-white/20"></div>
                <div class="flex gap-5">
                    <a href="#" class="!text-light hover:!text-white hover:scale-110 transition-transform"><i class="bi bi-instagram text-lg"></i></a>
                    <a href="#" class="!text-light hover:!text-white hover:scale-110 transition-transform"><i class="bi bi-twitter-x text-lg"></i></a>
                    <a href="#" class="!text-light hover:!text-white hover:scale-110 transition-transform"><i class="bi bi-envelope text-lg"></i></a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('lang.switch', 'es') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'es' ? '!border-light !bg-light !text-primary font-black shadow-sm' : '!border-white/30 !text-light hover:!border-white hover:!text-white font-medium' }} transition-colors text-xs tracking-widest uppercase no-decoration">ES</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'en' ? '!border-light !bg-light !text-primary font-black shadow-sm' : '!border-white/30 !text-light hover:!border-white hover:!text-white font-medium' }} transition-colors text-xs tracking-widest uppercase no-decoration">EN</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'fr' ? '!border-light !bg-light !text-primary font-black shadow-sm' : '!border-white/30 !text-light hover:!border-white hover:!text-white font-medium' }} transition-colors text-xs tracking-widest uppercase no-decoration">FR</a>
                <a href="{{ route('lang.switch', 'it') }}" class="px-3 py-1.5 rounded-md border {{ app()->getLocale() == 'it' ? '!border-light !bg-light !text-primary font-black shadow-sm' : '!border-white/30 !text-light hover:!border-white hover:!text-white font-medium' }} transition-colors text-xs tracking-widest uppercase no-decoration">IT</a>
            </div>
        </div>

        <div class="w-full h-px bg-white/10 mb-6"></div>

        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 text-xs !text-light">
            <div class="flex flex-wrap justify-center lg:justify-start gap-x-4 gap-y-2 font-medium">
                <a href="#" class="!text-light hover:!text-white transition-colors">@lang('messages.terms_conditions_purchase')</a>
                <span class="text-white/20 hidden md:inline">|</span>
                <a href="#" class="!text-light hover:!text-white transition-colors">@lang('messages.terms_conditions_hanger')</a>
                <span class="text-white/20 hidden md:inline">|</span>
                <a href="#" class="!text-light hover:!text-white transition-colors">@lang('messages.privacy_policy')</a>
                <span class="text-white/20 hidden md:inline">|</span>
                <a href="#" class="!text-light hover:!text-white transition-colors">@lang('messages.cookie_policy')</a>
                <span class="text-white/20 hidden md:inline">|</span>
                <a href="#" class="!text-light hover:!text-white transition-colors">@lang('messages.privacy_management')</a>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                <div class="flex items-center gap-3 text-lg !text-light opacity-80">
                    <i class="bi bi-credit-card"></i>
                    <i class="bi bi-paypal"></i>
                    <i class="bi bi-apple"></i>
                </div>
                <span class="font-bold tracking-wider !text-light">&copy; {{ date('Y') }} HANGER.</span>
            </div>
        </div>
    </div>
</footer>