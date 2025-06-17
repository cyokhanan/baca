# 📚 BACA - Digital Library Management System

A comprehensive web-based library management system built using **Laravel** and **MySQL**, designed to streamline the operations of modern libraries. This system supports core library functionalities such as book management, borrowing and returning processes, damage handling, copy tracking, top-ups, and more.

## 🚀 Features

- ✅ **Book Management**  
  Add, categorize, and manage books with detailed information including rental costs and star ratings.

- ✍️ **Author Collaboration**  
  Assign one or multiple authors to a book using a dynamic author-book relationship (`tim_penulis`).

- 📦 **Physical Copy Tracking**  
  Automatically generate physical book copies (`salinan_bukus`) with unique codes and real-time availability status.

- 👥 **Borrower Accounts**  
  Register borrowers with secure authentication, deposit tracking, and blacklist status.

- 💳 **Top-Up System**  
  Support for deposit top-ups to manage borrowing balances.

- 📆 **Borrow & Return Process**  
  Record borrowing activities, calculate penalties, and handle book returns efficiently.

- 🔧 **Damage Reports**  
  Track and log book damage with repair cost calculations.

- 📅 **Booking & Waiting List**  
  Allow users to book books and join a waiting list if a title is unavailable.

## 🛠️ Tech Stack

- **Backend Framework**: Laravel 10+
- **Database**: MySQL
- **ORM**: Eloquent
- **Authentication**: Laravel Auth
- **Other Tools**: Carbon, Faker, Hashing, Artisan CLI

## 🗂️ Database Design

The system uses a normalized relational schema consisting of the following core tables:

- `penulis`, `kategoris`, `bukus`, `tim_penulis`, `salinan_bukus`
- `peminjams`, `topups`, `pinjams`, `kerusakans`, `bookings`, `daftar_tunggus`
- `users`, `personal_access_tokens`, `password_reset_tokens`, `failed_jobs`

Relational integrity is enforced through foreign key constraints to ensure data consistency.

## 📦 Getting Started

1. Clone the repository  
   ```bash
   git clone https://github.com/your-username/your-repo-name.git

2. **Install dependencies**  
   ```bash
   composer install

3. **Copy the .env example file and configure database**  
   ```bash
   cp .env.example .env
   php artisan key:generate

4. **Run migrations and seed the database**  
   ```bash
   php artisan migrate:fresh --seed

5. **Start the development server**  
   ```bash
   php artisan serve

## 📌 License
This project is open-sourced and available for educational or non-commercial use.

Created with ❤️ by BACA TEAM
