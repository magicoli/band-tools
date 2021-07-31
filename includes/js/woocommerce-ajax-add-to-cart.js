var cartLinks = document.getElementsByClassName("ajax_add_to_cart");

for (var i = 0; i < cartLinks.length; i++) {
  cartLinks[i].addEventListener('click', function(e) {
    var product_id = e.target.id.replace('buy-', '');
    var tracks = document.getElementsByClassName("record_" + product_id);
    console.log("Looking for record_" + product_id);
    for (var t = 0; t < tracks.length; t++) {
      console.log("Add classes to  "+ t);
      tracks[t].classList.add('added');
      tracks[t].classList.add('included');
      tracks[t].classList.remove('ajax_add_to_cart');
      tracks[t].href='#';
    }
  }, false);
}
