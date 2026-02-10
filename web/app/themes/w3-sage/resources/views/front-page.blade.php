@extends('layouts.app')

@section('content')
  <div class="">
<header class="my-6 flex flex-col gap-x-12 lg:mb-12 lg:flex-row">
  <div class="flex flex-col items-start justify-start space-y-6 md:mt-12 md:flex-row md:items-center md:justify-center md:space-x-8">
    
    <div class="space-y-4 md:border-r-2 md:border-gray-200 dark:md:border-gray-700 pr-8">
      <x-author-card titleTag="h1" />
      <p class="text-primary-600 font-semibold text-sm tracking-wider uppercase">
        {{wp_specialchars_decode(get_bloginfo('description'), ENT_QUOTES)}}
      </p>
      
    </div>

    <div class="max-w-xl space-y-4 text-gray-600 dark:text-gray-400 prose prose-slate">
      <p class="text-lg leading-relaxed">
        Expert WordPress depuis <strong>25 ans</strong>, je partage ici mes analyses pour transformer vos sites en outils <strong>performants</strong>, <strong>scalables</strong> et <strong>durables</strong>. 
      </p>
      <p class="text-sm">
        Que vous soyez développeur ou propriétaire de boutique WooCommerce, découvrez mes retours d'expérience sans filtre sur les bonnes pratiques du web moderne.
      </p>
      
      <p>
        <a class="group no-underline mt-2 inline-flex items-center font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400" href="{{get_the_permalink(1404)}}">
          {{ __('En savoir plus sur mon parcours')}} 
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
        </a>
      </p>
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
