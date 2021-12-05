const bcrypt = require("bcrypt");

function encryptPassword(password) {
  const saltRounds = 10;
  return bcrypt.hashSync(password, saltRounds);
}

module.exports.encryptPassword = encryptPassword;