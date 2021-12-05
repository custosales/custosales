
;(async () => {
  const db = require('./db');
  const bcrypt = require('bcrypt');
  const saltRounds = 10;
     
  // Connect
    let client = await db.pool.connect()
    console.log("Database connected from model/save_newuser");
    
let save = (req) => {
  const first_name = req.body.first_name;
  const last_name = req.body.last_name;
  const username = req.body.username;
  const password_plain = req.body.password;
  const password = bcrypt.hashSync(password_plain, saltRounds);
  const user_email = req.body.user_email;
  let start_date = null;
  if(req.body.start_date!='') {
    start_date = req.body.start_date;
  }
  let end_date = null;
 if(req.body.end_date!='') {
   end_date = req.body.end_date;
  } 
    
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
  const user_comments = req.body.user_comments;
 
  const sql = {
    text: 'INSERT INTO users(first_name,last_name,username,password,user_email,'
    +'start_date,end_date,title_id,address,zipcode,city,signed_contract,enabled,skills,supervisor_id,workplace_id,department_id,user_comments)'
    +' VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18)', values: [first_name,last_name,username,password,user_email,start_date,end_date,title_id,address,zip,city,signed_contract,enabled,skills,supervisor_id,workplace_id,department_id,user_comments]
  }
  
  // Query
  try {
    console.log(sql);
    const newuser = client.query(sql);
} finally {
  // Make sure to release the client before any error handling,
  // just in case the error handling itself throws an error.
  client.release()
}
 
}

module.exports.save = save; 


})().catch(err => console.log(err.stack))
      
