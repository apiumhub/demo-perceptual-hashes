# Perceptual Hashes (pHashes)

> Demostración de cómo construir un Reverse Image Search con PHP



[TOC]

## Introducción

TODO

![thumb](/home/arc/Projects/perceptual-hashes/screenshot.png)

### Aprendiendo sobre p-Hashes

TODO



## Construído con

* [Docker](https://www.docker.com/) - La manera más rápida de crear aplicaciones en contenedores.
* [nginx](https://www.nginx.com/) - Servidor web, balanceador de carga avanzado y reverse proxy todo en uno.
* [PHP-FPM](https://www.php.net/) -  Lenguaje de programación generalista que está especialmente diseñado para el desarrollo web.
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

### Parando el servicio

```bash
~demos/perceptual-hashes$ make down
```