var express = require('express');
const bcrypt = require('bcrypt');
const saltRounds = 10;

var router = express.Router();

/* GET newuser page. */
router.get('/', async function (req, res, next) {

    const get_titles = require('../../../model/get_titles');
    const get_departments = require('../../../model/get_departments');
    const get_workplaces = require('../../../model/get_workplaces');
    const get_managers = require('../../../model/get_managers');


    res.render('modules/admin/newuser', {
        title: 'Ny bruker',
        message: '',
        titles: await get_titles.titles.rows,
        departments: await get_departments.departments.rows,
        workplaces: await get_workplaces.workplaces.rows,
        managers: await get_managers.managers.rows
    });
});

/* Register new user. */
router.post('/', function (req, res, next) {

    const save_newuser = require('../../../model/save_newuser');

    console.log(save_newuser.newuser.rows[0]);

    // res.render('modules/admin/newuser', {
    //     title: 'Ny bruker',
    //     message: `Ny bruker lagret`

    // });

}); // end router.post




module.exports = router;
