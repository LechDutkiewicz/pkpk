<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    @php(do_action('get_header'))
    <div id="app">
      @include('partials.headers.lesson')
      <div class="content content--app">
        <main class="main">
          @if(have_posts())
            @while(have_posts()) @php(the_post())
              @component('components.skewy-container', ['variant' => 'white'])
                @yield('content')
              @endcomponent
            @endwhile
          @endif
        </main>
      </div>
      @php(do_action('get_footer'))
      @include('partials.footer')
    </div>
    @php(wp_footer())
  </body>
</html>
