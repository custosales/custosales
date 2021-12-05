async function saveNewUser({
  body: {
    first_name,
    last_name,
    username,
    password,
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
  },
}) {
  const db = require("./db");
  const bcrypt = require("bcrypt");
  const saltRounds = 10;

  const client = await db.pool.connect();
  console.log("Database connected from model/save_newuser");

  const bcryptedPassword = bcrypt.hashSync(password, saltRounds);
  const {
    signed_contract: contract_validated,
    enabled_validated,
    start_date_validated,
    end_date_validated,
  } = validateFormInput(req);
  
  const sql = {
    text:
      "INSERT INTO users(first_name,last_name,username,password,user_email," +
      "start_date,end_date,title_id,address,zipcode,city,signed_contract,enabled,skills,supervisor_id,workplace_id,department_id,user_comments)" +
      " VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18)",
    values: [
      first_name,
      last_name,
      username,
      bcryptedPassword,
      user_email,
      start_date_validated,
      end_date_validated,
      title_id,
      address,
      zip,
      city,
      contract_validated,
      enabled_validated,
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
  } finally {
    // Make sure to release the client before any error handling,
    // just in case the error handling itself throws an error.
    client.release();
    return newuser;
  }
}

module.exports.saveNewUser = saveNewUser;
//module.exports.saveUser = saveUser;

//)().catch((err) => console.log(err.stack));

function validateFormInput({
  body: {
    first_name,
    last_name,
    username,
    password,
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
  },
}) {
  if (!start_date) start_date = null;
  if (!end_date) end_date = null;
  if (enabled == undefined) enabled = false;
  if (signed_contract == undefined) signed_contract = false;

  return {
    first_name,
    last_name,
    username,
    password,
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
  };
}
