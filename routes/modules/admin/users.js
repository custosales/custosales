var express = require("express");
var router = express.Router();
const { getUsers } = require("../../../model/get_users");

// GET users page.
router.get("/", async function (req, res, next) {
  const { rows } = await getUsers();
  const title = "Brukeroversikt";
  res.render("modules/admin/users", {
    title,
    rows,
  });
});

module.exports = router;
