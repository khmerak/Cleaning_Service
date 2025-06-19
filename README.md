## Service have not completed yet
🧹 Cleaning Service App – Database Structure
This document summarizes the database structure for the Cleaning Service Web App.

📂 Overview
The database contains tables for managing:

Users & Roles (admin/user)

Customers & Bookings

Services & Products

Orders, Invoices, Carts

Employees, Branches & Positions

Authentication (sessions, tokens)

File uploads

🗃️ Key Tables and Relationships
👤 Users
Stores registered users with roles.

Columns: name, email, password, role.

👥 Customers
Linked to a user_id.

Unique by email and phone.

🏢 Branches
Each branch has a unique name, email, and phone.

👨‍🔧 Employees
Connected to branch_id and position_id.

Stores employee personal data and profile image.

💼 Positions
Stores role titles for employees (e.g., Manager, Cleaner).

Note: No records yet.

📦 Products
Products include price, stock, and category_id.

Linked to categories.

🛍️ Categories
Categories for products (e.g., Bath Cleaning, Cleaning Machine).

🛒 Orders & Order Items
Orders linked to users.

Each order can have multiple items.

Items reference both order_id and product_id.

🧾 Invoices
Linked to order_id.

Stores payment method.

📅 Bookings
Customers book services at a branch.

Linked to service_id, customer_id, branch_id.

🧰 Services
Linked to service_categories.

Note: No data yet. Table exists but empty.

🧼 Service Categories
Parent categories for services.

Note: Table exists but empty.

🛒 Add to Cart
Users can add products to cart before placing orders.

🖼️ Uploads
Stores uploaded images.

Note: Table exists but no records yet.


# 🧼 Cleaning App - Database Schema Overview

This document provides an overview of the database structure used in the **Cleaning App** system.

---

## 🗄️ Database: `cleaning_app`

### 📌 General Notes
- MySQL version: 10.4.32 (MariaDB)
- Character Set: `utf8mb4`
- Collation: `utf8mb4_unicode_ci`
- Engine: InnoDB

---

## 📊 Tables & Their Purpose

### 1. `users`
Stores user account data.

| Column           | Type         | Description                  |
|------------------|--------------|------------------------------|
| id               | BIGINT       | Primary Key                  |
| name             | VARCHAR(191) | User's full name             |
| email            | VARCHAR(191) | Unique user email            |
| role             | VARCHAR(191) | `admin`, `user`              |
| password         | VARCHAR(191) | Hashed password              |
| remember_token   | VARCHAR(100) | Used for "remember me" auth  |

---

### 2. `customers`
Customer profiles linked to a user.

| Column         | Type         | Description                |
|----------------|--------------|----------------------------|
| id             | BIGINT       | Primary Key                |
| customer_name  | VARCHAR(191) | Full name                  |
| phone, email   | VARCHAR(191) | Unique contact             |
| user_id        | BIGINT       | FK to `users`              |
| address        | VARCHAR(191) | Full address               |

---

### 3. `employees`
Staff members of the company.

| Column         | Type         | Description                |
|----------------|--------------|----------------------------|
| first_name     | VARCHAR(191) |                            |
| last_name      | VARCHAR(191) |                            |
| phone, email   | VARCHAR(191) | Unique                     |
| position_id    | BIGINT       | FK to `positions`          |
| branch_id      | BIGINT       | FK to `branches`           |
| hire_date      | DATE         | Employment start           |
| salary         | DECIMAL(10,2)| Monthly salary             |
| status         | ENUM         | `active`, `inactive`       |

---

### 4. `branches`
Company locations.

| Column       | Type         | Description        |
|--------------|--------------|--------------------|
| branch_name  | VARCHAR(191) | Unique             |
| location     | VARCHAR(191) | Branch address     |
| phone, email | VARCHAR(191) | Unique contacts    |

---

### 5. `positions`
Defines employee job titles.

| Column         | Type         | Description            |
|----------------|--------------|------------------------|
| position_name  | VARCHAR(191) | e.g. Cleaner, Manager  |

---

### 6. `categories`
Product categories.

