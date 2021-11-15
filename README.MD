<p align="center">
    <br><br>
    <img src="https://leafphp.dev/logo-circle.png" height="100"/>
    <br>
</p>

# Leaf API

[![Latest Stable Version](https://poser.pugx.org/leafs/api/v/stable)](https://packagist.org/packages/leafs/api)
[![Total Downloads](https://poser.pugx.org/leafs/api/downloads)](https://packagist.org/packages/leafs/api)
[![License](https://poser.pugx.org/leafs/api/license)](https://packagist.org/packages/leafs/api)

Leaf API is a minimal MVC wrapper built on top of Leaf PHP which allows you to build APIs with Leaf, faster and simpler than ever before.

v2 of leaf API packs in a ton of new features with enhanced usability for existing features. It also has better binding with other Leaf libraries as well as external libraries. Also since Leaf doesn't enforce particular systems like `Facades` in laravel, you can port in any valid PHP library and it should work fine.

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Leaf.

```bash
composer create-project leafs/api <project-name>
```

This will start a new Leaf api project.

## Basic Info

```bash
C:.
├── app
│   ├── console
│   ├── controllers
│   │   └── Auth
│   ├── database
│   │   ├── factories
│   │   ├── migrations
│   │   ├── schema
│   │   └── seeds
│   ├── helpers
│   ├── models
│   ├── routes
│   └── views
├── config
├── lib
├── public
├── storage
│   ├── app
│   │   └── public
│   ├── framework
│   │   └── views
│   └── logs
└── vendor
```

This directory structure is a blend of Ruby on Rails and Laravel

To run your Leaf api application, use

```bash
php leaf serve
```

## Learning LeafAPI

LeafAPI has a very easy to understand [documentation](https://leafphp.netlify.app/#/leaf-api/) which contains information on all operations in LeafAPI.

Since LeafAPI runs on Leaf, you can check out the Leaf PHP Framework documentation [here](https://leafphp.netlify.app).

## License

The LeafAPI framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## View LeafAPI's docs [here](https://leafphp.netlify.app/#/leaf-api/)

## View Leaf's docs [here](https://leafphp.netlify.app)
