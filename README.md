# PCSD Maintenance Inventory Vault.

## Clear View Caches
If you are experiencing issues with the views not updating, run the following command to clear the view caches:
```bash
    php artisan view:clear
```
## Modifying Styles
Inside your app container, run the following command to install the necessary dependencies:
### Install TailwindCSS
```bash
    npm install tailwindcss @tailwindcss/vite
```
### Run the following command to compile the CSS live while editing
```bash
    npx tailwindcss -i ./resources/css/input.css -o ./public/assets/css/tailwind.css --watch
```

## Adding Logging Events
To add logging events, use the following code snippet:
```php
   Log::info('This is a direct test log for laravel.log.');
```
potential log levels are: debug, info, warning, error, critical, alert, emergency
## Notes
- The `php artisan migrate --seed` command will create the necessary tables and seed the database with the necessary data. Required for first build to get started.
- need to push www-data ownership through src/ folder on first build to correct permissions.
