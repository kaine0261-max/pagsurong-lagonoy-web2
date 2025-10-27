@extends('layouts.app')

@section('title', 'Complete Your Profile')

@section('content')
<h1 class="text-2xl font-bold mb-6">Complete Your Profile</h1>
<form method="POST" action="{{ route('profile.setup.store') }}">
    @csrf
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition-colors duration-200">Mark Profile as Complete</button>
</form>
@endsection