var express = require('express');
const get_users = require('../../../model/get_users');

var router = express.Router();



// GET users page.
router.get('/', function (req, res, next) {

    res.render('modules/admin/users', {
      title: 'Brukeroversikt',
      rows: get_users.users.rows
    });
 
});


module.exports = router;
