# portfolio-drupal
portfolio personal creado con drupal usando el módulo Noahs para la parte de enmaquetado

Este repositorio contiene el desarrollo de un portfolio profesional realizado con Drupal 10, utilizando DDEV como entorno local basado en Docker y Noah’s Page Builder como constructor visual principal. El proyecto se ha trabajado siguiendo un flujo lo más cercano posible a un entorno real de cliente, con control de versiones, snapshots frecuentes y resolución de incidencias técnicas reales.

Objetivo del proyecto

El objetivo ha sido construir un portfolio funcional, mantenible y extensible, que sirva tanto como carta de presentación profesional como ejercicio práctico avanzado de Drupal. El foco no ha estado solo en “que funcione”, sino en entender la arquitectura del sistema, la relación entre configuración, contenido y tema, y en trabajar con criterio técnico.

Tecnologías y herramientas: 
    -Drupal 10
    -Noah’s Page Builder
    -Noah’s Builder Theme + subtema personalizado
    -DDEV (Docker)
    -Drush
    -Twig
    -CSS y JavaScript nativo
    -Git y GitHub

El proyecto incluye:
    -Página de inicio creada con Noah’s Page Builder
    -Sección “Sobre mí” editable con Noah’s
    -Tipo de contenido Proyecto, con:
        -Imagen
        -Descripción
        -Cliente
        -Año
        -Tecnologías (taxonomía)
        -Enlace al proyecto
        -Vista de listado de proyectos con filtro por tecnologías
        -Página de detalle de proyecto con template Twig personalizado

    -Formulario de contacto reutilizable (Webform), integrado mediante Noah’s
    -Cabecera y footer globales correctamente gestionados mediante bloques
    -Roles y permisos personalizados (Administrador, Editor, Cliente)
    -Integración de JavaScript propio desde el subtema (scroll y animaciones simples)
    -Adaptación responsive para escritorio, tablet y móvil

Trabajo con temas y frontend
Se ha trabajado sobre un subtema propio que hereda de noahs_builder_theme, evitando modificar directamente temas contrib.
El proyecto incluye:
    -Sobrescritura controlada de templates Twig (page y node)
    -Resolución de problemas de renderizado de Noah’s mediante integración correcta de variables (noahs_node_html)
    -Organización clara de CSS y JS en el subtema, sin pipeline adicional (gulp/npm descartados conscientemente por no -aportar valor en este contexto)
    -Activación de modo desarrollo (theme debug, caché deshabilitada) para facilitar el trabajo con Twig
