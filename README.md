# Perceptual Hashes (pHashes)

> Demostración sobre cómo construir un Reverse Image Search basado en p-Hashes y PHP


[TOC]

## Qué son los Perceptual Hashes

Para obtener más información sobre los Perceptual Hashes, también llamados p-Hashes, puede consultar la entrada [Introduction to Perceptual Hashes - Measuring similarity](https://apiumhub.com/tech-blog-barcelona/xxxxxxxxxx/) de nuestro blog que trata precisamente de este tema.

## Sobre esta aplicación

> Esta aplicación es una prueba de concepto que demuestra cómo aplicar p-Hashes para mejorar los procesos de búsqueda de un ecommerce.
>
> Debe ser considerada como una PoC a título informativo y-o educativo.

### Caso de Uso

Imaginemos el supuesto en el que un usuario quiere comprar unas gafas porque las que actualmente usa están rotas. Debido al paso del tiempo, ni la marca, ni el modelo ni el código de referencia son legibles por lo que al usuario no le quedan más opciones que pasarse horas y horas realizando búsquedas y puede que termine sin encontrar el modelo deseado.

Para el ecommerce esta situación supone un impacto en términos de consumo de recursos ya que implica un número elevado de peticiones para paginar prácticamente todo su catálogo sin apenas conversión.

#### Propuesta

Para mejorar la experiencia de usuario se desarrollará un Reverse Image Search basado en p-Hashes.

#### Expectativas

Con esta funcionalidad el buscador del ecommerce permitirá, además de las funciones básicas, mostrar el catálogo de productos ordenados por similitud a uno determinado.

Así pues, en el supuesto actual, el usuario sacaría una foto de las gafas actuales y la enviaría al servidor. Éste calculará el Hash de dicha imágen y lo compara con los asignados a todas las imágenes del catálogo, pudiendo así definir un grado de similitud a partir del cual excluir aquellos productos que sean totalmente diferentes o bien, que por cuestiones de negocio, que no sean relevantes para el usuario.

De este modo, en el mejor de los casos, el usuario podrá encontrar las gafas que desea en la primera página de resultados o bien, en su defecto, aquellos modelos más parecidos al buscado, mejorando así la experiencia de usuario.

Desde el punto de vista del ecommerce esta propuesta reduce el número de peticiones al servidor y aumenta el grado de conversión al mostrar en la primera página de resultados todos los productos que son similares al buscado.

### Mockup

Para poder mostrar este caso de uso se ha creado un pequeño componente reactivo en Vue que permita hacer las búsquedas y mostrar el resultado de una manera dinámica:

![thumb](./screenshot.png)


## Construído con

* [Docker](https://www.docker.com/) - La manera más rápida de crear aplicaciones en contenedores.
* [nginx](https://www.nginx.com/) - Servidor web, balanceador de carga avanzado y reverse proxy todo en uno.
* [PHP-FPM](https://www.php.net/) - Lenguaje de programación generalista que está especialmente diseñado para el desarrollo web.
* [ImageMagick](https://imagemagick.org/) - Software que permite manipular imágenes desde el lado del servidor.
* [VueJS](https://vuejs.org/) - Un framework JavaScript progresivo.
* Make - Utilidad make GNU para mantener grupos de programas.

## Requisitos

- Docker
- Git

## Consideraciones

Para simplificar la puesta en marcha la aplicación responde por defecto a la URL `http://localhost`

## Instalación

Para instalar esta aplicación basta con clonar el proyecto en local:

```bash
$ cd ~ && mkdir -p demos/perceptual-hashes
~demos/perceptual-hashes$ git clone https://github.com/xxxxxxxxx
```

## Uso

La aplicación cuenta con un Makefile que contiene todos los comandos útiles para su puesta en marcha:

### Construcción del servicio

```bash
~demos/perceptual-hashes$ make build
```

### Iniciando el servicio

```bash
~demos/perceptual-hashes$ make up
```

> Ahora ya puedes acceder al servicio usando tu navegador favorito desde la URL`http://localhost` 

### Parando el servicio

```bash
~demos/perceptual-hashes$ make down
```