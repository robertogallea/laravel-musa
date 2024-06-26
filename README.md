# Laravel Musa

## Installazione

1. Copiare `.env.example` su `.env`
2. Creare la chiave applicativa lanciando il comando `php artisan key:generate`
3. Completare il file `.env` con i dati mancanti (es. `DB_USER`, `DB_PASSWORD`, ...)

Per caricare la **versione** finale di ciascuna giornata del corso, effettuare il checkout del branch corrispondente,
come
segue:

- [Lezione 1](#lezione-1-30042024) (30/04/2024): Nessun branch creato
- [Lezione 2](#lezione-2-02052024) (02/05/2024): `git checkout 02.2024-05-02`
- [Lezione 3](#lezione-3-03052024) (03/05/2024): `git checkout 03.2024-05-03`
- [Lezione 4](#lezione-4-06052024) (06/05/2024): `git checkout 04.2024-05-06`
- [Lezione 5](#lezione-5-08052024) (08/05/2024): `git checkout 05.2024-05-08`
- [Lezione 6](#lezione-6-09052024) (09/05/2024): `git checkout 06.2024-05-09`
- [Lezione 7](#lezione-7-10052024) (10/05/2024): `git checkout 07.2024-05-10`
- [Lezione 8](#lezione-8-13052024) (13/05/2024): `git checkout 08.2024-05-13`
- [Lezione 9](#lezione-9-16052024) (16/05/2024): `git checkout 09.2024-05-16`
- [Lezione 10](#lezione-10-20052024) (20/05/2024): `git checkout 10.2024-05-20`
- [Lezione 11](#lezione-11-21052024) (21/05/2024): `git checkout 11.2024-05-21`
- [Lezione 12](#lezione-12-23052024) (23/05/2024): `git checkout 12.2024-05-23`
- [Lezione 13](#lezione-13-24052024) (24/05/2024): `git checkout 13.2024-05-24`
- [Lezione 14](#lezione-14-27052024) (27/05/2024): `git checkout 14.2024-05-27`
- [Lezione 15](#lezione-15-30052024) (30/05/2024): `git checkout 15.2024-05-30`

> **Nota**: per essere sicuri di avere sempre le dipendenze composer e gli asset aggiornati lanciare ad ogni checkout i
> seguenti comandi:
> ```shell
> composer install
> npm install
> npm run build
> php artisan migrate
>```


## Lezione 1 (30/04/2024)

- Composer e gestione delle dipendenze di progetto
- Introduzione a Laravel
    - Cos'è Laravel
    - Il pattern MVC
    - Feature di Laravel
    - La comunità
- Installazione
- Struttura di un progetto
- Primo passi col framework


## Lezione 2 (02/05/2024)

- Estensioni MS Code per Laravel
- Laravel Breeze
- Routing
- Middleware


## Lezione 3 (03/05/2024)

- Eloquent ORM 
- Migrations 
- Factories 
- Seeding


## Lezione 4 (06/05/2024)

- Requests
- Responses
- Views
- Templates Blade


## Lezione 5 (08/05/2024)

- Layout Blade
- Operazioni CRUD


## Lezione 6 (09/05/2024)

- Validazione dati
- Query builder


## Lezione 7 (10/05/2024)

- Query builder (cont.d)
- Relazioni
- Sessioni
- Logging
- Cache


## Lezione 8 (13/05/2024)

- Comandi console
- Collections
- Events


## Lezione 9 (16/05/2024)

- Model events
- Pagination
- Queues

## Lezione 10 (20/05/2024)

- Queues (cont.d)
- Client HTTP
- Mail
- Gestione errori

## Lezione 11 (21/05/2024)

- Gestione errori (cont.d)
- API
  - Sanctum vs Passport
  - Gestione token Sanctuum
- API Resources
- Security
  - Encryption
  - Signed routes

## Lezione 12 (23/05/2024)

- Localization
- Email verification
- Authorization
- Scheduler

## Lezione 13 (24/05/2024)

- Storage
- Notifications
- Broadcasting / Reverb
- View Components

## Lezione 14 (27/05/2024)

- Service Container
- Tests e TDD - Repo applicazione disponibile su https://github.com/robertogallea/laravel-musa-tdd


## Lezione 15 (30/05/2024)

- Asset bundling
- Package development
