var express = require('express');
var router = express.Router();

/* GET users page. */
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

    res.render('modules/admin/users', {
      title: 'Brukeroversikt',
      rows: sql.rows
    });
  
    client.end();
  });



});

module.exports = router;
