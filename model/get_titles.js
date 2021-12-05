async function getTitles() {
  const db = require("./db");
  const sql = "select title_id, title from titles order by title";
  let titles;
  const client = await db.pool.connect();
  // Connect
  try {
    console.log("Database connected from model/get_titles");
    titles = await client.query(sql);
  } catch (error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return titles;
  }
}

module.exports.getTitles = getTitles;