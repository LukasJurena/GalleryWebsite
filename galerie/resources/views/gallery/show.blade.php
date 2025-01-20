<!-- resources/views/gallery/show.blade.php -->
@extends('layouts.app')
@section('content')
<body>

    <h1>{{ $image->title }}</h1>
    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="600">
    <p>{{ $image->description }}</p>
    <p><strong>Kategorie:</strong> {{ $image->category }}</p>

    <a href="{{ route('home') }}">Zpět na galerii</a>

@endsection