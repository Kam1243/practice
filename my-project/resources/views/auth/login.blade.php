@extends('layouts.app')

@section('content')
<h2>Login</h2>
<form method="POST" action="/login">
    @csrf
    <div>
        <label>Email</label>
        <input name="email" value="{{ old('email') }}">
        @error('email')<div style="color:red">{{ $message }}</div>@enderror
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password">
        @error('password')<div style="color:red">{{ $message }}</div>@enderror
    </div>
    <button type="submit">Login</button>
</form>
@endsection
