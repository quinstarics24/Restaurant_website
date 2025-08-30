
# 🍽️ Aunty Cos Kitchen – Restaurant Website

Welcome to **Aunty Cos Kitchen**, a responsive and modern restaurant website designed to showcase daily specials, menu items, and allow customers to reserve meals or contact the restaurant for delivery. This project brings together an attractive frontend, a functional admin backend, and a seamless user experience.


## 🔹 Features

### Frontend (Customer-Facing)

* **Homepage: Displays hero section, featured meals, and daily specials.
* **Gallery: A beautiful visual showcase of meals and dishes.
* **Contact & Reservation:** Users can contact the restaurant or reserve meals.
* **Responsive Design:** Fully responsive on mobile, tablet, and desktop screens.
* **Meal Descriptions:** All dishes come with names and detailed descriptions.

### Admin Dashboard (Backend)

* **Gallery Management:** Upload multiple meal images, add names and descriptions.
* **Delete Images:** Remove meals easily from the gallery.
* **Secure Login:** Admin authentication ensures only authorized users manage content.
* **Instant Frontend Updates:** Any change in the backend reflects on the website immediately.


## 🔹 Technologies Used

* **Frontend:** HTML5, CSS3, JavaScript, Font Awesome, Google Fonts.
* **Backend:** PHP, MySQL (using `mysqli` for database interaction).
* **Server:** Local development with XAMPP / Apache.


## 🔹 Database Structure

### Table: `gallery_images`

| Column              | Type                            | Description              |
| ------------------- | ------------------------------- | ------------------------ |
| `id`                | INT PRIMARY KEY AUTO\_INCREMENT | Unique ID for each image |
| `image_name`        | VARCHAR(255)                    | Name of the meal/dish    |
| `image_filename`    | VARCHAR(255)                    | Stored image file name   |
| `image_description` | TEXT                            | Description of the meal  |
| `upload_date`       | DATE                            | Date of upload           |
| `created_at`        | TIMESTAMP DEFAULT               |                          |
