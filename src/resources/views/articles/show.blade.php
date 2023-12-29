@php use App\Http\Requests\Web\Articles\CreateRequest;use App\Http\Requests\Web\Auth\LoginRequest; @endphp

@extends('layout.app')

@section('content')
    <div
        class="relative bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-100 selection:bg-red-500 selection:text-white">
        <div class="flex min-h-full flex-col justify-center px-6 lg:px-8">
            <div class="p-10 dark:bg-gray-300 rounded mt-10 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl border-2">
                <h2 class="border-b-2 border-sky-500 column-12">
                    <strong>Article Detail</strong>
                </h2>
                <div class="my-4 py-2 border-b-2 border-sky-300">
                    <strong class="mb-3 block font-semibold">{{ __('Title') }}:</strong>
                    {{ __($article->title()) }}
                </div>
                <div class="my-4 py-2 border-b-2 border-sky-300">
                    <strong class="mb-3 block font-semibold">{{ __('Content') }}:</strong>
                    {{ __($article->content()) }}
                </div>
                <div class="my-4 py-2 border-b-2 border-sky-300">
                    <strong class="mb-3 block font-semibold">{{ __('Publication Date') }}:</strong>
                    {{ __($article->publicationDate()) }}
                </div>
                <div class="my-4 py-2 border-b-2 border-sky-300">
                    <strong class="mb-3 block font-semibold">{{ __('Author') }}:</strong>
                    {{ __($article->author->name) }}
                </div>
                <div class="my-4 py-2 border-b-2 border-sky-300">
                    <strong class="mb-3 block font-semibold">{{ __('Status') }}:</strong>
                    {{ __($article->status->title) }}
                </div>
                <div class="my-4 py-2">
                    <a
                        href="{{ route('web.articles.edit', $article) }}"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >{{ __('Edit Article') }}</a>
                </div>
                <div class="my-4 py-2">
                    <form
                        action="{{ route('web.articles.delete', $article) }}"
                        method="POST"
                        >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                        >{{ __('Delete Article') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
