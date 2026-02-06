<ul class="flex flex-wrap gap-2 md:gap-3 my-6">
    @foreach ($tags as $tag)
        <li>
            <a href="{{ esc_url(get_tag_link($tag->term_id)) }}"
               title="{{ esc_attr(sprintf(__('View all posts tagged under %s'), $tag->name)) }}"
               class="inline-block px-3 py-1 text-sm bg-gray-100 hover:bg-primary hover:text-white border border-gray-200 rounded-full transition-all duration-200 {{ implode(' ', $classes($tag->term_id, $current_tag_id)) }}">
                <span class="font-medium">{{ esc_html($tag->name) }}</span>
                <span class="ml-1 opacity-60 text-xs">({{ intval($tag->count) }})</span>
            </a>
        </li>
    @endforeach
</ul>