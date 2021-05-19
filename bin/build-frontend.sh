#!/bin/bash

CWD="$(cd -P -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"

export PROJECT_ROOT="${PROJECT_ROOT:-"$(dirname "$CWD")"}"

export FRONTEND_ROOT="${FRONTEND_ROOT:-"${PROJECT_ROOT}/src/Resources/app/frontend"}"

# build storefront
npm --prefix "${FRONTEND_ROOT}" install
npm --prefix "${FRONTEND_ROOT}" run sass-compile
