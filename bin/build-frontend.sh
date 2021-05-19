#!/bin/bash

CWD="$(cd -P -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"

export PROJECT_ROOT="${PROJECT_ROOT:-"$(dirname "$CWD")"}"

export FRONTEND_ROOT="${FRONTEND_ROOT:-"${PROJECT_ROOT}/src/Resources/app/frontend"}"
FRONTEND_NODE_MODULES="${FRONTEND_NODE_MODULES:-"${FRONTEND_ROOT}/node_modules"}"
FRONTEND_SRC_BASE="${FRONTEND_SRC_BASE:-"${FRONTEND_ROOT}/src/sass/base.scss"}"
PROJECT_PUBLIC_CSS="${PROJECT_PUBLIC_CSS:-"${PROJECT_ROOT}/public/css/style.css"}"

# build storefront
npm --prefix "${FRONTEND_ROOT}" install
npm --prefix "${FRONTEND_ROOT}" run sass-compile

# node src/Resources/app/src/node_modules/sass/sass.js --watch src/Resources/app/src/scss/base.scss:public/css/style.css --style compressed --no-source-map

# node $FRONTEND_NODE_MODULES/sass/sass.js $FRONTEND_SRC_BASE:$PROJECT_PUBLIC_CSS --style compressed --no-source-map
