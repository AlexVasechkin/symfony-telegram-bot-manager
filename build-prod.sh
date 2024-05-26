#!/bin/bash
docker build -t symfony-tg-bot:7-18-8.3 \
 --build-arg FRONT_SCRIPT=build \
 .
