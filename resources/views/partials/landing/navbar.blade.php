<header class="nav" id="nav">
    <div class="container">
        <a href="{{ url('/') }}#accueil" class="brand" aria-label="{{ $appName }}">
            <span class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="Logo {{ $appName }}" height="34">
            </span>
            <span class="sr-only">{{ $appName }}</span>
        </a>

        <button class="nav-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav-menu">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-menu" id="nav-menu">
            <ul class="nav-links">
                <li><a href="#fonctionnalites">Fonctionnalités</a></li>
                <li><a href="#demo" class="hot"><i class="fa-solid fa-gamepad"></i>Jouer</a></li>
                <li><a href="#comment">Comment ça marche</a></li>
                <li><a href="#apropos">À propos</a></li>
                <li><a href="#tarifs">Tarifs</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-cta">
                <a href="{{ $loginUrl }}" class="btn btn-ghost"><i class="fa-solid fa-right-to-bracket"></i> Connexion</a>
                <a href="{{ $registerUrl }}" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> S'inscrire</a>
            </div>
        </div>
    </div>
</header>