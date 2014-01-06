# Contributing to __

If you’d like to contribute a feature or bug fix, you can [fork](https://help.github.com/articles/fork-a-repo) __, commit your changes, and [send a pull request](https://help.github.com/articles/using-pull-requests).
Please make sure to [search the issue tracker](https://github.com/MaciejCzyzewski/__/issues) first; your issue may have already been discussed or fixed in `master`.

## Tests

Include updated unit tests in the `tests` directory as part of your pull request.
You can run the tests from the command line via `phpunit`.

## Coding Guidelines

In addition to the following guidelines, please follow the conventions already established in the code.

- **Spacing**:<br>
  Use four spaces for indentation. No tabs.

- **Naming**:<br>
  Keep variable and method names concise and descriptive.<br>

- **Quotes**:<br>
  Single-quoted strings are preferred to double-quoted strings; however, please use a double-quoted string if the value contains a single-quote character to avoid unnecessary escaping.

- **Comments**:<br>
  Please use single-line comments to annotate significant additions, and [Doxygen-style](https://gist.github.com/MaciejCzyzewski/8275896/raw/6e58fb90139d067ae32fa7661d8049742de50f91/CONTRIBUTING.txt) comments for new methods.