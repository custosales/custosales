
;(async () => {
    const db = require('./db');
    let titles;
    
    // Connect
    const client = await db.pool.connect()
    console.log("Database connected from model/get_departmens");
    
    // SQL
    const sql= "select department_id, department_name from departments order by department_name";
    // Query
    try {
        const departments = await client.query(sql)
        module.exports.departments = departments;
    } finally {
      // Make sure to release the client before any error handling,
      // just in case the error handling itself throws an error.
      client.release()
    }
  })().catch(err => console.log(err.stack))
  