| Column         | Type         | Description              |
|----------------|--------------|--------------------------|
| category_name  | VARCHAR(191) | Unique category name     |

---

### 7. `products`
Products available for sale.

| Column          | Type         | Description              |
|-----------------|--------------|--------------------------|
| product_name    | VARCHAR(191) | Unique name              |
| price, discount | DECIMAL      | Pricing fields           |
| stock_quantity  | INT          | Inventory stock          |
| category_id     | BIGINT       | FK to `categories`       |

---

### 8. `product_add_to_carts`
Tracks cart items before checkout.

| Column     | Type      | Description       |
|------------|-----------|-------------------|
| product_id | BIGINT    | FK to `products`  |
| user_id    | BIGINT    | FK to `users`     |
| quantity   | INT       | Default: 1        |
| price      | DECIMAL   | Default: 0.00     |

---

### 9. `orders`
User orders.

| Column      | Type         | Description            |
|-------------|--------------|------------------------|
| user_id     | BIGINT       | FK to `users`          |
| order_date  | DATE         | Order date             |
| status      | VARCHAR      | `pending`, etc.        |

---

### 10. `order_items`
Items in an order.

| Column      | Type        | Description               |
|-------------|-------------|---------------------------|
| order_id    | BIGINT      | FK to `orders`            |
| product_id  | BIGINT      | FK to `products`          |
| quantity    | INT         | Default: 1                |
| price       | DECIMAL     | Product price at checkout|

---

### 11. `invoices`
Links payment method to orders.

| Column     | Type         | Description        |
|------------|--------------|--------------------|
| method     | VARCHAR(191) | Payment method     |
| order_id   | BIGINT       | FK to `orders`     |

---

### 12. `services`
Cleaning services offered.

| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| service_name | VARCHAR(191) | Unique name              |
| type         | VARCHAR(191) | Type of service          |
| price        | DECIMAL      | Service cost             |
| category_id  | BIGINT       | FK to `service_categories` |

---

### 13. `service_categories`
Categories of services.

| Column                 | Type         | Description        |
|------------------------|--------------|--------------------|
| service_category_name  | VARCHAR(191) | Unique category    |

---

### 14. `bookings`
Customer bookings for services.

| Column      | Type         | Description                    |
|-------------|--------------|--------------------------------|
| customer_id | BIGINT       | FK to `customers`              |
| service_id  | BIGINT       | FK to `services`               |
| branch_id   | BIGINT       | FK to `branches`               |
| booking_date| DATE         | Scheduled date                 |
| amount      | DECIMAL      | Price                          |
| status      | ENUM         | `pending`, `confirmed`, `cancelled` |

---

### 15. `uploads`
Image uploads (e.g. banners, ads, etc.)

| Column   | Type         | Description         |
|----------|--------------|---------------------|
| image    | VARCHAR(191) | Image file path     |
| position | VARCHAR(191) | Where it's shown    |

---

### 16. `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `migrations`, `personal_access_tokens`, `password_reset_tokens`
System and Laravel-related tables for:
- Auth
- Queues & Jobs
- Session and Cache
- Token Auth
- Migration tracking

---

## 🔐 Relationships Summary

- `customers.user_id → users.id`
- `employees.branch_id → branches.id`
- `employees.position_id → positions.id`
- `bookings.customer_id → customers.id`
- `bookings.service_id → services.id`
- `bookings.branch_id → branches.id`
- `products.category_id → categories.id`
- `orders.user_id → users.id`
- `order_items.order_id → orders.id`
- `order_items.product_id → products.id`
- `invoices.order_id → orders.id`
- `product_add_to_carts.product_id → products.id`
- `product_add_to_carts.user_id → users.id`
- `services.category_id → service_categories.id`

---

## 📦 Example Data

✅ Sample data exists for:
- `users`
- `categories`
- `products`
- `orders`
- `order_items`
- `invoices`

---

## 📅 Export Date
- **Generated on:** `2025-06-19 15:46:11`
- **Exported by:** Navicat Premium

---

## 📝 License

This schema is proprietary to the Cleaning App project. For internal use only.
