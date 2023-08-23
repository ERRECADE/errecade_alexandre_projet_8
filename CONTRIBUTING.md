# CONTRIBUTING

Bienvenue dans le dépôt TO DO LIST APP ! Nous vous remercions de votre intérêt pour contribuer à notre projet. Ce fichier CONTRIBUTING.md sert de guide pour vous aider à comprendre comment contribuer de manière efficace.

## Objectif de CONTRIBUTING.md

Le but de ce fichier est de fournir des directives et des instructions aux personnes souhaitant contribuer au projet. Il décrit le processus de contribution, les conventions de codage et autres informations pertinentes afin d'assurer une collaboration harmonieuse entre les contributeurs.

## Pourquoi CONTRIBUTING.md est-il important ?

Le fichier CONTRIBUTING.md revêt une importance cruciale car il permet de maintenir une approche structurée et organisée des contributions. Il établit des attentes claires pour les contributeurs et garantit que tous sont sur la même longueur d'onde en ce qui concerne le style du code, les standards de documentation et les lignes directrices générales du projet. En suivant ces directives, nous pouvons rationaliser le processus de contribution et maintenir la qualité et la cohérence du projet.

Nous vous encourageons vivement à lire attentivement ce fichier avant de faire des contributions. Si vous avez des questions ou besoin de clarifications supplémentaires, n'hésitez pas à contacter notre équipe.

Merci de votre intérêt pour la contribution à TO DO LIST APP ! Nous apprécions votre soutien et attendons avec impatience vos précieuses contributions.

Bon développement !


## Participer au projet

Avant de contribuer à ce projet, veuillez lire l'intégralité de ce document afin de comprendre la structure du code et les éventuelles commandes nécessaires pour faire fonctionner le projet.

