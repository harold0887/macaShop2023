@component('mail::message')
# ¡Confirmación de compra!

## Hola {{$name}}, sigue estos pasos para descargar los materiales. ##

<ol>
    <li>Iniciar sesión con tu usuario y contraseña</li>
    <li>Ingresar a la sección de “Mis compras”.</li>
    <li>Da click en el botón detalle de compra.</li>
    <li>Da click en el botón descargar.</li>
    <li>Disfruta el material didáctico.</li>
</ol>

<hr>

Queda estrictamente prohibido:
<ul>
    <li>Revender el documento.</li>
    <li>Editar o alterar alguna parte del documento.</li>
    <li>Compartir el archivo en algún sitio web, red social o WhatsApp.</li>
    <li>Reproducir total o parcial este documento, bajo cualquiera de sus formas, electrónica u otras, sin la autorización por escrito de Material Didáctico MaCa. </li>
</ul>

<br>
<small>
    Todos nuestros documentos estan protegidos con derechos de autor y tienen un folio único. Material Didáctico MaCa se reserva la facultad de presentar las acciones civiles o penales que considere necesarias por la utilización indebida de los materiales adquiridos y sus contenidos.
</small>

<br>
<br>


@component('mail::panel')

<small>
    Si tiene alguna pregunta, no dude en contactarme. Solo da click en el logo de WhatsApp
</small>
<br>
<a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
    <img src="{{ asset('img/whatsapp.png') }}" alt="logo WhatsApp" width="60">
</a>

@endcomponent


@endcomponent