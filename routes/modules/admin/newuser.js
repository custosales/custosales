var express = require('express');
const bcrypt = require('bcrypt');
const saltRounds = 10;
const get_titles = require('../../../model/get_titles');
const get_departments = require('../../../model/get_departments');
const get_workplaces = require('../../../model/get_workplaces');
const get_managers = require('../../../model/get_managers');

var router = express.Router();

console.log("Database connected from newuser/GET");


/* GET newuser page. */
router.get('/', async function(req, res, next) {
  

      res.render('modules/admin/newuser', { 
      title: 'Ny bruker', 
      message: '',
      titles : await get_titles.titles.rows,
      departments : await get_departments.departments.rows,
      workplaces : await get_workplaces.workplaces.rows,
      managers : await get_managers.managers.rows
    });
});

/* Register new user. */
router.post('/', function(req, res, next) {

    
    const first_name = req.body.first_name;
    const last_name = req.body.last_name;
    const username = req.body.username;
    const password_plain = req.body.password;
    const password = bcrypt.hashSync(password_plain, saltRounds);
    const user_email = req.body.user_email;
    const start_date = req.body.start_date;
    const end_date = req.body.end_date;
    const title_id = req.body.title_id;
    const enabled = req.body.enabled;
    const address = req.body.address;
    const zip = req.body.zip;
    const city = req.body.city;
    const signed_contract = req.body.signed_contract;
    const contract_id = req.body.contract_id;
    const skills = req.body.skills;
    const supervisor_id = req.body.supervisor_id;
    const workplace_id = req.body.workplace_id;
    const user_comments = req.body.user_comments;
         

    
    res.render('newuser', {
        title: 'Ny bruker',
        message: `Ny bruker ${navn} lagret`

    });
    
}); // end router.post




module.exports = router;