Pour commencer, téléchargez le projet depuis la branche Main disponible ici : [https://github.com/ERRECADE/errecade_alexandre_projet_8].
Ensuite, installez le projet en utilisant les commandes suivantes :

```bash
symfony install
symfony bin/console doctrine:database:create 
symfony console make:migration

```
Veuillez vérifier attentivement la version de PHP requise par le projet pour vous assurer que vous utilisez la version appropriée sur votre ordinateur (ne modifiez pas la version du projet à moins qu'un nouveau ticket sur le dépôt GitHub ne le demande).

Pour ce projet, vous devez avoir des compétences en PHP/Symfony ainsi qu'en développement front-end.

## Soumettre une contribution 
Si vous souhaitez contribuer au projet, veuillez suivre ces étapes :

Fork du dépôt sur GitHub.
Créez une branche distincte pour votre contribution.
Effectuez les modifications nécessaires dans votre branche.
Testez soigneusement vos modifications pour vous assurer qu'elles fonctionnent correctement.
Soumettez une pull request en expliquant clairement les changements apportés et leur objectif.
Attendez que votre pull request soit examinée et discutée.
Nous apprécions grandement vos contributions et nous efforcerons de les examiner et de vous fournir un retour d'ici peu.

N'hésitez pas à nous contacter si vous avez des questions ou besoin d'aide supplémentaire.

Merci de votre intérêt pour ce projet et nous nous réjouissons de vos contributions !



## Structure du projet

Le projet est organisé en plusieurs parties :

- Le dossier `app` contient toutes les configurations dans le dossier `config`. Vous trouverez également les fichiers pour le front-end dans le dossier `resource`.
- Le dossier `src` contient les contrôleurs (`controllers`), les entités (`entity`), et les formulaires (`form`).
- Le dossier `tests` est dédié aux tests. Vous pouvez y voir, ajouter ou modifier les tests (veuillez noter que les tests ne doivent être modifiés que si vous avez modifié les contrôleurs correspondants).
- Enfin, si vous souhaitez ajouter des éléments ou des fonctionnalités, veuillez les documenter dans le fichier `README.md`.

Nous vous encourageons à explorer ces différents dossiers et à respecter la structure du projet lors de vos contributions.

Assurez-vous de consulter le fichier `README.md` pour des instructions plus détaillées sur l'utilisation et la contribution au projet.

Si vous avez des questions supplémentaires concernant la structure du projet, n'hésitez pas à les poser.

Merci pour votre participation au projet !


## Conventions de codage

Nous suivons une approche simple pour les conventions de codage, en respectant l'architecture MVC (Modèle-Vue-Contrôleur) pour maintenir la cohérence du projet.

### Structure du code

- Les contrôleurs (`controllers`) sont responsables de la logique métier et de la gestion des requêtes et réponses.
- Les entités (`entities`) représentent les objets du modèle et les structures de données.
- Les formulaires (`forms`) sont utilisés pour la validation et la gestion des données utilisateur.
- Les vues (`views`) sont responsables de l'affichage des données au format HTML.

### Nommage des fichiers et des variables

- Utilisez des noms de fichiers et de dossiers significatifs et explicites.
- Privilégiez la notation en camelCase pour les noms de fichiers et de variables (par exemple, `nomDuFichier.php`, `nomDeVariable`).
- Pour les classes, utilisez la notation en PascalCase (par exemple, `MaClasse`).
- Respectez les conventions de nommage des frameworks ou bibliothèques utilisés.

### Style de code

- Indentez votre code avec des tabulations ou des espaces pour améliorer la lisibilité.
- Utilisez des commentaires pertinents pour expliquer les parties complexes ou les décisions de conception.
- Limitez la longueur des lignes de code pour faciliter la lecture (généralement moins de 80 ou 100 caractères).

### Documentation

- Documentez votre code pour faciliter la compréhension et la maintenance.
- Ajoutez des commentaires explicatifs pour décrire les fonctionnalités, les paramètres de fonction, les valeurs de retour, etc.
- N'oubliez pas de mettre à jour la documentation existante lorsque vous apportez des modifications importantes.

Ces conventions de codage simples, basées sur l'architecture MVC, contribuent à maintenir la lisibilité et la cohérence du projet. Merci de les respecter lors de vos contributions.

Si vous avez des questions supplémentaires concernant les conventions de codage, n'hésitez pas à les poser.


## Tests

Les tests jouent un rôle crucial dans l'assurance qualité du projet. Nous utilisons PHPUnit comme framework de test pour garantir le bon fonctionnement du code.

### Structure des tests

- Les tests unitaires sont regroupés dans le dossier `tests/unit` pour tester des parties spécifiques et isolées du code.
- Les tests d'intégration sont placés dans le dossier `tests/integration` pour vérifier le bon fonctionnement des différentes parties du projet ensemble.
- Les tests fonctionnels sont situés dans le dossier `tests/functional` pour valider le comportement de l'application du point de vue de l'utilisateur.

### Écriture des tests

- Les tests doivent être écrits de manière claire, concise et compréhensible.
- Ils doivent être indépendants et ne pas dépendre de l'ordre d'exécution ou d'autres tests.
- Utilisez des assertions pour vérifier les résultats attendus et les comparer avec les résultats réels.
- Ajoutez des commentaires pour expliquer la logique des tests et les scénarios testés.

### Exécution des tests

- Pour exécuter tous les tests, utilisez la commande `phpunit` à la racine du projet.
- Vous pouvez également exécuter des tests spécifiques en fournissant le chemin du fichier de test ou du répertoire.

### Maintenance des tests

- Les tests doivent être régulièrement mis à jour pour refléter les changements du code et garantir leur pertinence continue.
- Veillez à inclure des tests pour les nouvelles fonctionnalités et les cas de bord qui peuvent survenir.

Assurez-vous d'exécuter les tests avant de soumettre une contribution et de corriger tout échec de test. Les tests aident à maintenir la qualité du code et à prévenir les régressions.

Si vous avez des questions supplémentaires concernant les tests ou l'utilisation de PHPUnit, n'hésitez pas à les poser.

## Communication

Nous encourageons une communication ouverte et transparente pour favoriser une collaboration efficace au sein du projet. Voici les principaux canaux de communication à utiliser :

### Commentaires sur GitHub

- Utilisez les commentaires sur les problèmes (issues) pour signaler des problèmes, soumettre des demandes de fonctionnalités ou poser des questions spécifiques au code.
- Commentez les pull requests pour discuter des modifications proposées et fournir des commentaires détaillés.
- N'hésitez pas à interagir avec les autres contributeurs à travers les commentaires et les discussions pour échanger des idées et résoudre les problèmes ensemble.

### E-mails

- Les e-mails peuvent être utilisés pour des discussions plus approfondies, des questions sensibles ou des sujets qui nécessitent une communication privée.
- Si vous avez besoin d'assistance ou de clarifications supplémentaires, n'hésitez pas à envoyer un e-mail à l'équipe de développement.

Nous encourageons tous les contributeurs à participer activement aux discussions, à donner leur avis et à poser des questions. Assurez-vous de respecter les autres contributeurs et de favoriser un environnement collaboratif et respectueux.

N'hésitez pas à utiliser ces canaux de communication pour partager vos idées, demander de l'aide ou signaler des problèmes. Nous sommes là pour vous soutenir et travailler ensemble pour améliorer le projet.

Merci de votre engagement et de votre volonté de communiquer efficacement !

