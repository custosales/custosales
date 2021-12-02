
;(async () => {
  const db = require('./db');
   
  // Connect
    let client = await db.pool.connect()
    console.log("Database connected from model/get_workplaces");
    
    // SQL
    const sql= "select user_id, concat(first_name,' ',last_name) as name from users u inner join titles t on u.title_id = t.title_id where t.manager=true order by name";
    // Query
    try {
        const managers = await client.query(sql)
        module.exports.managers = managers;
    } finally {
      // Make sure to release the client before any error handling,
      // just in case the error handling itself throws an error.
      client.release()
    }
  })().catch(err => console.log(err.stack))
  

