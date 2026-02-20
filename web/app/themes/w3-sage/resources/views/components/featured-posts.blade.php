@if($query->have_posts())
    @if($type === 'list')
        <ul class="space-y-2 text-sm">
            @while($query->have_posts()) @php $query->the_post() @endphp
                <li>
                    <a href="{{ get_permalink() }}" class="hover:text-blue-400 transition-colors no-underline group inline-flex sm:inline" title="{{ get_the_title() }}">
                        {!! \Illuminate\Support\Str::limit(get_the_title(), $length, '...') !!}<x-arrow />
                    </a>
                </li>
            @endwhile
        </ul>

    @elseif($type === 'lectures')
        {{-- DESIGN 1 : LECTURES CONSEILLÉES --}}
        <div class="mt-8 pt-8 border-t border-gray-800 md:border-none md:pt-0">
            <h3 class="text-xs font-bold uppercase tracking-widest text-primary-500 mb-4">
                {{ $title ?? __('Lectures conseillées', 'sage') }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @while($query->have_posts()) @php $query->the_post() @endphp
                    <a href="{{ get_permalink() }}" class="group p-3 rounded-lg bg-zinc-50 dark:bg-[#1a1a1a] hover:bg-zinc-100 dark:hover:bg-[#2a2a2a] border border-[#444444] dark:hover:border-white transition-all inline-block">
                        <span class="text-sm font-medium group-hover:text-primary-400">
                            {{ get_the_title() }} <x-arrow />
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
                    <x-post-card :post="get_post()" />
                @endwhile
            </div>
        </div>
    @endif

    @php wp_reset_postdata() @endphp
@endif