<div class="shadow-box shadow-box--{{ $variant }} col-{{ $col }} {{ $classes }}">
  <div class="shadow-box__container @if($row) row @endif">
    {{ $slot }}
  </div>
</div>
