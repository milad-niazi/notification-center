# Notification Center

A Laravel-based notification system demonstrating the use of **Events, Listeners, Repositories, Resources, and Logging**. This project is designed for educational purposes and as a **portfolio sample**.

---

## Features

-   **Notification Templates**

    -   Create, update, delete, and view notification templates via API.
    -   Templates include a `key`, `subject`, and `body`.
    -   Supports dynamic placeholders (e.g., `{{name}}`) for personalized notifications.

-   **Event-driven Notifications**

    -   Trigger events on template creation, update, or deletion.
    -   Listeners handle sending notifications via `NotificationService`.
    -   Logs every action for monitoring and debugging.

-   **Logging**

    -   Comprehensive logging for:

        -   Event firing
        -   Notification sending success/failure

    -   Supports custom log channels.
    -   Includes context (template key, ID, timestamp) for easier debugging.

-   **Repository Pattern**

    -   All database interactions are encapsulated in the repository layer.
    -   Keeps controllers clean and maintainable.

-   **API Responses**

    -   Standardized responses using `ApiController` and API Resources.
    -   Consistent success and error messages.

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/notification-center.git
cd notification-center
```

2. Install dependencies:

```bash
composer install
```

3. Copy the environment file and configure:

```bash
cp .env.example .env
php artisan key:generate
```

4. Set database credentials in `.env`.

5. Run migrations:

```bash
php artisan migrate
```

---

## API Endpoints

| Method | Endpoint              | Description                     |
| ------ | --------------------- | ------------------------------- |
| GET    | `/api/templates`      | List all notification templates |
| GET    | `/api/templates/{id}` | View a single template          |
| POST   | `/api/templates`      | Create a new template           |
| PUT    | `/api/templates/{id}` | Update an existing template     |
| DELETE | `/api/templates/{id}` | Delete a template               |

**Example POST Request (Create Template)**

```json
POST /api/templates
{
  "key": "welcome",
  "subject": "Welcome Aboard!",
  "body": "Hello {{name}}, welcome to our awesome system!"
}
```

---

## Events & Listeners

-   **Events**

    -   `TemplateCreated`
    -   `TemplateUpdated`
    -   `TemplateDeleted`

-   **Listeners**

    -   `TemplateCreatedListener`
    -   `TemplateUpdatedListener`
    -   `TemplateDeletedListener`

> Listeners handle sending notifications and logging.

**Flow:**

1. Controller triggers an event (e.g., on template creation).
2. Listener reacts to the event:

    - Sends notification via `NotificationService`.
    - Logs the event and the notification status.

---

## Logging

-   **Channels**

    -   Custom `notification` channel configured in `config/logging.php`.

-   **Levels**

    -   `info`: General actions and event triggers
    -   `warning`: Non-critical issues
    -   `error`: Failures in sending notifications
    -   `debug`: Template content and context for troubleshooting

**Example Log Entry:**

```
[2025-12-10 23:32:37] local.INFO: TemplateCreated event fired {"template_id":27,"template_key":"welcome","time":"2025-12-10 23:32:37"}
[2025-12-10 23:32:37] local.INFO: Notification sent successfully {"template_key":"welcome"}
```

---

## Testing

-   Use **Postman** or any API client to interact with endpoints.
-   Verify logs in `storage/logs/laravel.log` to confirm events and notifications are firing.
-   Ensure the `notification` log channel is set correctly for event listener logging.

---

## Repository & Service Structure

```
app/
├─ Events/
│  ├─ TemplateCreated.php
│  ├─ TemplateUpdated.php
│  └─ TemplateDeleted.php
├─ Listeners/
│  └─ Template/
│     ├─ TemplateCreatedListener.php
│     ├─ TemplateUpdatedListener.php
│     └─ TemplateDeletedListener.php
├─ Repositories/
│  └─ NotificationTemplateRepository.php
├─ Http/
│  └─ Controllers/Api/
│     └─ TemplateController.php
├─ Resources/
│  └─ NotificationTemplateResource.php
├─ Services/
│  └─ Notification/
│     └─ NotificationService.php
```

---

## Notes

-   This project demonstrates **event-driven architecture** in Laravel.
-   Logging every action helps in **debugging and monitoring**.
-   Repository pattern keeps database logic separate from controllers.
-   API Resources provide a consistent response structure.

---

## License

This project is open-source and available under the [MIT License](LICENSE).
