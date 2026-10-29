@extends('layouts.landing')

@section('title', $appName . ' — Gérez vos projets, votre temps et vos factures')
@section('description', 'Chronomètre, Kanban, devis, factures et espace client dans un seul outil. Gratuit pour démarrer, essai de 14 jours des plans payants, paiement en Ariary par mobile money.')

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqs)->map(fn ($f) => [
        '@type' => 'Question',
        'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ])->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

{{-- ============ HERO ============ --}}
<section class="hero" id="accueil">
    <span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span>
    <div class="container hero-grid">
        <div>
            <span class="pill"><i class="dot"></i> Gratuit pour démarrer · Sans carte bancaire</span>
            <h1>Un seul outil pour gérer vos <span class="grad">projets, votre temps et vos factures</span></h1>
            <p class="lead">
                {{ $appName }} réunit chronomètre, tâches, Kanban, devis, factures et espace client.
                Sachez enfin ce que chaque projet vous rapporte vraiment.
            </p>
            <div class="hero-cta">
                <a href="{{ $registerUrl }}" class="btn btn-primary">Commencer gratuitement <i class="fa-solid fa-arrow-right"></i></a>
                <a href="#demo" class="btn btn-ghost"><i class="fa-solid fa-gamepad"></i> Essayer en jouant</a>
            </div>
            <ul class="hero-points">
                <li><i class="fa-solid fa-circle-check"></i>Essai 14 jours des plans payants</li>
                <li><i class="fa-solid fa-circle-check"></i>Export de vos données à tout moment</li>
                <li><i class="fa-solid fa-circle-check"></i>Paiement en Ariary</li>
            </ul>
        </div>

        {{-- Maquette animée (cliquez dessus : confettis) --}}
        <div class="stage" aria-hidden="true">
            <div class="device">
                <div class="device-bar"><i></i><i></i><i></i><span>Site e-commerce · Client Rakoto</span></div>
                <div class="device-body">
                    <div class="timer-row">
                        <div>
                            <small>Chronomètre</small>
                            <strong class="timer" data-timer="8138">02:15:38</strong>
                        </div>
                        <span class="rec"><i></i> En cours</span>
                    </div>
                    <div class="progress"><span style="--w:72%"></span></div>
                    <small class="p-label">Avancement du projet · 72 %</small>
                    <div class="kanban">
                        <div><b>À faire</b><u></u><u></u></div>
                        <div><b>En cours</b><u class="drag"></u><u></u></div>
                        <div><b>Livré</b><u class="ok"></u><u class="ok"></u><u class="ok"></u></div>
                    </div>
                    <div class="bars">
                        <i style="--h:35%;--n:0"></i><i style="--h:55%;--n:1"></i><i style="--h:42%;--n:2"></i>
                        <i style="--h:70%;--n:3"></i><i style="--h:60%;--n:4"></i><i style="--h:85%;--n:5"></i>
                        <i style="--h:100%;--n:6"></i>
                    </div>
                </div>
            </div>
            <div class="chip c1"><i class="fa-solid fa-file-invoice-dollar"></i> Facture envoyée</div>
            <div class="chip c2"><i class="fa-solid fa-arrow-trend-up"></i> Marge +38 %</div>
            <div class="chip c3"><i class="fa-solid fa-circle-check"></i> Jalon validé</div>
        </div>
    </div>
</section>

{{-- ============ MARQUEE ============ --}}
<div class="marquee" aria-hidden="true">
    <div class="track">
        @for ($i = 0; $i < 2; $i++)
            <span><i class="fa-solid fa-stopwatch"></i>Chronomètre</span>
            <span><i class="fa-solid fa-table-columns"></i>Kanban</span>
            <span><i class="fa-solid fa-file-signature"></i>Devis</span>
            <span><i class="fa-solid fa-file-invoice-dollar"></i>Factures</span>
            <span><i class="fa-solid fa-share-nodes"></i>Espace client</span>
            <span><i class="fa-solid fa-chart-line"></i>Rentabilité</span>
            <span><i class="fa-solid fa-vault"></i>Coffre d'accès</span>
            <span><i class="fa-solid fa-arrows-rotate"></i>Récurrence</span>
            <span><i class="fa-solid fa-globe"></i>Domaines &amp; SSL</span>
            <span><i class="fa-solid fa-mobile-screen-button"></i>Mobile money</span>
        @endfor
    </div>
    <div class="track rev">
        @for ($i = 0; $i < 2; $i++)
            <span><i class="fa-solid fa-users"></i>Équipe et rôles</span>
            <span><i class="fa-solid fa-list-check"></i>Tâches</span>
            <span><i class="fa-solid fa-flag-checkered"></i>Jalons</span>
            <span><i class="fa-solid fa-file-export"></i>Export</span>
            <span><i class="fa-solid fa-cloud-arrow-up"></i>Sauvegardes</span>
            <span><i class="fa-solid fa-shield-halved"></i>Données isolées</span>
            <span><i class="fa-solid fa-coins"></i>Ariary · € · $</span>
            <span><i class="fa-solid fa-rocket"></i>Mises à jour</span>
            <span><i class="fa-solid fa-lock"></i>Chiffrement</span>
            <span><i class="fa-solid fa-bolt"></i>Rapide</span>
        @endfor
    </div>
</div>

{{-- ============ CHIFFRES ============ --}}
<section class="stats">
    <div class="container stats-grid">
        <div class="stat reveal"><i class="fa-solid fa-calendar-check"></i><b data-count="14">0</b><span>jours d'essai, sans carte</span></div>
        <div class="stat reveal" style="--d:.08s"><i class="fa-solid fa-gift"></i><b data-count="0">0</b><span>Ar pour démarrer</span></div>
        <div class="stat reveal" style="--d:.16s"><i class="fa-solid fa-calendar-plus"></i><b data-count="2">0</b><span>mois offerts en annuel</span></div>
        <div class="stat reveal" style="--d:.24s"><i class="fa-solid fa-file-export"></i><b data-count="100" data-suffix="%">0</b><span>de vos données exportables</span></div>
    </div>
</section>

{{-- ============ FONCTIONNALITÉS ============ --}}
<section id="fonctionnalites" class="light">
    <div class="container">
        <header class="section-head reveal">
            <span class="eyebrow">Fonctionnalités</span>
            <h2>Tout ce qu'il faut pour piloter votre activité</h2>
            <p>Du premier chronomètre à la facture payée, sans jongler entre cinq outils.</p>
        </header>

        <div class="bento">
            <article class="card reveal"><span class="ico"><i class="fa-solid fa-stopwatch"></i></span><h3>Suivi du temps</h3><p>Lancez le chronomètre en un clic, rattachez chaque minute à un projet et à un client.</p></article>
            <article class="card reveal" style="--d:.06s"><span class="ico"><i class="fa-solid fa-table-columns"></i></span><h3>Tâches, Kanban et jalons</h3><p>Organisez le travail, suivez les étapes clés et gardez le cap jusqu'à la livraison.</p></article>
            <article class="card reveal" style="--d:.12s"><span class="ico"><i class="fa-solid fa-file-invoice-dollar"></i></span><h3>Devis et factures PDF</h3><p>Forfait, à l'heure ou par projet. Des documents propres, prêts à envoyer.</p></article>
            <article class="card reveal" style="--d:.18s"><span class="ico"><i class="fa-solid fa-share-nodes"></i></span><h3>Espace client</h3><p>Un lien pour montrer l'avancement. Le client voit le projet, jamais vos tarifs ni vos heures.</p></article>
            <article class="card wide reveal"><span class="ico"><i class="fa-solid fa-chart-line"></i></span><h3>Rentabilité par projet</h3><p>Revenu, dépenses et heures par projet. Avec les plans supérieurs : coût du temps par membre, marge et taux horaire effectif.</p></article>
            <article class="card reveal" style="--d:.06s"><span class="ico"><i class="fa-solid fa-vault"></i></span><h3>Coffre d'accès chiffré</h3><p>Centralisez accès et mots de passe de vos clients, en sécurité.</p></article>
            <article class="card reveal" style="--d:.12s"><span class="ico"><i class="fa-solid fa-arrows-rotate"></i></span><h3>Factures récurrentes</h3><p>Maintenance, hébergement, abonnements : facturez sans y repenser.</p></article>
            <article class="card reveal" style="--d:.18s"><span class="ico"><i class="fa-solid fa-globe"></i></span><h3>Domaines &amp; SSL</h3><p>Ne ratez plus un renouvellement de domaine ou de certificat.</p></article>
            <article class="card reveal" style="--d:.24s"><span class="ico"><i class="fa-solid fa-users"></i></span><h3>Équipe et rôles</h3><p>Invitez vos collaborateurs et choisissez qui voit les finances.</p></article>
        </div>
    </div>
</section>

{{-- ============ À VOUS DE JOUER (animations jouables) ============ --}}
<section id="demo">
    <div class="container">
        <header class="section-head reveal">
            <span class="eyebrow">À vous de jouer</span>
            <h2>Testez l'outil… en vous amusant</h2>
            <p>Lancez le chrono, déplacez les tâches, battez le record de Facture Rush. Tout est cliquable.</p>
        </header>

        <div class="play-grid">

            {{-- Jeu 1 : chrono & gains --}}
            <article class="card play reveal" id="p-timer">
                <h3><i class="fa-solid fa-stopwatch"></i> Chrono &amp; gains</h3>
                <p class="sub">Lancez le chrono et regardez vos revenus grimper en direct.</p>
                <div class="clock" data-clock>00:00:00</div>
                <div class="earn"><span data-earn>0</span> <small>Ar gagnés</small></div>
                <label class="field">
                    <span>Taux horaire <output data-rate-out>25 000 Ar/h</output></span>
                    <input type="range" min="5000" max="100000" step="5000" value="25000" data-rate>
                </label>
                <label class="switch">
                    <input type="checkbox" data-turbo checked>
                    <i></i> Mode turbo (1 seconde = 1 minute)
                </label>
                <div class="row">
                    <button type="button" class="btn btn-primary" data-toggle><i class="fa-solid fa-play"></i><span>Démarrer</span></button>
                    <button type="button" class="btn btn-outline" data-reset><i class="fa-solid fa-rotate-left"></i>Remettre à zéro</button>
                </div>
            </article>

            {{-- Jeu 2 : Kanban jouable --}}
            <article class="card play reveal" style="--d:.08s">
                <h3><i class="fa-solid fa-table-columns"></i> Kanban jouable</h3>
                <p class="sub">Glissez les tâches d'une colonne à l'autre (ou utilisez la flèche) jusqu'à 100 % livré.</p>
                <div class="pk-top"><span id="pk-pct">20 % livré</span><button type="button" class="btn btn-outline" id="pk-reset"><i class="fa-solid fa-rotate-left"></i>Réinitialiser</button></div>
                <div class="pk-progress"><span id="pk-bar" style="--p:20%"></span></div>
                <div class="pk-board">
                    <div class="pk-col" data-col="todo">
                        <b>À faire <em>3</em></b>
                        <ul class="pk-list">
                            <li class="pk-card" draggable="true" data-id="1"><span>Maquette</span><button type="button" class="pk-next" aria-label="Faire avancer la tâche"><i class="fa-solid fa-arrow-right"></i></button></li>
                            <li class="pk-card" draggable="true" data-id="2"><span>Paiement MVola</span><button type="button" class="pk-next" aria-label="Faire avancer la tâche"><i class="fa-solid fa-arrow-right"></i></button></li>
                            <li class="pk-card" draggable="true" data-id="3"><span>Tests</span><button type="button" class="pk-next" aria-label="Faire avancer la tâche"><i class="fa-solid fa-arrow-right"></i></button></li>
                        </ul>
                    </div>
                    <div class="pk-col" data-col="doing">
                        <b>En cours <em>1</em></b>
                        <ul class="pk-list">
                            <li class="pk-card" draggable="true" data-id="4"><span>Intégration</span><button type="button" class="pk-next" aria-label="Faire avancer la tâche"><i class="fa-solid fa-arrow-right"></i></button></li>
                        </ul>
                    </div>
                    <div class="pk-col" data-col="done">
                        <b>Livré <em>1</em></b>
                        <ul class="pk-list">
                            <li class="pk-card" draggable="true" data-id="5"><span>Cahier des charges</span><button type="button" class="pk-next" aria-label="Remettre la tâche à faire"><i class="fa-solid fa-rotate-left"></i></button></li>
                        </ul>
                    </div>
                </div>
                <p class="pk-hint"><i class="fa-solid fa-hand-pointer"></i>Chaque tâche livrée déclenche des confettis.</p>
            </article>

            {{-- Jeu 3 : Facture Rush --}}
            <article class="card play play-wide reveal" id="p-game">
                <h3><i class="fa-solid fa-gamepad"></i> Facture Rush</h3>
                <p class="sub">30 secondes pour encaisser un maximum de factures. Attention aux bugs !</p>
                <div class="g-hud">
                    <span>Temps <b id="g-time">30</b></span>
                    <span>Score <b id="g-score">0</b></span>
                    <span>Record <b id="g-best">0</b></span>
                    <div class="g-legend">
                        <span class="l1"><i class="fa-solid fa-file-invoice-dollar"></i>+1</span>
                        <span class="l2"><i class="fa-solid fa-coins"></i>+3</span>
                        <span class="l3"><i class="fa-solid fa-bug"></i>−2</span>
                    </div>
                </div>
                <div class="g-field" id="g-field">
                    <div class="g-overlay" id="g-overlay">
                        <h4 id="g-title">Prêt à encaisser ?</h4>
                        <p id="g-text">Cliquez ou touchez les factures et les pièces avant qu'elles ne tombent. Évitez les bugs.</p>
                        <button type="button" class="btn btn-dark" id="g-start"><i class="fa-solid fa-play"></i><span>Jouer</span></button>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

{{-- ============ COMMENT ÇA MARCHE ============ --}}
<section id="comment" class="light">
    <div class="container">
        <header class="section-head reveal">
            <span class="eyebrow">Démarrage rapide</span>
            <h2>Opérationnel en moins de 5 minutes</h2>
        </header>
        <ol class="steps">
            <li class="reveal"><i>1</i><h3>Créez votre espace</h3><p>Nom, email, mot de passe. Vérification par lien ou code à 6 chiffres.</p></li>
            <li class="reveal" style="--d:.1s"><i>2</i><h3>Configurez en 5 étapes</h3><p>Agence, préférences, premier client, premier projet avec modèle (site web, mobile, CRM, e-commerce…).</p></li>
            <li class="reveal" style="--d:.2s"><i>3</i><h3>Travaillez et facturez</h3><p>Lancez le chrono, partagez l'avancement avec votre client, envoyez votre premier devis.</p></li>
        </ol>
        <p class="center reveal"><a href="{{ $registerUrl }}" class="btn btn-dark"><i class="fa-solid fa-rocket"></i> Créer mon espace gratuit</a></p>
    </div>
</section>

{{-- ============ À PROPOS ============ --}}
<section id="apropos">
    <div class="container about">
        <div class="reveal">
            <span class="eyebrow">À propos</span>
            <h2>Pensé par une agence, pour les agences et les freelances</h2>
            <p>{{ $appName }} est né d'un besoin simple : savoir précisément où passe le temps, ce que chaque projet rapporte et ce qu'il reste à facturer, sans usine à gaz.</p>
            <p>Conçu depuis Madagascar, l'outil parle aussi bien Ariary (MVola, Orange Money, Airtel Money) qu'euro et dollar, pour accompagner les équipes d'ici comme d'ailleurs.</p>
        </div>
        <ul class="values">
            <li class="reveal"><i class="fa-solid fa-lock-open"></i><b>Jamais d'otage</b><span>Même abonnement expiré, vous gardez l'accès en lecture et l'export de vos données.</span></li>
            <li class="reveal" style="--d:.08s"><i class="fa-solid fa-sliders"></i><b>Limites douces</b><span>Une limite atteinte bloque la création, jamais la consultation ni le travail en cours.</span></li>
            <li class="reveal" style="--d:.16s"><i class="fa-solid fa-tags"></i><b>Prix transparents</b><span>Quatre plans, une grille lisible, aucune surprise de facturation.</span></li>
            <li class="reveal" style="--d:.24s"><i class="fa-solid fa-shield-halved"></i><b>Vos clients, vos données</b><span>Chaque espace est strictement isolé des autres. Sauvegardes quotidiennes.</span></li>
        </ul>
    </div>
</section>

{{-- ============ TARIFS ============ --}}
<section id="tarifs" class="light">
    <div class="container">
        <header class="section-head reveal">
            <span class="eyebrow">Tarifs</span>
            <h2>Simple, lisible, sans engagement</h2>
            <p>Commencez gratuitement, passez au niveau supérieur quand votre activité le demande.</p>
        </header>

        <div class="toggles reveal">
            <div class="seg" role="group" aria-label="Période">
                <button type="button" data-per="m" aria-pressed="true">Mensuel</button>
                <button type="button" data-per="y" aria-pressed="false">Annuel <em>2 mois offerts</em></button>
            </div>
            <div class="seg" role="group" aria-label="Devise">
                <button type="button" data-cur="MGA" aria-pressed="true">Ariary (Ar)</button>
                <button type="button" data-cur="EUR" aria-pressed="false">Euro (€)</button>
                <button type="button" data-cur="USD" aria-pressed="false">Dollar ($)</button>
            </div>
        </div>

        <div class="plans">
            @foreach ($plans as $plan)
                <article class="plan reveal {{ $plan['featured'] ? 'featured' : '' }}" style="--d:{{ $loop->index * 0.08 }}s"
                         data-prices='@json($plan['prices'])'>
                    @if ($plan['featured']) <span class="ribbon"><i class="fa-solid fa-star"></i> Le plus choisi</span> @endif
                    <h3>{{ $plan['name'] }}</h3>
                    <p class="for">{{ $plan['for'] }}</p>
                    <div class="price">
                        <span class="amount">{{ number_format($plan['prices']['MGA'][0], 0, ',', ' ') }} Ar</span>
                        <span class="period">{{ $plan['prices']['MGA'][0] > 0 ? '/mois' : 'pour toujours' }}</span>
                    </div>
                    <p class="save" hidden>2 mois offerts</p>
                    <ul>
                        @foreach ($plan['features'] as $f)
                            <li>{{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ $registerUrl }}?plan={{ strtolower($plan['name']) }}"
                       class="btn {{ $plan['featured'] ? 'btn-dark' : 'btn-outline' }}"
                       data-plan-click="{{ strtolower($plan['name']) }}">{{ $plan['cta'] }}</a>
                </article>
            @endforeach
        </div>

        <p class="banner reveal"><i class="fa-solid fa-circle-info"></i>Sans engagement · Essai de 14 jours · Export de vos données à tout moment</p>

        <details class="compare reveal">
            <summary>Voir le tableau comparatif complet</summary>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Fonction</th>
                            @foreach ($plans as $plan)
                                <th class="{{ $plan['featured'] ? 'hl' : '' }}">{{ $plan['name'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparison as $row)
                            <tr>
                                <th scope="row">{{ $row[0] }}</th>
                                @foreach (array_slice($row, 1) as $i => $cell)
                                    <td class="{{ $i === 2 ? 'hl' : '' }}">
                                        @if ($cell === true) <span class="yes"><i class="fa-solid fa-check"></i></span>
                                        @elseif ($cell === false) <span class="no"><i class="fa-solid fa-minus"></i></span>
                                        @else {{ $cell }} @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <div class="included reveal">
            <h3>Inclus dans tous les plans</h3>
            <ul>
                <li><i class="fa-solid fa-stopwatch"></i>Suivi du temps</li>
                <li><i class="fa-solid fa-list-check"></i>Tâches</li>
                <li><i class="fa-solid fa-share-nodes"></i>Espace client</li>
                <li><i class="fa-solid fa-file-export"></i>Export</li>
                <li><i class="fa-solid fa-cloud-arrow-up"></i>Sauvegardes</li>
                <li><i class="fa-solid fa-rocket"></i>Mises à jour</li>
            </ul>
        </div>
    </div>
</section>

{{-- ============ FAQ ============ --}}
<section id="faq">
    <div class="container narrow">
        <header class="section-head reveal">
            <span class="eyebrow">FAQ</span>
            <h2>Questions fréquentes</h2>
        </header>
        <div class="faq">
            @foreach ($faqs as $faq)
                <details name="faq" class="reveal">
                    <summary>{{ $faq[0] }}</summary>
                    <p>{{ $faq[1] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CTA FINAL + CONTACT ============ --}}
<section id="contact" class="cta light">
    <span class="blob b1"></span><span class="blob b2"></span>
    <div class="container center reveal">
        <h2>Prêt à reprendre le contrôle de vos projets ?</h2>
        <p>Créez votre espace gratuit en moins de 5 minutes. Une question ? Écrivez-nous.</p>
        <div class="hero-cta" style="justify-content:center">
            <a href="{{ $registerUrl }}" class="btn btn-primary">Commencer gratuitement <i class="fa-solid fa-arrow-right"></i></a>
            <a href="{{ $loginUrl }}" class="btn btn-ghost"><i class="fa-solid fa-right-to-bracket"></i> J'ai déjà un compte</a>
        </div>
        <p class="mail"><i class="fa-solid fa-envelope"></i><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
    </div>
</section>

@endsection