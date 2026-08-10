# Cahier des charges & modélisation 📐

# Entité

* Users
* Project
* Task
* Comment

## Relation

Un utilisateur peut créer plusieur projet

Un projet est crée par un seul utilisateur
Un utilisateurs peut travailler sur plusieur projet

Un projet peut avoir plusieurs

Un projet a plusieurs tache utilisateurs
Une tache peut avoir plusieurs commentaires
Un utilisateur peut mettre plusieurs commentaires

Un commentaire est écrit par **un seul utilisateur**

# Schema



# Endpoint



# API de gestion de tâches d'équipe

## Présentation

API REST Laravel permettant à plusieurs utilisateurs
de collaborer sur des projets, gérer des tâches
et échanger via des commentaires.

## Entités

- User
- Project
- Task
- Comment

## Modèle relationnel

[diagramme Mermaid]

## Relations

- User 1-N Project : un utilisateur peut créer plusieurs projets.
- User N-N Project : plusieurs utilisateurs peuvent travailler sur plusieurs projets.
- Project 1-N Task : un projet possède plusieurs tâches.
- Task 1-N Comment : une tâche possède plusieurs commentaires.
- User 1-N Comment : un utilisateur peut écrire plusieurs commentaires.

## Endpoints

### Authentification

| Verbe | URL           | Rôle            |
| ----- | ------------- | ---------------- |
| POST  | /api/register | Créer un compte |
| POST  | /api/login    | Se connecter     |
| POST  | /api/logout   | Se déconnecter  |

### Projects

...

### Tasks

...

### Comments

...
