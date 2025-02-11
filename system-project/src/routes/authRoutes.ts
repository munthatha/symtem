import { Router } from 'express';
import AuthController from '../controllers/authController';

const router = Router();
const authController = new AuthController();

export function setAuthRoutes(app) {
    router.post('/login', authController.login);
    router.post('/logout', authController.logout);

    app.use('/auth', router);
}