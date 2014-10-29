var tweets = false;
var last_tweet = '0';
//var production_url = 'http://localhost/gdgtweetmonitor/devfestnorte/';
var production_url = 'http://tm.app/férias/'; // Hélio/
var development_url = 'http://localhost/gdgtweetmonitor/example.json';

jQuery(document).ready(function ($) {
  setInterval(function () {
    busca_tweets()
  }, 13000); // 10 + (3 para carregar as imagens)
  $('#template').hide();

  // Começa imediatamente
  busca_tweets();
});


function busca_tweets() {
  //var url = development_url;
  var url = production_url + last_tweet;
  var jqxhr = $.getJSON(url, function (data) {
    tweets = data;

    $.each(tweets, function (key, val) { // Precarrega imagens de perfil
      $('<img />').attr('src', val.author.picture).appendTo('.preload');
    });

    setTimeout(function () { // Espera um pouco ate as imagens carregarem
      carrega_tweets()
    }, 3000);
    
  }).fail(function () {
    console.log("Erro ao atualizar");
  });
}

function carrega_tweets() {
  var newrow;
  if (tweets) {
    $.each(tweets, function (key, val) {
      last_tweet = val.id;
      newrow = $('#template').clone();
      newrow.attr('id', 'row-' + val.id);
      var tweet = newrow.children('.tweet');
      tweet.attr('id', val.id);
      var autor = tweet.children('.author');
      autor.children('.text').text(val.text);
      autor.children('.timestamp').text(val.timestamp);
      autor.children('.name').text(val.author.name)
      autor.children('.screen-name').text('@' + val.author.screen_name);
      tweet.children('.picture').css('background-image', 'url(' + val.author.picture + ')');
      newrow.prependTo("#stage");
      newrow.fadeIn(800).show();
    });

  }
  tweets = false;
}
