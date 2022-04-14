---
title: Similar plugin for Craft CMS 3.x
description: Documentation for the Similar plugin. The Similar plugin lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... Other related elements.
---
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-similar/badges/quality-score.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-similar/?branch=v1) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-similar/badges/coverage.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-similar/?branch=v1) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-similar/badges/build.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-similar/build-status/v1) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-similar/badges/code-intelligence.svg?b=v1)](https://scrutinizer-ci.com/code-intelligence)

# Similar plugin for Craft CMS 3.x

Similar for Craft lets you find elements, Entries, Categories, Commerce Products, etc, that are similar, based on... Other related elements.

![Screenshot](./resources/img/plugin-logo.png)

Related: [Similar for Craft 2.x](https://github.com/aelvan/Similar-Craft)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-similar

3. Install the plugin via `./craft install/plugin similar` via the CLI, or in the Control Panel, go to Settings → Plugins and click the “Install” button for Similar.

You can also install Similar via the **Plugin Store** in the Craft AdminCP.

## Similar Overview

Similar is a Craft CMS 3 port of the [Similar for Craft 2.x](https://github.com/aelvan/Similar-Craft) plugin by André Elvan.

Below is the original README.md (with minor edits to reflect changes due to the port to Craft CMS 3):

## Using Similar

The plugin has one template method, `find`, which takes a parameters object with two required parameters, `element` and `context`. To find entries that are similar to `entry`, based on its tags in the Tagtag field `entry.tags`:

```twig
    {% set similarEntriesByTags = craft.similar.find({ element: entry, context: entry.tags }) %}
    <ul>
    {% for similarEntry in similarEntriesByTags %}
        <li>{{ similarEntry.title }} ({{ similarEntry.count }} tags in common)</li>
    {% endfor %}
    </ul>
```

There is also a third, optional parameter that you probably would want to use most of the time, `criteria`. `criteria` lets you create the base ElementQuery that Similar will extend, giving you the ability to use all of Craft’s usual goodies for your queries. If you’d want to limit the number of entries returned (good idea!), you could do it like this:

```twig
    {% set limitCriteria = craft.entries().limit(4) %}
    {% set similarEntriesByTags = craft.similar.find({ element: entry, context: entry.tags, criteria: limitCriteria }) %}
    
    <ul>
    {% for similarEntry in similarEntriesByTags %}
        <li>{{ similarEntry.title }} ({{ similarEntry.count }} tags in common)</li>
    {% endfor %}
    </ul>
```

Since the `criteria` is an ElementQuery, you can tailor your results set to narrow in on one section of content, or force an association with a particular category, tag, etc. Expanding on the `limitCriteria` variable above, these would all be possibilities:

```twig
   {% set limitCriteria = craft.entries().section(['recipes','ingredients']).limit(4) %}
   {% set limitCriteria = craft.entries().myField(':notEmpty:').limit(4) %}
   {% set limitCriteria = craft.entries().type('vlogEntry').limit(8) %}
```

The supported element types are `Entry`, `Asset`, `Category`, `Tag`, `User` and `Commerce_Product`. If you miss one, send me a feature request.

The `context` parameter takes either an `ElementQuery`, or a list of IDs. To find similar entries based on an entry’s tags and categories, you could do:

 ```twig
    {% set ids = entry.tags.ids() | merge(entry.categories.ids()) %}
    {% set limitCriteria = craft.entries().limit(4) %}
    {% set similarEntriesByTagsAndCategories = craft.similar.find({ element: entry, context: ids, criteria: limitCriteria }) %}
```

The returned model will be an extended version of the model of the element type you supplied. In the above examples where similar entries are returned, a `SimilarEntry` which extends `Entry` will be returned, giving you all the methods and properties of `Entry` in addition to `count` which indicates how many relations the entries had in common.

### Matrix gotcha

Similar will not take relations inside Matrix blocks into account. 

Brought to you by [nystudio107.com](https://nystudio107.com/)
