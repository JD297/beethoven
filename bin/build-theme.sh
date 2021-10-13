#!/bin/bash

CWD="$(cd -P -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"

export PROJECT_ROOT="${PROJECT_ROOT:-"$(dirname "$CWD")"}"

export THEME_ROOT="${THEME_ROOT:-"${PROJECT_ROOT}/$1"}"

# build storefront
npm --prefix "${THEME_ROOT}" install
npm --prefix "${THEME_ROOT}" run sass-compile

bin/console assets:install public
