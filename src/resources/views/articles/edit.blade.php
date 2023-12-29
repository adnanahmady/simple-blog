@php use App\Http\Requests\Web\Articles\UpdateRequest; @endphp
@extends('layout.app')

@section('content')
    @include('articles.article-form', [
        'titleField' => UpdateRequest::TITLE,
        'contentField' => UpdateRequest::CONTENT,
        'submitText' => __('Update Article'),
        'article' => $article
    ])
@endsection
