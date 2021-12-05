var express = require('express');
const bcrypt = require('bcrypt');
const saltRounds = 10;
const { getTitles } = require('../../../model/get_titles');
const get_departments = require('../../../model/get_departments');
const get_workplaces = require('../../../model/get_workplaces');
const get_managers = require('../../../model/get_managers');

var router = express.Router();

/* GET newuser page. */
router.get('/', async function (req, res, next) {
    const titles = await getTitles();
    res.render('modules/admin/newuser', {
        title: 'Ny bruker',
        message: '',
        titles: titles.rows,
        departments: get_departments.departments.rows,
        workplaces: get_workplaces.workplaces.rows,
        managers: get_managers.managers.rows
    });
});

/* Register new user. */
router.post('/', function (req, res, next) {

    const save_newuser = require('../../../model/save_newuser');
    save_newuser.save(req);

   

    // res.render('modules/admin/newuser', {
    //     title: 'Ny bruker',
    //     message: `Ny bruker lagret`

    // });

}); // end router.post




module.exports = router;
