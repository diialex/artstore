@extends('adminLayout')
@section('title', 'Usuarios')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight uppercase">@lang('messages.users')</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">@lang('messages.clients_mngment_personal')</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-full hover:bg-gray-50 hover:text-dark transition-all active:scale-95 shadow-sm">
                <i class="bi bi-shield-plus text-lg"></i> @lang('messages.createrole')
            </a>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all active:scale-95 shadow-sm">
                <i class="bi bi-person-plus text-lg"></i> @lang('messages.createuser')
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="bg-dark text-white p-4 rounded-xl text-sm font-bold mb-8 flex items-center justify-between shadow-lg js-alert">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-success text-lg"></i>
                <span>{{ session('msg') }}</span>
            </div>
            <button onclick="this.closest('.js-alert').remove()" class="text-gray-400 hover:text-white transition-colors focus:outline-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">@lang('messages.user')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">@lang('messages.contact')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap hidden md:table-cell">@lang('messages.phone')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">@lang('messages.roles')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">@lang('messages.actions')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 align-middle">
                                <span class="font-black text-dark text-lg">{{ $user->username }}</span>
                            </td>
                            
                            <td class="px-6 py-4 align-middle">
                                <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs font-medium text-gray-500 flex items-center gap-1 mt-0.5"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                            </td>
                            
                            <td class="px-6 py-4 align-middle hidden md:table-cell text-sm font-medium text-gray-600">
                                {{ $user->phone ?? '-' }}
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-primary/10 text-primary text-[0.65rem] font-bold uppercase tracking-widest border border-primary/20">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-500 text-[0.65rem] font-bold uppercase tracking-widest">
                                            @lang('messages.no_roles')
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('addresses.show', $user->username) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-dark hover:text-white transition-colors" title="Direcciones">
                                        <i class="bi bi-geo-alt"></i>
                                    </a>
                                    
                                    <a href="{{ route('users.edit', $user->username) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('users.delete', $user->username) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de borrar al usuario {{ $user->username }} por completo?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Borrar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-people text-5xl text-gray-200 mb-3"></i>
                                    <p class="text-gray-500 font-medium">@lang('messages.no_users_registeres')</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection