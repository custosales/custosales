
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Dashboard plugin</title>

	    <script type="text/javascript" src="lib/jquery.dashboard.min.js"></script>
    

    <script type="text/javascript">
      // This is the code for definining the dashboard
      $(document).ready(function() {

        // load the templates
        $('body').append('<div id="templates"></div>');
        $("#templates").hide();
        $("#templates").load("templates.html", initDashboard);

        // call for the themeswitcher
        $('#switcher').themeswitcher();

        function initDashboard() {

          // to make it possible to add widgets more than once, we create clientside unique id's
          // this is for demo purposes: normally this would be an id generated serverside
          var startId = 100;

          var dashboard = $('#dashboard').dashboard({
            // layout class is used to make it possible to switch layouts
            layoutClass:'layout',
            // feed for the widgets which are on the dashboard when opened
            json_data : {
              url: "jsonfeed/mywidgets.json"
            },
            // json feed; the widgets whcih you can add to your dashboard
            addWidgetSettings: {
              widgetDirectoryUrl:"jsonfeed/widgetcategories.json"
            },

            // Definition of the layout
            // When using the layoutClass, it is possible to change layout using only another class. In this case
            // you don't need the html property in the layout

            layouts :
              [
                { title: "Layout1",
                  id: "layout1",
                  image: "layouts/layout1.png",
                  html: '<div class="layout layout-a"><div class="column first column-first"></div></div>',
                  classname: 'layout-a'
                },
                { title: "Layout2",
                  id: "layout2",
                  image: "layouts/layout2.png",
                  html: '<div class="layout layout-aa"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-aa'
                },
                { title: "Layout3",
                  id: "layout3",
                  image: "layouts/layout3.png",
                  html: '<div class="layout layout-ba"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-ba'
                },
                { title: "Layout4",
                  id: "layout4",
                  image: "layouts/layout4.png",
                  html: '<div class="layout layout-ab"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-ab'
                },
                { title: "Layout5",
                  id: "layout5",
                  image: "layouts/layout5.png",
                  html: '<div class="layout layout-aaa"><div class="column first column-first"></div><div class="column second column-second"></div><div class="column third column-third"></div></div>',
                  classname: 'layout-aaa'
                }
              ]

          }); // end dashboard call

          // binding for a widgets is added to the dashboard
          dashboard.element.live('dashboardAddWidget',function(e, obj){
            var widget = obj.widget;

            dashboard.addWidget({
              "id":startId++,
              "title":widget.title,
              "url":widget.url,
              "metadata":widget.metadata
              }, dashboard.element.find('.column:first'));
          });

          // the init builds the dashboard. This makes it possible to first unbind events before the dashboars is built.
          dashboard.init();
        }
      });

    </script>

    <link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
    
  </head>

  <body>

  <div class="header_tile_image">
    <div class="headerbox">
      <div id="switcher"></div>
    </div>
    <div class="headerlinks">
      <a class="openaddwidgetdialog headerlink" href="#">Add Widget</a>&nbsp;<span class="headerlink">|</span>&nbsp;
      <a class="editlayout headerlink" href="#">Edit layout</a>
    </div>
  </div>


  <div id="dashboard" class="dashboard">
    <!-- this HTML covers all layouts. The 5 different layouts are handled by setting another layout classname -->
    <div class="layout">
      <div class="column first column-first"></div>
      <div class="column second column-second"></div>
      <div class="column third column-third"></div>
    </div>
  </div>

  </body>
</html>
