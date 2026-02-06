@php
    $walker = new App\Models\CustomWalkerCategory();
    $args = array(
        'walker' => $walker,
        'style' => 'list',
        'show_count' => true,
        'use_desc_for_title' => false,
        'title_li' => '',
    );
@endphp

<ul class="category-list">
    @php wp_list_categories($args); @endphp
</ul>