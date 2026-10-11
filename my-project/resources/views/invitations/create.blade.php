@extends('layouts.app')

@section('content')
<h2>Create Invitation</h2>

<form method="POST" action="{{ route('invitations.store') }}">
    @csrf
    <div>
        <label>Name</label>
        <input name="name" required>
    </div>
    <div>
        <label>Email</label>
        <input name="email" type="email" required>
    </div>
    @if(auth()->user()->isSuperAdmin())
        <div>
            <label>Company Name</label>
            <input name="company_name" required>
        </div>
    @endif

    @if(auth()->user()->isAdmin())
        <div>
            <label>Role</label>
            <select name="role_id">
                @foreach($roles as $role)
                    @if(in_array($role->name,['Admin','Member']))
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    @endif

    <button type="submit">Invite</button>
</form>

<h3>Pending Invitations</h3>
<ul>
    @foreach($invitations as $inv)
        <li>{{ $inv->email }} → {{ $inv->company->name }} ({{ $inv->role->name }})</li>
    @endforeach
</ul>

@endsection
