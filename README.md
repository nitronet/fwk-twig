# fwk-twig

Brings [Twig](http://twig.sensiolabs.org/) template engine support for [Fwk\Core](https://github.com/fwk/Core) Applications.

## Installation

### 1: Install the sources

Via [Composer](http://getcomposer.org):

```
{
    "require": {
        "nitronet/fwk-twig": "dev-master",
    }
}
```

If you don't use Composer, you can still [download](https://github.com/nitronet/fwk-twig/zipball/master) this repository and add it
to your ```include_path``` [PSR-0 compatible](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)

### 2: Defines Twig as a Service

Define a ```Twig_Environment``` instance in your [Di](https://github.com/fwk/Di) Container, and configure it the way you want:

``` xml
<!-- Twig_Environment Configuration -->
<array-definition name="twig.config">
    <param key="debug">true</param>
</array-definition>

<!-- Twig_Loader definition -->
<class-definition name="twig.loader" class="\Twig_Loader_Filesystem" shared="true">
    <!-- :packageDir = directory of this .xml file -->
    <argument>:packageDir/path/to/templates</argument>
</class-definition>

<!-- Twig_Environment definition -->
<class-definition name="twig" class="\Twig_Environment" shared="true">
    <argument>@twig.loader</argument>
    <argument>@twig.config</argument>
</class-definition>
```

### 3: Register Twig ResultType

Registers a new ResultType in fwk.xml:

``` xml
<result-type name="twig" class="FwkTwig\TwigResultType" />
```

### 4: Enjoy!

Use the ResultType where you want:

``` xml
<action name="Home" shortcut="MyApp\Controllers\Home:show">
    <result name="success" type="twig">
        <param name="file">home.twig</param>
    </result>
</action>
```

## Contributions / Community

- Issues on Github: https://github.com/nitronet/fwk-twig/issues
- Follow *Fwk* on Twitter: [@phpfwk](https://twitter.com/phpfwk)
