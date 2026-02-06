<header class="banner flex py-10">
  @if (has_custom_logo())
  {!! get_custom_logo() !!} 
  <a class="brand text-4xl md:text-3xl ml-2 font-bold font-sans text-gray-900 dark:text-white no-underline mb-2" href="{{ home_url('/') }}">
  Blog
  @else
  <a class="brand text-2xl font-bold font-sans text-gray-900 dark:text-white no-underline" href="{{ home_url('/') }}">
        {!! $site_name !!}
    @endif
  </a>

  <div class="flex ml-auto  items-center">
    <div class="md:order-2">
        <x-themeswitch />
    </div>

    <div class="md:order-1">
        <x-togglemenu />
    </div>
  </div>
</header>