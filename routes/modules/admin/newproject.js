var express = require("express");
const { getUsers } = require("../../../model/admin/get_users_name_id");
const { getClients } = require("../../../model/admin/get_clients_name_id");
const { getProjectCategories } = require("../../../model/admin/get_project_categories_name_id");
var router = express.Router();

/* GET newuser page. */
router.get("/", async function (req, res, next) {
  const get_users = getUsers();
  const get_clients = getClients();
  const get_project_categories = getProjectCategories();

  const [users, clients, projectCategories] = await Promise.all([
    get_users,
    get_clients,
    get_project_categories,
  ]);

  res.render("modules/admin/newproject", {
    title: "Nytt prosjekt",
    message: "",
    users: users.rows,
    clients: clients.rows,
    projectCategories: projectCategories.rows,
  });
});

/* Register new user. */
router.post("/", async function (req, res, next) {
  const saved = await saveNewUser(req);
  console.log(saved);
  res.redirect("modules/admin/projects");
  // res.render('modules/admin/newuser', {
  //     title: 'Ny bruker',
  //     message: `Ny bruker lagret`

  // });
}); // end router.post

module.exports = router;
