@extends('layout.app')

@section('content')
    @include('articles.article-form', [
        'titleField' => 'title',
        'contentField' => 'content',
        'submitText' => __('Update Article'),
        'article' => $article
    ])
@endsection
