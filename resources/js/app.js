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
        responsive: [
            {
                breakpoint: 2048,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    $(".relacionados").slick({
        autoplay: true,
        autoplaySpeed: 2300,
        arrows: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 2048,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".relacionados1").slick({
        autoplay: true,
        autoplaySpeed: 2300,
        arrows: false,
        dots: true,
        infinite: true,
        responsive: [
            {
                breakpoint: 2048,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".coments-autoplay").slick({
        autoplay: true,
        autoplaySpeed: 2300,
        arrows: false,
        infinite: true,
    
        responsive: [
          {
            breakpoint: 2048,
            settings: {
              slidesToShow: 5,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 700,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
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
            border: "solid 1px #c09aed",
        });
    });
    $("#input-search-home,#input-search1").blur(function () {
        $(this).css({
            background: "#c09aed",
            color: "white",
        });
    });
}

//activar modal al enviar, se cierra al retornar controlador
function showModalLoad() {
    $(
        "#create-product-admin,#create-membership-admin,#create-package,#edit-package,#edit-product"
    ).submit(() => {
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
                Accept: "application/json",
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
                        $("#" + key + "-error")
                            .children("strong")
                            .text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            },
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

Livewire.on("alertDownload", ($message) => {
    alertFloat("left", $message["message"], "add_alert");
});

Livewire.on("alertComment", ($message) => {
    window.location.reload();
    alertFloat("right", $message["message"], "check_circle");
});

Livewire.on("alertlogin", ($message) => {
    alertFloat("right", $message["message"], "fingerprint");
    showloginModal();
});

Livewire.on("deleteCartAlert", ($message) => {
    alertFloat("right", $message["message"], "check_circle");
});

Livewire.on("addCartAlert", function ($product) {
    //novedadesAutoplay();
    $("#adCart").modal("show");
    $(".modal-backdrop").remove();
    novedadesAutoplay();
});


Livewire.on("sendSuccessHtml", function (message) {
    text =
        "<span class='font-weight-bold'>" +
        message["product"] +
        "</span>" +
        "<span> <br><br> " +
        message["note"] +
        "</span>" +
        "<span class='font-italic font-weight-bold'> " +
        message["email"] +
        "</span>";

    swal({
        title: "Enviado!",
        html: text,
        type: "success",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
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

    $.notify(
        {
            icon: icon,
            message: message,
        },
        {
            type: type[color],
            timer: 3000,
            placement: {
                from: "top",
                align: align,
            },
        }
    );
}
