# Contributing to Bodyloom Icon List

First off, thanks for taking the time to contribute! 🎉

## Code of Conduct

This project and everyone participating in it is governed by the [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## How to Contribute

### Reporting Bugs

Bugs are tracked as GitHub issues. When filing an issue, please include:

*   A clear and descriptive title.
*   Steps to reproduce the behavior.
*   Expected behavior vs. actual behavior.
*   Screenshots or recordings if possible.
*   Your environment details (WordPress version, PHP version, Browser, etc.).

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When suggesting an enhancement:

*   Explain why this enhancement would be useful.
*   Provide a clear and detailed description of the suggested change.

### Pull Requests

1.  **Fork** the repository and clone it locally.
2.  Create a branch for your edit.
3.  Make your changes.
4.  Ensure your code follows our [Coding Standards](#coding-standards).
5.  Push to your fork and submit a Pull Request.

## Branching Strategy

We follow a standard git flow:

*   `main`: The stable branch containing the latest release. **Do not strict push to main.**
*   `develop`: The integration branch for the next release.
*   `feature/feature-name`: For new features (branch off `develop`).
*   `fix/bug-name`: For bug fixes (branch off `develop` or `main` for hotfixes).

## Coding Standards

*   **PHP:** We follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/). A `phpcs.xml.dist` file is included in the root for checking your code.
*   **JS/CSS:** Follow standard WordPress formatting guidelines.
*   **Security:** Always escape output (`esc_html`, `esc_attr`) and sanitize input (`sanitize_text_field`). Verify nonces for all form actions.

## Licensing

By contributing, you agree that your contributions will be licensed under its GPLv2 or later License.
