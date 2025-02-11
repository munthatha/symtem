# System Project

This project is a web application that provides user and admin login functionality, along with customer and product management features. It uses MySQL as the database to store user, customer, and product information.

## Features

- **User and Admin Authentication**: Secure login functionality for users and administrators.
- **Customer Management**: Ability to list and add customers.
- **Product Management**: Ability to list and add products.

## Project Structure

```
system-project
├── src
│   ├── controllers
│   │   ├── authController.ts
│   │   ├── customerController.ts
│   │   └── productController.ts
│   ├── models
│   │   ├── userModel.ts
│   │   ├── customerModel.ts
│   │   └── productModel.ts
│   ├── routes
│   │   ├── authRoutes.ts
│   │   ├── customerRoutes.ts
│   │   └── productRoutes.ts
│   ├── views
│   │   ├── login.ejs
│   │   ├── adminDashboard.ejs
│   │   ├── customerList.ejs
│   │   ├── addCustomer.ejs
│   │   ├── productList.ejs
│   │   └── addProduct.ejs
│   ├── app.ts
│   └── database.ts
├── package.json
├── tsconfig.json
└── README.md
```

## Installation

1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd system-project
   ```
3. Install the dependencies:
   ```
   npm install
   ```

## Usage

1. Start the application:
   ```
   npm start
   ```
2. Access the application in your web browser at `http://localhost:3000`.

## Database Setup

Make sure to set up a MySQL database and update the database connection details in `src/database.ts`.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License.