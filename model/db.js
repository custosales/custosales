const { Client } = require('pg');
const dbclient = new Client({
  user: 'custosales',
  host: 'custosales.com',
  database: 'custosales',
  password: 'custo432a',
  port: 5432
});

module.exports.dbclient = dbclient;

