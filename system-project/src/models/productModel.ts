export class ProductModel {
    private db: any;

    constructor(database: any) {
        this.db = database;
    }

    public async listProducts(): Promise<any> {
        const query = 'SELECT * FROM products';
        const [rows] = await this.db.execute(query);
        return rows;
    }

    public async addProduct(product: { name: string; price: number; description: string }): Promise<any> {
        const query = 'INSERT INTO products (name, price, description) VALUES (?, ?, ?)';
        const result = await this.db.execute(query, [product.name, product.price, product.description]);
        return result;
    }
}