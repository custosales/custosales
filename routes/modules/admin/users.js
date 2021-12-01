var express = require('express');
var router = express.Router();

// Connect to database
const get_users = require('../../../model/get_users');

// GET users page.
router.get('/', async function (req, res, next) {
  
    res.render('modules/admin/users', {
      title: 'Brukeroversikt',
      rows: await get_users.users.rows
    });
 
});


module.exports = router;
