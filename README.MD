<p align="center">
    <br><br>
    <img src="https://leafphp.dev/logo-circle.png" height="100"/>
    <br><br>
</p>

# Leaf API 3 &lt;BETA&gt;

[![Latest Stable Version](https://poser.pugx.org/leafs/api/v/stable)](https://packagist.org/packages/leafs/api)
[![Total Downloads](https://poser.pugx.org/leafs/api/downloads)](https://packagist.org/packages/leafs/api)
[![License](https://poser.pugx.org/leafs/api/license)](https://packagist.org/packages/leafs/api)

Leaf API is a minimal API wrapper built on top of [Leaf PHP](https://leafphp.dev) which allows you to build APIs with Leaf, faster and simpler than ever before. Leaf API provides an simple and opinionated structure with a tons of functionality built in.

It is built on Leaf 3 which makes it even more lightweight and faster than earlier versions, but comes with a ton of upgrades and security fixes.

## 📦 Installation

You can install Leaf API v3 with the [Leaf CLI](https://cli.leafphp.dev)

```sh
leaf create <project-name> --v3 --api
```

`<project-name>` is your project name

You can also use [Composer](https://getcomposer.org/) to install Leaf API quickly.

```bash
composer create-project leafs/api <project-name>
```

This will start a new Leaf API app.

## 🗂 Directory Structure

```bash
C:.
├───app
│   ├───console
│   ├───controllers
│   │   └───Auth
│   ├───database
│   │   ├───factories
│   │   ├───migrations
│   │   └───seeds
│   ├───helpers
│   ├───models
│   ├───routes
│   └───views
├───config
│   └───command
├───public
├───storage
│   ├───app
│   │   └───public
│   ├───framework
│   │   └───views
│   └───logs
└───vendor
```

This directory structure is a blend of Ruby on Rails and Laravel

To run your Leaf API application, use

```bash
php leaf serve
```

## 📓 Learning Leaf API

Leaf API has a very easy to understand [documentation](https://api.leafphp.dev) which contains information on all operations in Leaf API.

Since Leaf API runs on Leaf, you should check out the Leaf PHP Framework documentation [here](https://leafphp.dev).

## 😇 Contributing

We are glad to have you. All contributions are welcome! To get started, familiarize yourself with our [contribution guide](https://leafphp.dev/community/contributing.html) and you'll be ready to make your first pull request 🚀.

To report a security vulnerability, you can reach out to [@mychidarko](https://twitter.com/mychidarko) or [@leafphp](https://twitter.com/leafphp) on twitter. We will coordinate the fix and eventually commit the solution in this project.

## 🤩 Sponsoring Leaf

Your cash contributions go a long way to help us make Leaf even better for you. You can sponsor Leaf and any of our packages on [open collective](https://opencollective.com/leaf) or check the [contribution page](https://leafphp.dev/support/) for a list of ways to contribute.

We will furthermore like to thank our existing supporters, we love you all ❤️

## 📃 License

The Leaf API framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Links

- [Leaf Docs](https://leafphp.dev)
- [Leaf API Docs](https://api.leafphp.dev)
- [Leaf CLI Docs](https://cli.leafphp.dev)
- [Aloe CLI Docs](https://leafphp.dev/aloe-cli/)
