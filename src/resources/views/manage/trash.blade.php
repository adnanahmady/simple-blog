@php use App\Http\Requests\Web\Articles\CreateRequest; @endphp

@extends('layout.app')

@section('content')
    @if(count($articles))
        @include('articles.list-partial', [
            'articles' => $articles
        ])
    @else
        <div class="flex flex-align-center p-10">
            <div class="mx-auto">{{ __('There is no trashed article!') }}</div>
        </div>
    @endif
@endsection
