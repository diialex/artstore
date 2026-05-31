@extends('auth.template')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-50 mb-4 text-amber-500 shadow-inner">
                <i class="bi bi-key text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-dark tracking-tight">@lang('messages.restore_password')</h2>
        </div>

        <div class="px-8 py-8">
            
            @if (session('status'))
                <div class="bg-success bg-opacity-20 text-green-800 p-4 rounded-xl text-sm font-bold mb-6 flex items-start gap-3 border border-green-200">
                    <i class="bi bi-check-circle-fill text-lg mt-0.5"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <p class="text-sm text-gray-500 mb-8 text-center leading-relaxed">
                @lang('messages.forgot_msg_psg')
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400" 
                           placeholder="tu@email.com">
                </div>

                <button type="submit" class="w-full mt-2 bg-dark text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 flex justify-center items-center gap-2">
                    <i class="bi bi-envelope-paper"></i> @lang('messages.send_link')
                </button>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-primary transition-colors uppercase tracking-widest flex items-center justify-center gap-1">
                        <i class="bi bi-arrow-left"></i> @lang('messages.back_login')
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection