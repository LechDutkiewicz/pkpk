<section class="skewy skewy--{{ $variant }} {{ $classes }}" @if($id) id="{{ $id }}" @endif>
  <div class="skewy__container">
    {{ $slot }}
  </div>
</section>
