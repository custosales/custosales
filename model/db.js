const { Pool } = require('pg')
const pool = new Pool({
  user: 'custosales',
  host: 'custosales.com',
  database: 'custosales',
  password: 'custo432a',
  port: 5432
});

pool.on('error', (err, client) => {
  console.error('Unexpected error on idle client', err)
  process.exit(-1)
})

module.exports.pool = pool;

