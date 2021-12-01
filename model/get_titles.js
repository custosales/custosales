const db = require('./db');
const client = db.dbclient;
let titles;

// Coonect
client.connect();
console.log("Database connected from model/get_titles");

// SQL
const query_titles= "select title_id, title from titles order by title";

client.query(query_titles, function (err, result, fields) {
    if (err) {
        console.error(err);;
    } else {
        // console.log("Firma:" + result[0].Firmanavn);
        titles = result;
        client.end();
       module.exports.res_titles = titles;
    }
  
});

