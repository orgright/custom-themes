// javaScript functions for orgRightA theme

// Function to run when the page has loaded
$(document).ready(function () {
  // set scrolling on extracted contents for file cabinet documents if required
  var maxHeight = 150;
  if ($('.filecabinet.item.nodebody > .item-val').height() > maxHeight) {
    $('.filecabinet.item.nodebody > .item-val').css('height', maxHeight+'px').css('overflow-y', 'scroll');
    var pWidth = $('.filecabinet.item.nodebody > .item-val > p').width();
    $('.filecabinet.item.nodebody > .item-val > p').css('width', pWidth-15+'px');
  }
  // Set the sidebar heights if necessary to get the border to run full length
  var mainHeight = $('#main').height();
  var sideBarSection = $('#main > .region.sidebar > .section');
  sideBarSection.each(function () { 
    var topBottom = $(this).outerHeight(true) - $(this).height();
    var sectionHeight = mainHeight - topBottom;
    if ($(this).height() < sectionHeight) {
      $(this).css('height', sectionHeight+'px'); 
    }
  })
  // End of document.ready function
})

