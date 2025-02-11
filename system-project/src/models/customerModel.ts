export class CustomerModel {
    private db: any;

    constructor(db: any) {
        this.db = db;
    }

    public async listCustomers(): Promise<any> {
        const query = 'SELECT * FROM customers';
        const [rows] = await this.db.execute(query);
        return rows;
    }

    public async addCustomer(customerData: any): Promise<any> {
        const query = 'INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)';
        const { name, email, phone } = customerData;
        const [result] = await this.db.execute(query, [name, email, phone]);
        return result;
    }
}