# 🏨 Hotel Admin - Sistema de Gestión Hotelera

Sistema completo de administración hotelera desarrollado en PHP con arquitectura MVC.

## 📋 Características

### Módulos Principales

- **👥 Gestión de Clientes** - Registro y administración de huéspedes
- **🚪 Gestión de Habitaciones** - Control de cuartos, pisos y precios
- **✅ Estancias (Check-in/Check-out)** - Sistema de 4 horas por bloque
- **📅 Reservaciones** - Sistema de reservas anticipadas (12 horas por bloque)
- **📊 Reportes Mensuales** - Estadísticas y análisis de ingresos
- **👤 Gestión de Usuarios** - Control de acceso y perfiles

### Diferencias entre Estancias y Reservaciones

| Característica | Estancias | Reservaciones |
|---------------|-----------|---------------|
| **Duración** | 4 horas/bloque | 12 horas/bloque |
| **Uso** | Check-in inmediato | Reserva anticipada |
| **Estados** | Activo/Completado | Pendiente/Confirmada/Cancelada/Completada |
| **Propósito** | Habitaciones de paso | Estancias más largas planificadas |

## 🚀 Instalación

### Requisitos

- XAMPP (PHP 7.4+ y MySQL)
- Navegador web moderno

### Pasos de Instalación

1. **Clonar o descargar el proyecto** en `c:\xampp\htdocs\hotel-admin`

2. **Crear la base de datos:**
   ```sql
   -- En phpMyAdmin, ejecutar:
   sql/hotel_admin.sql
   sql/expenses_table.sql
   sql/reservations_table.sql
   ```

3. **Configurar conexión a base de datos:**
   Editar `config/database.php` con tus credenciales

4. **Acceder al sistema:**
   ```
   http://localhost/hotel-admin/
   ```

## 📁 Estructura del Proyecto

```
hotel-admin/
├── app/
│   ├── controllers/     # Controladores MVC
│   │   ├── AuthController.php
│   │   ├── ClientsController.php
│   │   ├── DashboardController.php
│   │   ├── ReportsController.php
│   │   ├── ReservationsController.php  # ✨ NUEVO
│   │   ├── RoomsController.php
│   │   └── StaysController.php
│   ├── models/          # Modelos de datos
│   │   ├── Client.php
│   │   ├── Model.php
│   │   ├── Reservation.php  # ✨ NUEVO
│   │   ├── Room.php
│   │   ├── Stay.php
│   │   └── User.php
│   └── views/           # Vistas HTML/PHP
│       ├── auth/
│       ├── clients/
│       ├── dashboard/
│       ├── layout/
│       ├── reports/
│       ├── reservations/  # ✨ NUEVO
│       ├── rooms/
│       ├── stays/
│       └── users/
├── config/
│   └── database.php     # Configuración BD
├── core/
│   ├── Controller.php   # Clase base controlador
│   └── View.php         # Clase base vista
├── public/
│   ├── index.php        # Punto de entrada
│   └── assets/          # CSS, JS, imágenes
└── sql/                 # Scripts SQL
    ├── hotel_admin.sql
    ├── expenses_table.sql
    ├── reservations_table.sql  # ✨ NUEVO
    └── reservations_test_data.sql  # ✨ NUEVO
```

## 🎯 Módulo de Reservaciones (Nuevo)

### Características

✅ Reservar cuartos con fechas futuras
✅ Bloques de 12 horas
✅ Estados: Pendiente, Confirmada, Cancelada, Completada
✅ Verificación automática de disponibilidad
✅ Prevención de conflictos de horarios
✅ Integración con sistema de check-in
✅ Cálculo automático de totales

### Flujo de Uso

1. **Crear Reservación**
   - Seleccionar cliente y cuarto
   - Definir fecha/hora de inicio
   - Elegir número de bloques (12h cada uno)
   - Sistema calcula automáticamente fecha de fin y total

2. **Confirmar Reservación**
   - Cambiar estado de Pendiente a Confirmada

3. **Completar Reservación**
   - Cuando el cliente usa la habitación
   - Marcar como Completada

4. **Cancelar Reservación**
   - Si el cliente cancela
   - Libera el cuarto automáticamente

### Documentación Completa

Ver: [`RESERVACIONES_README.md`](RESERVACIONES_README.md)

## 🔧 Tecnologías Utilizadas

- **Backend:** PHP 7.4+
- **Base de Datos:** MySQL
- **Frontend:** Bootstrap 5.3, Bootstrap Icons
- **Arquitectura:** MVC (Model-View-Controller)
- **Servidor:** Apache (XAMPP)

## 🎨 Características Técnicas

- ✅ Arquitectura MVC limpia y organizada
- ✅ PDO para consultas seguras (prevención SQL injection)
- ✅ Sistema de sesiones para autenticación
- ✅ Validación de disponibilidad en tiempo real
- ✅ Cálculos automáticos de costos
- ✅ Interfaz responsive (Bootstrap 5)
- ✅ Manejo de errores y alertas
- ✅ Código documentado y mantenible

## 📊 Base de Datos

### Tablas Principales

- `users` - Usuarios del sistema
- `clients` - Clientes/huéspedes
- `rooms` - Habitaciones del hotel
- `stays` - Estancias (check-in/check-out)
- `reservations` - Reservaciones anticipadas ✨ NUEVO
- `expenses` - Gastos del hotel

## 🔐 Seguridad

- Contraseñas hasheadas con `password_hash()`
- Validación de sesiones en todas las páginas
- Preparación de consultas SQL (PDO)
- Escape de salidas HTML con `htmlspecialchars()`
- Validación de datos de entrada

## 📈 Reportes

El sistema genera:
- 📊 Ingresos mensuales por estancias
- 📊 Ingresos mensuales por reservaciones
- 📊 Gráficos comparativos por año
- 📊 Análisis de ocupación

## 🤝 Contribución

Este es un proyecto educativo. Sugerencias de mejora:

1. Fork del proyecto
2. Crear branch (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push al branch (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## 📝 Licencia

Proyecto educativo - Uso libre para aprendizaje

## 🐛 Problemas Conocidos

Ninguno reportado hasta el momento

## 📞 Soporte

Para problemas o dudas:
1. Revisar la documentación
2. Verificar logs de PHP en XAMPP
3. Revisar consola del navegador (F12)

---

**Desarrollado con ❤️ para gestión hotelera eficiente**

**Última actualización:** 27 de noviembre de 2025 - Módulo de Reservaciones implementado ✨
