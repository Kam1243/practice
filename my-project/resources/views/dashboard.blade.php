@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>
<ul>
    @if(auth()->user()->isSuperAdmin())
        <li><a href="/invitations/create">Invite Admin (create company)</a></li>
    @endif
    @if(auth()->user()->isAdmin())
        <li><a href="/invitations/create">Invite Admin/Member</a></li>
    @endif
    @if(auth()->user()->isAdmin() || auth()->user()->isMember())
        <li><a href="/urls/create">Create Short URL</a></li>
    @endif
    <li><a href="/urls">List Short URLs</a></li>
</ul>
@endsection
