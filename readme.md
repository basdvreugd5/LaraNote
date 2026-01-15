# LaraNote

LaraNote is a small Laravel 12 application built as a **clean, idiomatic reference project**.

It demonstrates how I approach Laravel applications today: by leaning on the framework’s conventions, keeping responsibilities clearly separated, and avoiding abstractions unless they are genuinely required.

This repository is intended to be the **primary portfolio example** of my Laravel work, prioritizing clarity, correctness, and maintainability over architectural experimentation or feature breadth.

---

## Purpose

This repository exists as a **portfolio reference**.

It focuses on:
- clear separation of concerns
- idiomatic Laravel patterns
- readable, maintainable code
- testable business rules

It intentionally avoids:
- premature service layers
- custom domain architectures
- heavy frontend frameworks
- over‑engineering

---

## Features

- User authentication (Laravel 12 Livewire starter kit)
- CRUD notes (create, update, archive)
- Authorization via policies
- Validation via Form Requests
- Query scopes for common filters
- Feature & policy tests
- Light / dark mode compatible UI

---

## Architecture Overview

**Request flow:**

```
Request → FormRequest → Controller → Policy → Model → View
```

### Models
- `Note`
  - owns query scopes (`active`, `archived`, `forUser`)
  - contains simple domain behavior (`archive()`)

### Policies
- `NotePolicy`
  - enforces ownership rules
  - enforces max notes per user

### Form Requests
- `StoreNoteRequest`
- `UpdateNoteRequest`

Responsibilities:
- input validation
- authorization delegation to policies

### Controllers
- `NoteController`

Responsibilities:
- orchestration only
- no business logic

---

## Testing

Tests focus on **behavior**, not implementation details:

- Policy tests (authorization rules)
- Feature tests (request → response flow)

No mocking of Eloquent or framework internals.

---

## UI

- Blade + Tailwind
- Uses the Laravel 12 Livewire starter kit layout
- Supports light and dark mode via Tailwind `dark:` variants

UI is intentionally minimal to keep focus on backend correctness.

---

## Why no Services / Domain Layer?

Laravel already provides:
- Controllers (application layer)
- Policies (authorization)
- Form Requests (validation)
- Models & scopes (data access)

Adding extra abstraction here would reduce clarity rather than improve it.

---

## Setup

```bash
composer install
php artisan migrate
php artisan test
php artisan serve
```

---

## Notes

This project favors **clarity over cleverness**.

The goal is to show what clean, idiomatic Laravel code looks like — and nothing more.

