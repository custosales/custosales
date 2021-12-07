var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');


// Sales Module
var salesRouter = require('./routes/modules/sales/sales');
var enheterRouter = require('./routes/enheter'); 
// Admin Module 
var usersRouter = require('./routes/modules/admin/users'); 
var newUserRouter = require('./routes/modules/admin/newuser');
var projectsRouter = require('./routes/modules/admin/projects'); 
var newProjectRouter = require('./routes/modules/admin/newproject'); 
// System
var loginRouter = require('./routes/login'); 
var indexRouter = require('./routes/index');
var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);
app.use('/users', usersRouter);
app.use('/newuser', newUserRouter);
app.use('/enheter', enheterRouter);
app.use('/login', loginRouter);
app.use('/sales', salesRouter);
app.use('/admin/projects', projectsRouter);
app.use('/admin/newproject', newProjectRouter);
// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
