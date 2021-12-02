
;(async () => {
    const db = require('./db');
    let titles;
    
    // Connect
    const client = await db.pool.connect()
    console.log("Database connected from model/get_titles");
    
    // SQL
    const sql= "select title_id, title from titles order by title";
    // Query
    try {
        const titles = await client.query(sql)
        module.exports.titles = titles;
    } finally {
      // Make sure to release the client before any error handling,
      // just in case the error handling itself throws an error.
      client.release()
    }
  })().catch(err => console.log(err.stack))
  

