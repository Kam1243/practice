@extends('layouts.app')

@section('content')
<h2>Create Short URL</h2>
<form method="POST" action="{{ route('urls.store') }}">
    @csrf
    <div>
        <label>Original URL</label>
        <input name="original_url" required>
        @error('original_url')<div style="color:red">{{ $message }}</div>@enderror
    </div>
    <button type="submit">Create</button>
    </form>
@endsection
