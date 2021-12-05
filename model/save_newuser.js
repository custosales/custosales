const { validateNewUser } = require('./validation')
const { encryptPassword } = require('./utils')

async function saveNewUser(req) {
  const db = require("./db");
  const client = await db.pool.connect();
  console.log("Database connected from model/save_newuser");
  
  const {
    address,
    city,
    department_id,
    enabled,
    end_date,
    first_name,
    last_name,
    password,
    signed_contract,
    skills,
    start_date,
    supervisor_id,
    title_id,
    user_comments,
    user_email,
    username,
    workplace_id,
    zip
  } = validateNewUser(req);

  const encryptedPassword = encryptPassword(password);
  

  const sql = {
    text:
      "INSERT INTO users(first_name,last_name,username,password,user_email," +
      "start_date,end_date,title_id,address,zipcode,city,signed_contract,enabled,skills,supervisor_id,workplace_id,department_id,user_comments)" +
      " VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18)",
    values: [
      first_name,
      last_name,
      username,
      encryptedPassword,
      user_email,
      start_date,
      end_date,
      title_id,
      address,
      zip,
      city,
      signed_contract,
      enabled,
      skills,
      supervisor_id,
      workplace_id,
      department_id,
      user_comments,
    ],
  };

  // Query
  try {
    console.log(sql);
    newuser = client.query(sql);
  } catch(error) {
    console.error(error);
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return newuser;
  }
}

module.exports.saveNewUser = saveNewUser;