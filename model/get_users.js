
;(async () => {
  const db = require('./db');
  let titles;
  
  // Connect
    let client = await db.pool.connect()
    console.log("Database connected from model/get_titles");
    
    // SQL
    const sql= "select * from users order by user_id";
    // Query
    try {
        const users = await client.query(sql)
        console.log(users.rows[0])
        module.exports.users = users;
    } finally {
      // Make sure to release the client before any error handling,
      // just in case the error handling itself throws an error.
      client.release()
    }
  })().catch(err => console.log(err.stack))
  

