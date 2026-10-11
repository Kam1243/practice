@extends('layouts.app')

@section('content')
<h2>Accept Invitation for {{ $inv->email }}</h2>

<form method="POST" action="{{ route('invitations.processAccept', $inv->token) }}">
    @csrf
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Set Password & Accept</button>
</form>

@endsection
