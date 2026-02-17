{{-- resources/views/search.blade.php --}}
@extends('layouts.app')

@section('content')
  {{-- Header de la page de recherche --}}
  <div class="py-12 bg-gray-50 dark:bg-gray-800/50 rounded-3xl mb-12 px-8">
  <h1 class="text-4xl font-bold mb-4">
    @if ($result_count > 0)
      {{ sprintf(_n('%d résultat pour :', '%d résultats pour :', $result_count, 'sage'), $result_count) }}
    @else
      {{ __('Aucun résultat pour :', 'sage') }}
    @endif
    
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[var(--accent-500)] to-[var(--accent-600)]">
      "{{ get_search_query() }}"
    </span>
  </h1>
    
    {{-- On réaffiche le formulaire pour permettre de relancer une recherche facilement --}}
    <div class="max-w-2xl mt-8">
      {!! get_search_form(false) !!}
    </div>
  </div>

  {{-- Liste des résultats --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @if (!have_posts())
      <div class="col-span-full py-12 text-center">
        <div class="text-6xl mb-4 float">🔍</div>
        <p class="text-xl text-gray-500">
          {{ __('Essayez avec d\'autres mots-clés ou parcourez nos catégories.', 'sage') }}
        </p>
      </div>
    @endif

    @while(have_posts()) @php(the_post())
      <x-post-card class="mb-6" />
      
    @endwhile
  </div>

  {{-- Pagination --}}
  <div class="mt-12">
    {!! get_the_posts_navigation([
        'prev_text' => '← ' . __('Précédent', 'sage'),
        'next_text' => __('Suivant', 'sage') . ' →'
    ]) !!}
  </div>
@endsection