@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('no_header')
@endsection

@section('content')
    <div class="thanks__content">
        <p class="thanks__message">
            お問い合わせありがとうございました
        </p>
        <a href="{{ route('index') }}" class="thanks__button">HOME</a>
    </div>
@endsection
