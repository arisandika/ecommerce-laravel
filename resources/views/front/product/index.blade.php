@extends('layouts.app')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <h2 class="section__title">{{ $category->name }}</h2>
    <livewire:front.product.index :category="$category" />
@endsection
