const db = require('./db');
let titles;

// SQL
const query_titles= "select title_id, title from titles";

db.connection.query(query_company, function (err, result, fields) {
    if (err) {
        throw err;
    } else {
        // console.log("Firma:" + result[0].Firmanavn);
        result_company = result;
        module.exports.result_company = result_company;
    }
});

