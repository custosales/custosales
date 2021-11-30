var express = require('express');
var router = express.Router();

// Connect to database
let db = require("../../../model/db.js");
var client = db.dbclient;

// GET users page.
router.get('/', function (req, res, next) {
  
client.connect();
console.log("Database connected from users/GET");

client.query('SELECT * from users', (err, sql) => {
  if (err) {
    console.error(err); 
    } else {
    res.render('modules/admin/users', {
      title: 'Brukeroversikt',
      rows: sql.rows
     });
     client.end();
    }
  });



});



module.exports = router;
