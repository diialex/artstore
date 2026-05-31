@extends('auth.template')

@section('content')
<div class="flex justify-center items-center w-full py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all">
        
        <div class="px-8 pt-10 pb-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-dark bg-opacity-5 mb-4 text-dark shadow-inner">
                <i class="bi bi-person text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-dark tracking-tight">@lang('messages.login')</h2>
        </div>

        <div class="px-8 py-8">
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold mb-6 text-center border border-red-100">
                    @lang('messages.wrong_credentials')
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf
                
                <div>
                    <label for="userCredential" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.user_mail')</label>
                    <input type="text" id="userCredential" name="userCredential" required autofocus
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">@lang('messages.password')</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder-gray-400">
                </div>

                <div class="text-right mt-[-10px]">
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-gray-400 hover:text-primary transition-colors uppercase tracking-widest">
                        @lang('messages.forgot_password')
                    </a>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-opacity-90 hover:shadow-lg transition-all active:scale-95 mt-2">
                    @lang('messages.enter')
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-xs font-medium text-gray-500 mb-4">@lang('messages.no_account')</p>
                <a href="{{ route('register') }}" class="block w-full bg-white text-primary border-2 border-primary font-bold uppercase tracking-widest py-3 rounded-xl hover:bg-light transition-all">
                    @lang('messages.create_account')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection