# GYMPACT - Modern Gym Management System 🏋️‍♂️

GYMPACT is a modern, full-stack web application designed for gym management. It provides a seamless experience for members to book classes and manage their profiles, while offering administrators powerful tools to oversee gym operations.

![Project Hero](assets/images/chestpress.webp)
_(Note: Screenshot or representative image)_

## 🚀 Features

### For Members

- **Modern Dashboard**: View available classes and upcoming schedules.
- **Class Booking**: Book classes with a simulated payment gateway.
- **User Profile**: A sleek, glassmorphism-styled profile page to manage personal details.
- **Membership Plans**: Explore and subscribe to flexible membership tiers.

### For Admins

- **Admin Dashboard**: comprehensive overview of active classes, total members, and growth stats.
- **Class Management**:
  - Add new classes with detailed attributes (Price, Category, Capacity, Schedule).
  - Delete outdated classes.
  - Rich data input: Categories (Strength, Cardio, Yoga, etc.), Pricing, and Optional Descriptions.
- **User Oversight**: View a list of recently registered members.

## 🛠️ Technology Stack

- **Backend**: PHP (Vanilla)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (Custom Properties, Flexbox/Grid), JavaScript
- **Styling**: Custom dark theme with specific brand colors (`#FFE500` Yellow accent).

## ⚙️ Installation & Setup

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/yourusername/GYMPACT_REWORK.git
    cd GYMPACT_REWORK
    ```

2.  **Database Setup**

    - Open your MySQL administration tool (e.g., phpMyAdmin).
    - Create a new database named `gym_db`.
    - Import the `database.sql` file located in the root directory.

3.  **Configuration**

    - Open `config/db.php` and verify the database credentials:
      ```php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "gym_db";
      ```

4.  **Run the Application**
    - Place the project folder in your local server directory (e.g., `htdocs` for XAMPP).
    - Navigate to `http://localhost/GYMPACT_REWORK` in your browser.

## 🔑 Default Credentials

**Admin Account**

- Email: `admin@gympact.com`
- Password: `admin123`

**Test User**

- Email: `john@gympact.com`
- Password: `user123`

## 🎨 UI/UX Highlights

- **Global Yellow Scrollbar**: Custom webkit scrollbar matching the brand.
- **Glassmorphism**: Used on profile cards for a premium feel.
- **Responsive Design**: Optimized for various screen sizes.

---

Built with 💪 by GYMPACT Team.
