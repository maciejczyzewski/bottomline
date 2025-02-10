# Contributing

## Guidelines

:octocat: It is recommended to have an issue open for any work you take on and intend to submit as a pull request - it helps core members review your concept and direction early and is a good way to discuss what you're planning to do. If there is no issue tied to the Pull Request, please include a detailed description in the PR.

:100: We are aiming for 100% code coverage. Please keep this in mind when you're submitting new code.

:ok_hand: We use [PSR standard](http://www.php-fig.org/psr/) to keep our code sanitized and easy to follow.

## Development Environment

The library itself requires PHP >= 5.5 but for development purposes, we require PHP >= 8.1. The library itself only needs `ext-mbstring` to handle special characters but for development, we also need `ext-json` available. Use [Composer v2](https://getcomposer.org/download/) for handling dependencies.

For generating the documentation website, you'll also need Ruby with [`bundle`](https://bundler.io/).

## Development setup

1. Fork our repository
2. Clone your forked repository `git clone git@github.com:<your namespace>/bottomline.git`
3. Install development dependencies `composer install`
4. Run tests `composer run test`

Also useful:

* Run benchmarks: `composer run bench`
* Format the code: `composer run cs-fix`
* Generate the doc: `composer run doc`
* Generate the doc website: `composer run site`

## Development checklist

- Add or update phpDocs for the new function with a **Usage** and **Result** section ;
- Always add tests for the code that you write, including edge cases ;
- Place the new functions where they belong (collections, arrays, utilities, etc.) ;
- Add `README.md` doc entry for the functions ;
- Execute `composer run doc` script to automatically build an updated `load.php` ;
- Update the benchmark `bench.php`, this helps us to validate the performance of the library ;
- Update `CHANGELOG.md` with your changes.

## How to open a PR

- Create a branch in your forked repository and push your code into it ;
- Create a PR in [bottomline](https://github.com/maciejczyzewski/bottomline) that points to your forked branch ;
- Add description of the PR (issue links, etc.).

### PR Title Recommendations

- Squash commits into 1 commit before the PR is merged into master, this help reduces git tree and makes it easier to revert to a certain state. (can be multiple commits, but they have to be meaningful commits) ;
- Open PR title starting with one of the following words:
    + `Fix` - for a bug fix ;
    + `New` - implemented a new feature ;
    + `Update` - for a backwards-compatible enhancement ;
    + `Breaking` - for a backwards-incompatible enhancement or feature ;
    + `Docs` - changes to documentation only ;
- Use `LF` line endings.

## Release Checklist

- [ ] Update `CHANGELOG.md` with the new version and date of release
- [ ] Update the `bottomline v0.x.x` comment located in `src/__/__.php`
- [ ] Ensure that any new functions added during this release have an `@since` tag in their phpDocs
