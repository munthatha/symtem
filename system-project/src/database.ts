import mysql from 'mysql';

const db = mysql.createConnection({
    host: 'localhost',
    user: 'your_username',
    password: 'your_password',
    database: 'your_database_name'
});

db.connect((err) => {
    if (err) {
        console.error('Database connection failed: ' + err.stack);
        return;
    }
    console.log('Connected to database.');
});

export const query = (sql: string, values: any[]) => {
    return new Promise((resolve, reject) => {
        db.query(sql, values, (error, results) => {
            if (error) {
                return reject(error);
            }
            resolve(results);
        });
    });
};