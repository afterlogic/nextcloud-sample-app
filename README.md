Sample app for Nextcloud
========================

When working on [Nextcloud connector for Afterlogic WebMail](https://github.com/afterlogic/nextcloud-connector) to make it compatible with Nextcloud version 19, we considered a complete rewrite of the application. What we couldn't find was a really basic "Hello world" kind of application we could start from. And to make things work, we had to create such an application ourselves. Now that the application is released, we thought it may be worth sharing such a sample with the community, for those interested in making their apps for Nextcloud.

Application structure
=====================

To start working on the application, we need to create a subdirectory under `apps` dir of Nextcloud installation, directory name must match app ID, and in our case, it's going to be `sample`.

At the very least, application directory needs to contain the following subdirectories:
* `appinfo` stores meta information about the app and core information on application structure;
* `img` will hold the application icon;
* `lib` is where main code of the application resides;
* `templates` stores files in charge of visual look of the application.

Files of the application
========================

Primary file of your application is `appinfo/info.xml`. It contains app name, description, licensing info, version number and so on. In this sample, we've only included the required entries but the file can contain much more than that, check [official Nextcloud documentation](https://docs.nextcloud.com/server/19/developer_manual/app/info.html) for more detail on this.

`appinfo/app.php` is the first PHP file of your application that gets executed. In this sample, its only purpose is to add a navigation button for the application:

```php
...
        'href' => $urlGenerator->linkToRoute('sample.page.index'),
        'icon' => $urlGenerator->imagePath('sample', 'sample.svg'),
...
```

It refers to SVG icon found in `img` directory, and to route defined in `appinfo/routes.php` file:

```php
<?php

return [
    'routes' => [
	['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
    ]
];
 ```

The routing rule used there means that the main '/' URL uses the controller called **page** and its method called **index**. That controller must reside under `lib/Controller` directory, must be called `PageController.php` and needs to have **index()** method:

```
public function index() {
	$oTemplate = new TemplateResponse('sample', 'index');
	return $oTemplate;
}
```

The controller itself holds the logic, and uses `templates/index.php` file for presentation purposes.

This concludes the sample, but we've also wanted to give some guidelines for turning this sample into a more complex app.

Using IFrame approach
==============

Let's assume you're willing to embed some external application (probably running on the same server) into Nextcloud. You can do so with a minimal modification of this sample. Replace `templates/index.php` file content with the following:

```html
<iframe id="appcon" style="border: none; width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; right: 0px; bottom: 0px;" tabindex="-1" frameborder="0" src="http://localhost/external-app/"></iframe> 
```

This code provides an IFrame container for placing the external application into it.

By default, Content Security Policy used by Nextcloud will block such an external content. To allow for the content, modify `lib/Controller/PageController.php` file, adding the use of ContentSecurityPolicy class:

```php
use OCP\AppFramework\Http\ContentSecurityPolicy;
```

As for **index()** method, you'll need something like this:

```php
public function index() {
	$oTemplate = new TemplateResponse('sample', 'index');
	$oCsp = new ContentSecurityPolicy();
	$oCsp->addAllowedFrameDomain("localhost");
	$oTemplate->setContentSecurityPolicy($oCsp);
	return $oTemplate;
}
```

Feedback
===

Hope you find this sample useful for your needs. If you have any comments or suggestions, please feel free to post them at the [issue tracker](https://github.com/afterlogic/nextcloud-sample-app/issues).
