async function getUsers() {
  const db = require("../db");
  const sql = "select user_id, concat(first_name,' ',last_name) as name from users order by last_name, first_name";
  let users;
  // Connect
  let client = await db.pool.connect();
  console.log("Database connected from model/admin/get_user_name_id");
  // SQL
  // Query
  try {
    users = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return users;
  }
}

module.exports.getUsers = getUsers;
// })().catch((err) => console.log(err.stack));
