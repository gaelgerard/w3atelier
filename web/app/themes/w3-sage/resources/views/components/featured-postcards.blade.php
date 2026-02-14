@php
    $featured_query = new WP_Query([
        'post_type'      => array('post', 'page'),
        'posts_per_page' => 3,
        'meta_query'     => [[
            'key'   => '_featured_post',
            'value' => '1',
        ]]
    ]);
@endphp

@if($featured_query->have_posts())

    <div class="mb-16">
        <h3 class="text-2xl font-bold text-primary-800 mb-8 text-center font-serif">{!! __('Popular Articles You Might Like','sage') !!}</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @while($featured_query->have_posts()) 
            @php
                $featured_query->the_post(); // Call the post data
                $thumb_id  = get_post_thumbnail_id();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: 'https://via.placeholder.com/800x450';
                $image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title();
            @endphp
             <!-- Article Card 1 -->
                <div class="bg-white rounded-2xl overflow-hidden border border-primary-100 card-hover">
                    <div class="h-48 overflow-hidden">
                        <img 
                            src="{{ $image_url }}" 
                            alt="{{ $image_alt }}" 
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                            loading="lazy"
                        >
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="px-3 py-1 bg-accent-100 text-accent-700 text-xs font-semibold rounded-full">{!! get_the_category()[0]->name !!}</span>
                            <span class="ml-3 text-sm text-primary-500">@readingtime {{__('read')}}</span>
                        </div>
                        <h4 class="text-lg font-bold text-primary-800 mb-2">{{ get_the_title() }}</h4>
                        <a href="{{ get_the_permalink() }}" class="group text-accent-600 font-medium text-sm hover:text-accent-700 transition-colors flex items-center no-underline">
                                {{__('Read article', 'sage')}} <x-arrow />

                        </a>
                    </div>
                </div>
        @endwhile
    </div>
</div>
@php wp_reset_postdata() @endphp {{-- TRÈS IMPORTANT --}}
@endif