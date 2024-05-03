<?php

namespace App\DataFixtures;

use App\Entity\Taille;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Etat;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DataFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private CategorieRepository $categorieRepository
    ) {
    }

    public static function getGroups(): array
    {
        return ['DataFixtures'];
    }

    public function load(ObjectManager $manager): void
    {

        // Définir les catégories
        $categories = [
            'Chaussures' => 'La collection de chaussures propose des bottes, ballerines, chaussures à talon, mocassins, chaussures oxford, sandales et claquettes. Les chaussures sont proposées par des marques de créateurs telles que Balenciaga, Prada, Hermès, Louis Vuitton, Timberland, Versace, Crocs, Birkenstock, Chanel, Dior, Gucci et Dr. Martens. La collection de chaussures comprend des chaussures de course, des chaussures de golf, des bottes de randonnée, des chaussures de football et des chaussures de basketball. Les chaussures sont fabriquées à partir de matériaux tels que le cuir, le caoutchouc, les textiles, les matériaux synthétiques et la mousse. Les chaussures sont disponibles dans divers coloris et designs.',
            'Sacs' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'Vêtements' => 'De Supreme, Nike, adidas, et Travis Scott à Bape et Fear of God, il existe divers vêtements disponibles pour tous. Il y a des tenues de créateurs et des looks streetwear disponibles pour tous les âges et tous les genres. Nous offrons un peu de tout, des pulls en cachemire neufs ou d’occasion aux pantalons de créateurs, robes, costumes, sweat-shirts et bien plus encore. Des options de vêtements intemporels et tendance sont également disponibles auprès d’autres marques, telles que Supreme, North Face, Nike et adidas.'
        ];

        foreach ($categories as $categorie => $description) {
            $entity = new Categorie();
            $entity->setName($categorie);
            $entity->setDescription($description);

            $manager->persist($entity);
        }

        $manager->flush();

        $produits = [
            'Chaussures' => [
                [
                    'name' => 'Sneaker LV Rush', 'description' => "Dévoilée lors du défilé Croisière 2024, cette sneaker LV Rush présente un mélange de matières dont du cuir de veau lisse et velours. Le directeur artistique, Nicolas Ghesquière, s'est inspiré des chaussures de trail pour la concevoir. Elle intègre parmi d'autres détails phares un accessoire LV Circle métallique et une semelle extérieure en forme de vague.", "image" => "rush1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Beige',
                        'Genre' => 'Homme'
                    ],
                    'photos' => [
                        'rush1.avif', 'rush2.avif', 'rush3.avif', 'rush4.avif'
                    ]
                ],
                [
                    'name' => 'Sneaker LV Skate', 'description' => "Cette sneaker LV Skate se décline dans une édition féminine réalisée en cuir de veau et en résille technique. Ce modèle inspiré des années 90 se distingue par une tige bicolore élaborée agrémentée de fleurs de Monogram. Il se dote également d'une cheville matelassée, de lacets doubles techniques et d'une semelle extérieure bicolore en gomme ornée de fleurs de Monogram.", "image" => "skate1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Bleu',
                        'Genre' => 'Homme'
                    ],
                    'photos' => [
                        'skate1.avif', 'skate2.avif', 'skate3.avif', 'skate4.avif'
                    ]
                ],
                [
                    'name' => 'Sneaker LV Trainer', 'description' => "Emblème de la collection Homme, cette sneaker LV Trainer a été redessinée pour les femmes. Créée par Virgil Abloh, elle s'inspire des modèles vintage de basket-ball. Cette version en denim Monogram présente une attache velcro agrémentée de fleurs de Monogram.", "image" => "trainer1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Noir',
                        'Genre' => 'Autres'
                    ],
                    'photos' => [
                        'trainer1.avif', 'trainer2.avif', 'trainer3.avif', 'trainer4.avif'
                    ]
                ],
                [
                    'name' => 'Escarpin ouvert Blossom', 'description' => "Cet escarpin ouvert Blossom en chevreau velours, est sublimé d'une bride réglable en cuir naturel emblématique de Louis Vuitton à l'arrière. Celle-ci porte la signature de la Maison ainsi qu'un clou gravé en métal doré. Le talon inspiré de la fleur de Monogram ronde est assorti à la tige pour composer une allure ultra-raffinée.", "image" => "blossom1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Vert',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'blossom1.avif', 'blossom2.avif', 'blossom3.avif', 'blossom4.avif'
                    ]
                ],
                [
                    'name' => 'Mocassin Academy', 'description' => "Pour la saison, ce mocassin Academy est revisité en cuir de veau lisse. Il s'orne d'un accessoire mousqueton oversize en métal doré gravé de la signature Louis Vuitton. Inspiré par les souliers masculins classiques, ce modèle repose sur une semelle extérieure épaisse en microcellulaire léger qui assure un confort exceptionnel.", "image" => "academy1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Noir',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'academy1.avif', 'academy2.avif', 'academy3.avif', 'academy4.avif'
                    ]
                ],
                [
                    'name' => 'Sneaker LV Stadium', 'description' => "Cette sneaker LV Stadium en tweed à motif Monogram se distingue par son style nautique estival. Ce modèle d'inspiration vintage est souligné d'une bordure en cuir de veau velours à l'avant et en cuir naturel emblématique de Louis Vuitton à l'arrière. Il se dote de lacets blancs classiques et d'une semelle extérieure souple en gomme estampée de la signature de la Maison.", "image" => "stadium1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Beige',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'stadium1.avif', 'stadium2.avif', 'stadium3.avif', 'stadium4.avif'
                    ]
                ],
                [
                    'name' => 'Desert boot Lauréate à plateforme', 'description' => "Revisitée en denim Monogram, cette desert boot Lauréate à plateforme s'agrémente d'une garniture en cuir de la même couleur. Sur la languette, une étiquette en cuir naturel est embossée de la signature Louis Vuitton. Assortie à la tige, la semelle extérieure crantée en gomme est ornée d'une rangée de LV Initiales évoquant les bords à lozines des malles historiques de la Maison.", "image" => "desert1.avif", 'caracteristiques' => [
                        'Marque' => 'Louis Vuitton',
                        'Taille' => '36',
                        'Couleur' => 'Bleu',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'desert1.avif', 'desert2.avif', 'desert3.avif', 'desert4.avif'
                    ]
                ],
                [
                    'name' => 'Opyum sandales en cuir verni', 'description' => "Sandales à talon Cassandre, munies d'une bride ajustable à la cheville.", "image" => "opyum1.jpg", 'caracteristiques' => [
                        'Marque' => 'Yves Saint Laurent',
                        'Taille' => '36',
                        'Couleur' => 'Noir',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'opyum1.jpg', 'opyum2.jpg', 'opyum3.jpg', 'opyum4.jpg'
                    ]
                ],
                [
                    'name' => 'Jodie sandales à plateforme en cuir lisse', 'description' => "Sandales à plateforme et bout ouvert en amande, dotées d'une bride cheville ajustable et d'un talon carré couvert.", "image" => "jodie1.jpg", 'caracteristiques' => [
                        'Marque' => 'Yves Saint Laurent',
                        'Taille' => '36',
                        'Couleur' => 'Blanc',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'jodie1.jpg', 'jodie2.jpg', 'jodie3.jpg'
                    ]
                ],
                [
                    'name' => 'Babylone sandales en cuir lisse', 'description' => "Sandales à talon aiguille ornées du CASSANDRE, munies d’un bout en amande et de brides cheville à lacets.", "image" => "babylone1.jpg", 'caracteristiques' => [
                        'Marque' => 'Yves Saint Laurent',
                        'Taille' => '36',
                        'Couleur' => 'Noir',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'babylone1.jpg', 'babylone2.jpg', 'babylone3.jpg'
                    ]
                ],
                [
                    'name' => 'Peep escarpins en crêpe satin', 'description' => "Escarpins à talon aiguille munis d'un bout ouvert en amande orné d’une plaque carrée en crêpe de Chine.", "image" => "peep1.jpg", 'caracteristiques' => [
                        'Marque' => 'Yves Saint Laurent',
                        'Taille' => '36',
                        'Couleur' => 'Blanc',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'peep1.jpg', 'peep2.jpg', 'peep3.jpg'
                    ]
                ],
                [
                    'name' => 'Opyum slingbacks en cuir à tannage végétal', 'description' => "Sandales à talon Cassandre, munies d'un bout carré en amande et d'une bride arrière ajustable.", "image" => "slingbacks1.jpg", 'caracteristiques' => [
                        'Marque' => 'Yves Saint Laurent',
                        'Taille' => '38',
                        'Couleur' => 'Marron',
                        'Genre' => 'Femme'
                    ],
                    'photos' => [
                        'slingbacks1.jpg', 'slingbacks2.jpg', 'slingbacks3.jpg'
                    ]
                ],
                [
                    'name' => 'Mocassins Paris', 'description' => "Mocassins en chèvre, rehaussés d'une pièce métallique signature, pour une allure élégante du matin au soir. Fabriqué en Italie", "image" => "mocassinsParis1.jpg", 'caracteristiques' => [
                        'Marque' => 'Hermès',
                        'Taille' => '38',
                        'Couleur' => 'Noir',
                        'Genre' => 'Homme'
                    ],
                    'photos' => [
                        'mocassinsParis1.jpg', 'mocassinsParis2.jpg', 'mocassinsParis3.jpg', 'mocassinsParis4.jpg'
                    ]
                ],
            ],
            'Sacs' => [
                ['name' => 'Sac Neverfull MM', 'description' => "Confectionné en toile Monogram souple avec une garniture en cuir de vache naturel, ce sac Neverfull MM conjugue silhouette intemporelle et détails emblématiques. Ultra spacieux sans être trop volumineux, il présente des lacets à resserrer sur le côté pour obtenir une allure élégante ou à desserrer afin de créer un look plus décontracté. Les poignées fines et confortables se glissent aisément à l'épaule ou au bras. Doublé de textile coloré, ce modèle comporte une pochette amovible qui peut également être utilisée comme une poche supplémentaire.", "image" => "neverfull1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'M',
                    'Couleur' => 'Marron',
                    'Genre' => 'Femme'
                ],
                'photos' => [
                    'neverfull1.avif', 'neverfull2.avif', 'neverfull3.avif', 'neverfull4.avif'
                ]],
                ['name' => 'Sac Noé BB', 'description' => "Issu de la collection Nautical, ce sac seau Noé BB se compose de cuir de veau Épi souple embossé de son motif ondulé caractéristique. Il s'associe à du cuir de vache lisse autour de la base et sur la bandoulière détachable pour garantir résistance et élégance. L'intérieur révèle une pochette amovible.", "image" => "noe1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'S',
                    'Couleur' => 'Rouge',
                    'Genre' => 'Femme'
                ],
                'photos' => [
                    'noe1.avif', 'noe2.avif', 'noe3.avif'
                ]],
                ['name' => 'Sac Keepall Bandoulière 50', 'description' => "Le directeur artistique Pharrell Williams revisite le sac Keepall Bandoulière 50 avec cette version en cuir de veau Damier Scuba jaune éclatant. Le cuir souple est embossé du motif Damier et doublé de néoprène pour prêter à la pièce une allure unique. Les poignées supérieures et les bandes latérales en cuir noir soulignent l'esprit nautique et sportif de l'ensemble.", "image" => "keepall1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'L',
                    'Couleur' => 'Jaune',
                    'Genre' => 'Homme'
                ],
                'photos' => [
                    'keepall1.avif', 'keepall2.avif', 'keepall3.avif'
                ]],
                ['name' => 'Sac à dos Christopher MM', 'description' => "Idéal au quotidien, ce sac à dos Christopher MM est un modèle visuellement remarquable qui évoque les grands espaces. Il présente un intérieur spacieux.", "image" => "christopher1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'L',
                    'Couleur' => 'Noir',
                    'Genre' => 'Homme'
                ],
                'photos' => [
                    'christopher1.avif', 'christopher2.avif', 'christopher3.avif','christopher4.avif'
                ]],
            ],
            'Vêtements' => [
                ['name' => 'Surchemise de soirée manches longues en soie mélangée', 'description' => "Compagne idéale des tenues de soirée, cette chemise fluide façon pyjama allie décontraction et élégance. Conçue dans un jacquard de soie mélangée texturé, elle est habillée d’un motif Wavy Damier discrètement orné de détails Monogram, revisitant le motif historique de la Maison. Cette pièce peut être portée avec le pantalon à taille élastique assorti pour créer un ensemble sophistiqué.", "image" => "surchemise1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'M',
                    'Couleur' => 'Bleu',
                    'Genre' => 'Homme'
                ],
                'photos' => [
                    'surchemise1.avif', 'surchemise2.avif', 'surchemise3.avif','surchemise4.avif'
                ]],
                ['name' => 'Blouson varsity en cuir mélangé', 'description' => "S'inspirant du passé de percussionniste de Pharrell Williams au sein de l'orchestre du lycée Princess Anne en Virginie, ce blouson varsity rouge vif allie tradition américaine et savoir-faire Louis Vuitton. Issu du défilé Printemps-Été 2024, ce modèle emblématique s'habille d'un motif Damier ton sur ton embossé sur ses manches en cuir de veau blanc. Le dos s'agrémente d'une signature Louis Vuitton brodée de perles, tandis qu'un patch PA brodé de cristaux sur la poitrine évoque la jeunesse de Pharrell Williams.", "image" => "varsity1.avif", 'caracteristiques' => [
                    'Marque' => 'Louis Vuitton',
                    'Taille' => 'M',
                    'Couleur' => 'Rouge',
                    'Genre' => 'Autres'
                ],
                'photos' => [
                    'varsity1.avif', 'varsity2.avif', 'varsity3.avif','varsity4.avif'
                ]],
            ],
        ];

        foreach ($produits as $categorie => $items) {
            foreach ($items as $item) {

                $entity = new Produit();
                $entity->setCategorie($this->categorieRepository->getOne('name=' . $categorie));
                $entity->setName($item['name']);
                $entity->setDescription($item['description']);
                $entity->setCaracteristiques($item['caracteristiques']);
                $entity->setPathImage($item['image']);
                if (isset($item['photos'])) {
                    $entity->setPhotos($item['photos']);
                }


                $manager->persist($entity);
            }
        }

        $manager->flush();

        // Récupérer les catégories
        $sacsCategorie = $this->categorieRepository->findOneBy(['name' => 'Sacs']);
        $vetementsCategorie = $this->categorieRepository->findOneBy(['name' => 'Vêtements']);
        $chaussuresCategorie = $this->categorieRepository->findOneBy(['name' => 'Chaussures']);

        // Ajouter des filtres pour les sacs
        $this->addTailles($manager, $sacsCategorie, [
            ['name' => 'S', 'rank' => 1],
            ['name' => 'M', 'rank' => 2],
            ['name' => 'L', 'rank' => 3],

        ]);

        // Ajouter des filtres pour les vêtements
        $this->addTailles($manager, $vetementsCategorie, [
            ['name' => 'XXS', 'rank' => 1],
            ['name' => 'XS', 'rank' => 2],
            ['name' => 'S', 'rank' => 3],
            ['name' => 'M', 'rank' => 4],
            ['name' => 'L', 'rank' => 5],
            ['name' => 'XL', 'rank' => 6],
            ['name' => 'XXL', 'rank' => 7],
        ]);

        // Ajouter des filtres pour les chaussures
        $this->addTailles($manager, $chaussuresCategorie, [
            ['name' => '36', 'rank' => 1],
            ['name' => '37', 'rank' => 2],
            ['name' => '38', 'rank' => 3],
            ['name' => '39', 'rank' => 4],
            ['name' => '40', 'rank' => 5],
            ['name' => '41', 'rank' => 6],
            ['name' => '42', 'rank' => 7],
            ['name' => '43', 'rank' => 8],
        ]);

        $this->addEtat($manager, [
            ['name' => 'Neuf', 'rank' => 1],
            ['name' => 'Très bon état', 'rank' => 2],
            ['name' => 'Bon état', 'rank' => 3],

        ]);
    }

    private function addTailles(ObjectManager $manager, $categorie, $filtres)
    {
        foreach ($filtres as $filtreData) {
            $filtre = new Taille();
            $filtre->setCategorie($categorie);
            $filtre->setName($filtreData['name']);
            $filtre->setRank($filtreData['rank']);

            $manager->persist($filtre);
        }

        $manager->flush();
    }

    private function addEtat(ObjectManager $manager, $filtres)
    {
        foreach ($filtres as $filtreData) {
            $filtre = new Etat();
            $filtre->setName($filtreData['name']);
            $filtre->setRank($filtreData['rank']);

            $manager->persist($filtre);
        }

        $manager->flush();
    }
}
