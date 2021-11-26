var express = require('express');
var router = express.Router();

/* GET eneheter page. */
router.get('/', function(req, res, next) {
  res.render('login', { title: 'Login',login_text: 'Logg inn', logofile:"/images/logo_blue_200.png" });
});

module.exports = router;
