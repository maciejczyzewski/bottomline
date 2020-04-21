---
layout: full
show_in_menu: false
homepage: true
title: bottomline.php
description: A full-on PHP manipulation utility belt; a lodash or underscore equivalent for PHP.
---

<div class="row">
<div class="col-md-6" markdown="1">

## Installation

Install bottomline in your project via [Composer](https://getcomposer.org/).

```bash
composer require maciejczyzewski/bottomline
```

### Requirements

- PHP 5.5+

</div>
<div class="col-md-6" markdown="1">

## Documentation

This library organizes functions into several namespaces based on their own functionality. These are the available namespaces:

{% assign namespaces = site.data.fxn_registry.methods | map: "namespace" | uniq %}
{% for method in namespaces -%}
- [{{ method | capitalize }}](documentation/#{{ method }})
{% endfor %}

</div>
</div>
