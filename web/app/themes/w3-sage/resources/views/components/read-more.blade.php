@props([
    'post' => get_post()
])

@php
    $id = is_object($post) ? $post->ID : $post;
    $type = get_post_type($id);
    $text = ($type === 'page') ? __('View page', 'sage') : __('Read article', 'sage');
    $title = get_the_title($id);
@endphp

<a {{ $attributes->merge(['class' => 'group mt-auto mb-2 no-underline inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-200 dark:hover:text-gray-100']) }} 
   href="{{ get_permalink($id) }}" 
   aria-label="{{ $text }}: {{ $title }}">
    {{ $text }} 
    <x-arrow />
</a>