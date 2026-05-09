# Plan de Migración: CodeIgniter → Odoo 18
## Global Pagos - Calculadora de Transferencias

---

## 1. Análisis de las Vistas Actuales

Antes de construir en Odoo, es fundamental entender qué hace cada módulo actual.

### 1.1 `calc1` - Calculadora FDX (FedEx)
**Archivo CI:** `views/calculadora/calcfdx.php`

**Campos:**
| Campo | Tipo CI | Descripción |
|---|---|---|
| `pais` | `<select>` dinámico | País destino (carga desde DB `calculadora_pais`) |
| `peso` | `<input number>` | Peso en KG (step 0.5) |
| `cotifedex` | `<input readonly>` | Cotización 1KG en CLP |
| `cotifedex10` | `<input readonly>` | Cotización 10KG en CLP |
| `cotifedex20` | `<input readonly>` | Cotización 20KG en CLP |

**Lógica:** Seleccionar país + peso → botón "COTIZAR" → retorna precios por rango de KG.

---

### 1.2 `calc2` - Calculadora DHL
**Archivo CI:** `views/calculadora/calcdhl.php`

**Campos:**
| Campo | Tipo CI | Descripción |
|---|---|---|
| `pais` | `<select>` dinámico | País destino |
| `peso` | `<input number>` | Peso en KG |
| `tipo` | `<select>` | Paquete / Sobre |
| `cotidhl` | `<input readonly>` | Cotización 1KG en CLP |
| `cotidhl10` | `<input readonly>` | Cotización 10KG en CLP |
| `cotidhl20` | `<input readonly>` | Cotización 20KG en CLP |

**Diferencia con FDX:** Agrega campo `tipo` (Paquete o Sobre).

---

### 1.3 `wuintegrador` - Ticket Western Union
**Archivo CI:** `views/calculadora/ticket_western_integrado.php`

Este es el módulo más complejo. Tiene **2 tabs (pestañas)**:

**Tab 1: Otros Países**
| Campo | Descripción |
|---|---|
| `ing_pais` | Destino (Otros / Colombia) |
| `ing_mnt` | Monto a transferir (CLP) |
| `ing_crg` | Cargo 1 (CLP) |
| `ing_crg_2` | Cargo 2 (CLP) |
| `ing_iva` | % IVA (19%, readonly) |
| `ing_tiva` | Total IVA calculado (CLP) |
| `ing_tot` | Total bruto (CLP) |
| `ing_tc` | Tipo de cambio base |
| `ing_tcact` | Tipo de cambio actual |
| `ing_appago` | Monto aproximado a pagar |
| `edt_mnt`, `edt_sbt`, `edt_tot`, `edt_tc`, `edt_appago` | Montos modificados para el PDF |
| `edt_formato` | Radio: Formato 1, 2, 3 o 4 del PDF |
| `adjunto` | Upload del ticket PDF original |
| `nroboleta` | Número de boleta para facturación |
| `utilidad` | Utilidad de la operación (readonly, calculado) |

**Tab 2: Colombia** (campos similares con prefijo `co_`)

---

### 1.4 `ventaswu` - Reporte de Ventas WU
**Archivo CI:** `views/calculadora/ventaswu_vista.php`

Tiene **3 tabs**:

| Tab | Descripción | Filtros |
|---|---|---|
| Transacciones | Tabla detallada de todas las transferencias | Vendedor, País, Fecha |
| Tiendas | Resumen de ventas por tienda | Tienda, Fecha |
| Cajeros | Resumen de ventas por usuario/cajero | Vendedor, Tienda, Fecha |

**Columnas de la tabla principal:** Item, País, Tienda, Usuario, Monto, Cargo, IVA, Sub.Total, Total Ventas, TC, Aprox Pago, Utilidad, Fecha, Hora, Formato, Original, Modificado.

---

## 2. Estrategia de Migración a Odoo 18

### ¿Por qué crear un módulo personalizado en Odoo?

En Odoo, la manera correcta de agregar funcionalidades propias es crear un **addon (módulo)**. Un módulo de Odoo tiene esta estructura mínima:

```
global_pagos/                    ← Nombre del módulo
├── __init__.py                  ← Le dice a Python que es un paquete
├── __manifest__.py              ← Metadatos del módulo (nombre, versión, etc.)
├── models/
│   ├── __init__.py
│   └── gp_transfer.py           ← Definición de los campos (los "campos" de la DB)
└── views/
    └── gp_transfer_views.xml    ← Las vistas XML (los formularios/listas)
```

### ¿Módulo aquí en CodeIgniter o en tu proyecto Odoo?

