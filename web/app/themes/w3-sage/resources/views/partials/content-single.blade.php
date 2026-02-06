<article @php(post_class('h-entry'))>
  <div class="xl:divide-y xl:divide-gray-200 xl:dark:divide-gray-700">
    <header class="pt-6 xl:pb-6">
      <div class="space-y-1 text-center">
        @include('partials.entry-meta')
        <h1 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10 md:text-5xl md:leading-14 dark:text-gray-100">
          {!! $title !!}
        </h1>
        @php($tags = get_the_tags())
        @if($tags)
          <div class="gap-2 text-center mt-4 text-lead">
          @foreach($tags as $tag)
              <a class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 mr-3 text-sm font-medium uppercase no-underline" href="{{ get_tag_link($tag->term_id) }}">
              {{ $tag->name }}
              </a>
          @endforeach
          </div>
        @endif
      </div>
  
    </header>
  
    <div class="e-content grid-rows-[auto_1fr] divide-y divide-gray-200 pb-8 xl:grid xl:grid-cols-4 xl:gap-x-6 xl:divide-y-0 dark:divide-gray-700">
      @include('partials.author-meta')
      <div class="divide-y divide-gray-200 xl:col-span-3 xl:row-span-2 xl:pb-0 dark:divide-gray-700">
        <div class="prose dark:prose-invert max-w-none pt-10 pb-8">
          @php(the_content())
        </div>
        @if ($pagination)
          <footer>
              {!! $pagination !!}
          </footer>
        @endif

      </div>
    </div>
  
  
    @php(comments_template())
  </div>
</article>
