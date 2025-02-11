export class ProductController {
    private productModel: any;

    constructor(productModel: any) {
        this.productModel = productModel;
    }

    public async listProducts(req: any, res: any) {
        try {
            const products = await this.productModel.getAllProducts();
            res.render('productList', { products });
        } catch (error) {
            res.status(500).send('Error retrieving products');
        }
    }

    public async addProduct(req: any, res: any) {
        try {
            const newProduct = req.body;
            await this.productModel.createProduct(newProduct);
            res.redirect('/products');
        } catch (error) {
            res.status(500).send('Error adding product');
        }
    }
}