**Recomendación:** Crear la carpeta del módulo aquí (`/home/h3rnan/Work/Bitjoins/global_pagos/codeigniter/odoo_addons/global_pagos/`) y luego la copias/mueves a tu instancia de Odoo. Es lo más práctico porque:
- Tienes todo en un solo repositorio Git.
- Puedes revisar el código CI y el módulo Odoo lado a lado.
- Cuando esté listo, solo copias la carpeta `global_pagos/` a la carpeta `addons/` de tu servidor Odoo.

---

## 3. Mapeo: CodeIgniter → Odoo (Campos y Modelos)

En Odoo, los "campos" del formulario se definen en **Python** como atributos de una clase. La vista XML solo referencia esos campos.

### Correspondencia de tipos de campo

| Tipo HTML (CI) | Tipo en Odoo (Python) | Ejemplo |
|---|---|---|
| `<input type="text">` | `fields.Char` | `monto = fields.Char()` |
| `<input type="number">` | `fields.Float` o `fields.Integer` | `peso = fields.Float()` |
| `<select>` (lista fija) | `fields.Selection` | `tipo = fields.Selection([('1','Paquete'),('2','Sobre')])` |
| `<select>` (lista de DB) | `fields.Many2one` | `pais_id = fields.Many2one('gp.pais')` |
| `<input readonly>` (calculado) | `fields.Float(compute='...')` | Se calcula con un método Python |
| `<input type="date">` | `fields.Date` | `fecha = fields.Date()` |
| `<input type="file">` | `fields.Binary` | `adjunto = fields.Binary()` |

---

## 4. Plan de Módulos a Crear

Se propone **un solo módulo** llamado `global_pagos` que contenga todos los submódulos.

```
odoo_addons/
└── global_pagos/
    ├── __init__.py
    ├── __manifest__.py
    ├── models/
    │   ├── __init__.py
    │   ├── gp_pais.py              ← Modelo: países (tabla calculadora_pais)
    │   ├── gp_tienda.py            ← Modelo: tiendas (tabla calculadora_tienda)
    │   ├── gp_agencia.py           ← Modelo: agencias FDX/DHL
    │   ├── gp_agencia_peso.py      ← Modelo: tarifas por peso y zona
    │   └── gp_transferencia.py     ← Modelo principal: transferencias WU
    ├── views/
    │   ├── gp_pais_views.xml
    │   ├── gp_tienda_views.xml
    │   ├── gp_calc_fdx_views.xml   ← Calc FDX
    │   ├── gp_calc_dhl_views.xml   ← Calc DHL
    │   ├── gp_wu_views.xml         ← WU Integrador (formulario)
    │   ├── gp_ventas_views.xml     ← Reporte Ventas WU
    │   └── gp_menus.xml            ← Menús de navegación
    └── security/
        └── ir.model.access.csv     ← Permisos de acceso
```

---

## 5. Mejoras de Interfaz Propuestas

Al migrar a Odoo, podemos aprovechar para mejorar la experiencia de usuario:

### 5.1 Calculadoras FDX y DHL (Unificar en una sola vista)
**Problema actual:** Son dos vistas separadas y casi idénticas.
**Mejora:** Crear una sola vista con un campo `agencia` (FedEx / DHL) que cambie los campos dinámicamente.

```xml
<!-- En Odoo se puede mostrar/ocultar campos con attrs -->
<field name="tipo_envio" invisible="agencia != 'DHL'"/>
```

### 5.2 WU Integrador (Mejoras de usabilidad)
- Separar "Montos PDF" y "Montos Modificados" en **dos columnas** o **dos grupos** claramente etiquetados.
- Agregar **validación de campos** antes de procesar (Odoo tiene `required`, `domain`, `constraint`).
- El `nroboleta` debería ser un campo relacionado a una orden de facturación de Odoo (`account.move`).

### 5.3 Ventas WU (Dashboard en lugar de tabs)
**Problema actual:** Los 3 reportes están en tabs sin totales claros.
**Mejora en Odoo:** Usar una **vista pivot** o **vista gráfica** de Odoo, que es nativa y permite:
- Agrupar por fecha, tienda, usuario.
- Ver totales automáticos.
- Exportar a Excel con un clic.

---

## 6. Proceso Paso a Paso para Crear el Módulo

### Paso 1: Crear la estructura de carpetas
```bash
mkdir -p odoo_addons/global_pagos/{models,views,security}
touch odoo_addons/global_pagos/__init__.py
touch odoo_addons/global_pagos/__manifest__.py
touch odoo_addons/global_pagos/models/__init__.py
```

