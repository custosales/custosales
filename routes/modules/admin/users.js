var express = require('express');
var router = express.Router();



// GET users page.
router.get('/', async function (req, res, next) {

  const get_users = require('../../../model/get_users');


    res.render('modules/admin/users', {
      title: 'Brukeroversikt',
      rows: await get_users.users.rows
    });
 
});


module.exports = router;
