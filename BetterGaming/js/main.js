// Toggle function of Menu

var menuList = document.getElementById("menuList");

menuList.style.maxHeight = "0px";

function togglemenu() {
  if (menuList.style.maxHeight == "0px") {
    menuList.style.maxHeight = "130px";
  } else {
    menuList.style.maxHeight = "0px";
  }
}

// Loading animation via PaceJS Framework

const paceOptions = {
  ajax: true,
  document: true,
  eventLag: false
};

Pace.on('done', function() {
  $('.p').delay(500).animate({
      top: '30%',
      opacity: '0'
  }, 3000, $.bez([0.19, 1, 0.22, 1]));


  $('#preloader').delay(1500).animate({
      top: '-100%'
  }, 2000, $.bez([0.19, 1, 0.22, 1]));

});

// Appear on Scroll via ScrollOut Framework

ScrollOut();

// Parallax mouse movement on Homepage (Changing x and y positions of image according to mouse movement)

document.addEventListener("mousemove", parallax);

function parallax(e) {
  var img = $(".controller");
  const speed = img.attr("data-speed");

  const x = (window.innerWidth - e.pageX * speed) / 100;
  const y = (window.innerHeight - e.pageY * speed) / 100;

  $(".controller").css("transform", `translate(${x}px,${y}px)`);
}
