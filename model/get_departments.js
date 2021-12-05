async function getDepartments() {
  const db = require("./db");
  const sql =
    "select department_id, department_name from departments order by department_name";
  let departments;

  const client = await db.pool.connect();
  console.log("Database connected from model/get_departments");

  try {
    departments = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return departments;
  }
}

module.exports.getDepartments = getDepartments;
//)().catch((err) => console.log(err.stack));
