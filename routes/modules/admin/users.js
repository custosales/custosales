var express = require("express");
var router = express.Router();
const { getUsers } = require("../../../model/get_users");

// GET users page.
router.get("/", async function (req, res, next) {
  const { rows } = await getUsers();
  const response = {
    title: "Brukeroversikt",
    rows,
  };
  
  res.render("modules/admin/users", response);
});

module.exports = router;
