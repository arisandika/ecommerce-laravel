@extends('layouts.app')

@section('title')
    {{ $product->name }}
@endsection

@section('meta_keyword')
    {{ $product->meta_keyword }}
@endsection

@section('meta_description')
    {{ $product->meta_description }}
@endsection

@section('content')
    <div class="space-5"></div>
    <livewire:front.product.single-product :category="$category" :product="$product" />
@endsection
