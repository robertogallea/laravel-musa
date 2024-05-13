# Laravel Musa

## Installazione

1. Copiare `.env.example` su `.env`
2. Creare la chiave applicativa lanciando il comando `php artisan key:generate`
3. Completare il file `.env` con i dati mancanti (es. `DB_USER`, `DB_PASSWORD`, ...)

Per caricare la **versione** finale di ciascuna giornata del corso, effettuare il checkout del branch corrispondente,
come
segue:

- Lezione 1 (30/04/2024): Nessun branch creato
- Lezione 2 (02/05/2024): `git checkout 02.2024-05-02`
- Lezione 3 (03/05/2024): `git checkout 03.2024-05-03`
- Lezione 4 (06/05/2024): `git checkout 04.2024-05-06`
- Lezione 5 (08/05/2024): `git checkout 05.2024-05-08`
- Lezione 6 (09/05/2024): `git checkout 06.2024-05-09`
- Lezione 7 (10/05/2024): `git checkout 07.2024-05-10`

> **Nota**: per essere sicuri di avere sempre le dipendenze composer e gli asset aggiornati lanciare ad ogni checkout i
> seguenti comandi:
> ```shell
> composer install
> npm install
> npm run build
>```

