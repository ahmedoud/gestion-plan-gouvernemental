# 📊 Gestion des Plans d'Actions et Programmes Gouvernementaux

Application web développée avec Laravel permettant la gestion de :

- 📦 Programmes
- 📁 Plans
- 📌 Activités
- 🧩 Sous-activités
- ✅ Tâches
- 👥 Utilisateurs & rôles (Admin, Responsable, Utilisateur)

---

## 🚀 Technologies

- Laravel 11
- PHP 8+
- MySQL
- Bootstrap
- Spatie Permission

---

## ⚙️ Installation

```bash
git clone https://github.com/Ahmed-Oudaa/gestion-plan-gouvernemental.git
cd gestion-plan-gouvernemental
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
