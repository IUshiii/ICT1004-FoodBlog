<script>
    lidi.create({
      // (D1) LIKE/DISLIKE BUTTON SETTINGS
      hWrap : document.getElementById("demo"),
      status : <?=$reacts["user"]?>,
      count : [<?=$reacts["react"][0]?>, <?=$reacts["react"][1]?>],

      // (D2) UPDATE SERVER ON REACTION CHANGE
      onChange : (status, recount) => {
        // FORM DATA
        var data = new FormData();
        data.append("id", <?=$id?>);
        data.append("react", status);

        // FETCH
        fetch("4-ajax.php", { method: "POST", body: data })
        .then(res => res.json())
        .then((res) => {
          if (res.error) { alert(res.error); }
          else { recount(res); }
        })
        .catch((err) => { console.error(err); });
      }
    });
</script>