<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    @include('partials.head-dark-mode')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body @php(body_class('bg-zinc-50 pl-[calc(100vw-100%)] text-zinc-900 antialiased dark:bg-gray-950 dark:text-zinc-50'))>
    @php(wp_body_open())

    <div id="app" class="max-w-4xl mx-auto px-4 sm:px-6 xl:px-0">
      <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main">
        @yield('content')
      </main>

      @include('sections.footer')
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
