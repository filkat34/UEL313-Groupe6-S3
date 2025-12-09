# UEL313 : Bibliothèques logicielles - GROUPE 6 - S3

## Membres du groupe

| Etudiant.e  |   Alias    |
| :---------: | :--------: |
| Mathilde C. | Clouddy23  |
|   Kamo G.   | Spaghette5 |
| Mathieu L.  |  mathleys  |
| Filippos K. |  filkat34  |

## Objectifs

- [x] Assurer la maintenance corrective et évolutive d'une application existante
- [x] Savoir utiliser le client git et la plateforme Github en vue de collaborer au sein d'une équipe de développement.

## Environnement de développement

- Cloner ce dépôt GIT sur votre machine.
- Suivre le guide d'installation de l'environnement docker (pdf fourni dans les ressources de l'UE) en remplaçant lors de l'étape "Run a new container" le "Host path" par le chemin vers le dossier cloné du dépôt sur votre machine.

## Principe général de collaboration

### Répartition du travail

|  Flux RSS  | Page "Links"   |  Refonte UI       |
| :------:   | :------------:  | :------:          |
| Filippos   |    Mathilde ?   |   Kamo, Mathieu ? |

### Calendrier

| Code Review n. | Date   |                                                                          Objectif                                                         |
| :------------: | :---:  |:-------------------------------------------------------------------------------------------------------------------------------           |
|       1        | 11/12   | Phase de documentation et de réflexion sur la façon d'implémenter la fonctionnalité. Décrire le choix d'implémentation retenu ci-dessous. |
|       2        | 13/12   | Phase de développement de chaque fonctionnalité sur une branche distincte.                                                                |
|       3        | 13/12   | Relecture des branches, fusion et tests manuels fonctionnels.                                                                             |

## Phase de documentation et de réflexion

Ci-dessous sont explicitées les implémentations choisies pour chaque intervention évolutive sur l'application.

### Flux RSS
Les cadriciels fournissent souvent des modules spécifiques pour la génération de flux RSS comme (sfeed)[https://symfony.com/legacy/doc/cookbook/1_1/fr/syndication] pour Symfony. Vu la simplicité du fonctionnement de cette application, nous avons décidé de ne pas avoir recours à l'un de ces modules mais de mettre en place nous-mêmes le flux RSS en suivant le protocole d'implémentation suivant :
* Création une nouvelle route pour le flux RSS `/feed.xml`  qui servira le flux RSS.
* Ajout une méthode DAO pour récupérer les 15 derniers liens dans `LinkDAO.php`
* Création un nouveau contrôleur `RssFeedController.php` qui récupérer les 15 derniers liens grâce à la méthode DAO précédemment implémentée et qui génère le fichier xml du flux à partir des liens récupérés.

### Page de liens
### Refonte UI

## Phase de développement

Plusieurs issues ont été identifiées en fonction des fonctionnalités à implémenter :

1. Chaque membre de l'équipe s'assigne une issue en fonction de son choix dans la répartition du travail.
2. Il crée une branche sur laquelle il travaille sur l'issue choisie en lui donnant un nom correspondant à ce qu'il implémente. Exemples : `feature/fluxRSS`, `feature/pagelinks`, etc.
3. Une fois son travail fini, il fait une demande de tirage et dans la description, ne pas oublier de lier la demande à une issue en mettant "Fixes #[numéro de l'issue concernée]" (par exemple : "Fixes #11"). Github se chargera de fermer l'issue en question une fois la fusion de la demande faite.

## Tests manuels fonctionnels
