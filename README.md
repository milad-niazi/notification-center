# Notification Center

A **Laravel-based notification system** demonstrating the use of **Events, Listeners, Repositories, Resources, Jobs, and Logging**.
This project is designed for educational purposes and as a **portfolio-ready sample**.

---

## Features

-   **Notification Templates**

    -   Create, update, delete, and view notification templates via API
    -   Templates include `key`, `subject`, and `body`
    -   Supports **dynamic placeholders** (e.g., `{{name}}`, `{{order_id}}`) for personalized notifications

-   **Event-driven Notifications**

    -   Trigger events on template creation, update, or deletion
    -   **Listeners now dispatch notifications asynchronously** via **Laravel Jobs/Queue**
    -   Logs every action for monitoring and debugging

-   **Multiple Channels**

    -   **Email**, **SMS**, **Push notifications**
    -   **Fallback mechanism**: if sending fails on one channel, next channel in list is attempted

-   **Dynamic Placeholders**

    -   `TemplateParser` replaces placeholders with real data
    -   Example: `"Hello {{name}}" → "Hello Milad"`

-   **Async Jobs & Queue**

    -   Notifications are sent in background using **Laravel Jobs**
    -   Retry attempts controlled (`$tries`)
    -   Graceful fail handling with logging

-   **Logging**

    -   Custom `notification` log channel in `config/logging.php`
    -   Logs include context: template key, recipient, channels, timestamp
    -   Levels: `info`, `error`, `debug`

-   **Repository Pattern**

    -   Notifications and logs stored via **NotificationLogRepository**
    -   Keeps service layer clean and maintainable

-   **API Responses & Resources**

    -   Standardized JSON response using `NotificationResource`
    -   Returns **dispatched notification info** (`recipient`, `channels`, `status`, `templateKey`)

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

3. Copy the environment file and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Set database credentials in `.env`.

5. Run migrations:

```bash
php artisan migrate
```

6. Start the queue worker (for async notifications):

```bash
php artisan queue:work
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
| POST   | `/api/notifications`  | Dispatch notification(s)        |

---

### Example: Create Template

```json
POST /api/templates
{
  "key": "welcome",
  "subject": "Welcome Aboard!",
  "body": "Hello {{name}}, welcome to our awesome system!"
}
```

---

### Example: Dispatch Notification (Multi-channel)

```json
POST /api/notifications
{
  "channels": ["email", "sms"],
  "template": "welcome",
  "recipient": "milad@example.com",
  "data": {
    "name": "Milad",
    "order_id": 1234
  }
}
```

**Response Example**

```json
{
    "success": true,
    "message": "Notification dispatched!",
    "notification": {
        "recipient": "milad@example.com",
        "templateKey": "welcome",
        "channels": ["email", "sms"],
        "status": "pending",
        "data": {
            "name": "Milad",
            "order_id": 1234
        }
    }
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

**Flow**:

1. Controller triggers an event (e.g., template creation)
2. Listener reacts:

    - Dispatches **SendNotificationJob** to queue
    - Logs the event and notification status

---

## Logging

-   Custom `notification` channel in `config/logging.php`
-   **Example Log Entries**:

```
[2025-12-11 12:45:12] notification.INFO: Notification sent successfully {"recipient":"milad@example.com","channels":["email","sms"],"template_key":"welcome"}
[2025-12-11 12:46:03] notification.ERROR: Notification failed on all channels {"recipient":"milad@example.com","channels":["email","sms"],"template_key":"welcome"}
```

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
│  └─ NotificationLogRepository.php
├─ Http/
│  └─ Controllers/Api/
│     └─ TemplateController.php
│     └─ NotificationController.php
├─ Resources/
│  └─ NotificationTemplateResource.php
│  └─ NotificationResource.php
├─ Jobs/
│  └─ SendNotificationJob.php
├─ Services/
│  └─ Notification/
│     ├─ NotificationService.php
│     ├─ Template/TemplateLoader.php
│     └─ Template/TemplateParser.php
├─ Services/Notification/Channels/
│  ├─ EmailChannel.php
│  ├─ SmsChannel.php
│  └─ PushChannel.php
```

---

## Notes

-   Demonstrates **event-driven architecture**, **async jobs**, **multi-channel notifications**, **fallback**
-   Logging every action helps in **debugging and monitoring**
-   Repository pattern keeps database logic separate from controllers
-   API Resources provide a **consistent response structure**
-   Dynamic placeholders allow **personalized notifications**

---

## License

This project is open-source and available under the MIT License.
