@extends('layouts.default')

@section('title', 'Accueil')

@section('content')
<section aria-labelledby="hero-title" style="margin-top:1rem">
        <article class="grid" style="align-items:center">
          <div>
            <h1 id="hero-title">Projet concours-robots</h1>
            <p class="contrast">
              Application web de gestion du concours (inscriptions, saisie des épreuves, classements).
              Édition 2025 tenue le <strong>vendredi 5 avril 2025</strong> à Valette (9h–15h).
            </p>
            <nav>
              <a role="button" class="primary" href="/inscriptions">Inscrire une équipe</a>
              <a role="button" href="/resultats">Voir les résultats</a>
              <a role="button" href="/informations">Infos &amp; règlement</a>
            </nav>
          </div>

          <figure>
            <img
              src="./images/robot.jpg"
              alt="Robot de compétition sur une piste"
              loading="eager"
              decoding="async"
              style="width:100%;height:auto;border-radius:1rem" />
            <figcaption class="secondary">Concours des collèges — Technologie 3<sup>e</sup></figcaption>
          </figure>
        </article>
      </section>
@endsection
