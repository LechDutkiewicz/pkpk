<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    <div id="app">
      @php(do_action('get_header'))
      @include('partials.header-shop')
      <div class="content content--app">
        <main class="main">
          @php
          if (isset($wp_subscribe_reloaded)){ global $posts; $posts = $wp_subscribe_reloaded->stcr->subscribe_reloaded_manage(); } 
          @endphp
          @if(have_posts())
            @while(have_posts()) @php(the_post())
              @component('components.skewy-container', ['variant' => 'white'])
                <div class="container">
                  <div class="row justify-content-center no-gutters">
                    @component('components.shadow-box', ['variant' => 'white', 'col' => 'md-10 col-lg-8 shop-content', 'row' => false])
                      <div class="container--flex justify-content-center container--full-width">
                        <div class="col-sm-10">
                          @yield('content')
                        </div>
                      </div>
                    @endcomponent
                  </div>
                </div>
              @endcomponent
            @endwhile
          @else
            @component('components.skewy-container', ['variant' => 'white'])
              <div class="container">
                <div class="row justify-content-center no-gutters">
                  @component('components.shadow-box', ['variant' => 'white', 'col' => 'md-10 col-lg-8 shop-content', 'row' => false])
                    <div class="container--flex justify-content-center container--full-width">
                      <div class="col-sm-10">
                        @yield('content')
                      </div>
                    </div>
                  @endcomponent
                </div>
              </div>
            @endcomponent
          @endif
        </main>
      </div>
      @php(do_action('get_footer'))
    </div>
    @php(wp_footer())
  </body>
</html>
