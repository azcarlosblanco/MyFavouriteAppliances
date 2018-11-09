
### Installation
1. Clone the repo and `cd` into it.
2. Open the terminal and write this command `composer install`
3. Rename or copy `.env.example` file to `.env` and write required database information. You can use sqlite to faster set up. `touch database/database.sqlite`.
4. Run `php artisan key:generate` command.
5. With `php artisan migrate --seed` command, create the tables.
6. `php artisan import:products` To retrieve all data from www.appliancesdelivered.ie. You have tu set up laravel cron task feature to keep database updated.
