async function getProjectCategories() {
  const db = require("../db");
  const sql = "select project_category_id, project_category_name from project_categories order by project_category_name";
  let projectCategories;
  // Connect
  let client = await db.pool.connect();
  console.log("Database connected from model/admin/get_project_categories_name_id");
  // SQL
  // Query
  try {
    projectCategories = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return projectCategories;
  }
}

module.exports.getProjectCategories = getProjectCategories;
// })().catch((err) => console.log(err.stack));
