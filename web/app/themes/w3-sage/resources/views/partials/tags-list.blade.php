@if ($isCloud)
    <div class="flex max-w-5xl flex-wrap">
    @foreach ($tags as $tag)
            <div class="mt-2 mr-5 mb-2 group">
            <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
               title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
               class="text-sm no-underline transition-all font-mono uppercase hover:underline mr-2 py-1 text-primary-500 font-bold group-transition-color">
                {!! esc_html($tag->name) !!}
            </a>
            <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
               title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
               class="-ml-2 text-sm font-semibold text-gray-600 uppercase dark:text-gray-300 group-transition-color {{ implode(' ', $classes($tag->term_id, $current_tag_id)) }}">
                ({{ intval($tag->count) }})
            </a>
            </div>
    @endforeach
    </div>
@else
    <ul>
        @foreach ($tags as $tag)
            <li>
                <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
                   title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
                   class="{{ implode(' ', $classes($tag->term_id, $current_tag_id)) }}">
                    {!! esc_html($tag->name) !!} ({{ intval($tag->count) }})
                </a>
            </li>
        @endforeach
</ul>
@endif
