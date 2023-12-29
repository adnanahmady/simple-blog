@extends('layout.app')

@section('content')
    <div class="rounded border-2 shadow-2x1 m-4 p-10">
        {{ __('Welcome to dashboard!') }}
    </div>
    @include('articles.list-partial', ['articles' => $articles])
@endsection