### Paso 2: Escribir el `__manifest__.py`
```python
{
    'name': 'Global Pagos - Calculadora',
    'version': '18.0.1.0.0',
    'summary': 'Módulo de calculadoras y transferencias WU',
    'category': 'Finance',
    'depends': ['base', 'mail'],
    'data': [
        'security/ir.model.access.csv',
        'views/gp_menus.xml',
        'views/gp_pais_views.xml',
        'views/gp_wu_views.xml',
        'views/gp_ventas_views.xml',
    ],
    'installable': True,
    'application': True,
}
```

### Paso 3: Definir los modelos Python
```python
# models/gp_transferencia.py
from odoo import models, fields

class GpTransferencia(models.Model):
    _name = 'gp.transferencia'
    _description = 'Transferencia Western Union'

    # Campos que venían de CI (ticket_western_integrado)
    pais_destino    = fields.Selection([('1','Otros'),('2','Colombia')], string='País Destino')
    ing_mnt         = fields.Float(string='Monto', digits=(16,2))
    ing_crg         = fields.Float(string='Cargo 1', digits=(16,2))
    ing_crg_2       = fields.Float(string='Cargo 2', digits=(16,2))
    ing_iva         = fields.Float(string='% IVA', default=19.0, readonly=True)
    ing_tiva        = fields.Float(string='Total IVA', compute='_compute_totales', store=True)
    ing_tot         = fields.Float(string='Total', compute='_compute_totales', store=True)
    ing_tc          = fields.Float(string='Tipo de Cambio', digits=(16,4))
    ing_appago      = fields.Float(string='Aprox. Pago', compute='_compute_totales', store=True)
    utilidad        = fields.Float(string='Utilidad', compute='_compute_totales', store=True)
    nroboleta       = fields.Char(string='Nro. Boleta')
    adjunto         = fields.Binary(string='Adjunto PDF')
    fecha           = fields.Date(string='Fecha', default=fields.Date.today)
    # ...más campos según necesidades
```

### Paso 4: Crear las vistas XML
```xml
<!-- views/gp_wu_views.xml -->
<odoo>
  <record id="view_gp_wu_form" model="ir.ui.view">
    <field name="name">gp.transferencia.form</field>
    <field name="model">gp.transferencia</field>
    <field name="arch" type="xml">
      <form string="Ticket WU">
        <sheet>
          <group>
            <group string="Montos PDF">
              <field name="pais_destino"/>
              <field name="ing_mnt"/>
              <field name="ing_crg"/>
              <field name="ing_crg_2"/>
              <field name="ing_iva"/>
              <field name="ing_tiva"/>
              <field name="ing_tot"/>
              <field name="ing_tc"/>
              <field name="ing_appago"/>
            </group>
            <group string="Montos Modificados">
              <!-- campos edt_ aquí -->
              <field name="nroboleta"/>
              <field name="utilidad"/>
              <field name="adjunto" widget="binary"/>
            </group>
          </group>
        </sheet>
      </form>
    </field>
  </record>
</odoo>
```

### Paso 5: Agregar permisos de acceso
```csv
# security/ir.model.access.csv
id,name,model_id:id,group_id:id,perm_read,perm_write,perm_create,perm_unlink
access_gp_transferencia,gp.transferencia,model_gp_transferencia,,1,1,1,0
```

### Paso 6: Copiar el módulo a Odoo
```bash
# Copiar la carpeta al directorio de addons de tu instancia Odoo
cp -r odoo_addons/global_pagos /ruta/a/tu/odoo/addons/

# En Odoo: Ajustes → Activar modo desarrollador → Actualizar lista de módulos → Instalar "Global Pagos"
```

---

## 7. Resumen Visual del Flujo

```
CodeIgniter (PHP)          →      Odoo 18 (Python + XML)
─────────────────────────────────────────────────────────
calcfdx.php (Form HTML)    →      gp_calc_fdx_views.xml (form view)
calcdhl.php (Form HTML)    →      gp_calc_dhl_views.xml (form view)
ticket_western_integrado   →      gp_wu_views.xml (form con 2 groups)
ventaswu_vista.php (tabs)  →      gp_ventas_views.xml (list + pivot view)

DB calculadora_pais        →      model gp.pais
DB calculadora_tienda      →      model gp.tienda
DB calculadora_transferencia→     model gp.transferencia (modelo principal)
```

---

## 8. ¿Qué NO necesitas hacer por ahora?

Dado que el objetivo inicial es **solo vistas sin funcionalidad**:
- ❌ No necesitas métodos `_compute_` en Python (pueden quedar vacíos).
- ❌ No necesitas controladores ni rutas.
- ❌ No necesitas conectar con la API de WU.
- ✅ Sí necesitas: modelos con campos + vistas XML + menús + permisos básicos.
