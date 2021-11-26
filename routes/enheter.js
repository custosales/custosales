var express = require('express');
var router = express.Router();

/* GET eneheter page. */
router.get('/', function(req, res, next) {
  res.render('enheter', { title: 'Søk i Enhetsregisteret' });
});

module.exports = router;
