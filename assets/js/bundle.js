!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=0)}([function(e,t,r){"use strict";r.r(t);r(1),r(2);document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelector("#historic-modal");e&&(!function(){var e=document.querySelector("#county-tops-tabs .active").querySelectorAll(".btn"),t=new URLSearchParams(window.location.search),r=Object.fromEntries(t.entries());if(console.log(r),r.error_id){console.log("HAS ERROR"),console.log(parseInt(r.error_id));for(var n=0;n<e.length;n++)e[n].dataset.id==r.error_id&&setTimeout((function(){$("#peak-".concat(r.error_id)).click()}),500)}}(),function(){var e=document.querySelector("#historic-modal");e&&document.querySelectorAll(".js-btn-complete").forEach((function(t){t.addEventListener("click",(function(t){var r=t.target.dataset,n=t.target.innerText.toLowerCase();console.log(r),console.log(n);var o=e.querySelector(".btn-complete"),a=e.querySelector(".btn-edit"),c=e.querySelector(".btn-trash");"edit"==t.target.innerText.toLowerCase()?(a.classList.remove("d-none"),c.classList.remove("d-none"),o.classList.add("d-none"),e.querySelector(".js-summit-date").value=r.date,e.querySelector(".js-field-report").value=r.fieldreport):(a.classList.add("d-none"),c.classList.add("d-none"),o.classList.remove("d-none")),document.querySelector(".js-county-top-id").value=r.id,document.querySelector(".js-peak_county").value=r.posttitle,document.querySelector(".js-peak-country").value=r.country,document.querySelector(".js-summit-date").value=""!=r.date?r.date:"",document.querySelector(".js-field-report").value=""!=r.fieldreport?r.fieldreport:"",document.querySelector(".js-button-type").value=n,document.querySelector(".js-modal-title").innerHTML="<span>".concat(n,"</span> ").concat(r.name);var i=document.querySelector(".js-preview-image");""!=r.guid?(i.querySelector(".js-peak-summit-image-preview").src=r.guid,i.classList.remove("d-none")):(i.src="",i.classList.add("d-none"))}))}))}(),function(){var e=document.querySelector(".page-template-page-peakbagging");if(e){var t=new URLSearchParams(window.location.search);"success"==Object.fromEntries(t.entries()).update&&(e.insertAdjacentHTML("afterbegin",'<div class="alert alert-success alert-dismissible fade show" role="alert">\n    <strong>Update Successful!</strong>\n    <button\n        type="button"\n        class="btn-close"\n        data-bs-dismiss="alert"\n        aria-label="Close"\n    >\n    </button>\n  </div>'),setTimeout((function(){document.querySelector(".alert").remove()}),3e3))}}(),$("#historic-modal").on("hidden.bs.modal",(function(){for(var e=document.querySelectorAll(".form-error"),t=0;t<e.length;t++)e[t].remove()})))}))},function(e,t){var r=function(e){document.querySelector(".congratulations-dialog-message span").innerHTML=e.county,document.querySelector(".congratulations-dialog-badge").src=location.origin+"/app/plugins/high_willhays_peak_bagging/assets/images/badges/"+e.county+"-historic-county-top.png"};document.addEventListener("DOMContentLoaded",(function(){var e,t;document.querySelector(".js-congratulations-dialog")&&(e=new URLSearchParams(window.location.search),(t=Object.fromEntries(e.entries())).completed&&(r(t),$(".bd-example-modal-sm").modal("show")))}))},function(e,t){function r(e){return function(e){if(Array.isArray(e))return n(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return n(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return n(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelector(".honour-roll-page");e&&function(e){for(var t,n=e.querySelectorAll(".total-peaks"),o=[],a=0;a<n.length;a++){o.push(n[a].innerText),t=r(new Set(o));var c=n[a].parentElement.dataset.position;c==t[0]&&n[a].parentElement.classList.add("table-warning"),c==t[1]&&n[a].parentElement.classList.add("table-success"),c==t[2]&&n[a].parentElement.classList.add("table-secondary")}!function(e,t){for(var r=e.querySelectorAll(".honour-roll-row"),n=0;n<r.length;n++){if(r[n].dataset.position==t[0])r[n].querySelector(".place-".concat(t[0]," .award")).innerHTML='<i class="bi bi-trophy"></i>';if(r[n].dataset.position==t[1])r[n].querySelector(".place-".concat(t[1]," .award")).innerHTML='<i class="bi bi-award"></i>';if(r[n].dataset.position==t[2])r[n].querySelector(".place-".concat(t[2]," .award")).innerHTML='<i class="bi bi-award"></i>'}}(e,t)}(e)}))}]);