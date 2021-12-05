async function getManagers() {
  const db = require("./db");
  const sql =
    "select user_id, concat(first_name,' ',last_name) as name from users u inner join titles t on u.title_id = t.title_id where t.manager=true order by name";
  let managers;

  let client = await db.pool.connect();

  console.log("Database connected from model/get_managers");
  try {
    managers = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return managers;
  }
}

//)().catch((err) => console.log(err.stack));

module.exports.getManagers = getManagers;
