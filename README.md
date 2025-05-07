# Système de Gestion des Affectations

```
├── config/
│   └── Database.php         # Configuration de la connexion PDO
├── models/
│   ├── User.php             # Gestion des utilisateurs
│   ├── Student.php          # Gestion des profils étudiants
│   ├── Teacher.php          # Gestion des enseignants
│   ├── Project.php          # Gestion des projets
│   ├── Assignment.php       # Gestion des affectations
│   └── Reminder.php         # Gestion des relances
├── migrations/
│   └── create_tables.php    # Script de création des tables
├── seeds/
    └── seed_data.php        # Données initiales de test
```

## Modèles de Données

- **User** : Gère les utilisateurs (nom, prénom, email, mot de passe, rôle)
- **Student** : Profils étudiants avec spécialité (AL, SRC, SI)
- **Teacher** : Enseignants avec domaines de compétence (AL, SRC, SI, multiples)
- **Project** : Projets étudiants (titre, binôme, spécialité, PDF)
- **Assignment** : Affectation d'un enseignant à un projet
- **Reminder** : Relances pour projets non affectés

## Installation et Configuration


### Configuration de la Base de Données
1. Créez une base de données MySQL
2. Mettez à jour les informations de connexion dans `config/Database.php`

### Migrations
Exécutez les migrations pour créer les tables nécessaires :
```bash
cd migrations
php migrations.php
```

### Données de Test (Seed)
Insérez des données initiales pour tester l'application :
```bash
cd seeder
php seed.php
```

