var express = require('express');
var router = express.Router();
              
/* GET home page. */
router.get('/', async function (req, res, next) {

  const { getProjects } = require("../model/admin/get_projects");
  const { rows } = await getProjects();
  
    res.render('index', {
      title: 'Custosales',
      projectRows: rows
    });
  

});


router.post('/', function (req, res, next) {
  res.render('index', { title: 'Custosales' });
});


module.exports = router;
