<?php
session_start();
if(!isset($_SESSION['username'])){
  header("Location: login.php");
  die;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include "system/db_connect.php";
    $url = mysqli_real_escape_string($db, $_GET['pdf']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Open EPUB File</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
  <script src="dist/js/epub.js"></script>

  <link rel="stylesheet" type="text/css" href="epub.css">
</head>
<body>
  <select id="toc"></select>
  <div id="viewer" class="spreads"></div>
  <div id="prev" class="arrow">‹</div>
  <div id="next" class="arrow">›</div>
  <script>
    var params = URLSearchParams && new URLSearchParams(document.location.search.substring(1));
    var url = params && params.get("url") && decodeURIComponent(params.get("url"));
    var currentSectionIndex = (params && params.get("loc")) ? params.get("loc") : undefined;

    window.book = ePub(url || "https://fajarmf.com/.pdf/" + "<?php echo $url; ?>");
    var rendition = book.renderTo("viewer", {
      manager: "continuous",
      flow: "paginated",
      width: "100%",
      height: 600
    });

    var displayed = rendition.display(currentSectionIndex);


    displayed.then(function(renderer){
    });

    book.loaded.navigation.then(function(toc){
    });

    book.ready.then(() => {

      var next = document.getElementById("next");

      next.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();
        e.preventDefault();
      }, false);

      var prev = document.getElementById("prev");
      prev.addEventListener("click", function(e){
        book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();
        e.preventDefault();
      }, false);

      var keyListener = function(e){

        if ((e.keyCode || e.which) == 37) {
          book.package.metadata.direction === "rtl" ? rendition.next() : rendition.prev();
        }

        if ((e.keyCode || e.which) == 39) {
          book.package.metadata.direction === "rtl" ? rendition.prev() : rendition.next();
        }

      };

      rendition.on("keyup", keyListener);
      document.addEventListener("keyup", keyListener, false);

    });

    rendition.on("selected", function(range) {
      console.log("selected", range);
    });

    rendition.on("layout", function(layout) {
      let viewer = document.getElementById("viewer");

      if (layout.spread) {
        viewer.classList.remove('single');
      } else {
        viewer.classList.add('single');
      }
    });

    rendition.on("relocated", function(location){
      console.log(location);

      var next = book.package.metadata.direction === "rtl" ?  document.getElementById("prev") : document.getElementById("next");
      var prev = book.package.metadata.direction === "rtl" ?  document.getElementById("next") : document.getElementById("prev");

      if (location.atEnd) {
        next.style.visibility = "hidden";
      } else {
        next.style.visibility = "visible";
      }

      if (location.atStart) {
        prev.style.visibility = "hidden";
      } else {
        prev.style.visibility = "visible";
      }

    });

    book.loaded.navigation.then(function(toc){
			var $select = document.getElementById("toc"),
					docfrag = document.createDocumentFragment();

			toc.forEach(function(chapter) {
				var option = document.createElement("option");
				option.textContent = chapter.label;
				option.ref = chapter.href;

				docfrag.appendChild(option);
			});

			$select.appendChild(docfrag);

			$select.onchange = function(){
					var index = $select.selectedIndex,
							url = $select.options[index].ref;
					rendition.display(url);
					return false;
			};

		});

  </script>

</body>
</html>
