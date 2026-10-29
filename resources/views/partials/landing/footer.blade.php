<footer class="footer">
    <div class="container footer-grid">
        <div>
            <a href="#accueil" class="brand" aria-label="{{ $appName }}">
                <span class="brand-logo">
                    <img src="{{ asset('logo.png') }}" alt="Logo {{ $appName }}" height="34" loading="lazy">
                </span>
                <span class="sr-only">{{ $appName }}</span>
            </a>
            <p class="muted-l">{{ $appName }} : projets, temps, devis, factures et espace client dans un seul outil. Conçu pour les freelances et les agences.</p>
        </div>
        <div>
            <h4>Plan du site</h4>
            <ul>
                <li><a href="#fonctionnalites"><i class="fa-solid fa-chevron-right"></i>Fonctionnalités</a></li>
                <li><a href="#demo"><i class="fa-solid fa-gamepad"></i>Jouer</a></li>
                <li><a href="#comment"><i class="fa-solid fa-chevron-right"></i>Comment ça marche</a></li>
                <li><a href="#apropos"><i class="fa-solid fa-chevron-right"></i>À propos</a></li>
                <li><a href="#tarifs"><i class="fa-solid fa-chevron-right"></i>Tarifs</a></li>
                <li><a href="#faq"><i class="fa-solid fa-chevron-right"></i>FAQ</a></li>
            </ul>
        </div>
        <div>
            <h4>Compte</h4>
            <ul>
                <li><a href="{{ $loginUrl }}"><i class="fa-solid fa-right-to-bracket"></i>Connexion</a></li>
                <li><a href="{{ $registerUrl }}"><i class="fa-solid fa-user-plus"></i>Inscription</a></li>
                <li><a href="#contact"><i class="fa-solid fa-headset"></i>Contact</a></li>
                <li><a href="{{ url('/sitemap.xml') }}"><i class="fa-solid fa-sitemap"></i>Sitemap XML</a></li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li><a href="mailto:{{ $contactEmail }}"><i class="fa-solid fa-envelope"></i>{{ $contactEmail }}</a></li>
                <li><a href="{{ $termsUrl }}"><i class="fa-solid fa-file-contract"></i>Conditions d'utilisation</a></li>
                <li><a href="{{ $privacyUrl }}"><i class="fa-solid fa-user-shield"></i>Confidentialité</a></li>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© {{ date('Y') }} {{ $appName }}. Tous droits réservés.</span>
        <span><i class="fa-solid fa-database"></i>Vos données vous appartiennent. Export à tout moment.</span>
    </div>
</footer>