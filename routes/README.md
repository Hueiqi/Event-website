# MyGovEvent — Laravel Source Files

This zip contains ONLY the custom application files for the MyGovEvent system
(matching your report's ERD, MVC architecture, and system requirements).
It is NOT a full Laravel project by itself — you must merge these into a
fresh Laravel installation.

## Folder structure in this zip

```
app/
├── Models/                  (6 files - Agency, User, Category, Event, Registration, PresentationMaterial)
└── Http/
    ├── Controllers/         (9 files)
    │   └── Auth/AuthController.php
    └── Middleware/CheckRole.php

bootstrap/app.php             (replace your existing file)

database/
├── migrations/                (6 files, run in order)
└── seeders/DatabaseSeeder.php

routes/web.php                (replace your existing file)

resources/views/               (all Blade templates)
├── layouts/app.blade.php
├── auth/ (login, register)
├── events/ (public-index, show, create, edit, index, registrations, report)
├── dashboard/ (admin, agency-admin, organizer, participant)
├── agencies/ (index, create, edit, reports)
├── users/ (index, profile)
├── categories/index.blade.php
├── admin/ (reports, activity)
├── certificates/template.blade.php
└── registrations/questionnaire.blade.php
```

## Setup steps

1. Create a fresh Laravel project (if you haven't already):
   ```bash
   composer create-project laravel/laravel mygovevent
   cd mygovevent
   ```

2. Copy every folder from this zip INTO your `mygovevent` project root,
   merging with the existing folders (don't overwrite `vendor`, `config`,
   `public`, etc. — those stay as Laravel generated them).

3. Install the PDF package for e-certificates:
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

4. Set your database credentials in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_DATABASE=mygovevent
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Create the database, then run:
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   php artisan serve
   ```

6. Visit http://127.0.0.1:8000

   Seeded admin login: **admin@jdn.gov.my** / **password**

## Notes

- `php artisan storage:link` is required for presentation material downloads
  to work (files are stored in `storage/app/public`).
- Role-based access is enforced via `CheckRole` middleware registered as the
  `role` alias in `bootstrap/app.php`.

## Email Service (Section 4.1/4.2 of the report)

Real `Mail` classes are wired up for every email-triggering feature named in
the report:

| Trigger | Mailable | Where it's sent from |
|---|---|---|
| Registration | `AccountActivationMail` | `AuthController::register()` — signed, expiring link |
| Event registration | `RegistrationConfirmationMail` | `RegistrationController::store()` |
| Event cancelled | `EventCancelledMail` | `EventController::destroy()` |
| Organizer announcement | `EventAnnouncementMail` | `EventController::announce()` |

For testing without a real mail server, set this in `.env` — emails will be
written to `storage/logs/laravel.log` instead of actually sending:
```
MAIL_MAILER=log
```
To send real email (e.g. for your demo), switch to `smtp` and fill in
`MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`, etc.

## Digital Attendance Slip + QR Code Generator (Section 2.2 / 4.1)

`RegistrationController::attendanceSlip()` renders
`registrations/attendance-slip.blade.php`, which displays the participant's
`qr_code` as an actual scannable QR image (via the free
`api.qrserver.com` image endpoint — no package install needed). This
implements the "Attendance Slip / Digital attendance verification" function
from Section 2.2 and the "QR Code Generator" external service named in the
Section 4.1 architecture diagram.
