if (window == window.parent) {
  window.location.href = "../?jumpTo=" + encodeURIComponent(window.location.href);
}
;