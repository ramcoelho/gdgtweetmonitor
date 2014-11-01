$(function () {
  var last_tweet = '0';
  var production_url = 'http://devfestnorte.nexy.com.br/devfestnorte/';
  //var development_url = 'http://www.twitterdevfest.dev/gdgtweetmonitor/public/example.json';

  setInterval(function() {
    //var url = development_url;
    var url = production_url + last_tweet;
    var loadJSON = function(data) {
      var newrow;
      if (data) {
        $.each(data, function(key, val) {
          last_tweet = val.id;
          newrow = $('#template').clone();
            newrow.attr('id', 'row-' + val.id);

          var tweet = newrow.children('.tweet');
            tweet.attr('id', val.id);

          var autor = tweet.children('.author');
            autor.children('.row-content').children('.lead').html(val.text);
            autor.children('.row-content').children('.timestamp').text(val.timestamp);
            autor.children('.row-content').children('.name').text(val.author.name);
            autor.children('.row-content').children('.screen-name').text('@'+val.author.screen_name);
            autor.children('.picture').children('img').attr('src', val.author.picture);
          newrow.prependTo("#stage");
          newrow.show();
        });
      }
      data = false;
    };
    var jqxhr = $.getJSON(url, loadJSON)
        .fail(function() {
          console.log("Erro ao atualizar");
        });
  }, 10000);
  $('#template').hide();
  loadJSON();
});

