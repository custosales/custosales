async function getClients() {
  const db = require("../db");
  const sql =
    "select company_id, company_name from companies c inner join company_status cs on c.company_status_id = cs.company_status_id where cs.customer = true  order by company_name";
  let clients;

  let client = await db.pool.connect();

  console.log("Database connected from model/get_managers");
  try {
    clients = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return clients;
  }
}

//)().catch((err) => console.log(err.stack));

module.exports.getClients = getClients;
