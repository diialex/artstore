@extends('adminLayout')
@section('title', 'Roles')

@section('content')
<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-black text-dark tracking-tight uppercase">Roles y Permisos</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Gestiona los niveles de acceso al sistema</p>
        </div>
        <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark text-white font-bold rounded-full hover:bg-opacity-90 transition-all active:scale-95 shadow-sm">
            <i class="bi bi-shield-plus text-lg"></i> Crear Rol
        </a>
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

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-5xl">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap w-1/4">@lang('messages.name')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest w-2/4">@lang('messages.description')</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right w-1/4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 align-middle">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-md bg-dark text-white text-xs font-bold uppercase tracking-widest">
                                    {{ $role->name }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 align-middle">
                                <p class="text-sm font-medium text-gray-600">{{ $role->description }}</p>
                            </td>

                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors" title="Editar Rol">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form method="post" action="{{ route('roles.delete', $role->id) }}" class="m-0" onsubmit="return confirm('¿Estás seguro de borrar el rol {{ uppercase($role->name) }}? Esto podría afectar a los usuarios que lo tengan asignado.');">
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
                            <td colspan="3" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-shield-x text-5xl text-gray-200 mb-3"></i>
                                    <p class="text-gray-500 font-medium">@lang('messages.no_role_assigned')</p>
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