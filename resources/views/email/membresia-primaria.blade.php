@component('mail::message')
RESUMEN DE COMPRA: {{$order}}




## {{$title}} ##

CANTIDAD PAGADA: ${{$price}}.00 MXN

FECHA DE COMPRA: {{date_format(now(),'d-M-Y')}}

VÁLIDO POR: Más de 100 recursos de 1ro, 2do y 3ro PRIMARIA a lo largo del ciclo escolar.




{{$name}}, muchas gracias por su compra!!🫶🏻
Me alegra poder darle la bienvenida al grupo VIP DE PRIMARIA!!🌈


Favor de dar clic al siguiente enlace para enviarnos un mensaje en WhatsApp y activar tu membresía.

@component('mail::button', ['url' => $url])
Activar membresía
@endcomponent






Saludos,<br>
Material Didáctico MaCa
@endcomponent

