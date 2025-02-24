# PCSD Maintenance Inventory Vault.

Requires `php artisan migrate --seed` to get started on first container build

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