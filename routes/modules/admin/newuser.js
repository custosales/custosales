var express = require("express");
const { getTitles } = require("../../../model/get_titles");
const { getDepartments } = require("../../../model/get_departments");
const { getWorkPlaces } = require("../../../model/get_workplaces");
const { getManagers } = require("../../../model/get_managers");
const { saveNewUser } = require("../../../model/save_newuser");
var router = express.Router();

/* GET newuser page. */
router.get("/", async function (req, res, next) {
  const titles = await getTitles();
  const managers = await getManagers();
  const departments = await getDepartments();
  const workplaces = await getWorkPlaces();

  res.render("modules/admin/newuser", {
    title: "Ny bruker",
    message: "",
    titles: titles.rows,
    departments: departments.rows,
    workplaces: workplaces.rows,
    managers: managers.rows,
  });
});

/* Register new user. */
router.post("/", async function (req, res, next) {
  const saved = await saveNewUser(req);
  console.log(saved);
  res.redirect('/users');
  // res.render('modules/admin/newuser', {
  //     title: 'Ny bruker',
  //     message: `Ny bruker lagret`

  // });
}); // end router.post

module.exports = router;
