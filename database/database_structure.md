# Database Structure

This document outlines the database schema for the Portfolio Admin Panel, based on the migrations found in `database/migrations/`.

## Tables

### 1. `users`
Standard Laravel users table with Fortify's two-factor authentication support.

| Column                      | Type        | Constraints                 | Description                                |
| :-------------------------- | :---------- | :-------------------------- | :----------------------------------------- |
| `id`                        | `bigint`    | Primary Key, Auto Increment | Unique identifier for the user.            |
| `name`                      | `string`    |                             | Full name of the user.                     |
| `email`                     | `string`    | Unique                      | User's email address (used for login).     |
| `email_verified_at`         | `timestamp` | Nullable                    | Date and time when the email was verified. |
| `password`                  | `string`    |                             | Hashed password.                           |
| `two_factor_secret`         | `text`      | Nullable                    | Secret for 2FA.                            |
| `two_factor_recovery_codes` | `text`      | Nullable                    | Recovery codes for 2FA.                    |
| `two_factor_confirmed_at`   | `timestamp` | Nullable                    | Date and time when 2FA was confirmed.      |
| `remember_token`            | `string`    | Nullable                    | Token for "remember me" functionality.     |
| `created_at`                | `timestamp` | Nullable                    | Record creation timestamp.                 |
| `updated_at`                | `timestamp` | Nullable                    | Record last update timestamp.              |

---

### 2. `password_reset_tokens`
Laravel's default password reset tokens table.

| Column       | Type        | Constraints | Description               |
| :----------- | :---------- | :---------- | :------------------------ |
| `email`      | `string`    | Primary Key | User's email address.     |
| `token`      | `string`    |             | Reset token.              |
| `created_at` | `timestamp` | Nullable    | Token creation timestamp. |

---

### 3. `sessions`
Database-backed session storage.

| Column          | Type         | Constraints     | Description                   |
| :-------------- | :----------- | :-------------- | :---------------------------- |
| `id`            | `string`     | Primary Key     | Session identifier.           |
| `user_id`       | `bigint`     | Nullable, Index | ID of the authenticated user. |
| `ip_address`    | `string(45)` | Nullable        | User's IP address.            |
| `user_agent`    | `text`       | Nullable        | User's browser agent string.  |
| `payload`       | `longtext`   |                 | Serialized session data.      |
| `last_activity` | `integer`    | Index           | Last activity timestamp.      |

---

### 4. `cache` & `cache_locks`
Laravel's database cache and locking mechanism.

#### `cache`
| Column       | Type         | Constraints | Description           |
| :----------- | :----------- | :---------- | :-------------------- |
| `key`        | `string`     | Primary Key | Cache key.            |
| `value`      | `mediumtext` |             | Cached value.         |
| `expiration` | `integer`    | Index       | Expiration timestamp. |

#### `cache_locks`
| Column       | Type      | Constraints | Description                |
| :----------- | :-------- | :---------- | :------------------------- |
| `key`        | `string`  | Primary Key | Lock key.                  |
| `owner`      | `string`  |             | Lock owner identifier.     |
| `expiration` | `integer` | Index       | Lock expiration timestamp. |

---

### 5. `jobs`, `job_batches` & `failed_jobs`
Laravel's queue management tables.

#### `jobs`
| Column         | Type               | Constraints                 | Description                           |
| :------------- | :----------------- | :-------------------------- | :------------------------------------ |
| `id`           | `bigint`           | Primary Key, Auto Increment | Job identifier.                       |
| `queue`        | `string`           | Index                       | Queue name.                           |
| `payload`      | `longtext`         |                             | Job payload.                          |
| `attempts`     | `unsigned tinyint` |                             | Number of attempts.                   |
| `reserved_at`  | `unsigned integer` | Nullable                    | Timestamp when job was reserved.      |
| `available_at` | `unsigned integer` |                             | Timestamp when job becomes available. |
| `created_at`   | `unsigned integer` |                             | Job creation timestamp.               |

