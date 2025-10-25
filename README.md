🧍‍♂️ Student Search & Management System

A simple **PHP + MySQL** project built to practice backend logic and AJAX integration.  
This system allows users to **search, filter, sort, and paginate student records** without reloading the page.


 🚀 Features

- **AJAX Live Search** – instantly filter students by name or keyword without refreshing.  
- **Sorting by Columns** – sort students by ID, Name, Class, or Gender.  
- **Filtering** – filter by class and gender using dropdowns.  
- **Pagination** – handle large student lists with clean pagination logic.  
- **Interactive CSS** – responsive and user-friendly UI with dynamic hover effects.  
- **Comments Section** – supports adding and displaying comments (MySQL-based).  

---

## 🧠 Technologies Used

| Category | Tools / Languages |
|-----------|------------------|
| Backend   | PHP (Core PHP, MySQLi / PDO) |
| Frontend  | HTML, CSS, JavaScript, jQuery |
| Database  | MySQL |
| Extra     | AJAX for asynchronous data loading |

---

## ⚙️ Project Structure

student-search/ │ ├── index.php              # Main entry page (with AJAX search UI) ├── fetch_students.php     # Backend script to fetch data (with filters & sorting) ├── add_comment.php        # Handles comment submission │ ├── assets/ │   ├── css/ │   │   └── style.css │   └── js/ │       └── main.js │ ├── includes/ │   └── db_connect.php     # Database connection file │ └── README.md

---

## 📚 How It Works

1. User types in the search box → AJAX sends the input to `fetch_students.php`
2. Server queries the database and returns matching results in JSON or HTML
3. Results appear instantly in the table without page reload
4. Sorting and filtering are handled via AJAX calls
5. Comments are stored and fetched from the MySQL database

---

## 🧩 Database Structure (Example)

**Table: students**

| id | name | class | gender |
|----|------|--------|--------|
| 1 | John Doe | Form 3 | Male |
| 2 | Mary Kim | Form 2 | Female |

**Table: comments**

| id | student_id | comment | created_at |
|----|-------------|----------|-------------|

---

## 💻 Installation

1. Clone or download this repository  
   ```bash
   git clone https://github.com/albert-victor/Student-Search-and-Pagination-system.git

2. Move the folder to your XAMPP htdocs directory

3. Create a new MySQL database (e.g., student_db)

// you did not add it ?
 
4. Import the .sql file included in the project

5. Open your browser and visit:

http://localhost/student-search/



⭐ Future Improvements

Add authentication (Login/Logout)

Integrate Laravel for MVC structure

Export data to Excel or PDF

Add student photo uploads



🧡 If you find this project helpful, star it on GitHub!
