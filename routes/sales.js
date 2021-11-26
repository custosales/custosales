var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('sales', { title: 'Salg' });
});


router.post('/', function(req, res, next) {
  res.render('sales', { title: 'Salg' });
});


module.exports = router;
