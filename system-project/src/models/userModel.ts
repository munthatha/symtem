class UserModel {
    constructor(database) {
        this.database = database;
    }

    async createUser(username, password, role) {
        const query = 'INSERT INTO users (username, password, role) VALUES (?, ?, ?)';
        const values = [username, password, role];
        return this.database.query(query, values);
    }

    async findUserByUsername(username) {
        const query = 'SELECT * FROM users WHERE username = ?';
        const values = [username];
        const [rows] = await this.database.query(query, values);
        return rows[0];
    }

    async getAllUsers() {
        const query = 'SELECT * FROM users';
        const [rows] = await this.database.query(query);
        return rows;
    }
}

export default UserModel;