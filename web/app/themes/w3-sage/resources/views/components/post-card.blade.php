@php
    $id = $post->ID;
    $title = get_the_title($id);
    $url = get_permalink($id);
    // Préparation du placeholder dynamique comme dans ton ancien fichier
    $placeholder_text = str_replace(' ', '+', $title);
    $placeholder_url = "https://placehold.co/600x400/0793d7/white?text={$placeholder_text}&font=raleway";
@endphp

<article {{ $attributes->merge(['class' => post_class('bg-white dark:bg-gray-700 rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 dark:border-gray-600', $id)]) }}>
    <div class="aspect-video overflow-hidden">
        @if(has_post_thumbnail($id))
            {!! get_the_post_thumbnail($id, 'large', [
                'class' => 'w-full h-full object-cover transform hover:scale-105 transition-transform duration-500'
            ]) !!}
        @else 
            <img src="{!! $placeholder_url !!}" 
                 width="1024" height="800" alt="Placehold" 
                 class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
        @endif
    </div>
  
    <div class="p-6">
        <header>
            <h2 class="text-xl font-bold mb-3">
                <a href="{{ $url }}" class="hover:text-[var(--accent-500)] transition-colors">
                    {!! $title !!}
                </a>
            </h2>
            {{-- On vérifie le type de post pour inclure les meta si nécessaire --}}
            @if(get_post_type($id) === 'post')
                @include('partials.entry-meta')
            @endif
        </header>

        <div class="mt-4 text-gray-600 dark:text-gray-300">
            {{-- Utilisation de get_the_excerpt pour éviter les conflits de boucle --}}
            {!! get_the_excerpt($id) !!}
        </div>
    </div>
</article>