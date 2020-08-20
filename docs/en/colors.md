# Colors

## Adding colors
By default, a user can choose between `primary`, `success`, `warning` and `danger`
as background color. If your theme uses more colors or names them differently,
you can use the `colors` array:

```yaml
Syntro\SilverStripeElementalBootstrapAlertSection\Elements\ElementAlertSection:
  colors:
    highlight: Highlight
```

The key represents the bootstrap color name (as in `bg-primary`) and the value
the Name which is presented to the user.

## Setting font color
When adding custom colors (or changing the default bootstrap ones), the default
`light` color for text and buttons might not be useful. You can use the `textColors`
map:
```yaml
Syntro\SilverStripeElementalBootstrapAlertSection\Elements\ElementAlertSection:
  textColors:
    highlight: dark
```
where the key maps a background color to a font color.
> Keep in mind that bootstrap doesn't provide `white` buttons by default, so use `light` instead!
