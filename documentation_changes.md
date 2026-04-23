# Documentación de Cambios Técnicos - Global Pagos (Local)

Este documento detalla los problemas encontrados y las soluciones técnicas implementadas para levantar el proyecto CodeIgniter localmente usando Docker.

---

## 1. Configuración de la URL Base (Redirección a Producción)

### Problema
Al intentar navegar o iniciar sesión, la aplicación redirigía automáticamente a `https://calculadora.globalpagoscl.com` en lugar de mantenerse en `http://localhost:8080`.

### Solución
En CodeIgniter 3, la variable `$config['base_url']` define la raíz del sitio. Si es estática, todas las funciones de ayuda como `redirect()` o `base_url()` usarán esa dirección.

**Cambio en `application/config/config.php`:**
Se reemplazó la URL fija por una lógica dinámica que detecta el host actual.

```php
// Antes (Estatico)
$config['base_url'] = 'https://calculadora.globalpagoscl.com'; 

// Después (Dinámico)
$config['base_url'] = (isset($_SERVER['HTTP_HOST'])) 
    ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']) 
    : 'https://calculadora.globalpagoscl.com';
```

**Aprendizaje:** Siempre que sea posible, usa una URL base dinámica en desarrollo para que el código funcione en cualquier puerto o dominio local sin cambios manuales.

---

## 2. Inicialización de la Base de Datos en Docker

### Problema
El contenedor de MySQL estaba vacío (`Table doesn't exist`). Aunque el contenedor corría, no tenía las tablas ni los datos necesarios para el login.

### Solución
Se importaron los respaldos SQL que se encontraban en el proyecto.

1.  **Estructura**: Se importó `assets/backup-db/TABLAS.sql`.
2.  **Datos**: El archivo `DATA-dbGlobalCaluladora.sql` era en realidad un archivo **ZIP** renombrado. Se tuvo que descomprimir y luego importar.
3.  **Integridad**: Durante la importación de datos, se desactivaron temporalmente las llaves foráneas (`FOREIGN_KEY_CHECKS=0`) para evitar errores de orden de inserción.

**Comando clave utilizado:**
```bash
(echo "SET FOREIGN_KEY_CHECKS=0;"; unzip -p DATA.sql; echo "SET FOREIGN_KEY_CHECKS=1;") | docker exec -i gp-mysql mysql -u...
```

**Aprendizaje:** Los contenedores de DB nuevos nacen vacíos a menos que pongas un script en `/docker-entrypoint-initdb.d`. Si tienes un error de "Table not found", verifica siempre si importaste los datos.

---

## 3. Extensiones de PHP Faltantes (`intl`)

### Problema
Error: `Class 'Locale' not found`. Esto ocurre cuando el código usa funciones de internacionalización (como nombres de países) pero la extensión `intl` no está instalada en PHP.

### Solución
Se modificó el `Dockerfile` de PHP para instalar las dependencias necesarias.

**Cambio en `docker/php/Dockerfile`:**
```dockerfile
# Se añadió icu-dev (dependencia del sistema) e intl (extensión de PHP)
RUN apk add --no-cache ... icu-dev \
    && docker-php-ext-install ... intl
```

**Aprendizaje:** Si recibes un error de "Class not found" para una clase estándar de PHP (como `Locale`, `PDO`, `ZipArchive`), lo más probable es que falte activar una extensión en el `Dockerfile` o `php.ini`.

---

## 4. Robustez ante Fallos de APIs Externas

### Problema
Error: `Undefined property: stdClass::$country`. El código intentaba obtener la ubicación del usuario mediante `ipinfo.io`. Al fallar el servicio localmente, el objeto estaba vacío y generaba un "Notice" de PHP. Este mensaje de error rompía la función `header()`, impidiendo el redireccionamiento después del login.

### Solución
Se agregaron validaciones con `isset()` para asegurar que las propiedades existan antes de usarlas.

**Cambio en `Calculadora.php` y `Login.php`:**
```php
// Antes
$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 

// Después (Seguro)
$data_pais = isset($arr->country) ? Locale::getDisplayRegion('-'.$arr->country,'es') : 'Unknown';
```

**Aprendizaje:** Nunca confíes en la respuesta de un servicio externo (`file_get_contents`, API REST). Siempre valida que los datos llegaron correctamente antes de procesarlos para evitar que un fallo externo tumbe tu aplicación.

---

## Resumen de Comandos Útiles

*   **Reconstruir PHP tras cambiar Dockerfile**:
    `docker compose up --build -d php`
*   **Ver tablas en el contenedor**:
    `docker exec gp-mysql mysql -uusAppCalc -prFe9yShDg6KSWG5zvOim dbGlobalCaluladora -e "SHOW TABLES;"`
*   **Importar un SQL a Docker**:
    `docker exec -i gp-mysql mysql -u... -p... db_name < archivo.sql`
