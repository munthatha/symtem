export class CustomerController {
    private customerModel: any;

    constructor(customerModel: any) {
        this.customerModel = customerModel;
    }

    public async listCustomers(req: any, res: any) {
        try {
            const customers = await this.customerModel.getAllCustomers();
            res.render('customerList', { customers });
        } catch (error) {
            res.status(500).send('Error retrieving customers');
        }
    }

    public async addCustomer(req: any, res: any) {
        try {
            const newCustomer = req.body;
            await this.customerModel.createCustomer(newCustomer);
            res.redirect('/customers');
        } catch (error) {
            res.status(500).send('Error adding customer');
        }
    }
}