Magento Authorization
=====================

Magento Authorization is a simple Magento module to restrict the frontend access to a store. It allows to grant the access previligue to particular customer groups and provides several redirect modes for unpreviligued access. All this can be configured individually for each store.

Prerequisites
-------------

* Magento Community Edition 1.7+

Installation
------------

1. Copy the content of the `src` folder into the root folder of your Magento installation.
2. Clear the cache `Configuration` under `System > Cache Management`, when caching is enabled.

Usage
-----

To restrict the access go under `System > Config > General` of the favored store and set `Enable Authorization` to `Yes` under `Store Authorization`.

The selection of `Allowed Customer Groups` restricts the access to specific customer groups. `Public CMS Pages` and `Public URLs` set the CMS pages respectively URLs of other modules, which can be accessed by everyone. 

For customers and guests without the required permission, several redirect methods are provided:

* `Login` redirects to the login page and shows a the custom `Error Message`, if set,
* `Page` redirects to the custom `Error Page`, which also has to be selected within `Public CMS Pages`,
* and `URL` redirects to the custom `Error URL`, which also has to be set in `Public URLs`.

Contribution
------------

Please report issues on the GitHub [issue tracker](https://github.com/witrin/magento-authorization/issues). Personal emails are not appropriate for bug reports. Patches are preferred as GitHub pull requests.

License
-------

This software is licensed under the [Open Software License version 3.0](http://opensource.org/licenses/osl-3.0).