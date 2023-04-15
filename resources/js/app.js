$(function () {
    novedadesAutoplay();
    showModalLoad();
    changeSearch();

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
                    slidesToShow: 6,
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
}

function changeSearch() {
    $("#input-search,#input-search1").focus(function () {
        $(this).css({
            background: "transparent",
            color: "#9c27b0",
            border: "solid 1px #c09aed",
        });
    });
    $("#input-search,#input-search1").blur(function () {
        $(this).css({
            background: "#c09aed",
            color: "white",
        });
    });
}

//activar modal al enviar, se cierra al retornar controlador
function showModalLoad() {
    $("#create-product-admin,#create-membership-admin").submit(() => {
        $("#modal-spinner").modal("show");
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
    alertFloat("right", $message["message"], "check_circle");
});

Livewire.on("alertlogin", ($message) => {
    alertFloat("right", $message["message"], "fingerprint");
});

Livewire.on("addCartAlert", function ($product) {
    //novedadesAutoplay();
    $("#adCart").modal("show");
    $('.modal-backdrop').remove();
  }); 












function alertFloat(align, message, icon) {
    type = ["", "info", "danger", "success", "warning", "rose", "primary"];

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
