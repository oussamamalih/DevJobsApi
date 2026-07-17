# DevJobsApi

API REST développée avec **Laravel 11** pour une plateforme de recherche d'emploi (job board). Elle permet aux entreprises de publier des offres, aux candidats de postuler, et gère l'authentification via des rôles (`admin`, `company`, `candidate`).

## 🛠️ Stack technique

- **Framework** : Laravel 11
- **Base de données** : MySQL
- **Authentification** : Laravel Sanctum (token-based)
- **PHP** : 8.2+

## 📊 Modèle de données

| Table | Description |
|---|---|
| `users` | Comptes utilisateurs (`first_name`, `last_name`, `email`, `password`, `role`) |
| `entreprises` | Profil d'entreprise, lié à un `user` de rôle `company` |
| `offres` | Offres d'emploi, liées à une `entreprise` |
| `competences` | Compétences/skills (relation many-to-many avec `offres`) |
| `candidatures` | Candidatures d'un `user` (candidate) à une `offre` |
| `competence_offre` | Table pivot entre `offres` et `competences` |

### Relations principales

- `User` **hasOne** `Entreprise` (si rôle `company`)
- `Entreprise` **hasMany** `Offre`
- `Offre` **belongsToMany** `Competence`
- `User` (candidate) **hasMany** `Candidature`
- `Candidature` **belongsTo** `User` et `Offre`

## 🔐 Rôles & permissions

Trois rôles gérés via le champ `role` sur `users`, contrôlés par un middleware custom (`app/Http/Middleware/CheckRole.php`) :

| Rôle | Peut faire |
|---|---|
| `candidate` | Consulter les offres, postuler |
| `company` | Créer/gérer son profil entreprise, publier/modifier/supprimer ses propres offres |
| `admin` | Gérer les compétences (skills), modérer entreprises/offres |

Usage dans les routes :
```php
Route::middleware(['auth:sanctum', 'role:company,admin'])->group(function () {
    // routes protégées
});
```

## 🚀 Installation

```bash
git clone https://github.com/oussamamalih/DevJobsApi.git
cd DevJobsApi

composer install

cp .env.example .env
php artisan key:generate
```

Configurer la base de données dans `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=devjobs_api
DB_USERNAME=root
DB_PASSWORD=
```

Créer les tables et les données de test :
```bash
php artisan migrate:fresh --seed
```

Lancer le serveur :
```bash
php artisan serve
```
L'API est disponible sur `http://127.0.0.1:8000/api`.

## 👤 Comptes de test (après seed)

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | `admin@devjobs.test` | `password` |
| Company | `company@devjobs.test` | `password` |
| Candidate | `candidate@devjobs.test` | `password` |

## 📡 Endpoints

### Authentification

| Méthode | Endpoint | Accès | Description |
|---|---|---|---|
| POST | `/api/register` | Public | Créer un compte |
| POST | `/api/login` | Public | Se connecter, récupère un token |
| POST | `/api/logout` | Auth | Révoque le token courant |
| GET | `/api/user` | Auth | Infos de l'utilisateur connecté |

### Offres

| Méthode | Endpoint | Accès | Description |
|---|---|---|---|
| GET | `/api/offres` | Public | Liste toutes les offres |
| GET | `/api/offres/{id}` | Public | Détail d'une offre |
| POST | `/api/offres` | `company`, `admin` | Créer une offre |
| PUT | `/api/offres/{id}` | `company` (propriétaire), `admin` | Modifier une offre |
| DELETE | `/api/offres/{id}` | `company` (propriétaire), `admin` | Supprimer une offre |

### Entreprises

| Méthode | Endpoint | Accès | Description |
|---|---|---|---|
| GET | `/api/entreprises` | Public | Liste toutes les entreprises |
| GET | `/api/entreprises/{id}` | Public | Détail d'une entreprise |
| POST | `/api/entreprises` | `company` | Créer son profil entreprise |
| PUT | `/api/entreprises/{id}` | `company` (propriétaire), `admin` | Modifier |
| DELETE | `/api/entreprises/{id}` | `company` (propriétaire), `admin` | Supprimer |

### Compétences

| Méthode | Endpoint | Accès | Description |
|---|---|---|---|
| GET | `/api/competences` | Public | Liste toutes les compétences |
| GET | `/api/competences/{id}` | Public | Détail d'une compétence |
| POST | `/api/competences` | `admin` | Créer une compétence |
| PUT | `/api/competences/{id}` | `admin` | Modifier |
| DELETE | `/api/competences/{id}` | `admin` | Supprimer |

> 🚧 Les endpoints pour `candidatures` et la gestion avancée des `users` sont en cours de développement.

## 🔑 Authentification dans les requêtes

Après login/register, ajouter le token reçu dans le header de chaque requête protégée :
```
Authorization: Bearer <votre_token>
Accept: application/json
```

## 🧪 Exemple de requête (POST /api/offres)

```json
{
  "title": "Développeur Laravel",
  "description": "Nous recherchons un développeur Laravel expérimenté...",
  "contract_type": "CDI",
  "competences": [1, 3, 5]
}
```

## 📁 Structure du projet

```
app/
├── Http/
│   ├── Controllers/Api/   # Logique métier (Auth, Offre, Entreprise, Competence...)
│   ├── Middleware/        # CheckRole.php (contrôle d'accès par rôle)
│   └── Requests/          # Validation (StoreOffreRequest, LoginRequest...)
├── Models/                # Eloquent models + relations
database/
├── migrations/            # Schéma de la base de données
├── factories/             # Génération de données fake
└── seeders/                # Peuplement de la base pour les tests
routes/
└── api.php                # Déclaration des routes API
```

## 📄 Licence

Projet académique — Laravel est open-source sous licence [MIT](https://opensource.org/licenses/MIT).