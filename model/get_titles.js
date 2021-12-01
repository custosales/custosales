const db = require('./db');
let titles;

// SQL
const query_titles= "select title_id, title from titles";

db.connection.query(query_company, function (err, result, fields) {
    if (err) {
        console.error(err);;
    } else {
        // console.log("Firma:" + result[0].Firmanavn);
        titles = result;
        module.exports.res_titles = titles;
    }
});

