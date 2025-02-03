![Image](https://github.com/user-attachments/assets/aa3c401f-10cd-470c-ac60-360d0d860c18)

# Blog API (Laravel 11)

This is a simple REST API application built with Laravel 11 for managing blog posts. Users can create accounts, publish blog posts, comment, categorize posts, and view posts by author and category. Authentication is handled using Laravel Sanctum.

## Features

- User authentication (register, login, logout) using Sanctum
- Blog post management (CRUD)
- Categories (CRUD and post assignment)
- Commenting system
- Filter posts by author and category

## Installation

### Prerequisites
Ensure you have the following installed:

- PHP 8.2+
- Composer
- MySQL or PostgreSQL
- Laravel 11

### Setup Instructions

1. **Clone the repository**
   ```sh
   git clone https://github.com/ahmod001/blog_site_backend.git
   cd blog_site_backend
   ```

2. **Install dependencies**
   ```sh
   composer install
   ```

3. **Set up environment**
   ```sh
   cp .env.example .env
   ```
   - Update database credentials in the `.env` file.

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Run migrations**
   ```sh
   php artisan migrate --seed
   ```

6. **Serve the application**
   ```sh
   php artisan serve
   ```

## API Endpoints

| Method | Endpoint                 | Description                      | Auth Required|
|--------|--------------------------|----------------------------------|--------------|
| POST   | `/api/register`          | Register a new user              | No           |
| POST   | `/api/login`             | Login and get token              | No           |
| POST   | `/api/logout`            | Logout user                      | Yes          |
| GET    | `/api/posts`             | Get all blog posts               | No           |
| POST   | `/api/posts`             | Create a new blog post           | Yes          |
| GET    | `/api/posts/{id}`        | Get a specific post              | No           |
| PUT    | `/api/posts/{id}`        | Update a post                    | Yes          |
| DELETE | `/api/posts/{id}`        | Delete a post                    | Yes          |
| POST   | `/api/posts/{id}/comment`| Add a comment to a post          | Yes          |
| GET    | `/api/posts/author/{id}` | Get posts by an author           | No           |
| GET    | `/api/posts/category/{id}` | Get posts by category          | No           |
| GET    | `/api/categories`        | Get all categories               | No           |
| POST   | `/api/categories`        | Create a category                | Yes          |
| PUT    | `/api/categories/{id}`   | Update a category                | Yes          |
| DELETE | `/api/categories/{id}`   | Delete a category                | Yes          |

## Authentication

This API uses Laravel Sanctum for authentication. Include the token in the `Authorization` header for protected endpoints:

Documentation Link: https://documenter.getpostman.com/view/29492560/2sAYX3sPKR

## License

This is a personal practice project. You can use it freely for your own purposes.

---

Made with ❤️ by Ahmod Hasan
