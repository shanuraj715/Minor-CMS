let keysDown = {};
window.onkeydown = function(e) {
  keysDown[e.key] = true;

  if (keysDown["Control"] && keysDown["/"]) {
    // window.open("/admin", "_SELF");
    window.open('#comment', "_self");
  }
  else if( keysDown["Control"] && keysDown["*"] ){
     window.open('#postdata', "_self");
  }
}

window.onkeyup = function(e) {
  keysDown[e.key] = false;
}