# API de gestion de tâches d'équipe

## Présentation

Cette application est une API REST Laravel dédiée à la gestion collaborative de projets et de tâches. Elle permet à plusieurs utilisateurs de créer des projets, d’ajouter des membres, de gérer des tâches et de commenter celles-ci.

Le projet est construit avec Laravel 12 et utilise Sanctum pour l’authentification par token.

## Fonctionnalités principales

- Authentification des utilisateurs via Sanctum
- Création et gestion de projets
- Association de plusieurs utilisateurs à un projet
- Création et suivi de tâches
- Ajout de commentaires sur les tâches
- Tests automatisés avec PHPUnit

## Stack technique

- PHP 8.2
- Laravel 12
- Sanctum
- SQLite par défaut pour les tests et le développement local
- PHPUnit

## Modèles principaux

Le projet repose sur quatre entités principales :

- User : utilisateur de l’application
- Project : projet de travail
- Task : tâche liée à un projet
- Comment : commentaire associé à une tâche

### Relations principales

- Un utilisateur peut créer plusieurs projets
- Plusieurs utilisateurs peuvent participer à un même projet
- Un projet contient plusieurs tâches
- Une tâche peut avoir plusieurs commentaires
- Un commentaire est rédigé par un utilisateur

## Installation

### 1. Prérequis

Assurez-vous d’avoir installé :

- PHP 8.2+
- Composer
- Node.js et npm (optionnel si vous souhaitez utiliser les assets Vite)

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l’environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Créer la base de données

```bash
php artisan migrate
```

### 5. Lancer l’application

```bash
php artisan serve
```

L’API sera accessible sur :

```bash
http://127.0.0.1:8000
```

## Authentification

L’authentification se fait avec Sanctum.

### Connexion

```bash
POST /api/login
```

Exemple de corps de requête :

```json
{
    "email": "user@example.com",
    "password": "secret"
}
```

Réponse attendue :

```json
{
    "token": "..."
}
```

Pour les routes protégées, ajoutez le header suivant :

```http
Authorization: Bearer <token>
Accept: application/json
```

## Endpoints principaux

### Authentification

| Méthode | Endpoint   | Description                      |
| ------- | ---------- | -------------------------------- |
| POST    | /api/login | Authentifier un utilisateur      |
| GET     | /api/user  | Récupérer l’utilisateur connecté |
| GET     | /api/test  | Vérifier que l’API répond        |

### Projets

| Méthode | Endpoint                | Description             |
| ------- | ----------------------- | ----------------------- |
| GET     | /api/projects           | Lister les projets      |
| POST    | /api/projects           | Créer un projet         |
| GET     | /api/projects/{project} | Consulter un projet     |
| PUT     | /api/projects/{project} | Mettre à jour un projet |
| PATCH   | /api/projects/{project} | Mise à jour partielle   |
| DELETE  | /api/projects/{project} | Supprimer un projet     |

### Tâches

| Méthode | Endpoint                      | Description                   |
| ------- | ----------------------------- | ----------------------------- |
| GET     | /api/projects/{project}/tasks | Lister les tâches d’un projet |
| POST    | /api/projects/{project}/tasks | Créer une tâche               |
| GET     | /api/tasks/{task}             | Consulter une tâche           |
| PUT     | /api/tasks/{task}             | Mettre à jour une tâche       |
| PATCH   | /api/tasks/{task}             | Mise à jour partielle         |
| DELETE  | /api/tasks/{task}             | Supprimer une tâche           |

### Commentaires

| Méthode | Endpoint                   | Description                         |
| ------- | -------------------------- | ----------------------------------- |
| GET     | /api/tasks/{task}/comments | Lister les commentaires d’une tâche |
| POST    | /api/tasks/{task}/comments | Ajouter un commentaire              |
| GET     | /api/comments/{comment}    | Consulter un commentaire            |
| PUT     | /api/comments/{comment}    | Mettre à jour un commentaire        |
| PATCH   | /api/comments/{comment}    | Mise à jour partielle               |
| DELETE  | /api/comments/{comment}    | Supprimer un commentaire            |

## Structure du projet

```text
app/
  Http/
    Controllers/Api/
    Requests/
    Resources/
  Models/
  Services/
config/
database/
migrations/
routes/
tests/
```

## Tests

Pour exécuter la suite de tests :

```bash
php artisan test
```

## Contribution

Les contributions sont les bienvenues. Avant de proposer une modification, il est recommandé de :

1. créer une branche dédiée ;
2. écrire ou mettre à jour les tests associés ;
3. exécuter la suite de tests.
