var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function (req, res, next) {

  const { Client } = require('pg');
  const client = new Client({
    user: process.env.DB_USER,
    host: process.env.DB_HOST,
    database: process.env.DB_DATABASE,
    password: process.env.DB_PASSWORD,
    port: process.env.DB_PORT
  });

  client.connect();

  client.query('SELECT * from users', (err, sql) => {

    console.log(err, "Hei", sql.rows[0]);

    res.render('index', {
      title: 'Custosales',
      sql: sql
    });
  
    client.end();
  });




});


router.post('/', function (req, res, next) {
  res.render('index', { title: 'Custosales' });
});


module.exports = router;
