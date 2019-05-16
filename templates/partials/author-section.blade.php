@component('components.bg-section', ['variant' => 'dark row no-gutters', 'id' => 'trener'])
  <div class="container container--padding">
    <div class="row">
      <div class="coach-content col-6">
        <div class="row">
        {{ the_field('coach_about') }}

        @if (have_rows('coach_social_media'))
          <ul class="social-profiles">
            @while(have_rows('coach_social_media')) @php(the_row())
              <li class="social-profiles__item">
                @if (get_sub_field('url_type') == 'email' )
                  <a href="mailto:{{ the_sub_field('email') }}">
                    <i class="zmdi {{ the_sub_field('icon') }}"></i>
                  </a>
                @elseif ( get_sub_field('url_type') == 'url' )
                  <a href="{{ the_sub_field('url') }}">
                    <i class="zmdi {{ the_sub_field('icon') }}"></i>
                  </a>
                @endif
              </li>
            @endwhile
          </ul>
        @endif
        </div>
      </div>
    </div>
  </div>
@endcomponent
