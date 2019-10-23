<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <link href="stile.css" type="text/css" rel="stylesheet" />
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>

  <div id="content">

  </div>

  <script>
    var listElm = document.querySelector('#content');

    var matchId = 1;

    var nextItem = 1;

    var loadMore = function() {

      axios.post('parser.php', {
          page: '3'
        })
        .then(function(response) {
          var item = response.data;

          for (let key in item) {
            let matchArray = item[key];
            let p = document.createElement('p');
            p.id = matchId;
            listElm.appendChild(p);
            let a = document.createElement('a');
            a.href = matchArray["match-href"];
            a.innerText = 'подробности матча';
            ptag = document.getElementById(matchId);
            ptag.innerHTML = matchArray["match-name"] + " - " + a.outerHTML;
            matchId++;
          }

        })
        .catch(function(error) {
          console.log(error);
        });

    }

    listElm.addEventListener('scroll', function() {
      if (listElm.scrollTop + listElm.clientHeight >= listElm.scrollHeight) {
        loadMore();
      }
    });

    loadMore();
  </script>
</body>
</html>