# Advanced Squad Filters for SeAT

A plugin for [SeAT](https://github.com/eveseat/seat) that provides a more flexible squad filter system.

## Installation

You will eventually be able to install this package via composer:

```bash
composer require tmas/seat-advanced-squad-filters # package unpublished, this doesn't work yet!
```

Then, publish the assets and run migrations:

```bash
php artisan vendor:publish --force --provider="Tmas\AdvancedSquadFilters\AdvancedSquadFiltersServiceProvider"
php artisan migrate
```

## Configuration

Configure your plugin settings at http://seat.your-domain/advanced-squad-filters

## Usage (for end users)

This package is a work in progress, so you can't actually use it yet. Eventually, it will add a new link in the menu called "Advanced Squad Filters". From the Advanced Squad Filters page, you will be able to configure a set of filters to run on a squad of the type "Manual". This is not ideal, but it's required to avoid conflicts with SeAT's built-in squad filters.

## Usage (for package developers)

You can register your custom filters by merging them into the config in your service provider's boot menu like this:
```php
$this->mergeConfigFrom(__DIR__ . '/Config/my-seat-plugin.characterfilter.php', 'advanced-squad-filters.characterfilter');
```

Your config file should be a simple non-keyed array of filter classes, much like the file found in this repository at src/Config/advanced-squad-filters.characterfilter.php.

Each filter must implement the `Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract` interface. I recommend using the filters defined in this repository as a reference. The most important part is the `apply` function, which receives a query and must apply filters to it.

If the filter you're adding would have also been possible to implement in SeAT's existing filter system, you can extend the abstract class `Tmas\AdvancedSquadFilters\Filters\LegacyFilter` as a shortcut. Simply put `public static array $legacyFilterDefinition = [...]` in the body of the class, replacing [...] with the filter array as you would've defined it in the existing squad system, and it should work as expected assuming I didn't somehow screw up backward compatibilty.


## Long-term goals

This project arose from a desire for a "Days In Current Corporation" filter, followed by a conversation on the SeAT Discord server about refactoring the filter system. I eventually hope to get something merged into SeAT core as a refactor of the existing filter system, or at least modify SeAT core a bit so this plugin can register a custom squad type instead of piggybacking on the Manual squad type.