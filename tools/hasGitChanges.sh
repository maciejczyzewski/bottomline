#!/usr/bin/env bash
if ! git diff-index --quiet HEAD --; then
    exit 1
fi
