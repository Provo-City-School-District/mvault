# PCSD Maintenance Inventory Vault.

Requires `php artisan migrate --seed` to get started on first container build

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