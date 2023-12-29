@foreach($articles as $article)
    <div class="rounded shadow-2x1 p-10 m-4 border-2 border-gray-200">
        <div class="flex border-sky-500 border-b-2">
            <a href="{{ route('web.articles.show', $article) }}" class="text-blue-700 mr-2">
                {{ $article->title() }}
            </a>
                <span class="mr-auto">
                {{ $article->author->name }}
            </span>
                <span>
                {{ $article->publicationDate() ?? __($article->status->title) }}
            </span>
        </div>
        <div class="mt-4">
            {{ $article->content() }}
        </div>
    </div>
@endforeach
