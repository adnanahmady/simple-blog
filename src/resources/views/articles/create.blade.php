@php use App\Http\Requests\Web\Articles\CreateRequest; @endphp

@extends('layout.app')

@section('content')
    @include('articles.article-form', [
        'titleField' => CreateRequest::TITLE,
        'contentField' => CreateRequest::CONTENT,
        'submitText' => __('Create Article')
    ])
@endsection
