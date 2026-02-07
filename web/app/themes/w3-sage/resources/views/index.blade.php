@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  @if ( is_archive() )
    @if ( category_description() )
    <div class="prose space-y-2">
      {!! category_description() !!}
    </div>
    @endif
  @endif
  @if (is_page() || !empty($page_content))
    <div class="prose space-y-2 mb-10">
      {!! $page_content ?? the_content() !!}
    </div>
  @endif
  <div class="flex flex-col gap-8 md:flex-row">
    @include('sections.archive-sidebar')
    
    <div class="min-w-0 flex-1">
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
