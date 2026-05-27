@extends('auth.template')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8 mb-20">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-dark bg-opacity-5 mb-4 text-dark shadow-inner">
                <i class="bi bi-shield-lock text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-dark tracking-tight uppercase">@lang('messages.createnewpass')</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Introduce y confirma tu nueva contraseña de acceso.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="p-8 space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            
            <div>
                <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" value="{{ request()->email }}" required readonly
                           class="w-full pl-12 bg-gray-100 border border-gray-200 text-gray-500 rounded-xl px-4 py-3.5 text-sm focus:outline-none cursor-not-allowed">
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.newpass')</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-key text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required autofocus placeholder="••••••••"
                           class="w-full pl-12 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.confirm_password')</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-check2-all text-gray-400"></i>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                           class="w-full pl-12 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
            </div>

            <button type="submit" class="w-full mt-4 bg-dark text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                <i class="bi bi-arrow-clockwise text-lg"></i> @lang('messages.resetpass')
            </button>
        </form>
        
    </div>
</div>
@endsection