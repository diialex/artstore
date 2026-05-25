@extends('adminLayout')

@section('title', 'Roles')

@section('content')

    <a href="{{ route('roles.create') }}">@lang('messages.createuser')</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>@lang('messages.name')</th>
                    <th>@lang('messages.description')</th>
                </tr>
            </thead>

            <tbody>

                @forelse($roles as $role)
                    <tr>
                        <td><strong>{{ $role->name }}</strong></td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}">@lang('messages.update_role')</a>
                        </td>
                        <td>
                            <form method="post" action="{{ route('roles.delete', $role->id) }}"
                                onsubmit="return confirm('¿Estás seguro de borrar el rol {{ $role->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">@lang('messages.eliminate')</button>

                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            @lang('messages.no_role_assigned')
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    @if (session('msg'))
        <div class="alert alert-success mt-3">
            {{ session('msg') }}
        </div>
    @endif

@endsection