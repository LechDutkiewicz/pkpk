@component('components.alert')
  @slot('icon')
    <i class="zmdi zmdi-mood-bad"></i>
  @endslot
  @slot('title')
    {{ __('Przykro mi', 'pkpk') }}
  @endslot
  @slot('subtitle')
    {{ __('Twoja przygoda z tą edycją kursu się zakończyła.', 'pkpk') }}
  @endslot

  <p>Warunkiem uczestnictwa w kursie było regularne wypełnianie obowiązkowych raportów. Tym razem się nie udało... Mam nadzieję, że znajdziesz chwilkę w przyszłej edycji kursu i jeszcze dołączysz!</p>
@endcomponent
