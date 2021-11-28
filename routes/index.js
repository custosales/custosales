var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function (req, res, next) {

  const { Client } = require('pg');
  const client = new Client({
    user: 'custosales',
    host: 'custosales.com',
    database: 'custosales',
    password: 'custo432a',
    port: 5432
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
