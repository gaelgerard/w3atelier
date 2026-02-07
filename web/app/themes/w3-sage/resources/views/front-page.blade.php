@extends('layouts.app')

@section('content')
  <div class="">
    <div class="my-6 flex flex-col gap-x-12 lg:mb-12 lg:flex-row">
      <div class="flex flex-col items-start justify-start space-y-6 md:mt-24 md:flex-row md:items-center md:justify-center md:space-x-6 ">
        <div class="space-y-4 md:border-r-2 md:border-gray-200 dark:md:border-gray-700">
          <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl dark:text-gray-100">{{wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES)}}</h1>
          <p class="text-primary-500 mr-2 text-sm tracking-wider uppercase">{{wp_specialchars_decode(get_bloginfo('description'), ENT_QUOTES)}}</p>
        </div>
        <div class="max-w-xl space-y-4 text-gray-600 dark:text-gray-400 prose">
          <!-- c'est mon blog je met ce que je veux -->
          {{get_the_excerpt(1404)}}...
          <p>
            <a class="group no-underline mt-4 inline-flex items-center text-sm text-gray-600  hover:text-gray-900 dark:text-gray-200 dark:hover:text-gray-100" href="{{get_the_permalink(1404)}}">
             {{ __('Read more')}} 
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-1 h-4 w-4 transition-transform group-hover:translate-x-0.5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="space-y-2 pt-6 pb-8 md:space-y-5 divide-y divide-gray-200 dark:divide-gray-700">
      <div class="space-y-2 pt-6 pb-8 md:space-y-5">
        <h2 class="font-mono text-sm tracking-wider text-gray-500 uppercase dark:text-gray-400">
        {!! __('Latest Writing', 'sage') !!}
        </h2>
      </div>
      <ul class="divide-y divide-gray-200 dark:divide-gray-700">
        @if (! have_posts())
          <x-alert type="warning">
            {!! __('Sorry, no results were found.', 'sage') !!}
          </x-alert>
        @endif
  
        @while(have_posts()) @php(the_post())
        @include('partials.content-' . get_post_type())
  
        @endwhile
      </ul>
    </div>

  </div>

@endsection
