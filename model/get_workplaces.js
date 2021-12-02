
;(async () => {
  const db = require('./db');
  let workplaces;
  
  // Connect
    let client = await db.pool.connect()
    console.log("Database connected from model/get_workplaces");
    
    // SQL
    const sql= "select workplace_id, workplace_name, workplace_city from workplaces order by workplace_name";
    // Query
    try {
        const workplaces = await client.query(sql)
        module.exports.workplaces = workplaces;
    } finally {
      // Make sure to release the client before any error handling,
      // just in case the error handling itself throws an error.
      client.release()
    }
  })().catch(err => console.log(err.stack))
  

