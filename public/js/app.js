/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

//import 'animate.css';
$(function () {
  novedadesAutoplay();
  showModalLoad();
  //changeSearch();
  showFilters();
  loginModal();
  $(".b-close").on("click", function () {
    return $("#adCart").modal("hide");
  });
});

//slider

function novedadesAutoplay() {
  $(".novedades-autoplay").slick({
    autoplay: true,
    autoplaySpeed: 2300,
    arrows: false,
    infinite: true,
    responsive: [{
      breakpoint: 2048,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }]
  });
  $(".relacionados").slick({
    autoplay: true,
    autoplaySpeed: 2300,
    arrows: false,
    infinite: true,
    responsive: [{
      breakpoint: 2048,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
  $(".relacionados1").slick({
    autoplay: true,
    autoplaySpeed: 2300,
    arrows: false,
    dots: true,
    infinite: true,
    responsive: [{
      breakpoint: 2048,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
  $(".coments-autoplay").slick({
    autoplay: true,
    autoplaySpeed: 2300,
    arrows: false,
    infinite: true,
    responsive: [{
      breakpoint: 2048,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
}
function showloginModal() {
  $("#loginModal").modal("show");
  $(".modal-backdrop").remove();
}
function showFilters() {
  $("#sidebarCollapse1").on("click", function () {
    $("#sidebar11").toggleClass("d-none");
    $value = $("#text-filter").text();
    if ($value == "Mostrar filtros") {
      $("#text-filter").text("Ocultar filtros");
      $("#icon-filter").text("remove");
    }
    if ($value == "Ocultar filtros") {
      $("#text-filter").text("Mostrar filtros");
      $("#icon-filter").text("add");
    }
  });
}
function changeSearch() {
  $("#input-search-home,#input-search1").focus(function () {
    $(this).css({
      background: "transparent",
      color: "#9c27b0",
      border: "solid 1px #c09aed"
    });
  });
  $("#input-search-home,#input-search1").blur(function () {
    $(this).css({
      background: "#c09aed",
      color: "white"
    });
  });
}

//activar modal al enviar, se cierra al retornar controlador
function showModalLoad() {
  $("#create-product-admin,#create-membership-admin,#create-package,#edit-package,#edit-product").submit(function () {
    $("#modal-spinner").modal("show");
  });
}
function clearlogin() {
  $("#btn-login-close").on("click", function () {
    $("#email-error,#password-error").children("strong").text("");
    $("#login-email, #login-password").val("");
    $("#login-remember").prop("checked", false);
  });
} //limpiar registro al cerrar

function loginModal() {
  var frm = $("#loginForm1");
  $("#btn-login-modal").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      type: frm.attr("method"),
      headers: {
        Accept: "application/json"
      },
      url: frm.attr("action"),
      data: frm.serialize(),
      success: function success() {
        return window.location.reload();
      },
      error: function error(response) {
        if (response.status === 422) {
          var errors = response.responseJSON.errors;
          Object.keys(errors).forEach(function (key) {
            $("#" + key + "-error").children("strong").text(errors[key][0]);
          });
        } else {
          window.location.reload();
        }
      }
    });
  });
}
Livewire.on("error", function ($message) {
  swal("¡error!", $message["message"], "error");
});
Livewire.on("success", function ($message) {
  if ($message["title"]) {
    title = $message["title"];
  } else {
    title = "¡Buen trabajo!";
  }
  swal(title, $message["message"], "success");
});
Livewire.on("info", function ($message) {
  alertFloat("right", $message["message"], "cancel");
});
Livewire.on("success-auto-close", function ($message) {
  alertFloat("right", $message["message"], "check_circle");
});
Livewire.on("reload", function () {
  return window.location.reload();
});
Livewire.on("alertDownload", function ($message) {
  alertFloat("left", $message["message"], "add_alert");
});
Livewire.on("alertComment", function ($message) {
  window.location.reload();
  alertFloat("right", $message["message"], "check_circle");
});
Livewire.on("alertlogin", function ($message) {
  alertFloat("right", $message["message"], "fingerprint");
  showloginModal();
});
Livewire.on("deleteCartAlert", function ($message) {
  alertFloat("right", $message["message"], "check_circle");
});
Livewire.on("addCartAlert", function ($product) {
  //novedadesAutoplay();
  $("#adCart").modal("show");
  $(".modal-backdrop").remove();
  novedadesAutoplay();
});
Livewire.on("sendSuccessHtml", function (message) {
  text = "<span class='font-weight-bold'>" + message["product"] + "</span>" + "<span> <br><br> " + message["note"] + "</span>" + "<span class='font-italic font-weight-bold'> " + message["email"] + "</span>";
  swal({
    title: "Enviado!",
    html: text,
    type: "success",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-info"
  });
});

// Livewire.on("terminos", function ($message) {
//     text =
//         '<div class="text-start"> <small class="text-muted">' +
//         "Queda estrictamente prohibido:" +"<br><br>"+
//         "<ul>" +
//         "<li>Revender el documento.</li>" +
//         "<li>Editar o alterar alguna parte del documento.</li>" +
//         "<li>Compartir el archivo en algún sitio web, red social o WhatsApp.</li>" +
//         "<li>Reproducir total o parcial este documento, bajo cualquiera de sus formas, electrónica u otras, sin la autorización por escrito de Material Didáctico MaCa. </li>" +
//         "</ul>" +
//         "<br>" +
//         "<small>" +
//         "Todos nuestros documentos estan protegidos con derechos de autor y tienen un folio único. Material Didáctico MaCa se reserva la facultad de presentar las acciones civiles o penales que considere necesarias por la utilización indebida de los materiales adquiridos y sus contenidos." +
//         "</small>" +
//         "<br>" +
//         "<br> </small></div>";

//     Swal.fire({
//         title: "Términos y Condiciones",
//         input: "checkbox",
//         inputPlaceholder: "Aceptar los términos y condiciones.",
//         html: text,
//         showCancelButton: false,
//         confirmButtonColor: "#a578da",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Continuar con la descarga!",
//     }).then((result) => {
//         if (result.value) {
//             Livewire.emit("finalDownload", $message["id"]);
//         } else if (result.value === 0) {
//             Swal.fire({
//                 type: "error",
//                 text: "Para finalizar la descarga, debe aceptar los términos y condiciones :(",
//             });
//         } else {
//             console.log(`modal was dismissed by ${result.dismiss}`);
//         }
//     });
// });

function alertFloat(align, message, icon) {
  type = ["info", "danger", "success", "warning", "rose", "primary"];
  color = Math.floor(Math.random() * 6 + 1);
  $.notify({
    icon: icon,
    message: message
  }, {
    type: type[color],
    timer: 3000,
    placement: {
      from: "top",
      align: align
    }
  });
}

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;