#### `job_batches`
| Column           | Type         | Constraints | Description             |
| :--------------- | :----------- | :---------- | :---------------------- |
| `id`             | `string`     | Primary Key | Batch identifier.       |
| `name`           | `string`     |             | Batch name.             |
| `total_jobs`     | `integer`    |             | Total jobs in batch.    |
| `pending_jobs`   | `integer`    |             | Pending jobs in batch.  |
| `failed_jobs`    | `integer`    |             | Failed jobs in batch.   |
| `failed_job_ids` | `longtext`   |             | IDs of failed jobs.     |
| `options`        | `mediumtext` | Nullable    | Batch options.          |
| `cancelled_at`   | `integer`    | Nullable    | Cancellation timestamp. |
| `created_at`     | `integer`    |             | Creation timestamp.     |
| `finished_at`    | `integer`    | Nullable    | Completion timestamp.   |

#### `failed_jobs`
| Column       | Type        | Constraints                 | Description            |
| :----------- | :---------- | :-------------------------- | :--------------------- |
| `id`         | `bigint`    | Primary Key, Auto Increment | Failed job identifier. |
| `uuid`       | `string`    | Unique                      | Unique identifier.     |
| `connection` | `text`      |                             | Queue connection.      |
| `queue`      | `text`      |                             | Queue name.            |
| `payload`    | `longtext`  |                             | Job payload.           |
| `exception`  | `longtext`  |                             | Exception trace.       |
| `failed_at`  | `timestamp` | Use Current                 | Failure timestamp.     |

---

### 6. `admins`
Table for administrative users (separate from standard users).

| Column           | Type        | Constraints                 | Description                |
| :--------------- | :---------- | :-------------------------- | :------------------------- |
| `id`             | `bigint`    | Primary Key, Auto Increment | Unique identifier.         |
| `name`           | `string`    |                             | Full name.                 |
| `username`       | `string`    | Unique                      | Unique username for login. |
| `password`       | `string`    |                             | Hashed password.           |
| `remember_token` | `string`    | Nullable                    | Remember me token.         |
| `created_at`     | `timestamp` | Nullable                    | Creation timestamp.        |
| `updated_at`     | `timestamp` | Nullable                    | Update timestamp.          |

---

### 7. `categories`
Categories for articles.

| Column          | Type               | Constraints                 | Description                          |
| :-------------- | :----------------- | :-------------------------- | :----------------------------------- |
| `id`            | `bigint`           | Primary Key, Auto Increment | Unique identifier.                   |
| `name`          | `string(50)`       | Unique                      | Display name.                        |
| `slug`          | `string(50)`       | Unique                      | URL-friendly slug.                   |
| `description`   | `string(255)`      |                             | Brief description.                   |
| `article_count` | `unsigned integer` | Default: 0                  | Cached count of associated articles. |
| `created_at`    | `timestampTz`      | Nullable                    | Creation timestamp (with timezone).  |
| `updated_at`    | `timestampTz`      | Nullable                    | Update timestamp (with timezone).    |

---

### 8. `tags`
Tags for articles.

| Column          | Type               | Constraints                 | Description                          |
| :-------------- | :----------------- | :-------------------------- | :----------------------------------- |
| `id`            | `bigint`           | Primary Key, Auto Increment | Unique identifier.                   |
| `name`          | `string(50)`       | Unique                      | Display name.                        |
| `slug`          | `string(50)`       | Unique                      | URL-friendly slug.                   |
| `description`   | `string`           |                             | Brief description.                   |
| `article_count` | `unsigned integer` | Default: 0                  | Cached count of associated articles. |
| `created_at`    | `timestampTz`      | Nullable                    | Creation timestamp (with timezone).  |
| `updated_at`    | `timestampTz`      | Nullable                    | Update timestamp (with timezone).    |

---

### 9. `tech_stacks`
Tech stacks for projects.

