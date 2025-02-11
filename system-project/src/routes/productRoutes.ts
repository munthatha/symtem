import { Router } from 'express';
import ProductController from '../controllers/productController';

const router = Router();
const productController = new ProductController();

export function setProductRoutes(app) {
    router.get('/products', productController.listProducts);
    router.post('/products', productController.addProduct);
    app.use('/api', router);
}