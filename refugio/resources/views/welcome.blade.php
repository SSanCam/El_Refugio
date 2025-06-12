{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<section class="welcome-section">
  <header class="welcome-header">
    <h1 class="welcome-title">Bienvenid@ a El Refugio</h1>
  </header>

  <article class="welcome-story">
    <p class="welcome-text">
      Somos un refugio sin ánimo de lucro comprometido con el bienestar de los animales más vulnerables. Nuestra
      labor consiste en rescatar perros y gatos de situaciones de abandono, maltrato o desamparo, brindándoles atención
      veterinaria integral, cuidados personalizados y mucho cariño. Trabajamos sin descanso para ofrecerles un entorno
      seguro donde puedan recuperarse física y emocionalmente, mientras buscamos la familia adecuada que les
      proporcione un hogar permanente o, en su defecto, un acogimiento temporal. Gracias al apoyo de voluntarios y
      donaciones, facilitamos programas de adopción responsable, campañas de concienciación y actividades de
      socialización, con el objetivo de garantizar que cada uno de nuestros peludos encuentre la oportunidad de
      vivir una vida llena de amor y respeto.
    </p>
    <figure class="welcome-figure">
      <img src="{{ asset('media/images/refugio1.jpg') }}" alt="Nuestra historia" class="welcome-image">
s    </figure>
  </article>

  <article class="welcome-mission">
    <h2 class="mission-title">Nuestra misión</h2>
    <ul class="mission-list">
      <li class="mission-item">Rescatar animales en situación de abandono.</li>
      <li class="mission-item">Proporcionar atención veterinaria y cariño.</li>
      <li class="mission-item">Fomentar la adopción responsable.</li>
    </ul>
  </article>
</section>

<section class="animal-index">
  <!-- Índice de animales -->
</section>

@endsection
