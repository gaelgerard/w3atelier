<article @php(post_class('bg-white dark:bg-gray-700 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-gray-600'))>
  <div class="aspect-video overflow-hidden">
      @if(has_post_thumbnail())
      {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-full object-cover transform hover:scale-105 transition-transform duration-500']) !!}
      @else 
      <img src="https://placehold.co/600x400/0793d7/white?text={!! str_replace(' ', '+', get_the_title()) !!}&font=raleway" width="1024" height="800" alt="Placehold" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
      @endif
    </div>
  
  <div class="p-6">
    <header>
      <h2 class="text-xl font-bold mb-3">
        <a href="{{ get_permalink() }}" class="hover:text-[var(--accent-500)] transition-colors">
          {!! get_the_title() !!}
        </a>
      </h2>
      @includeWhen(get_post_type() === 'post', 'partials.entry-meta')
    </header>

    <div class="mt-4 text-gray-600 dark:text-gray-300">
      @php(the_excerpt())
    </div>
  </div>
</article>

