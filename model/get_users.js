async function getUsers() {
  const db = require("./db");
  const sql = "select * from users order by user_id";
  let users;
  // Connect
  let client = await db.pool.connect();
  console.log("Database connected from model/get_users");
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
