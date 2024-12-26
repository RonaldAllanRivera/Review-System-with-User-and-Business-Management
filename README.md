# Laravel Application with Filament - Review System with User and Business Management

This Laravel application is built on the **TALL Stack** (TailwindCSS, Alpine.js, Laravel, and Livewire) and leverages **Laravel Filament** for modern, dynamic admin panel and CRUD management. Below are the key features implemented for Users and Business management:

## Features

### Users Management

-   **CRUD Operations**: Create, Read, Update, and Delete users with a Filament-powered, responsive interface.
-   **Email Verification**: Integrated Laravel's `MustVerifyEmail` interface for user email verification.
-   **Role Management**: Assign roles (`admin`, `editor`, `user`) to users during creation and editing.
-   **Dynamic Form Handling**:
    -   Conditional placeholders and validations for password fields (e.g., "Leave blank to keep the current password" on edit).
    -   Reactive dropdowns for `state` selection based on `country` (`United States` or `Canada`).
-   **Password Security**: Hash passwords securely during creation and editing.
-   **Duplicate Email Validation**: Prevents duplicate email usage during creation or updates.
-   **Custom Notifications**:
    -   Notifications for successful user creation or updates.
    -   Email notifications sent to users upon creation, with fallback for email failures.

### Business Management

-   **CRUD Operations**: Manage business entities with detailed attributes, including address, contact details, and additional metadata.
-   **User Association**: Businesses are linked to specific users via a `user_id` relationship.
-   **Dynamic Fields**: Populate business-related fields dynamically in forms.
-   **Business Factory**: Pre-defined factory for generating business data for seeding and testing.

### Testing

-   **Unit and Feature Tests**:
    -   Verified user creation with full data validation.
    -   Password validation during user creation and editing.
    -   Duplicate email validation tests to ensure data integrity.
    -   Business factory tests to validate relationships and data seeding.

---

## How to Clone and Set Up the Laravel Application Locally

Follow these steps to clone and set up the Laravel application on your local machine:

### Prerequisites

-   PHP (>= 8.1)
-   Composer
-   MySQL or another supported database
-   Node.js and npm (for frontend assets)
-   A web server like Apache or Nginx

### Steps

1. **Clone the Repository**:

    ```bash
    git clone <repository-url>
    cd <repository-folder>
    ```

2. **Install Dependencies**:

    ```bash
    composer install
    npm install && npm run dev
    ```

3. **Set Up the Environment**:

    - Copy the `.env.example` file and rename it to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database and mail configurations.

4. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

5. **Run Database Migrations**:

    ```bash
    php artisan migrate
    ```

6. **Seed the Database (Optional)**:

    ```bash
    php artisan db:seed
    ```

7. **Serve the Application**:

    ```bash
    php artisan serve
    ```

8. **Access the Application**:
    - Open your browser and navigate to `http://127.0.0.1:8000`.

---

This Laravel application showcases the power of the **TALL Stack** and **Laravel Filament** for modern admin panel development. It is designed to be scalable, dynamic, and user-friendly. For more details or contributions, explore the codebase or raise issues in the repository. 🚀
