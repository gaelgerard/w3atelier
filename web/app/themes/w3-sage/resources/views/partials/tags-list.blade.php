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