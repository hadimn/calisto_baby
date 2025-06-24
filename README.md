# Calisto Baby — E-commerce Website for Baby Products

A complete, custom-built online store specializing in baby products with a user-friendly frontend and a robust admin panel for managing products, orders, banners, and more.

---

## 🛒 Features

* **Product Catalog**
  Browse, search, and filter baby products with multiple layouts (grid, list, sidebar filters).

* **Shopping Cart & Checkout**
  Add to cart, update quantities, remove items, and proceed through a streamlined checkout process.

* **User Authentication**
  Secure login and registration pages with session management.

* **Order Management**
  Users can view order history and details.

* **Wishlist**
  Save favorite products for later.

* **Admin Panel**
  Full CRUD for products, categories/tags, banners, social media links, shipping fees, and orders.

* **Banner & Promotions Management**
  Dynamic banner management with image uploads and display order.

* **Product Discounts & Special Deals**
  Mark products as on sale, best deal, or special promotions.

* **PDF Invoice Generation**
  Using FPDF library for order invoices.

* **Responsive Design**
  Built with Bootstrap and custom CSS for mobile-friendly browsing.

---

## 📁 Project Structure

```
/
├── admin-pages/           # Admin dashboard, management pages, assets (CSS/JS/Images)
├── assets/                # Frontend static assets: CSS, JS, fonts, images, PHP mail handlers
├── classes/               # PHP backend classes: Product, Cart, Order, Customer, Banner, etc.
├── fpdf/                  # FPDF library for PDF invoice generation
├── proccess/              # Backend AJAX/process scripts (cart, wishlist, orders, login)
├── *.php                  # Frontend pages (shop, product details, blog, contact, cart, checkout)
├── erd.txt                # Database ERD diagram
├── README.md              # (You can add this file)
```

---

## 📦 Technologies Used

* **PHP** (Native OOP for backend logic)
* **MySQL** (Database)
* **FPDF** (PDF invoice generation)
* **Bootstrap 4+** (Responsive UI)
* **JavaScript / jQuery** (Frontend interactivity)
* **HTML5 / CSS3**

---

## 🚀 Usage

* Shop products, add to cart, place orders, and track them.
* Admins can log in to add/edit/delete products, banners, and manage orders.
* Manage discounts and special promotions via admin interface.
* Generate PDF invoices automatically for orders.

---

## 🛠 Future Improvements

* Integrate payment gateways (Stripe, PayPal)
* Enhance user profile and order tracking features
* Add product reviews and ratings
* Implement API endpoints for mobile app integration
* Optimize for SEO and speed improvements
