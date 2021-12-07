var express = require("express");
var router = express.Router();
const { getProjects } = require("../../../model/admin/get_projects");

// GET users page.
router.get("/", async function (req, res, next) {
  const { rows } = await getProjects();
  const response = {
    title: "Prosjektoversikt",
    rows,
  };
  
  res.render("modules/admin/projects", response);
});

module.exports = router;
