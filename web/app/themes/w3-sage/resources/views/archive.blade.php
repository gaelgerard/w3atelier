@extends('layouts.app')

@section('content')
<article @php(post_class('h-entry'))>
  <div class="xl:divide-y xl:divide-gray-200 xl:dark:divide-gray-700">
    <header class="pt-6 xl:pb-6">
      <div class="space-y-1 text-center">
        <h1 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10 md:text-5xl md:leading-14 dark:text-gray-100">
          {!! get_the_archive_title() !!}
        </h1>
      </div>
    </header>
    <div class="flex flex-col gap-8 md:flex-row mt-6">
      @include('sections.archive-sidebar')
      
      <div class="min-w-0 flex-1">
      @if ( get_the_archive_description() )
        <div class="prose space-y-2">
          {!! get_the_archive_description() !!}
        </div>
      @endif
      
      @if (! have_posts())
        <x-alert type="warning">
          {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>

        {!! get_search_form(false) !!}
      @endif
    <ul class="divide-y divide-gray-200 dark:divide-gray-800">
      @while(have_posts()) @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile
    </ul>
    
      {!! get_the_posts_navigation() !!}
    @endsection
    </div>

  </div>
  </div>
</article>
