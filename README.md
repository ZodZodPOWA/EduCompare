# Application EduCompare

Bienvenue dans l'application EduCompare ! Cette application vous permet de découvrir (en rapport à vos critères) les scolarités disponibles.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- PHP (version 7.0 ou supérieure)
- MySQL (ou un autre système de gestion de base de données compatible avec PHP)

## Instructions pour tester l'application localement

1. **Clonage du dépôt**

    Clonez ce dépôt sur votre machine locale en utilisant la commande suivante :
    ```
    git clone https://github.com/ZodZodPOWA/EduCompare.git
    ```

2. **Configuration de la base de données**

    - Importez le fichier SQL fourni dans le dossier `sql` pour créer la structure de la base de données.

3. **Configuration du serveur web**

    - Configurez votre serveur web pour qu'il pointe vers le répertoire où vous avez cloné ce dépôt.

4. **Configuration de l'environnement PHP**

    - Assurez-vous que PHP est configuré correctement sur votre serveur web.

5. **Configuration des paramètres de connexion à la base de données**

    - Modifiez les paramètres de connexion à la base de données dans le fichier `login.php` pour correspondre à votre configuration locale.
      
    ```
    $dbHost = "localhost";
    $dbUser = "votre_utilisateur";
    $dbPassword = "votre_modp";
    $dbName = "EduCompare";
    ```

6. **Exploration de l'application**

    - Vous pouvez maintenant explorer l'application EduCompare.

## Licence

Ce projet est sous licence [MIT](LICENSE).
