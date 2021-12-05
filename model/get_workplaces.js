async function getWorkPlaces() {
  const db = require("./db");
  const sql =
    "select workplace_id, workplace_name, workplace_city from workplaces order by workplace_name";
  let workplaces;
  let client = await db.pool.connect();
  console.log("Database connected from model/get_workplaces");
  try {
    workplaces = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return workplaces;
  }
}
//)().catch((err) => console.log(err.stack));

module.exports.getWorkPlaces = getWorkPlaces;
