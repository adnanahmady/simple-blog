@foreach($articles as $article)
    <div class="rounded shadow-2x1 p-10 m-4 border-2 border-gray-200">
        <div class="flex border-sky-500 border-b-2">
            <a href="{{ route('web.articles.show', $article) }}" class="text-blue-700 mr-2">
                {{ $article->title() }}
            </a>
                <span class="mr-auto">
                {{ $article->author->name }}
            </span>
            <span class="flex flex-align-center">
                <span class="mr-4 my-auto">
                    {{ $article->publicationDate() ?? __($article->status->title) }}
                </span>
                @if(auth()->user()->isAdmin())
                    @if(!$article->publicationDate())
                        <form action="{{ route('web.articles.approval', $article) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" value="1" name="approved">
                            <button
                                type="submit"
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >{{ __('Approve') }}</button>
                        </form>
                    @else
                        <form action="{{ route('web.articles.approval', $article) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" value="0" name="approved">
                            <button
                                type="submit"
                                class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                            >{{ __('disApprove') }}</button>
                        </form>
                    @endif
                @endif
            </span>
        </div>
        <div class="mt-4">
            {{ $article->content() }}
        </div>
    </div>
@endforeach
