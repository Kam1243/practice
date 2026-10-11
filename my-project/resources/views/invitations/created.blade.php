@extends('layouts.app')

@section('content')
<h2>Invitation Created</h2>
<p>Invitation for {{ $invite->email }} created.</p>
<p>Acceptance link (copy/paste): <a href="{{ $link }}">{{ $link }}</a></p>
@endsection