| Column          | Type               | Constraints                 | Description                          |
| :-------------- | :----------------- | :-------------------------- | :----------------------------------- |
| `id`            | `bigint`           | Primary Key, Auto Increment | Unique identifier.                   |
| `name`          | `string(50)`       | Unique                      | Display name.                        |
| `slug`          | `string(50)`       | Unique                      | URL-friendly slug.                   |
| `description`   | `string`           |                             | Brief description.                   |
| `project_count` | `unsigned integer` | Default: 0                  | Cached count of associated projects. |
| `created_at`    | `timestampTz`      | Nullable                    | Creation timestamp (with timezone).  |
| `updated_at`    | `timestampTz`      | Nullable                    | Update timestamp (with timezone).    |

---

### 10. `projects`
Portfolio projects.

| Column          | Type               | Constraints                 | Description                          |
| :-------------- | :----------------- | :-------------------------- | :----------------------------------- |
| `id`            | `bigint`           | Primary Key, Auto Increment | Unique identifier.                   |
| `title`         | `string(255)`      | Index                       | Project title.                       |
| `slug`          | `string(255)`      | Unique                      | URL-friendly slug.                   |
| `description`   | `text`             |                             | Full project description.            |
| `excerpt`       | `string(255)`      |                             | Short project summary.               |
| `thumbnail`     | `string`           | Nullable                    | Path to cover image.                 |
| `live_url`      | `string`           | Nullable                    | URL to live project.                 |
| `repo_url`      | `string`           | Nullable                    | URL to project repository.           |
| `status`        | `enum`             | Index, Default: 'ongoing'   | Status: `ongoing`, `completed`.      |
| `featured`      | `boolean`          | Index, Default: false       | Flag for featured projects.          |
| `created_at`    | `timestampTz`      | Nullable                    | Creation timestamp.                  |
| `updated_at`    | `timestampTz`      | Nullable                    | Update timestamp.                    |

---

### 11. `project_tech_stack` (Pivot)
Many-to-many relationship between projects and tech stacks.

| Column          | Type     | Constraints                     | Description             |
| :-------------- | :------- | :------------------------------ | :---------------------- |
| `project_id`    | `bigint` | FK (`projects`), Cascade Delete | ID of the project.      |
| `tech_stack_id` | `bigint` | FK (`tech_stacks`), Cascade Delete | ID of the tech stack.   |

**Primary Key:** `(project_id, tech_stack_id)`

---

### 12. `articles`
Main content table for portfolio posts.

| Column         | Type          | Constraints                 | Description                               |
| :------------- | :------------ | :-------------------------- | :---------------------------------------- |
| `id`           | `bigint`      | Primary Key, Auto Increment | Unique identifier.                        |
| `author_id`    | `bigint`      | FK (`admins`), Index        | ID of the admin who wrote the article.    |
| `category_id`  | `bigint`      | FK (`categories`), Index    | ID of the associated category.            |
| `title`        | `string(255)` | Index                       | Article title.                            |
| `slug`         | `string(255)` | Unique                      | URL-friendly slug.                        |
| `excerpt`      | `string(255)` |                             | Short summary of the article.             |
| `content`      | `jsonb`       |                             | Rich text content (TipTap JSON).          |
| `status`       | `enum`        | Index, Default: 'draft'     | Status: `draft`, `published`, `archived`. |
| `published_at` | `timestampTz` | Nullable                    | Date and time when published.             |
| `created_at`   | `timestampTz` | Nullable                    | Creation timestamp.                       |
| `updated_at`   | `timestampTz` | Nullable                    | Update timestamp.                         |
| `deleted_at`   | `timestampTz` | Nullable (Soft Delete)      | Soft deletion timestamp.                  |

---

### 13. `article_tag` (Pivot)
Many-to-many relationship between articles and tags.

| Column       | Type     | Constraints                     | Description        |
| :----------- | :------- | :------------------------------ | :----------------- |
| `article_id` | `bigint` | FK (`articles`), Cascade Delete | ID of the article. |
| `tag_id`     | `bigint` | FK (`tags`), Cascade Delete     | ID of the tag.     |

**Primary Key:** `(article_id, tag_id)`
