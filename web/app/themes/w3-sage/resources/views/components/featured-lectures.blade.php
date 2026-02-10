@php
    $featured_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'meta_query'     => [[
            'key'   => '_featured_product',
            'value' => '1',
        ]]
    ]);
@endphp

@if($featured_query->have_posts())
<div class="mt-8 pt-8 border-t border-gray-800 md:border-none md:pt-0">
    <h3 class="text-xs font-bold uppercase tracking-widest text-primary-500 mb-4">
        {{ __('Lectures conseillées', 'sage') }}
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @while($featured_query->have_posts()) @php $featured_query->the_post() @endphp            <a href="{{ get_permalink() }}" 
               class="group p-3 rounded-lg bg-gray-900/50 border border-gray-800 hover:border-primary-500/50 transition-all">
                <span class="text-sm font-medium group-hover:text-primary-400">
                    {{ get_the_title() }}
                </span>
            </a>
        @endwhile
    </div>
</div>
@php wp_reset_postdata() @endphp {{-- TRÈS IMPORTANT --}}
@endif