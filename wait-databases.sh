#!/bin/bash

set -e

while ! make ping-database &>/dev/null; do
    echo "Waiting for database connection..."
    sleep 5
done
