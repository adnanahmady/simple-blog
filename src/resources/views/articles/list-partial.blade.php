@foreach($articles as $article)
    <div class="rounded shadow-2x1 p-10 m-4 border-2 border-gray-200">
        <div class="flex border-sky-500 border-b-2">
            <span class="mr-2">
                {{ $article->title() }}
            </span>
                <span class="mr-auto">
                {{ $article->author->name }}
            </span>
                <span>
                {{ $article->publicationDate() }}
            </span>
        </div>
        <div class="mt-4">
            {{ $article->content() }}
        </div>
    </div>
@endforeach
