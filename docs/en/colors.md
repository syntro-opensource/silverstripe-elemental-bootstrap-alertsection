# Colors

This section can be configured to use any colors you might need.

## Adding colors
By default, a user can choose between `primary`, `success`, `warning` and `danger`
as background color. If your theme uses more colors or names them differently,
you can use the `background_colors` array:

```yaml
Syntro\SilverStripeElementalBootstrapAlertSection\Elements\AlertSection:
  background_colors:
    highlight: Readable description
```

The key represents the bootstrap color name (as in `bg-primary`) and the value
the Name which is presented to the user.

## Setting font color
When adding custom colors (or changing the default bootstrap ones), the default
color for text and buttons might not be useful. You can use the `text_colors_by_background`
map:
```yaml
Syntro\SilverStripeElementalBootstrapAlertSection\Elements\AlertSection:
  text_colors_by_background:
    highlight: dark
```
where the key maps a background color to a font color.
> Keep in mind that bootstrap doesn't provide `white` buttons by default, so use `light` instead!
