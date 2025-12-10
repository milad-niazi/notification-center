# Notification Center

A Laravel-based notification system demonstrating **Event-Driven Architecture**, **Repository Pattern**, and **Advanced Logging**.
This project provides a clean structure for managing **notification templates** and sending notifications via different channels like email.

---

## Features

### Core Features
- **CRUD for Notification Templates**
  Create, read, update, and delete notification templates with placeholders (e.g., `{{name}}`).

- **Event-Driven Notifications**
  - Events: `TemplateCreated`, `TemplateUpdated`, `TemplateDeleted`
  - Listeners handle sending notifications and logging automatically.

- **Notification Service**
  Centralized service to send notifications via multiple channels (email implemented).

- **Advanced Logging**
  - Dedicated `notification` channel in `storage/logs/notification.log`
  - Logs include context: template ID, template key, recipient, timestamp.
  - Logs both successes and failures for better debugging.

---

### Tech Stack
- Laravel 12
- PHP 8.2
- MySQL / SQLite (any relational DB)
- Postman for API testing

---

## Folder Structure Highlights

app/
├── Events/ # Event definitions
├── Listeners/ # Event listeners (notification logic)
├── Repositories/ # DB logic separated from controllers
├── Services/ # NotificationService
└── Http/Controllers/Api/TemplateController.php


---

## API Endpoints

Base URL: `/api`

| Method | Endpoint              | Description                 |
|--------|---------------------|-----------------------------|
| GET    | `/templates`        | List all templates          |
| GET    | `/templates/{id}`   | Get template by ID          |
| POST   | `/templates`        | Create new template         |
| PUT    | `/templates/{id}`   | Update existing template    |
| DELETE | `/templates/{id}`   | Delete template             |

### Sample Payloads

**Create Template**

```json
{
  "key": "welcome",
  "subject": "Welcome Aboard!",
  "body": "Hello {{name}}, welcome to our awesome system!"
}

Update Template

{
  "subject": "Welcome to Our Platform!"
}

Logging

Log file: storage/logs/notification.log

Example log entries:

{
  "template_id": 1,
  "template_key": "welcome",
  "time": "2025-12-10T23:34:09",
  "status": "Notification sent successfully"
}

Installation

Clone the repository:

git clone https://github.com/your-username/notification-center.git
cd notification-center


Install dependencies:

bash
composer install
Configure environment:

bash
cp .env.example .env
php artisan key:generate
Run migrations:

bash
php artisan migrate
Start the server:

bash
php artisan serve

Why this Project is Useful

Demonstrates clean architecture with Repositories and Event/Listener pattern.

Logging is detailed and structured, making debugging easier.

Can be extended to multiple channels: email, SMS, push notifications.

Perfect showcase for working with Laravel, notifications, and event-driven systems.
