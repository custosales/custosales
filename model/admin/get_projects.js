async function getProjects() {
  const db = require("../db");
  const sql =
    "select project_id, project_name, project_description,project_start_date,project_end_date, "
    +"project_client_id, project_owner_id, concat(first_name,' ',last_name) as project_owner, p.comments, "
    +"p.project_category_id, pc.project_category_name from projects p "
    +"inner join users u on p.project_owner_id = u.user_id "
    +"inner join project_categories pc on pc.project_category_id = p.project_category_id "
    +"order by project_name";
  let projects;

  const client = await db.pool.connect();
  console.log("Database connected from model/get_projects");

  try {
    projects = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return projects;
  }
}

module.exports.getProjects = getProjects;
//)().catch((err) => console.log(err.stack));
