
;(async () => {
  const db = require('./db');
   
  // Connect
    let client = await db.pool.connect()
    console.log("Database connected from model/get_managers");
    

    const first_name = req.body.first_name;
    const last_name = req.body.last_name;
    const username = req.body.username;
    const password_plain = req.body.password;
    const password = bcrypt.hashSync(password_plain, saltRounds);
    const user_email = req.body.user_email;
    const start_date = req.body.start_date;
    const end_date = req.body.end_date;
    const title_id = req.body.title_id;
    const address = req.body.address;
    const zip = req.body.zip;
    const city = req.body.city;
    const signed_contract = req.body.signed_contract;
    const enabled = req.body.enabled;
    const skills = req.body.skills;
    const supervisor_id = req.body.supervisor_id;
    const workplace_id = req.body.workplace_id;
    const department_id = req.body.department_id;
    const manager_id = req.body.manager_id;
    const user_comments = req.body.user_comments;
         


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
  

