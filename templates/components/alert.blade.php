<article class="alert-box">
  <header>
    @if ($icon)
      <div class="alert-box__icon">
        {{ $icon }}
      </div>
    @endif

    <h2 class="alert-box__heading std-heading">{{ $title }}</h2>
    <p class="alert-box__subheading">{{ $subtitle }}</p>
  </header>
  <div class="alert-box__content std-content">
    {{ $slot }}
  </div>
  <footer class="alert-box__cta-buttons">
    {{ $buttons }}
  </footer>
</div>
