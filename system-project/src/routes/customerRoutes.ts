import { Router } from 'express';
import CustomerController from '../controllers/customerController';

const router = Router();
const customerController = new CustomerController();

export default function setCustomerRoutes(app) {
    app.use('/customers', router);
    router.get('/', customerController.listCustomers);
    router.post('/add', customerController.addCustomer);
}