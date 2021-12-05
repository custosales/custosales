function validateNewUser({
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

module.exports.validateNewUser = validateNewUser;