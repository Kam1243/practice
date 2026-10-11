@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<h2>Short URLs</h2>
<table>
    <thead>
        <tr><th>Code</th><th>Original</th><th>Creator</th><th>Company</th><th>Created</th></tr>
    </thead>
    <tbody>
    @foreach($urls as $u)
        <tr>
            <td><a href="/s/{{ $u->short_code }}">{{ $u->short_code }}</a></td>
            <td><a href="{{ $u->original_url }}">{{ Str::limit($u->original_url,80) }}</a></td>
            <td>{{ $u->user->name ?? 'N/A' }}</td>
            <td>{{ $u->company->name ?? 'N/A' }}</td>
            <td>{{ $u->created_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
