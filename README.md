# Reason

Sometimes, you need to know not only can be things done or not,
but also _why_ things can be done.

## Reason status

Status describes current state of reason. It must be convertible to integer value -
status weight. Status with higher weight worse then smaller weight. 
(Make sense for appending and joining.)

## Appending reasons (orX)

Reasons can be appended to other reasons. It operations can be matched with `logical or`.
Reason with the lowest weight wins. If two reasons have same weight, those messages
will be merged.

```php
// weight: 1
// messages: foo, bar
$first = new Reason(...);

// weight: 2
// messages: baz
$second = new Reason(...);

// weight: 1
// messages: foo, bar
$firstOrSecond = $first->orX($second);

// weight: 1
// messages: foobar
$third = new Reason(...);

// weight: 1
// messages: foo, bar, foobar
$firstOrThird = $first->orX($third);
```

## Joining reasons (andX)

Same behavior as appending, but reason with the highest weight wins.
Looks like `logical and` operation.

```php
// weight: 1
// messages: foo, bar
$first = new Reason(...);

// weight: 2
// messages: baz
$second = new Reason(...);

// weight: 2
// messages: baz
$firstAndSecond = $first->andX($second);

// weight: 1
// messages: foobar
$third = new Reason(...);

// weight: 1
// messages: foo, bar, foobar
$firstAndThird = $first->andX($third);
```

## Testing

```
$ vendor/bin/phpunit
```