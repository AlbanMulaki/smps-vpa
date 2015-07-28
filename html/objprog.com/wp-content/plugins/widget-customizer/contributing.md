Pull requests should be opened with the `develop` branch as the base. Do not
open pull requests into the `master` branch, as this branch contains the latest
stable release.

Try running your code through PHP_CodeSniffer (PHPCS) and the [WordPress Coding Standards sniffs][1].
You can run PHPCS, JSHint, and (if available) PHPUnit automatically by symlinking to the bundled `pre-commit` hook:

```bash
cd .git/hooks
ln -s ../../bin/pre-commit .
```

[1]: https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
