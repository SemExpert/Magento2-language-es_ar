# Magento2-language-es_ar

Magento2 Spanish (Argentina) language pack build from Crowdin community translation tool.

Paquete de idioma de Español (Argentina) construido a partir de la plataforma de traducciones de la comunidad Crowdin. 

## Referencias

* [Magento Devdocs](http://devdocs.magento.com/guides/v2.2/frontend-dev-guide/translations/xlate.html) - La críptica
guía en la que me basé para armar el diccionario
* [Crowdin](https://crowdin.com/project/magento-2/es-AR) - La herramienta de traducciones que se utiliza como fuente
para este paquete

## Getting Started

Para construir el diccionario desde Crowdin, solo hace falta ejecutar el script `build.php` indicando la versión de
Magento como parámetro

```
php build.php 2.2.1
``` 

### Prerequisitos

El script utilizado para importar las traducciones desde Crowdin requiere las siguientes extensiones de PHP presentes

* cUrl
* Zip

### Instalación

Para agregar el paquete a una instalación de Magento 2, sólo hace falta hacerlo mediante composer indicando el número de
versión de Magento 2

```
composer require semexpert/language-es_ar:2.1.8
``` 

### Contribuciones

El objetivo principal de este proyecto es fomentar el uso de Crowdin como plataforma para traducir Magento por parte de
la comunidad. De esta manera podremos tener un paquete de idiomas mantenido lo más democráticamente posible. Por este
motivo, no estaré aceptando PR que modifiquen el archivo `es_AR.csv` directamente. La mejor forma de contribuir al 
mantenimiento de este paquete de idiomas es hacerlo directamente en Crowdin.

Por otro lado, si aceptaré con gusto (y trataré de responder lo más diligentemente posible) a cualquier pedido de 
regenerar el diccionario cuando hayan actualizaciones en Crowdin y republicarlo.

De la misma manera, todo PR para mejorar el script `build.php` o corregir bugs será más que bienvenido, agradecido y 
atribuido.

## Versioning

Usamos [SemVer](http://semver.org/) para el versionado. Para las versiones disponibles, mirá los
[tags de este repositorio](https://github.com/SemExpert/Magento2-language-es_ar/tags). 

La numeración de las versiones es la misma que la de Magento para simplificar la instalación. Cada nuevo build del 
diccionario contiene un identificado de pre-release con el número de build correspondiente a esa versión.

Por ejemplo:

* 2.1.8-1
* 2.2.0-1
* 2.2.0-2
* 2.2.1-1
* 2.2.1-2
* 2.2.1-3

Se aceptan sugerencias para mejorar este sistema de versionado.

## Autores

* **Matías Montes** - *Initial work* - [barbazul](https://github.com/barbazul/)

También revisa la lista de [contribuyentes](https://github.com/SemExpert/Magento2-language-es_ar/contributors) que 
participaron de este proyecto.

## Licencia

Este proyecto esta licenciado bajo MIT - mirá [LICENSE.md](LICENSE.md) más detalles.
