import express from 'express';
import { createConnection } from './database';
import { setAuthRoutes } from './routes/authRoutes';
import { setCustomerRoutes } from './routes/customerRoutes';
import { setProductRoutes } from './routes/productRoutes';

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.set('view engine', 'ejs');

// Database connection
createConnection();

// Routes
setAuthRoutes(app);
setCustomerRoutes(app);
setProductRoutes(app);

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});