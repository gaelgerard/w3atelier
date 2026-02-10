@extends('layouts.app')

@section('content')
  <div class="">
    <header class="my-6 lg:mb-12">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
          
          <div class="md:col-span-5 lg:col-span-4 space-y-6 md:border-r md:border-gray-800 md:pr-8">
              <x-author-card titleTag="h1" />
              
              <p class="text-primary-600 font-semibold text-sm tracking-wider uppercase">
                  {{wp_specialchars_decode(get_bloginfo('description'), ENT_QUOTES)}}
              </p>
          </div>

          <div class="md:col-span-7 lg:col-span-8 flex flex-col justify-between">
              
              <div class="space-y-4">
                  <h2 class="text-xl lg:text-2xl font-semibold leading-tight dark:text-gray-100">
                      Expert WordPress depuis <span class="text-primary-500">25 ans</span>, je partage ici mes analyses pour transformer vos sites en outils performants, scalables et durables. 
                  </h2>
                  <div class="prose prose-invert prose-sm sm:prose-base dark:text-gray-400">
                      <p>
                          Que vous soyez développeur, propriétaire de site internet ou de boutique WooCommerce, découvrez mes retours d'expérience sans filtre sur les bonnes pratiques du web moderne.
                      </p>
                  </div>
                  <a href="{{get_the_permalink(1404)}}" class="inline-flex items-center text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors">
                      En savoir plus sur mon parcours 
                      <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                  </a>
              </div>
              <x-featured-lectures />

              
          </div>
      </div>
    </header>
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
