@if($query->have_posts())
    @if($type === 'lectures')
        {{-- DESIGN 1 : LECTURES CONSEILLÉES --}}
        <div class="mt-8 pt-8 border-t border-gray-800 md:border-none md:pt-0">
            <h3 class="text-xs font-bold uppercase tracking-widest text-primary-500 mb-4">
                {{ $title ?? __('Lectures conseillées', 'sage') }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @while($query->have_posts()) @php $query->the_post() @endphp
                    <a href="{{ get_permalink() }}" class="group p-3 rounded-lg bg-gray-900/50 border border-gray-800 hover:border-primary-500/50 transition-all inline-block">
                        <span class="text-sm font-medium group-hover:text-primary-400">
                            {{ get_the_title() }} <x-arrow class="inline-block w-4 h-4" />
                        </span>
                    </a>
                @endwhile
            </div>
        </div>

    @else
        {{-- DESIGN 2 : POSTCARDS (PAR DÉFAUT) --}}
        <div class="mb-16">
            <h3 class="text-2xl font-bold text-primary-800 mb-8 text-center font-serif">
                {{ $title ?? __('Popular Articles You Might Like','sage') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @while($query->have_posts()) @php $query->the_post() @endphp
                    <div class="bg-white dark:bg-gray-950 rounded-2xl overflow-hidden border border-primary-100 card-hover">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'large') ?: 'https://via.placeholder.com/800x450' }}" 
                                 alt="{{ get_the_title() }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
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
    @endif

    @php wp_reset_postdata() @endphp
@endif