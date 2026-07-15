```markdown
# 🏰 Hogwarts Portal

A full-stack PHP/MySQL school management portal inspired by Hogwarts School of Witchcraft and Wizardry. Built with a custom MVC architecture from scratch — no Laravel, no Symfony.

Students can register, enroll in courses, submit assignments, earn house points, shop in Diagon Alley, and track the House Cup leaderboard. Professors and Dumbledore manage students, courses, assignments, scores, and academic dashboards.

---

## ✨ Features

- **JWT Authentication** — Stateless auth using HTTP-only cookies (migrated from PHP Sessions)
- **Role-Based Access Control** — Student / Professor / Dumbledore with middleware protection
- **Sorting Hat** — Randomly assigns house on registration (Gryffindor, Slytherin, Ravenclaw, Hufflepuff)
- **Wand Assignment** — Random wand generated on registration (wood + core combination)
- **Student Panel** — Courses, pending work, quizzes, tasks, assignments, balance, wand data
- **On-Time Submission Workflow** — Awards full points to student and house if submitted before deadline
- **Professor Dashboard** — Manage students, courses, quizzes, tasks, assignments, and scores
- **House Leaderboard** — Backed by `HousePoints` table with automatic DB triggers
- **Diagon Alley Shop** — Buy brooms, potion ingredients, and spell books
- **Student Inventory** — Track owned items with quantities
- **Owl Messaging System** — Students can send and receive messages

---

## 🛠 Tech Stack

- **Backend** — PHP 8.3 (custom MVC, no framework)
- **Database** — MySQL with PDO prepared statements
- **Authentication** — JWT via `firebase/php-jwt`
- **Frontend** — Bootstrap 5, Font Awesome, Plain CSS & JavaScript
- **Containerization** — Docker & Docker Compose

---

## 🔒 Security

- JWT tokens stored in HTTP-only cookies (XSS protection)
- Passwords hashed with bcrypt via `password_hash()`
- Prepared statements (PDO) to prevent SQL injection
- Role-based middleware on every protected route
- POST/Redirect/GET pattern to prevent form resubmission
- Input sanitization with `htmlspecialchars()`

---

## 📁 Folder Structure

> Install `tree` first:
> - Windows: built-in `tree /A`
> - Linux: `sudo apt install tree`

```bash
tree -d -L 3
```

```
.
├── Core
│   ├── DB
│   └── Middleware
├── Http
│   ├── Controllers
│   ├── Forms
│   └── Models
├── public
│   └── assets
└── views
    ├── Dashboard
    ├── inventory
    ├── partials
    ├── registration
    ├── session
    ├── shop
    └── student
```

---

## 🚀 Setup

### Run with Docker

1. Clone the repository.
```bash
git clone https://github.com/w0lfsh4d0w/Hogwarts-Portal.git
cd Hogwarts-Portal
```

2. Build and start the containers.
```bash
docker compose up --build
```

3. Wait until MySQL finishes importing `Core/DB/schema.sql`.

4. Open the app.
```
http://localhost:8888
```

5. Stop the containers.
```bash
docker compose down
```

6. Reset the database if needed.
```bash
docker compose down -v
docker compose up --build
```

**Docker default credentials:**
| Key | Value |
|-----|-------|
| Host (inside Docker) | `db` |
| Host (from machine) | `localhost:3307` |
| Database | `hogwarts_db` |
| Username | `root` |
| Password | `MyRoot@1234` |

---

### Run Locally Without Docker

1. Clone the repository.
```bash
git clone https://github.com/w0lfsh4d0w/Hogwarts-Portal.git
cd Hogwarts-Portal
```

2. Install dependencies.
```bash
composer install
```

3. Create and seed the database.
```bash
mysql -u root -p < Core/DB/schema.sql
```

4. Update database credentials in `config.php`.

5. Start the local PHP server.
```bash
php -S localhost:8888 -t public
```

6. Open the app.
```
http://localhost:8888
```

---

## 👤 Default Demo Users

| Role | Email | Password |
|------|-------|----------|
| Student | `a@gmail.com` | `123456789` |
| Professor | `m@gmail.com` | `000000000` |
| Dumbledore | `dumbledore@hogwarts.edu` | `elderwand123` |

---

## 📍 Useful Paths

| Path | Description |
|------|-------------|
| `/` | Home page |
| `/register` | Student registration |
| `/login` | Login |
| `/student-panel` | Student workspace |
| `/dashboard` | Staff dashboard |
| `/leaderboard` | House rankings |
| `/shop` | Diagon Alley shop |
| `/inventory` | Student inventory |
| `/owlery` | Owl messaging system |

---

## 🏆 Submission & House Points

Students submit from the Student Panel. If the deadline has not passed, the portal creates a `Submission`, awards the assignment's full `max_points`, and inserts a `HousePoints` record. Database triggers automatically update each house total when points are inserted or removed.

---

## 👥 Team

Built as a team project for **IEEE CS Zagazig Student Chapter** — Backend Phase 2 Final Project.
```
