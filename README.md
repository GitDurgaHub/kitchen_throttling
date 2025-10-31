# 🍽️ Order Queueing & Kitchen Throttling (Core PHP Implementation)

This project demonstrates a **simple order queueing and kitchen throttling system** built using **Core PHP (without frameworks)** to showcase object-oriented architecture, clean separation of concerns, and design pattern usage.

---

## 🚀 Features

- Create new orders with or without VIP priority.
- Mark orders as completed.
- Retrieve currently active orders.
- Implements kitchen throttling logic (limiting concurrent active orders).
- Structured architecture using **Controller**, **Service**, **Model**, **DTO**, and **Error Handling** layers.
- Uses **PDO** for secure database operations.
- **Singleton design pattern** for database connection.
- Minimal custom routing (regex-based).

---

kitchen_throttling/
│
├── Config.php                  # Database configuration
├── Database.php                # Singleton design pattern for db connection
│
├── src/                        # Core application source code
│   │
│   ├── Controllers/
│   │   └── OrdersController.php    # Handles HTTP requests
│   │
│   ├── Models/
│   │   └── Order.php               # Order model DTO for response
│   │
│   ├── Services/
│   │   └── KitchenService.php      # Business logic and throttling
│   │
│   ├── Repositories/
│   │   └── OrderRepository.php     # Order data access layer (PDO)
│   │
│   ├── DTO/
│   │   ├── CreateOrderRequest.php  # Input data structure
│   │   └── OrderResponse.php       # Output data structure
│   │
│   ├── Exceptions/
│   │   ├── HttpException.php
│   │   └── ValidationException.php
│   │
│   └── Validators/
│       └── CreateOrderValidator.php # Validate input request parameters
│
├── Migrations/
│   └── schema.sql                 # Database setup script
│
├── index.php                      # Entry point and simple router
│
├── .htaccess                      # Route all requests to index.php
│
└── README.md                      # Project documentation



---

## ⚙️ Setup Instructions

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/<your-username>/kitchen_throttling_core.git
cd kitchen_throttling_core


2️⃣ Database Setup

Create a new MySQL database named orders_db

Import the schema:

mysql -u root -p orders_db < Migrations/schema.sql

By default, database credentials are configured as:

Database Name: orders_db

Username: root

Password: (empty string)

You can modify these in Config.php if needed.


3️⃣ Run the Project

You can run this directly from PHP’s built-in server:
php -S localhost:8000 -t public



🧠 API Endpoints

1️⃣ Get Active Orders
GET
http://localhost/kitchen_throttling/orders/active


2️⃣ Create Order
POST
http://localhost/kitchen_throttling/orders

Sample Request Body:
{
    "items": ["coke", "garlic bread"],
    "pickup_time": "2025-10-30T12:30:00Z"
}

VIP Order Example:
{
    "items": ["coke", "garlic bread"],
    "pickup_time": "2025-10-30T12:30:00Z",
    "VIP": true
}


3️⃣ Mark Order as Completed
POST
http://localhost/kitchen_throttling/orders/5/complete


🧩 Technical Highlights
Architecture: Clean MVC-inspired modular architecture.
Design Patterns: Singleton (Database), DTO (data encapsulation).
Error Handling: Centralized try-catch and JSON error responses.
Routing: Simple regex-based routing without external libraries.
Database Layer: PDO prepared statements for secure data access.
Scalability: Logic easily portable to Slim/Laravel if required.


🧑‍💻 Author

Vijaya Durga Prasanna
Senior Software Engineer — PHP | AWS | Angular | Full Stack
LinkedIn: https://www.linkedin.com/in/durgakota-seniorfullstackengineer/
