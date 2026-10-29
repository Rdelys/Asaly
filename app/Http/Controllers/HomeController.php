<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        // TODO : remplacer par Plan::with('prices','limits')->get() (voir section 14 du cahier des charges)
        // prices[devise] = [mensuel, annuel] — annuel = 10 mois payés (SAAS-P2)
        $plans = [
            [
                'name' => 'Gratuit', 'for' => 'Pour découvrir et démarrer', 'featured' => false,
                'cta' => 'Commencer gratuitement', 'trial' => false,
                'prices' => ['MGA' => [0, 0], 'EUR' => [0, 0], 'USD' => [0, 0]],
                'features' => [
                    '1 utilisateur, 3 projets actifs',
                    '5 clients, 5 devis/factures par mois',
                    'Chrono, tâches et Kanban illimités',
                    'Espace client (avec badge)',
                    '200 Mo de stockage',
                    'Export de toutes vos données',
                ],
            ],
            [
                'name' => 'Pro', 'for' => 'Pour le freelance qui facture', 'featured' => false,
                'cta' => 'Essayer 14 jours', 'trial' => true,
                'prices' => ['MGA' => [25000, 250000], 'EUR' => [9, 90], 'USD' => [9, 90]],
                'features' => [
                    'Projets, clients et documents illimités',
                    'Espace client en marque blanche',
                    'PDF sans filigrane',
                    'Coffre d\'accès chiffré',
                    'Factures récurrentes et rentabilité',
                    '5 Go de stockage, 500 emails/mois',
                ],
            ],
            [
                'name' => 'Équipe', 'for' => 'Pour la petite agence', 'featured' => true,
                'cta' => 'Essayer 14 jours', 'trial' => true,
                'prices' => ['MGA' => [59000, 590000], 'EUR' => [19, 190], 'USD' => [19, 190]],
                'features' => [
                    '5 utilisateurs inclus',
                    'Rôles et permissions finances',
                    'Rentabilité complète (marge, taux horaire)',
                    'Journal d\'activité 1 an',
                    '20 Go de stockage, 2 000 emails/mois',
                    'Support email 24 h',
                ],
            ],
            [
                'name' => 'Agence', 'for' => 'Pour les structures qui grandissent', 'featured' => false,
                'cta' => 'Essayer 14 jours', 'trial' => true,
                'prices' => ['MGA' => [120000, 1200000], 'EUR' => [39, 390], 'USD' => [39, 390]],
                'features' => [
                    '15 utilisateurs inclus',
                    'Domaine personnalisé pour la page client',
                    'API et webhooks (à venir)',
                    'Journal d\'activité 2 ans',
                    '100 Go de stockage, 10 000 emails/mois',
                    'Support prioritaire 12 h',
                ],
            ],
        ];

        // true = inclus, false = non inclus, string = valeur affichée
        $comparison = [
            ['Utilisateurs inclus', '1', '1', '5', '15'],
            ['Utilisateur supplémentaire', false, false, '+3 € / +15 000 Ar', '+2 € / +10 000 Ar'],
            ['Projets actifs', '3', 'Illimité', 'Illimité', 'Illimité'],
            ['Clients', '5', 'Illimité', 'Illimité', 'Illimité'],
            ['Devis et factures / mois', '5', 'Illimité', 'Illimité', 'Illimité'],
            ['Stockage de fichiers', '200 Mo', '5 Go', '20 Go', '100 Go'],
            ['Emails envoyés / mois', '30', '500', '2 000', '10 000'],
            ['Chrono, tâches, Kanban, jalons', true, true, true, true],
            ['Espace client (avancement)', 'Avec badge', 'Marque blanche', 'Marque blanche', 'Marque blanche'],
            ['PDF des documents', 'Filigrane', 'Sans filigrane', 'Sans filigrane', 'Sans filigrane'],
            ['Renouvellements (domaines, SSL…)', '3 éléments', 'Illimité', 'Illimité', 'Illimité'],
            ['Coffre d\'accès chiffré', false, true, true, true],
            ['Factures récurrentes', false, true, true, true],
            ['Rentabilité par projet', false, 'Basique', 'Complète', 'Complète'],
            ['Rôles et permission finances', false, false, true, true],
            ['Journal d\'activité', false, '30 jours', '1 an', '2 ans'],
            ['Export CSV et PDF', true, true, true, true],
            ['Domaine personnalisé', false, false, false, true],
            ['API et webhooks', false, false, false, 'Bientôt'],
            ['Support', 'Centre d\'aide', 'Email 48 h', 'Email 24 h', 'Prioritaire 12 h'],
            ['Essai gratuit', false, '14 jours', '14 jours', '14 jours'],
        ];

        $faqs = [
            ['Puis-je essayer avant de payer ?', 'Oui. Le plan gratuit est sans limite de durée et les plans payants ont un essai de 14 jours, sans carte bancaire.'],
            ['Que se passe-t-il à la fin de l\'essai ?', 'Votre espace repasse automatiquement au plan gratuit. Rien n\'est supprimé : ce qui dépasse les limites passe simplement en lecture seule.'],
            ['Puis-je changer de plan ou annuler ?', 'À tout moment depuis vos paramètres, sans appeler le support. Une hausse de plan est immédiate (au prorata), une baisse prend effet à la fin de la période payée.'],
            ['Comment payer à Madagascar ?', 'Par MVola, Orange Money, Airtel Money ou virement local, en Ariary. Un rappel d\'échéance vous est envoyé avant chaque renouvellement.'],
            ['Et si je suis à l\'international ?', 'Paiement par carte en euro ou en dollar, avec portail de facturation pour changer de carte et facture téléchargeable à chaque paiement.'],
            ['Mes données m\'appartiennent-elles ?', 'Oui. Vous pouvez les exporter à tout moment (CSV et PDF) et demander leur suppression. Même abonnement expiré, vous gardez la lecture et l\'export.'],
            ['Mes clients voient-ils mes tarifs ou mes heures ?', 'Non. La page client n\'affiche que l\'avancement du projet, en lecture seule.'],
            ['Puis-je ajouter des collaborateurs ?', 'Oui, à partir du plan Équipe. Des utilisateurs supplémentaires peuvent être ajoutés à tout moment.'],
            ['Y a-t-il des frais cachés ?', 'Non. Le prix affiché est le prix payé, les taxes éventuelles sont précisées avant le paiement.'],
            ['Puis-je être remboursé ?', 'Oui, dans les 14 jours suivant le premier paiement d\'un abonnement.'],
        ];

        return view('home', compact('plans', 'comparison', 'faqs'));
    }
}