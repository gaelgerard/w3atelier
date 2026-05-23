<ul {{ $attributes->merge(['class' => 'category-list']) }}>
    @php wp_list_categories($args); @endphp
</ul>