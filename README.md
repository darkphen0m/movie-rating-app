# Movie Rating App

Laravel-Webanwendung zur Suche und Bewertung von Filmen. Code Challenge für die GEDISA.

## Features

- Benutzer-Authentifizierung (Laravel Breeze)
- Filmsuche via OMDb API mit Live-Suche
- Filmbewertung (1-10 Sterne)
- Liste aller bewerteten Filme (öffentlich)
- Watchlist (Bonus)
- Tests mit Pest (Bonus)

## Tech Stack

- PHP 8.4
- Laravel 12
- Livewire
- Tailwind CSS
- MariaDB
- Spatie Laravel Data (DTOs)
- Pest

## Installation
```bash
# Repository klonen
git clone <repository-url>
cd movie-rating-app

# Dependencies
composer install
npm install

# Environment
cp .env.example .env
# OMDB_API_KEY in .env eintragen!

# Setup
php artisan key:generate
php artisan migrate
npm run build

# Server starten (mit Laravel Herd oder php artisan serve)
```

## Konfiguration

**`.env` wichtige Werte:**
```env
DB_CONNECTION=mysql
DB_DATABASE=movie_rating_app
DB_USERNAME=root
DB_PASSWORD=

OMDB_API_KEY=your_key_here
```

OMDb API Key: [omdbapi.com](https://www.omdbapi.com/)

## Tests
```bash
php artisan test
```

## Architektur

- **DTOs** mit Spatie Laravel Data + Wireable für Livewire
- **Single Action Classes** für Business-Logik (SaveMovieRating, ToggleWatchlist)
- **Filmdaten**: Nur IMDb-ID, Titel, Jahr und Poster gecacht. API-Calls für Details.

## Struktur
```
app/
├── Actions/         # Business-Logik
├── DTOs/            # Data Transfer Objects
├── Livewire/        # Komponenten
├── Models/          # Movie, Rating, Watchlist
└── Services/        # OmdbService

tests/Feature/       # Pest Tests
```

## Verwendung

1. Registrieren/Login
2. Filmsuche - Ergebnisse mit interner Bewertung
3. Film auswählen - Details ansehen, bewerten und auf Watchlist setzen
4. Watchlist
5. "Bewertete Filme" (Öffentliche Liste)


Entwickelt von Robin Just für eine Code Challenge der GEDISA.