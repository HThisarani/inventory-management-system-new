
# Inventory Management System

A web-based Inventory Management System developed using **Laravel**, **Inertia.js**, and **Vue 3**.  
The system allows authenticated users to manage inventory items, including adding stock, deducting stock, and viewing transaction history through a user-friendly interface.

---

## 🚀 Features

- User authentication (Login & Logout)
- Dashboard with summary overview
- Add inventory items (multiple items at once)
- Deduct inventory quantities
- View inventory list
- Transaction history tracking
- Search inventory items
- Responsive UI with navigation bar
- Secure access using authentication middleware

---

## 🛠️ Technologies Used

- **Backend:** Laravel 9  
- **Frontend:** Vue 3 + Inertia.js  
- **Styling:** Tailwind CSS  
- **Database:** MySQL  
- **Authentication:** Laravel Breeze  
- **Build Tool:** Vite  

---

## ⚙️ Installation & Setup

### Prerequisites
- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL
- XAMPP / WAMP

---

### Steps

1. Clone the repository
```bash
git clone https://github.com/HThisarani/inventory-management-system.git
````

2. Navigate to the project directory

```bash
cd inventory-management-system
```

3. Install backend dependencies

```bash
composer install
```

4. Install frontend dependencies

```bash
npm install
```

5. Create environment file

```bash
cp .env.example .env
```

6. Configure database credentials in the `.env` file

7. Generate application key

```bash
php artisan key:generate
```

8. Run database migrations

```bash
php artisan migrate
```

9. Start the development servers

```bash
php artisan serve
npm run dev
```

10. Open the application in your browser

```
http://127.0.0.1:8000
```

---

## 📂 Key Project Files

* `routes/web.php` – Application routes
* `app/Http/Controllers/InventoryController.php` – Inventory logic
* `resources/js/Pages/Inventory/` – Inventory pages
* `resources/js/Layouts/AuthenticatedLayout.vue` – Navigation bar layout
* `resources/js/Pages/Dashboard.vue` – Dashboard UI

---

## 👩‍💻 Author

**H. Thisarani**

---

## 📄 License

This project was developed for **academic purposes**.

````

---

### ✅ FINAL STEP (ONLY ONCE)

```bash
git add README.md
git commit -m "Add project README"
git push origin main
````

---

