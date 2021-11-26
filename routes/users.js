var express = require('express');
var router = express.Router();

/* GET users page. */
router.get('/', function (req, res, next) {

  const MongoClient = require('mongodb').MongoClient;
  const uri = "mongodb://kurs:kurs123@noderia.com:31017/kurs?retryWrites=true&w=majority";
  const client = new MongoClient(uri, { useNewUrlParser: true });

  client.connect(err => {
    console.log("Connected successfully to server");
    const col = client.db("kurs").collection("kursbrukere");

    col.find({}).toArray(function (err, docs) {

      res.render('users', {
        title: 'Brukeroversikt',
        docs: docs
      });

      client.close();
    });

  });


});

module.exports = router;
