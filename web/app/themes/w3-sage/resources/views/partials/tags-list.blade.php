@if ($isCloud)
    <div class="flex max-w-xl flex-wrap">
    @foreach ($tags as $tag)
            <div class="mt-2 mr-5 mb-2">
            <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
               title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
               class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 mr-3 text-sm font-medium uppercase mr-0 {{ implode(' ', $classes($tag->term_id, $current_tag_id)) }}">
                {{ esc_html($tag->name) }}
            </a>
            <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
               title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
               class="-ml-2 text-sm font-semibold text-gray-600 uppercase dark:text-gray-300 {{ implode(' ', $classes($tag->term_id, $current_tag_id)) }}">
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
                    {{ esc_html($tag->name) }} ({{ intval($tag->count) }})
                </a>
            </li>
        @endforeach
</ul>
@endif
