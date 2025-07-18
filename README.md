-----

# SIR API (Quiz Platform Backend)

This repository hosts the **Laravel-based RESTful API** for the Quiz Platform. This API serves as the robust backend engine behind the mobile application, providing essential functionalities such as user authentication, class and quiz management, and automated processing for question generation and answer evaluation.

-----

## 💡 Overview

The SIR API is designed to be the central hub for all data and automated processing for the Quiz platform. It exposes a set of endpoints that the frontend mobile application (or any other client) interacts with to provide a seamless experience for teachers and students.

**Key Responsibilities:**

  * **User Management:** Handles teacher and student registration, login, and profile management.
  * **Class and Quiz Management:** Manages the creation, retrieval, updating, and deletion of classes and quizzes.
  * **PDF Processing & Question Generation:** Receives PDF uploads, processes the content, and automatically generates relevant quiz questions.
  * **Automated Answer Evaluation:** Evaluates student essay answers and provides structured feedback.
  * **Database Interaction:** Persists all application data (users, classes, quizzes, questions, answers, results).

-----

## ✨ Technologies Used

  * **Laravel:** The robust PHP framework providing the MVC architecture, routing, ORM (Eloquent), authentication, and more.
  * **PHP:** The core programming language.
  * **MySQL (or your chosen database):** The relational database used to store application data.
  * **Composer:** PHP dependency manager.
  * **Git:** Version control.
  * *(Add any other specific Laravel packages or libraries you use for PDF processing or text analysis, if not integrated as a separate service.)*

-----

## ⚙️ Setup and Installation

To get the SIR API up and running on your local machine, follow these steps:

### Prerequisites

  * PHP (8.1 or higher recommended)
  * Composer
  * MySQL (or compatible database)
  * Git

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Selvster/sir-api.git
    cd sir-api
    ```
2.  **Install Composer dependencies:**
    ```bash
    composer install
    ```
3.  **Environment Configuration:**
      * Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
      * Open the `.env` file and configure your database connection:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_db_username
        DB_PASSWORD=your_db_password
        ```
      * Generate an application key:
        ```bash
        php artisan key:generate
        ```
4.  **Run Database Migrations:**
      * This will create the necessary tables in your configured database.
    <!-- end list -->
    ```bash
    php artisan migrate
    ```
5.  **Seed the Database (Optional):**
      * If you have seeders to populate your database with initial data (e.g., test users, sample classes), run:
    <!-- end list -->
    ```bash
    php artisan db:seed
    ```
6.  **Start the Development Server:**
    ```bash
    php artisan serve
    ```
    The API will typically be accessible at `http://127.0.0.1:8000`. You can test this by navigating to this URL in your browser or using tools like Postman/Insomnia.

-----


## 🛠️ Development & Contributing

Contributions are welcome\! Please ensure you adhere to the following:

1.  **Fork the repository.**
2.  **Create a new branch:** `git checkout -b feature/your-feature-name`.
3.  **Implement your changes.**
4.  **Commit your changes:** `git commit -m 'feat: Add new feature X'`.
5.  **Push to your branch:** `git push origin feature/your-feature-name`.
6.  **Open a Pull Request** against the `main` branch of this repository.

-----

## 🔒 Security

  * Ensure your `.env` file is never committed to version control.
  * Regularly update Laravel and its dependencies to the latest stable versions to benefit from security patches.
  * Implement appropriate authorization (e.g., Laravel Policies) for all sensitive actions.

-----

## 📞 Contact

For any issues, questions, or collaboration inquiries regarding this backend API, please open an issue on this GitHub repository.

-----
