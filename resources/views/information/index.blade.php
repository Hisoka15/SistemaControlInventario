@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Informacion de la aplicacion</h2>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <p class="text-lg text-gray-700 mb-4">
            Este sistema, desarrollado con el framework <span class="font-semibold">Laravel</span> 
            proporciona una solución eficiente y escalable para la gestión de inventario y facturación en una tienda.
            Combina la potencia de Laravel para gestionar funciones del backend, con la consistencia y portabilidad que ofrecen los contenedores de Docker.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Características principales:</h2>

        <ul class="list-disc pl-5 mb-4">
            <li class="mb-2">
                <span class="font-semibold">Gestión de Inventario:</span> Permite el registro detallado de productos, categorías, precios, y niveles de stock,
                con alertas automáticas para productos con inventario bajo.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Control de Facturación:</span> Facilita la creación automática de facturas en ventas,
                calculando impuestos y descuentos, además de enviar facturas electrónicas.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Reportes y Estadísticas:</span> Genera informes sobre el estado del inventario, productos más vendidos,
                y resúmenes de ventas diarias o mensuales.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Gestión de Usuarios y Roles:</span> Incluye un sistema de autenticación y control de acceso basado en roles,
                permitiendo gestionar permisos de administradores y vendedores.
            </li>
        </ul>

        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Beneficios de usar Laravel y Docker:</h2>
        <ul class="list-disc pl-5 mb-4">
            <li class="mb-2">
                <span class="font-semibold">Portabilidad y Consistencia:</span> Docker asegura que el sistema funcione de manera idéntica en distintos entornos,
                evitando problemas de compatibilidad.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Escalabilidad:</span> La arquitectura basada en contenedores permite escalar fácilmente la aplicación,
                ajustándose al crecimiento de la tienda.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Despliegue Simplificado:</span> Docker facilita el despliegue en producción, asegurando la consistencia del código y las configuraciones.
            </li>
            <li class="mb-2">
                <span class="font-semibold">Seguridad:</span> Laravel proporciona funciones avanzadas de seguridad,
                mientras que Docker aísla los contenedores para mayor protección.
            </li>
        </ul>

        <p class="text-lg text-gray-700">
            Este sistema modular garantiza una gestión precisa de inventario y transacciones comerciales,
            optimizando las operaciones diarias y asegurando la satisfacción del cliente.
        </p>
    </div>
@endsection
