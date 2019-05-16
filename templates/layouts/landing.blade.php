<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    <div id="app">
      @php(do_action('get_header'))
      @include('partials.header')
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
      </div>
      @php(do_action('get_footer'))
      @include('partials.footer')
    </div>
    @php(wp_footer())
  </body>
</html>
