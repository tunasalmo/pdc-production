# PDC Production

A product catalog website with a **content-based "similar products" recommendation engine**, built with Laravel 12 and React. Customers can browse and search products, and every product page suggests the five most similar items. Admins manage products, categories, and the text-processing pipeline from a protected dashboard.

## Features

**Public site**
- Product catalog with keyword search (name, description, material), category filter, and pagination
- Product detail page with the **Top 5 similar products**
- About and Contact pages (contact form with server-side validation)
- Animated hero and menu built with React, Three.js, and GSAP

**Admin dashboard** (login required)
- Authentication with a dedicated admin middleware
- CRUD for products (with image upload) and categories
- Stopword management: add, bulk add, delete, and reset to defaults
- One-click recommendation pipeline: run all steps at once, or run preprocessing, TF-IDF, and similarity separately, with a progress summary and sample results

## How the recommendation works

Product text (name + description + material) goes through a pipeline implemented in `app/Services`:

1. **Preprocessing** (`PreprocessingService`): case folding, cleaning (numbers and symbols), tokenization, stopword removal (stored in the database), and Indonesian stemming with [Sastrawi](https://github.com/sastrawi/sastrawi)
2. **TF-IDF** (`TFIDFService`): term frequency x inverse document frequency, `IDF = log(N / df) + 1`, saved as a vector per product
3. **Cosine similarity** (`CosineSimilarityService`): computed for every product pair and stored, then queried as Top-N for each product page

## Tech stack

| Area | Technology |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| NLP | Sastrawi (Indonesian stemmer), custom TF-IDF and cosine similarity |
| Frontend | Blade, Tailwind CSS 4, React 19, Three.js (`@react-three/fiber`), GSAP |
| Build tool | Vite 7 |
| Database | SQLite by default (configurable in `.env`) |
| Testing | PHPUnit |

## Getting started

**Requirements:** PHP 8.2+, Composer, Node.js 18+, and npm.

```bash
# 1. Clone the repository
git clone https://github.com/tunasalmo/pdc-production.git
cd pdc-production

# 2. Install dependencies
composer install
npm install

# 3. Configure the environment
cp .env.example .env
php artisan key:generate
# Set your database connection in .env (SQLite is the default)

# 4. Create the database tables and seed the admin accounts
php artisan migrate
php artisan db:seed --class=AdminSeeder

# 5. Run the app (in two terminals)
npm run dev
php artisan serve
```

Open `http://localhost:8000` for the public site and `http://localhost:8000/admin/login` for the admin dashboard.

> **Security:** `AdminSeeder` creates demo admin accounts. Change their passwords (or remove the seeder) before deploying anywhere public.

## Using the recommendation engine

1. Log in to the admin dashboard and add some products and categories
2. Go to **Generate** and run the full pipeline (at least 2 products are required)
3. Open any product page on the public site to see its similar products

Re-run the pipeline whenever products or stopwords change.

## Project structure

```
app/
  Http/Controllers/Admin/    Dashboard, products, categories, stopwords, generate
  Http/Controllers/Public/   Catalog, about, contact
  Http/Middleware/AdminAuth  Admin route protection
  Models/                    Product, category, stopword, preprocessing, TF-IDF, similarity
  Services/                  Preprocessing, TF-IDF, cosine similarity
resources/
  views/                     Blade templates (admin and public)
  js/components/             React components (Beams, FlowingMenu)
routes/web.php               Public and admin routes
```

## Author

**Saddam Muhammad** - Informatics Engineering, Universitas Pamulang
[GitHub](https://github.com/tunasalmo)
