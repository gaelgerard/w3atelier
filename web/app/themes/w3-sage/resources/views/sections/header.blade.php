<header class="banner flex py-10">
  <a class="brand text-2xl font-bold font-sans text-gray-900 dark:text-white no-underline" href="{{ home_url('/') }}">
    {!! $site_name !!}
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