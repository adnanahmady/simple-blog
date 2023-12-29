<div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-100 selection:bg-red-500 selection:text-white">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="p-10 dark:bg-gray-300 rounded mt-10 sm:mx-auto sm:w-full sm:max-w-sm shadow-2xl border-2">
            <h2 class="border-b-2 border-sky-500 column-12">
                <strong>Create Article</strong>
            </h2>
            <form action="{{ route('web.articles.store') }}" method="POST" class="space-y-6">
                @csrf
                @method('POST')
                <div>
                    <label for="email" class="block text-sm font-medium leading-6">{{ __('Article Title') }}</label>
                    <div class="mt-2">
                        <input type="text" id="{{ $titleField }}" name="{{ $titleField }}" autocomplete="off" required
                               @isset($article) value="{{ $article->title() }}" @endisset
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3">
                    </div>
                    @if($errors->has($titleField))
                        <div class="mt-2">
                            @foreach($errors->get($titleField) as $error)
                                <span class="text-red-700">{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6">Article Content</label>
                    <div class="mt-2">
                        <textarea id="{{ $contentField }}" name="{{ $contentField }}" autocomplete="off"
                               required
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-3"
                        >@isset($article) {{ $article->content() }} @endisset</textarea>
                    </div>
                    @if($errors->has($contentField))
                        <div class="mt-2">
                            @foreach($errors->get($contentField) as $error)
                                <span class="text-red-700">{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ $submitText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
